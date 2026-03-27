<?php

namespace App\Controllers\Auth;

use App\Models\User;
use App\Controllers\User\Controller;

class RegisterController extends Controller
{
  public function __construct()
  {
    if (AUTHGUARD()->isUserLoggedIn()) {
      redirect('/home');
    }

    parent::__construct();
  }

  public function create()
  {
    $data = [
      'old' => $this->getSavedFormValues(),
      'errors' => session_get_once('errors')
    ];

    $this->sendPage('auth/register', $data);
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
    $this->saveFormValues($_POST, ['password', 'password_confirmation']);

    $data = $this->filterUserData($_POST);
    $newUser = new User(PDO());
    $model_errors = $newUser->validate($data);
    if (empty($model_errors)) {
      $newUser->fill($data)->save();

      $messages = ['success' => 'User has been created successfully.'];
      $_SESSION['success_Mess'] = 'Bạn đã đăng kí thành công';
      redirect('/login', ['messages' => $messages]);
    }

    redirect('/register', ['errors' => $model_errors]);
  }

  protected function filterUserData(array $data)
  {
    return [
      'name' => $data['name'] ?? null,
      'email' => filter_var($data['email'], FILTER_VALIDATE_EMAIL),
      'password' => $data['password'] ?? null,
      'password_confirmation' => $data['password_confirmation'] ?? null
    ];
  }
}
