<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'invoice', 'user_id', 'item_id', 'payment_id',
        'id_game_player', 'bukti_bayar',
        'total_harga', 'status'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    private function baseSelect(): static
    {
        return $this->select('orders.*, top_up_items.nama_paket, top_up_items.jumlah,
                              games.nama_game, games.needs_server_id,
                              games.label_player_id, games.label_server_id,
                              payment_methods.nama AS metode_bayar, users.username')
                    ->join('top_up_items',    'top_up_items.id = orders.item_id')
                    ->join('games',           'games.id = top_up_items.game_id')
                    ->join('payment_methods', 'payment_methods.id = orders.payment_id')
                    ->join('users',           'users.id = orders.user_id');
    }

    public function getByUser(int $userId, int $perPage = 10)
    {
        return $this->baseSelect()
                    ->where('orders.user_id', $userId)
                    ->orderBy('orders.created_at', 'DESC')
                    ->paginate($perPage, 'orders');
    }

    public function getDetail(int $orderId, int $userId = 0)
    {
        $q = $this->baseSelect()->where('orders.id', $orderId);
        if ($userId) $q->where('orders.user_id', $userId);
        return $q->first();
    }

    public function getAll(string $status = '', int $perPage = 15)
    {
        $q = $this->baseSelect()->orderBy('orders.created_at', 'DESC');
        if ($status) $q->where('orders.status', $status);
        return $q->paginate($perPage, 'admin_orders');
    }

    public function getRecent(int $limit = 8)
    {
        return $this->baseSelect()
                    ->orderBy('orders.created_at', 'DESC')
                    ->findAll($limit);
    }

    public function getTotalRevenue(): float
    {
        return (float) ($this->selectSum('total_harga', 'revenue')
                             ->where('status', 'sukses')
                             ->get()->getRow()->revenue ?? 0);
    }

    public function generateInvoice(): string
    {
        return 'INV-' . date('Ymd') . '-' . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
    }
}