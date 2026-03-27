<?php

namespace App\Controllers\Admin;

use League\Plates\Engine;

class Controller
{
    protected $view;

    public function __construct()
    {
        $this->view = new Engine(ROOTDIR . 'app/views/admin');
    }

    public function sendPage($page, array $data = [])
    {
        exit($this->view->render($page, $data));
    }

    // Lưu các giá trị của form được cho trong $data vào $_SESSION 
    protected function saveFormValues(array $data, array $except = [])
    {
        $form = [];
        foreach ($data as $key => $value) {
            if (!in_array($key, $except, true)) {
                $form[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
            }
        }
        $_SESSION['form'] = $form;
    }

    protected function getSavedFormValues()
    {
        return session_get_once('form', []);
    }
    public function sendNotFound()
    {
        http_response_code(404);
        $this->sendPage('errors/404');
    }
}
