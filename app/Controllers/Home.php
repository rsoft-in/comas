<?php

namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\PostsModel;

class Home extends BaseController
{
    public function index()
    {
        $theme = 'default';
        $settingsModel = new SettingsModel();
        $postsModel = new PostsModel();
        $siteConfig = $settingsModel->getDataByName('site-config');
        if (sizeof($siteConfig) > 0) {
            $json = json_decode($siteConfig[0]->setting_value);
            // var_dump($json);
            $theme = strtolower($json->site_theme);
            $data = [
                'site_name' => $json->site_name,
                'site_desc' => $json->site_desc,
                'site_isblog' => $json->site_isblog
            ];
            if ($json->site_isblog) {
                $postsPopular = $postsModel->getData('', 'post_visited DESC, post_modified DESC', 3, 0);
                $data['site_posts_popular'] = $postsPopular;
                $postsRecent = $postsModel->getData('', 'post_modified DESC', 10, 0);
                $data['site_posts_recent'] = $postsRecent;
            }
            return view('themes/' . $theme . '/home', $data);
        }

        return;
    }
}
