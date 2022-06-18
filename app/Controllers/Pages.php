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
        $postsModel = new PostsModel();
        $categoriesModel = new CategoriesModel();
        $pagesModel = new PagesModel();
        $data = $this->loadSettings();
        if ($data != null) {
            if ($data['site_isblog']) {
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
                return view('themes/' . $data['site-theme'] . '/home', $data);
            } else {
                // Show a static page here
            }
        }

        return;
    }

    public function page($urlSlug = "")
    {
        $pagesModel = new PagesModel();
        $postsModel = new PostsModel();
        $categoriesModel = new CategoriesModel();
        $data = $this->loadSettings();
        $page = $pagesModel->gePageByUrlSlug($urlSlug);
        if (sizeof($page) == 1) {
            $archived = $postsModel->getArchived();
            $data['site_archives'] = $archived;
            $categories = $categoriesModel->getData('', 'cg_name', 5, 0);
            $data['site_categories'] = $categories;
            $pageLinks = $pagesModel->getLinks();
            $data['site_links'] = $pageLinks;
            $data['page'] = $page[0];

            return view('themes/' . $data['site-theme'] . '/page', $data);
        } else {
            return view('unauthorized_access');
        }
    }

    public function post($id = "")
    {
        $pagesModel = new PagesModel();
        $postsModel = new PostsModel();
        $categoriesModel = new CategoriesModel();
        $data = $this->loadSettings();
        $post = $postsModel->getDataById($id);
        if (sizeof($post) == 1) {
            $archived = $postsModel->getArchived();
            $data['site_archives'] = $archived;
            $categories = $categoriesModel->getData('', 'cg_name', 5, 0);
            $data['site_categories'] = $categories;
            $pageLinks = $pagesModel->getLinks();
            $data['site_links'] = $pageLinks;
            $data['post'] = $post[0];

            return view('themes/' . $data['site-theme'] . '/post', $data);
        } else {
            return view('unauthorized_access');
        }
    }

    private function loadSettings()
    {
        $settingsModel = new SettingsModel();
        $data = null;
        $siteConfig = $settingsModel->getDataByName('site-config');
        if (sizeof($siteConfig) > 0) {
            $json = json_decode($siteConfig[0]->setting_value);
            $data = [
                'site-theme' => strtolower($json->site_theme),
                'site_name' => $json->site_name,
                'site_desc' => $json->site_desc,
                'site_isblog' => $json->site_isblog,
            ];
        } else {
            $data = [
                'site-theme' => 'default',
                'site_name' => SITE_NAME,
                'site_desc' => 'Content Management System',
                'site_isblog' => false,
            ];
        }
        return $data;
    }
}
