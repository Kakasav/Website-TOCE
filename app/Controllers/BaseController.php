<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    // Load helper url, form, text supaya
    // anchor(), url_to(), form_open(), form_close() tersedia di semua controller & view
    protected $helpers = ['url', 'form', 'text'];

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
    }

    protected function isLoggedIn(): bool
    {
        return (bool) session()->get('user_id');
    }

    protected function isAdmin(): bool
    {
        return session()->get('role') === 'admin';
    }
}