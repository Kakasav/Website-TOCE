<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('admin/users', [
            'title' => 'Pengguna — Admin TOCE',
            'users' => $this->userModel->getAllWithOrderCount(),
        ]);
    }

    public function delete(int $id)
    {
        if ($id === (int) session()->get('user_id')) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user = $this->userModel->find($id);
        if ($user && $user['role'] === 'admin') {
            return redirect()->back()->with('error', 'Tidak bisa menghapus admin.');
        }

        $this->userModel->delete($id);
        return redirect()->to('/admin/users')->with('success', 'User dihapus.');
    }

    public function store()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        $messages = [
            'username' => ['is_unique' => 'Username sudah digunakan.'],
            'email'    => ['is_unique' => 'Email sudah digunakan.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        (new \App\Models\UserModel())->insert([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role'     => 'admin',
        ]);

        return redirect()->to('/admin/users')->with('success', 'Akun admin berhasil dibuat.');
    }
}
