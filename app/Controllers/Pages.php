<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriesModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\PagesModel;
use App\Models\PostsModel;
use App\Models\SettingsModel;

class Pages extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return view('unauthorized_access');
    }

    public function page($urlSlug = "")
    {
        $theme = 'default';
        $settingsModel = new SettingsModel();
        $pagesModel = new PagesModel();
        $postsModel = new PostsModel();
        $categoriesModel = new CategoriesModel();
        $siteConfig = $settingsModel->getDataByName('site-config');
        $page = $pagesModel->gePageByUrlSlug($urlSlug);
        if (sizeof($page) == 1) {
            if (sizeof($siteConfig) > 0) {
                $json = json_decode($siteConfig[0]->setting_value);
                $theme = strtolower($json->site_theme);
                $data = [
                    'site_name' => $json->site_name,
                    'site_desc' => $json->site_desc,
                    'site_isblog' => $json->site_isblog
                ];

                $archived = $postsModel->getArchived();
                $data['site_archives'] = $archived;
                $categories = $categoriesModel->getData('', 'cg_name', 5, 0);
                $data['site_categories'] = $categories;
                $pageLinks = $pagesModel->getLinks();
                $data['site_links'] = $pageLinks;
                $data['page'] = $page[0];

                return view('themes/' . $theme . '/page', $data);
            }
        } else {
            return view('unauthorized_access');
        }
    }
}
