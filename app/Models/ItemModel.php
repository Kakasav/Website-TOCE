<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table         = 'top_up_items';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['game_id', 'nama_paket', 'jumlah', 'harga'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByGame(int $gameId)
    {
        return $this->where('game_id', $gameId)->orderBy('harga', 'ASC')->findAll();
    }

    public function getWithGame(int $id)
    {
        return $this->select('top_up_items.*, games.nama_game, games.id AS game_id_ref')
                    ->join('games', 'games.id = top_up_items.game_id')
                    ->find($id);
    }

    public function getAllWithGame()
    {
        return $this->select('top_up_items.*, games.nama_game')
                    ->join('games', 'games.id = top_up_items.game_id')
                    ->orderBy('games.nama_game, top_up_items.harga', 'ASC')
                    ->findAll();
    }
}