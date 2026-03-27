<?php

namespace App\Controllers\Admin;

use App\Models\User;

class AdminController extends Controller
{
  public function __construct()
  {
    parent::__construct();
  }

  public function users()
  {
    // $pdo = $this->getPDO(); // Hàm này nên trả về kết nối PDO
    $userpdo = new User(PDO());
    $users = $userpdo->all(); // Lấy tất cả dữ liệu smartphone

    $this->sendPage('content/users', [
      'users' => $users
    ]);
  }
}
