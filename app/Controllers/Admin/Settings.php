<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingsModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Utility;

class Settings extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url() . '/' . index_page() . '/admin/login');
        }

        $params = [
            'page_title' => lang('Default.settings'),
            'menu_id' => 'settings'
        ];
        if ($_SESSION['user_level'] == 5)
            return view('admin/admin_settings', $params);
        else
            return view('unauthorized_access');
    }

    public function getSetting()
    {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $settingsModel = new SettingsModel();
        $data = $settingsModel->getDataByName($postdata->name);
        return $this->respond($data);
    }

    public function updateSetting()
    {
        $post = $this->request->getPost('postdata');
        $setting_name = $this->request->getPost('name');
        $json = json_decode($post);
        $settingsModel = new SettingsModel();
        $value = [
            'site_name' =>  $json->site_name,
            'site_desc' => $json->site_desc,
            'site_keywords' => $json->site_keywords,
            'site_theme' => $json->site_theme,
            'site_logo' => $json->site_logo,
            'site_contact_email' => $json->site_contact_email,
            'site_contact_phone' => $json->site_contact_phone,
            'site_contact_mobile' => $json->site_contact_mobile,
            'site_show_logo_only' => $json->site_show_logo_only,
            'site_show_name_only' => $json->site_show_name_only,
            'site_isblog' => $json->site_isblog,
            'site_allow_comments' => $json->site_allow_comments,
            'site_allow_comments_moderation' => $json->site_allow_comments_moderation,
            'site_show_archive' => $json->site_show_archive,
            'site_show_categories' => $json->site_show_categories,
            'site_show_social_links' => $json->site_show_social_links,
            'site_social_fb_url' => $json->site_social_fb_url,
            'site_social_ig_url' => $json->site_social_ig_url,
            'site_social_tw_url' => $json->site_social_tw_url,
            'site_static_page' => $json->site_static_page
        ];
        $data = [
            'setting_name' => $setting_name,
            'setting_value' => json_encode($value)
        ];
        $setting = $settingsModel->getDataByName($setting_name);
        if (sizeof($setting) > 0) {
            $settingsModel->updateData($data);
        } else {
            $settingsModel->addData($data);
        }

        echo 'SUCCESS';
    }
}
