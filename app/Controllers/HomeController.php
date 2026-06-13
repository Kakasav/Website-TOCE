<?php

namespace App\Controllers;

use App\Models\GameModel;
use App\Models\ItemModel;
use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Models\UserModel;

class HomeController extends BaseController
{
    public function index()
    {
        $gameModel = new GameModel();
        return view('home/index', [
            'title' => 'TOCE — Top Up Game',
            'games' => $gameModel->getActive(),
        ]);
    }

    public function topup(int $gameId)
    {
        $gameModel = new GameModel();
        $itemModel = new ItemModel();

        $game = $gameModel->find($gameId);
        if (! $game || $game['status'] !== 'aktif') {
            return redirect()->to('/')->with('error', 'Game tidak ditemukan.');
        }

        return view('home/topup', [
            'title'    => 'Top Up ' . $game['nama_game'] . ' — TOCE',
            'game'     => $game,
            'packages' => $itemModel->getByGame($gameId),
        ]);
    }

    public function checkout()
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to(url_to('AuthController::login'))->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $itemId    = (int) $this->request->getGet('item_id');
        $itemModel = new ItemModel();
        $item      = $itemModel->getWithGame($itemId);

        if (! $item) {
            return redirect()->to('/')->with('error', 'Paket tidak ditemukan.');
        }

