<?php

namespace App\Controllers;

use App\Models\SettingsModel;
use App\Models\PostsModel;
use App\Models\CategoriesModel;
use App\Models\PagesModel;

class Home extends BaseController
{
    public function index()
    {
        $theme = 'default';
        $settingsModel = new SettingsModel();
        $postsModel = new PostsModel();
        $categoriesModel = new CategoriesModel();
        $pagesModel = new PagesModel();
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
                $postsPopular = $postsModel->getData(' AND post_published = 1', 'post_visited DESC, post_modified DESC', 2, 0);
                $data['site_posts_popular'] = $postsPopular;
                $postsRecent = $postsModel->getData(' AND post_published = 1', 'post_modified DESC', 10, 0);
                $data['site_posts_recent'] = $postsRecent;
                $archived = $postsModel->getArchived();
                $data['site_archives'] = $archived;
                $categories = $categoriesModel->getData('', 'cg_name', 5, 0);
                $data['site_categories'] = $categories;
                $pageLinks = $pagesModel->getLinks();
                $data['site_links'] = $pageLinks;
                return view('themes/' . $theme . '/home', $data);
            } else {
                // Show a static page here
            }
        }

        return;
    }
}
