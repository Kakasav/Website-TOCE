<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GameModel;

class Games extends BaseController
{
    protected GameModel $gameModel;

    public function __construct()
    {
        $this->gameModel = new GameModel();
    }

    public function index()
    {
        return view('admin/games', [
            'title' => 'Kelola Game — Admin TOCE',
            'games' => $this->gameModel->orderBy('id', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $rules = [
            'nama_game' => 'required|max_length[100]',
            'publisher' => 'required|max_length[100]',
            'status'    => 'required|in_list[aktif,nonaktif]',
            'gambar'    => 'if_exist|uploaded[gambar]|is_image[gambar]|max_dims[gambar,1000,1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_game' => $this->request->getPost('nama_game'),
            'publisher' => $this->request->getPost('publisher'),
            'status'    => $this->request->getPost('status'),
        ];

        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/games/', $newName);
            $data['gambar'] = $newName;
        }

        $this->gameModel->insert($data);
        return redirect()->to('/admin/games')->with('success', 'Game berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $rules = [
            'nama_game' => 'required|max_length[100]',
            'publisher' => 'required|max_length[100]',
            'status'    => 'required|in_list[aktif,nonaktif]',
            'gambar'    => 'if_exist|uploaded[gambar]|is_image[gambar]|max_dims[gambar,1000,1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_game' => $this->request->getPost('nama_game'),
            'publisher' => $this->request->getPost('publisher'),
            'status'    => $this->request->getPost('status'),
        ];

        $file = $this->request->getFile('gambar');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/games/', $newName);
            $data['gambar'] = $newName;
        }

        $this->gameModel->update($id, $data);
        return redirect()->to('/admin/games')->with('success', 'Game berhasil diupdate.');
    }

    public function delete(int $id)
    {
        $this->gameModel->delete($id);
        return redirect()->to('/admin/games')->with('success', 'Game dihapus.');
    }
}