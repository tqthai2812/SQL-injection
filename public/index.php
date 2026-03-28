<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../bootstrap.php';

define('APPNAME', 'SmartPhone');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$router = new \Bramus\Router\Router();

// Auth routes
$router->post('/logout', '\App\Controllers\Auth\LoginController@destroy');
$router->get('/register', '\App\Controllers\Auth\RegisterController@create');
$router->post('/register', '\App\Controllers\Auth\RegisterController@store');
$router->get('/login', '\App\Controllers\Auth\LoginController@create');
$router->post('/login', '\App\Controllers\Auth\LoginController@store');

// User routes
$router->get('/', '\App\Controllers\User\UserController@index');
$router->get('/home', '\App\Controllers\User\UserController@index');
$router->get('/product/{id:[0-9]+}', 'App\Controllers\User\UserController@product');
$router->get('/product-list', '\App\Controllers\User\UserController@productlist');
$router->get('/product-list/{brand}', '\App\Controllers\User\UserController@productbrand');
$router->get('/search', '\App\Controllers\User\UserController@search');
$router->get('/user/info', '\App\Controllers\User\UserController@info');
$router->set404('\App\Controllers\User\Controller@sendNotFound');

// Cart routes
$router->get('/cart', '\App\Controllers\User\UserController@cart');
$router->post('/cart/add', '\App\Controllers\User\UserController@addToCart');
$router->post('/cart/remove', '\App\Controllers\User\UserController@removeFromCart');
$router->post('/cart/clear', '\App\Controllers\User\UserController@clearCart');
$router->post('/cart/update', '\App\Controllers\User\UserController@updateCartQuantityByAction');

//admin
$router->get('/admin/products', 'App\Controllers\Admin\SmartphonesController@index');
$router->get('/admin/user', 'App\Controllers\Admin\AdminController@users');
$router->post('/admin', '\App\Controllers\Admin\SmartphonesController@store');
$router->get('/admin/create', '\App\Controllers\Admin\SmartphonesController@create');
$router->get('/admin/edit/(\d+)', '\App\Controllers\Admin\SmartphonesController@edit');
$router->post('/admin/(\d+)', '\App\Controllers\Admin\SmartphonesController@update');
$router->post('/admin/delete/(\d+)', '\App\Controllers\Admin\SmartphonesController@destroy');
// Admin brand routes
$router->get('/admin/brands', '\App\Controllers\Admin\BrandsController@index');
$router->get('/admin/brands/create', '\App\Controllers\Admin\BrandsController@create');
$router->post('/admin/brands/store', '\App\Controllers\Admin\BrandsController@store');
$router->get('/admin/brands/edit/(\d+)', '\App\Controllers\Admin\BrandsController@edit');
$router->post('/admin/brands/update/(\d+)', '\App\Controllers\Admin\BrandsController@update');
$router->post('/admin/brands/delete/(\d+)', '\App\Controllers\Admin\BrandsController@destroy');

$router->get('/lab-sqli', '\App\Controllers\User\UserController@labSqli');

$router->before('GET|POST', '/admin/.*', function () {
    if (!AUTHGUARD()->isAdmin()) {
        $_SESSION['error_Mess'] = 'Bạn không có quyền truy cập!';
        redirect('/home');
        exit;
    }
});
$router->run();
