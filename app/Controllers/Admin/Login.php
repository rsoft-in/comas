<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Login extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $params = [
            'page_title' => lang('Default.login'),
            'menu_id' => 'login'
        ];
        return view('admin/admin_login', $params);
    }

    public function checkUser()
    {
    }
}