        return view('home/checkout', [
            'title'    => 'Checkout — TOCE',
            'item'     => $item,
            'payments' => (new PaymentModel())->getActive(),
        ]);
    }

    public function checkoutProcess()
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to(url_to('AuthController::login'));
        }

        $itemId    = (int) $this->request->getPost('item_id');
        $itemModel = new ItemModel();
        $item      = $itemModel->getWithGame($itemId);

        if (! $item) {
            return redirect()->to('/')->with('error', 'Paket tidak valid.');
        }

        $rules = [
            'id_game_player' => 'required|max_length[100]',
            'payment_id'     => 'required|integer',
            'bukti_bayar'    => 'uploaded[bukti_bayar]|is_image[bukti_bayar]|mime_in[bukti_bayar,image/jpg,image/jpeg,image/png,image/webp]|max_size[bukti_bayar,2048]',
        ];

    

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload bukti bayar
        $buktiBayar = null;
        $file = $this->request->getFile('bukti_bayar');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $file->move(ROOTPATH . 'public/uploads/bukti', $file->getRandomName());
            $buktiBayar = $file->getName();
        }

        // Generate invoice unik
        $orderModel = new OrderModel();
        do {
            $invoice = $orderModel->generateInvoice();
        } while ($orderModel->where('invoice', $invoice)->first());

        $orderModel->insert([
            'invoice'        => $invoice,
            'user_id'        => session()->get('user_id'),
            'item_id'        => $itemId,
            'payment_id'     => $this->request->getPost('payment_id'),
            'id_game_player' => $this->request->getPost('id_game_player'),
            'bukti_bayar'    => $buktiBayar,
            'total_harga'    => $item['harga'],
            'status'         => 'pending',
        ]);

        return redirect()->to(url_to('HomeController::orderSuccess', $orderModel->getInsertID()));
    }

    public function orderSuccess(int $orderId)
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to(url_to('AuthController::login'));
        }

        $order = (new OrderModel())->getDetail($orderId, session()->get('user_id'));
        if (! $order) {
            return redirect()->to('/')->with('error', 'Order tidak ditemukan.');
        }

        return view('home/success', [
            'title' => 'Order Diterima — TOCE',
            'order' => $order,
        ]);
    }

    public function orders()
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to(url_to('AuthController::login'));
        }

        $orderModel = new OrderModel();
        return view('home/orders', [
            'title'  => 'Pesanan Saya — TOCE',
            'orders' => $orderModel->getByUser(session()->get('user_id'), 10),
            'pager'  => $orderModel->pager,
        ]);
    }

    public function orderDetail(int $orderId)
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to(url_to('AuthController::login'));
        }

        $order = (new OrderModel())->getDetail($orderId, session()->get('user_id'));
        if (! $order) {
            return redirect()->to('/orders')->with('error', 'Order tidak ditemukan.');
        }

        return view('home/order_detail', [
            'title' => 'Detail Order ' . $order['invoice'] . ' — TOCE',
            'order' => $order,
        ]);
    }

    public function profile()
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to(url_to('AuthController::login'));
        }

        return view('home/profile', [
            'title' => 'Profil Saya — TOCE',
            'user'  => (new UserModel())->find(session()->get('user_id')),
        ]);
    }

    public function profileUpdate()
    {
        if (! $this->isLoggedIn()) {
            return redirect()->to(url_to('AuthController::login'));
        }

        $userId    = session()->get('user_id');
        $userModel = new UserModel();
        $user      = $userModel->find($userId);

        $newPassword = $this->request->getPost('new_password');

        $rules = [
            'username' => "required|min_length[3]|max_length[50]|is_unique[users.username,id,{$userId}]",
            'email'    => "required|valid_email|is_unique[users.email,id,{$userId}]",
        ];

        $messages = [
            'username' => [
                'is_unique'  => 'Username sudah digunakan oleh akun lain.',
                'min_length' => 'Username minimal 3 karakter.',
            ],
            'email' => [
                'valid_email' => 'Format email tidak valid, contoh: nama@domain.com',
                'is_unique'   => 'Email sudah digunakan oleh akun lain.',
            ],
        ];

        if ($newPassword) {
            $rules['current_password'] = 'required';
            $rules['new_password']     = 'required|min_length[6]';
            $rules['confirm_password'] = 'required|matches[new_password]';

            $messages['new_password']     = ['min_length' => 'Password baru minimal 6 karakter.'];
            $messages['confirm_password'] = ['matches'    => 'Konfirmasi password tidak cocok.'];
            $messages['current_password'] = ['required'   => 'Password lama wajib diisi.'];
        }
        
        if (! $this->validate($rules, $messages)) {
            return view('home/profile', [
                'title'  => 'Profil Saya — TOCE',
                'user'   => (new UserModel())->find($userId),
                'errors' => $this->validator->getErrors(),
            ]);
        }

        if ($newPassword && $user['password'] !== $this->request->getPost('current_password')) {
            return redirect()->back()->withInput()->with('error', 'Password lama tidak sesuai.');
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'phone'    => $this->request->getPost('phone'),
            'bio'      => $this->request->getPost('bio'),
            'address'  => $this->request->getPost('address'),
        ];

        if ($newPassword) {
            $data['password'] = $newPassword; 
        }

        $userModel->update($userId, $data);

        // Update session
        session()->set('username', $data['username']);
        session()->set('email', $data['email']);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function uploadPhoto()
    {
        if (! $this->isLoggedIn()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $file = $this->request->getFile('photo');

        if (! $file || ! $file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak valid']);
        }

        if ($file->getSize() > 3 * 1024 * 1024) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ukuran maksimal 3MB']);
        }

        if (! in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Format harus JPG/PNG']);
        }

        $userId    = session()->get('user_id');
        $userModel = new UserModel();
        $user      = $userModel->find($userId);

        if (! empty($user['photo'])) {
            $oldPath = FCPATH . 'uploads/users/' . $user['photo'];
            if (file_exists($oldPath)) unlink($oldPath);
        }

        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/users/', $newName);

        $userModel->update($userId, ['photo' => $newName]);

        session()->set('profile_picture', $newName);

        return $this->response->setJSON([
            'success'   => true,
            'photo_url' => base_url('uploads/users/' . $newName),
        ]);
    }

    public function deletePhoto()
    {
        if (! $this->isLoggedIn()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized']);
        }

        $userId    = session()->get('user_id');
        $userModel = new UserModel();
        $user      = $userModel->find($userId);

        if (! empty($user['photo'])) {
            $path = FCPATH . 'uploads/users/' . $user['photo'];
            if (file_exists($path)) unlink($path);
            $userModel->update($userId, ['photo' => null]);
        }

        // Reset session
        session()->set('profile_picture', null);

        return $this->response->setJSON(['success' => true]);
    }
}
