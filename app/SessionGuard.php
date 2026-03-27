<?php

namespace App;

use App\Models\User;
use App\Models\Brand;

class SessionGuard
{
  protected $user;

  public function login(User $user, array $credentials)
  {
    $verified = password_verify($credentials['password'], $user->password);
    if ($verified) {
      $_SESSION['user_id'] = $user->id;
      $_SESSION['user_role'] = $user->role; // 🔧 Lưu role vào session
    }
    return $verified;
  }

  public function user()
  {
    if (!$this->user && $this->isUserLoggedIn()) {
      $this->user = (new User(PDO()))->where('id', $_SESSION['user_id']);
    }
    return $this->user;
  }

public function logout()
  {
    $this->user = null;
    session_unset();
    session_destroy();
    if (session_status() !== PHP_SESSION_ACTIVE) {
      session_start();
  }
    session_regenerate_id(true);
    $BrandModel = new Brand(PDO());
    $brands = $BrandModel->all();
    $_SESSION['brands'] = $brands;
  }

  public function isUserLoggedIn()
  {
    return isset($_SESSION['user_id']);
  }

  public function isAdmin() // 🔧 Thêm hàm kiểm tra admin
  {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
  }
}
