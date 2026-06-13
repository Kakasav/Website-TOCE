<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table         = 'payment_methods';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['nama', 'logo', 'is_aktif'];
    protected $useTimestamps = false;

    public function getActive()
    {
        return $this->where('is_aktif', 1)->findAll();
    }
}