<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GameModel;
use App\Models\ItemModel;

class Items extends BaseController
{
    protected ItemModel $itemModel;
    protected GameModel $gameModel;

    public function __construct()
    {
        $this->itemModel = new ItemModel();
        $this->gameModel = new GameModel();
    }

    public function index()
    {
        $filterGameId = (int) $this->request->getGet('game_id');

        $query = $this->itemModel->select('top_up_items.*, games.nama_game')
                                 ->join('games', 'games.id = top_up_items.game_id')
                                 ->orderBy('games.nama_game, top_up_items.harga', 'ASC');

        if ($filterGameId) {
            $query->where('top_up_items.game_id', $filterGameId);
        }

        return view('admin/items', [
            'title'      => 'Paket Top Up — Admin TOCE',
            'items'      => $query->findAll(),
            'games'      => $this->gameModel->where('status', 'aktif')->orderBy('nama_game')->findAll(),
            'filterGame' => $filterGameId,
        ]);
    }

    public function store()
    {
        $rules = [
            'game_id'    => 'required|integer',
            'nama_paket' => 'required|max_length[100]',
            'jumlah'     => 'required|integer|greater_than_equal_to[0]',
            'harga'      => 'required|decimal|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $this->itemModel->insert([
            'game_id'    => $this->request->getPost('game_id'),
            'nama_paket' => $this->request->getPost('nama_paket'),
            'jumlah'     => $this->request->getPost('jumlah'),
            'harga'      => $this->request->getPost('harga'),
        ]);

        return redirect()->to('/admin/items')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function update(int $id)
    {
        $rules = [
            'game_id'    => 'required|integer',
            'nama_paket' => 'required|max_length[100]',
            'jumlah'     => 'required|integer|greater_than_equal_to[0]',
            'harga'      => 'required|decimal|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $this->itemModel->update($id, [
            'game_id'    => $this->request->getPost('game_id'),
            'nama_paket' => $this->request->getPost('nama_paket'),
            'jumlah'     => $this->request->getPost('jumlah'),
            'harga'      => $this->request->getPost('harga'),
        ]);

        return redirect()->to('/admin/items')->with('success', 'Paket berhasil diupdate.');
    }

    public function delete(int $id)
    {
        $this->itemModel->delete($id);
        return redirect()->to('/admin/items')->with('success', 'Paket dihapus.');
    }
}