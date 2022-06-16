<?php

namespace App\Controllers;

use App\Models\SettingsModel;

class Home extends BaseController
{
    public function index()
    {
        $theme = 'default';
        $settingsModel = new SettingsModel();
        $siteConfig = $settingsModel->getDataByName('site-config');
        if (sizeof($siteConfig) > 0) {
            $json = json_decode($siteConfig[0]->setting_value);
            // var_dump($json);
            $theme = strtolower($json->site_theme);
            $data = [
                'site_name' => $json->site_name,
                'site_desc' => $json->site_desc
            ];
        }

        return view('themes/' . $theme . '_home', $data);
    }
}
