<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;

class Orders extends BaseController
{
    protected OrderModel $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $status      = $this->request->getGet('status') ?? '';
        $validStatus = ['pending', 'sukses', 'gagal'];
        if (! in_array($status, $validStatus)) $status = '';

        $orders = $this->orderModel->getAll($status, 15);
        $pager  = $this->orderModel->pager;

        return view('admin/orders', [
            'title'        => 'Pesanan — Admin TOCE',
            'orders'       => $orders,
            'filterStatus' => $status,
            'pager'        => $pager,
        ]);
    }

    public function detail(int $id)
    {
        $order = $this->orderModel->getDetail($id);
        if (! $order) {
            return redirect()->to('/admin/orders')->with('error', 'Order tidak ditemukan.');
        }

        return view('admin/order_detail', [
            'title' => 'Detail Order — Admin TOCE',
            'order' => $order,
        ]);
    }

    public function updateStatus(int $id)
    {
        $status = $this->request->getPost('status');
        if (in_array($status, ['pending', 'sukses', 'gagal'])) {
            $this->orderModel->update($id, ['status' => $status]);
        }
        return redirect()->back()->with('success', 'Status order diperbarui.');
    }
}