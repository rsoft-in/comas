<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $params = [
            'page_title' => lang('Default.dashboard'),
            'menu_id' => 'dashboard'
        ];
        return view('admin/admin_home', $params);
    }
}
