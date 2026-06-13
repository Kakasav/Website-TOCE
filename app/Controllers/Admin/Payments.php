<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaymentModel;

class Payments extends BaseController
{
    protected PaymentModel $paymentModel;

    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
    }

    public function index()
    {
        return view('admin/payments', [
            'title'    => 'Metode Pembayaran — Admin TOCE',
            'payments' => $this->paymentModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = ['nama' => 'required|max_length[50]'];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $this->paymentModel->insert([
            'nama'     => $this->request->getPost('nama'),
            'is_aktif' => (int) $this->request->getPost('is_aktif'),
        ]);

        return redirect()->to('/admin/payments')->with('success', 'Metode pembayaran ditambahkan.');
    }

    public function toggle(int $id)
    {
        $pm = $this->paymentModel->find($id);
        if ($pm) {
            $this->paymentModel->update($id, ['is_aktif' => ! $pm['is_aktif']]);
        }
        return redirect()->to('/admin/payments')->with('success', 'Status diperbarui.');
    }

    public function delete(int $id)
    {
        $this->paymentModel->delete($id);
        return redirect()->to('/admin/payments')->with('success', 'Metode pembayaran dihapus.');
    }
}