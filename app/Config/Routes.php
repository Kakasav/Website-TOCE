<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->setAutoRoute(false);

$routes->get('/', 'HomeController::index');
$routes->get('topup/(:num)', 'HomeController::topup/$1');
$routes->get('checkout', 'HomeController::checkout');
$routes->post('checkout', 'HomeController::checkoutProcess');
$routes->get('order/success/(:num)', 'HomeController::orderSuccess/$1');
$routes->get('order/(:num)', 'HomeController::orderDetail/$1');
$routes->get('orders', 'HomeController::orders');
$routes->get('profile', 'HomeController::profile');
$routes->post('profile', 'HomeController::profileUpdate');

$routes->post('home/uploadPhoto', 'HomeController::uploadPhoto');
$routes->post('home/deletePhoto', 'HomeController::deletePhoto');

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginProcess');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::registerProcess');
$routes->get('logout', 'AuthController::logout');

// ── Admin routes ──
$routes->group('admin', ['filter' => 'adminFilter'], function ($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->post('users/store', 'Admin\Users::store');

    $routes->get('games', 'Admin\Games::index');
    $routes->post('games/store', 'Admin\Games::store');
    $routes->post('games/update/(:num)', 'Admin\Games::update/$1');
    $routes->get('games/delete/(:num)', 'Admin\Games::delete/$1');

    $routes->get('items', 'Admin\Items::index');
    $routes->post('items/store', 'Admin\Items::store');
    $routes->post('items/update/(:num)', 'Admin\Items::update/$1');
    $routes->get('items/delete/(:num)', 'Admin\Items::delete/$1');

    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/(:num)', 'Admin\Orders::detail/$1');
    $routes->post('orders/status/(:num)', 'Admin\Orders::updateStatus/$1');

    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');

    $routes->get('payments', 'Admin\Payments::index');
    $routes->post('payments/store', 'Admin\Payments::store');
    $routes->post('payments/toggle/(:num)', 'Admin\Payments::toggle/$1');
    $routes->get('payments/delete/(:num)', 'Admin\Payments::delete/$1');
});
