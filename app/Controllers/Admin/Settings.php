<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingsModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Utility;

class Settings extends BaseController{


    use ResponseTrait;

    public function index()
    {
        $params = [
            'page_title' => lang('Default.settings'),
            'menu_id' => 'settings'
        ];
        return view('admin/admin_settings', $params);
    }

    public function getSetting() {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $settingsModel = new SettingsModel();
        $data = $settingsModel->getDataByName($postdata->name);
        return $this->respond($data);
    }
}