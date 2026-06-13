<?php

namespace App\Models;

use CodeIgniter\Model;

class GameModel extends Model
{
    protected $table         = 'games';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'nama_game', 'gambar', 'publisher', 'status',
         'label_player_id'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getActive()
    {
        return $this->where('status', 'aktif')->orderBy('nama_game', 'ASC')->findAll();
    }

    public function getGameEmoji(string $name): string
    {
        $map = [
            'Mobile Legends' => '⚔️',
            'Free Fire'      => '🔥',
            'PUBG Mobile'    => '🪖',
            'Genshin Impact' => '🌸',
            'Valorant'       => '🎯',
        ];
        return $map[$name] ?? '🎮';
    }
}