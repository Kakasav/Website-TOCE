<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\GameModel;
use App\Models\ItemModel;

class TopupController extends BaseController
{
    public function index()
    {
        $gameModel = new GameModel();
        return view('home/index', [  // view list game yang udah ada
            'games' => $gameModel->findAll()
        ]);
    }

    public function detail($id)
    {
        $gameModel = new GameModel();
        $itemModel = new ItemModel();

        $game = $gameModel->find($id);
        if (!$game) {
            return redirect()->to('user/topup')->with('error', 'Game tidak ditemukan');
        }

        return view('users/topup', [
            'game'  => $game,
            'items' => $itemModel->where('game_id', $id)->findAll()
        ]);
    }

    public function order()
    {
        // nanti isi logic order
    }
}