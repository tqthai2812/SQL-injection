<?php

define('ROOTDIR', __DIR__ . DIRECTORY_SEPARATOR);

require_once ROOTDIR . 'vendor/autoload.php';

// Load biến môi trường từ file .env
$dotenv = Dotenv\Dotenv::createImmutable(ROOTDIR);
$dotenv->load();

// Kết nối cơ sở dữ liệu
try {
    $PDO = (new App\Models\PDOFactory())->create([
        'dbhost' => $_ENV['DB_HOST'],
        'dbname' => $_ENV['DB_NAME'],
        'dbuser' => $_ENV['DB_USER'],
        'dbpass' => $_ENV['DB_PASS'],
    ]);
} catch (Exception $ex) {
    die('Không thể kết nối đến MySQL. Vui lòng kiểm tra lại thông tin kết nối.<br>' . $ex->getMessage());
}

// Khởi tạo SessionGuard
$AUTHGUARD = new App\SessionGuard();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$BrandModel = new App\Models\Brand($PDO);
$_SESSION['brands'] = $BrandModel->all();
