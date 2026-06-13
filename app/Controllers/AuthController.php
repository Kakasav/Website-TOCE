<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to($this->isAdmin() ? base_url('admin') : base_url());
        }
        return view('auth/login', ['title' => 'Masuk — TOCE']);
    }

    public function loginProcess()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to($this->isAdmin() ? base_url('admin') : base_url());
        }

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $user      = $userModel->findByCredential($this->request->getPost('username'));

        if (! $user || $user['password'] !== $this->request->getPost('password')) {
            return redirect()->back()->withInput()->with('error', 'Username atau password salah.');
        }

        session()->set([
            'user_id'         => $user['id'],
            'username'        => $user['username'],
            'role'            => $user['role'],
            'profile_picture' => $user['photo'] ?? null,  
        ]);

        // Langsung ke admin dashboard kalau role admin
        if ($user['role'] === 'admin') {
            return redirect()->to(base_url('admin'));
        }

        return redirect()->to(base_url());
    }

    public function register()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to(base_url());
        }
        return view('auth/register', ['title' => 'Daftar — TOCE']);
    }

    public function registerProcess()
    {
        if ($this->isLoggedIn()) {
            return redirect()->to(base_url());
        }

        $rules = [
            'username'         => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        $messages = [
            'username'         => ['is_unique' => 'Username sudah dipakai.'],
            'email'            => ['is_unique' => 'Email sudah terdaftar.'],
            'confirm_password' => ['matches'   => 'Konfirmasi password tidak cocok.'],
        ];

        if (! $this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();
        $userModel->insert([
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'role'     => 'user',
        ]);

        return redirect()->to(base_url('login'))->with('success', 'Akun berhasil dibuat! Silakan masuk.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}