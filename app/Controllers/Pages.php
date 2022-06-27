<?php

namespace App\Controllers;

use App\Controllers\PublicSiteController;
use App\Models\CategoriesModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\PagesModel;
use App\Models\PostsModel;
use App\Models\SettingsModel;

class Pages extends PublicSiteController
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
                $postsPopular = $postsModel->getData(['post_published' => 1], 'post_visited DESC, post_modified DESC', 2, 0);
                $data['site_posts_popular'] = $postsPopular;
                $postsRecent = $postsModel->getData(['post_published' => 1], 'post_modified DESC', 10, 0);
                $data['site_posts_recent'] = $postsRecent;
                $archived = $postsModel->getArchived();
                $data['site_archives'] = $archived;
                $categories = $categoriesModel->getData([], 'cg_name', 5, 0);
                $data['site_categories'] = $categories;
                $pageLinks = $pagesModel->getLinks();
                $data['site_links'] = $pageLinks;

                return view('themes/' . $data['site-theme'] . '/home', $data);
            } else {
                // site_static_page
                $page = $pagesModel->gePageByUrlSlug($data['site_static_page']);
                if (sizeof($page) == 1) {
                    $archived = $postsModel->getArchived();
                    $data['site_archives'] = $archived;
                    $categories = $categoriesModel->getData([], 'cg_name', 5, 0);
                    $data['site_categories'] = $categories;
                    $pageLinks = $pagesModel->getLinks();
                    $data['site_links'] = $pageLinks;
                    $data['page'] = $page[0];

                    return view('themes/' . $data['site-theme'] . '/home', $data);
                }
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
            $categories = $categoriesModel->getData([], 'cg_name', 5, 0);
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
            $categories = $categoriesModel->getData([], 'cg_name', 5, 0);
            $data['site_categories'] = $categories;
            $pageLinks = $pagesModel->getLinks();
            $data['site_links'] = $pageLinks;
            $data['post'] = $post[0];

            return view('themes/' . $data['site-theme'] . '/post', $data);
        } else {
            return view('unauthorized_access');
        }
    }

    public function posts($pageNr = 1)
    {
        $pagesModel = new PagesModel();
        $postsModel = new PostsModel();
        $categoriesModel = new CategoriesModel();
        $data = $this->loadSettings();
        $posts = $postsModel->getData(['post_published' => 1], 'post_modified DESC', PAGE_SIZE, ($pageNr - 1) * PAGE_SIZE);
        $archived = $postsModel->getArchived();
        $data['site_archives'] = $archived;
        $categories = $categoriesModel->getData([], 'cg_name', 5, 0);
        $data['site_categories'] = $categories;
        $pageLinks = $pagesModel->getLinks();
        $data['site_links'] = $pageLinks;
        $data['posts'] = $posts;
        $data['current_page'] = $pageNr;
        $data["next_page"] = (sizeof($posts) == 30 ? $pageNr + 1 : $pageNr);

        return view('themes/' . $data['site-theme'] . '/posts', $data);
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
                'site_keywords' => $json->site_keywords,
                'site_isblog' => $json->site_isblog,
                'site_show_categories' => $json->site_show_categories,
                'site_show_archive' => $json->site_show_archive,
                'site_static_page' => $json->site_static_page,
                'site_show_social_links' => $json->site_show_social_links,
                'site_social_fb_url' => $json->site_social_fb_url,
                'site_social_ig_url' => $json->site_social_ig_url,
                'site_social_tw_url' => $json->site_social_tw_url,
                'site_static_page' => $json->site_static_page,
                'site_contact_email' => $json->site_contact_email,
                'site_contact_phone' => $json->site_contact_phone,
                'site_contact_mobile' => $json->site_contact_mobile
            ];
        } else {
            $data = [
                'site-theme' => 'default',
                'site_name' => SITE_NAME,
                'site_desc' => 'Content Management System',
                'site_keywords' => 'cms,blog,website,media',
                'site_isblog' => false,
                'site_show_categories' => false,
                'site_show_archive' => false,
                'site_static_page' => '',
                'site_show_social_links' => false,
                'site_social_fb_url' => '',
                'site_social_ig_url' => '',
                'site_social_tw_url' => '',
                'site_static_page' => '',
                'site_contact_email' => '',
                'site_contact_phone' => '',
                'site_contact_mobile' => ''
            ];
        }
        return $data;
    }
}
