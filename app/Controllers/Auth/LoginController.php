<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\User\Controller;

class LoginController extends Controller
{
  public function create()
  {
    if (AUTHGUARD()->isUserLoggedIn()) {
      redirect('/home');
    }

    $data = [
      'messages' => session_get_once('messages'),
      'old' => $this->getSavedFormValues(),
      'errors' => session_get_once('errors')
    ];

    $this->sendPage('auth/login', $data);
  }

  public function store()
  {
    session_start();
    $csrfToken = $_POST['csrf_token'] ?? '';
    if (!verifyCsrfToken($csrfToken)) {
      http_response_code(403);
      echo "CSRF token không hợp lệ.";
      exit;
    }
    if (empty($_POST['email']) || empty($_POST['password'])) {
      $_SESSION['errors'] = ['email' => 'Email và mật khẩu không được để trống.'];
      redirect('/login');
    }

    $user_credentials = $this->filterUserCredentials($_POST);

    if (!$user_credentials['email']) {
      $_SESSION['errors'] = ['email' => 'Email không hợp lệ.'];
      redirect('/login');
    }

    $user = (new User(PDO()))->where('email', $user_credentials['email']);

    if (!$user) {
      $_SESSION['errors'] = ['email' => 'Tài khoản không tồn tại hoặc sai thông tin đăng nhập.'];
      redirect('/login');
    }

    if (!AUTHGUARD()->login($user, $user_credentials)) {
      $_SESSION['errors'] = ['password' => 'Sai mật khẩu.'];
      redirect('/login');
    }

    if ($user->role === 'admin') {
      $_SESSION['success_Mess'] = 'Bạn đã đăng nhập thành công với tư cách Admin!';
      redirect('/admin/products');
    } else {

      redirect('/home');
    }
  }

  public function destroy()
  {
    AUTHGUARD()->logout();
    redirect('/login');
  }

  protected function filterUserCredentials(array $data)
  {
    return [
      'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
      'password' => $data['password'] ?? null
    ];
  }
}
