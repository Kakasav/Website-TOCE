<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['username', 'email', 'password', 'role', 'photo', 'bio', 'phone', 'address'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function findByCredential(string $login)
    {
        return $this->groupStart()
                        ->where('username', $login)
                        ->orWhere('email', $login)
                    ->groupEnd()
                    ->first();
    }

    public function getAllWithOrderCount()
    {
        return $this->select('users.*, COUNT(orders.id) AS total_orders')
                    ->join('orders', 'orders.user_id = users.id', 'left')
                    ->groupBy('users.id')
                    ->orderBy('users.created_at', 'DESC')
                    ->findAll();
    }
}