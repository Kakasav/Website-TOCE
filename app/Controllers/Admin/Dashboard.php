<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GameModel;
use App\Models\OrderModel;
use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $userModel  = new UserModel();
        $gameModel  = new GameModel();
        $db         = \Config\Database::connect();

        return view('admin/dashboard', [
            'title'         => 'Dashboard — Admin TOCE',
            'total_orders'  => $orderModel->countAll(),
            'total_revenue' => $orderModel->getTotalRevenue(),
            'total_users'   => $userModel->where('role', 'user')->countAllResults(),
            'total_games'   => $gameModel->where('status', 'aktif')->countAllResults(),
            'pending'       => $orderModel->where('status', 'pending')->countAllResults(),
            'sukses'        => $orderModel->where('status', 'sukses')->countAllResults(),
            'recent_orders' => $orderModel->getRecent(8),
        ]);
    }
}