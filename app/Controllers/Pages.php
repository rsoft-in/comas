<?php

namespace App\Controllers;

use App\Controllers\PublicSiteController;
use App\Libraries\Utility;
use App\Models\CategoriesModel;
use App\Models\CommentsModel;
use App\Models\GalleryModel;
use CodeIgniter\API\ResponseTrait;
use App\Models\PagesModel;
use App\Models\PostsModel;
use App\Models\SettingsModel;
use App\Models\UsersModel;
use CodeIgniter\I18n\Time;

class Pages extends PublicSiteController
{
    use ResponseTrait;

    public function index()
    {
        $postsModel = new PostsModel();
        $pagesModel = new PagesModel();
        $data = $this->loadSettings();
        if ($data != null) {
            if ($data['site_isblog']) {
                $postsPopular = $postsModel->getData(['post_published' => 1], 'post_visited DESC, post_modified DESC', 5, 0);
                $data['site_posts_popular'] = $postsPopular;
                $postsRecent = $postsModel->getData(['post_published' => 1], 'post_modified DESC', 10, 0);
                $data['site_posts_recent'] = $postsRecent;
                $data['page_title'] = '';

                return view('themes/' . $data['site-theme'] . '/home', $data);
            } else {
                // site_static_page
                $page = $pagesModel->gePageByUrlSlug($data['site_static_page']);
                if (sizeof($page) == 1) {
                    $data['page'] = $page[0];
                    $data['page_title'] = $page[0]->page_title;

                    return view('themes/' . $data['site-theme'] . '/home', $data);
                }
            }
        }

        return;
    }

    public function page($urlSlug = "")
    {
        $pagesModel = new PagesModel();
        $data = $this->loadSettings();
        $page = $pagesModel->gePageByUrlSlug($urlSlug);
        if (sizeof($page) == 1) {
            $data['page'] = $page[0];
            $data['page_title'] = $page[0]->page_title;
            $data['page_gallery'] = [];
            if (strpos($page[0]->page_content, "[GALLERY-") >= 0) {
                $gallery_id = substr($page[0]->page_content, 9, 36);
                $galleryModel = new GalleryModel();
                $gallery = $galleryModel->builder()->select('*')
                    ->where('gallery_id', $gallery_id)
                    ->get()->getResult();
                $data['page_gallery'] = $gallery;
            }

            return view('themes/' . $data['site-theme'] . '/page', $data);
        } else {
            return view('unauthorized_access');
        }
    }

    public function post($id = "")
    {
        $postsModel = new PostsModel();
        $commentsModel = new CommentsModel();
        $data = $this->loadSettings();

        $postsModel->updateVisited($id);

        $post = $postsModel->getDataById($id);
        if (sizeof($post) == 1) {
            $data['post'] = $post[0];
            $data['page_title'] = $post[0]->post_title;
            $comments = $commentsModel->getData([
                'cmt_post_id' => $post[0]->post_id,
                'cmt_published' => 1
            ], 'cmt_date DESC', 100, 0);
            $data['comments'] = $comments;

            return view('themes/' . $data['site-theme'] . '/post', $data);
        } else {
            return view('unauthorized_access');
        }
    }

    public function posts($pageNr = 1)
    {
        $postsModel = new PostsModel();
        $data = $this->loadSettings();

        $posts = $postsModel->getData(['post_published' => 1], 'post_modified DESC', PAGE_SIZE, ($pageNr - 1) * PAGE_SIZE);
        $data['posts'] = $posts;
        $data['page_title'] = 'Recent Posts';
        $data['current_page'] = $pageNr;
        $data["next_page"] = (sizeof($posts) == 30 ? $pageNr + 1 : $pageNr);

        return view('themes/' . $data['site-theme'] . '/posts', $data);
    }

    public function category($cg_id = '', $pageNr = 1)
    {
        $postsModel = new PostsModel();
        $categoriesModel = new CategoriesModel();
        $data = $this->loadSettings();

        $posts = $postsModel->getData(['post_published' => 1, 'post_cg_id' => $cg_id], 'post_modified DESC', PAGE_SIZE, ($pageNr - 1) * PAGE_SIZE);
        $data['posts'] = $posts;

        $curCategory = $categoriesModel->getData(['cg_id' => $cg_id], 'cg_name', 1, 0);
        $data['page_title'] = 'Category ' . $curCategory[0]->cg_name;
        $data['current_page'] = $pageNr;
        $data['current_category'] = $cg_id;
        $data["next_page"] = (sizeof($posts) == 30 ? $pageNr + 1 : $pageNr);

        return view('themes/' . $data['site-theme'] . '/category', $data);
    }

    public function user($user_id = '')
    {
        $postsModel = new PostsModel();
        $usersModel = new UsersModel();
        $data = $this->loadSettings();

        $posts = $postsModel->getData(['post_published' => 1, 'post_author_id' => $user_id], 'post_modified DESC', PAGE_SIZE, 0);
        $data['posts'] = $posts;

        $user = $usersModel->builder()->where(['user_id' => $user_id])->get()->getResult();
        $data['page_title'] = $user[0]->user_fullname;
        $data['user'] = $user[0];

        return view('themes/' . $data['site-theme'] . '/user', $data);
    }

    private function loadSettings()
    {
        $settingsModel = new SettingsModel();
        $postsModel = new PostsModel();
        $categoriesModel = new CategoriesModel();
        $pagesModel = new PagesModel();
        $usersModel = new UsersModel();

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
                'site_logo' => $json->site_logo,
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
                'site_contact_mobile' => $json->site_contact_mobile,
                'site_show_logo_only' => $json->site_show_logo_only,
                'site_show_name_only' => $json->site_show_name_only
            ];
        } else {
            $data = [
                'site-theme' => 'default',
                'site_name' => SITE_NAME,
                'site_desc' => 'Content Management System',
                'site_keywords' => 'cms,blog,website,media',
                'site_isblog' => false,
                'site_logo' => '',
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
                'site_contact_mobile' => '',
                'site_show_logo_only' => false,
                'site_show_name_only' => false
            ];
        }
        $archived = $postsModel->getArchived();
        $data['site_archives'] = $archived;

        $categories = $categoriesModel->getData([], 'cg_name', 5, 0);
        $data['site_categories'] = $categories;

        $pageLinks = $pagesModel->getLinks();
        $data['site_links'] = $pageLinks;

        $users = $usersModel->getData(['user_inactive' => 0, 'user_name !=' => 'admin'], 'user_modified DESC', 5, 0);
        $data['users'] = $users;

        return $data;
    }

    public function addComment()
    {
        $post = json_decode($this->request->getPost('postdata'));
        $comment = $this->request->getPost('ed');
        $today = new Time('now');
        $commentsModel = new CommentsModel();
        $utility = new Utility();
        $settingsModel = new SettingsModel();
        $siteConfig = $settingsModel->getDataByName('site-config');
        $config = json_decode($siteConfig[0]->setting_value);

        $data = [
            'cmt_id' => $utility->guid(),
            'cmt_post_id' => $post->pid,
            'cmt_date' => $today->toDateTimeString(),
            'cmt_user_id' => $post->user,
            'cmt_text' => $comment,
            'cmt_published' => ($config->site_allow_comments_moderation ? 0 : 1)
        ];
        $commentsModel->builder()->insert($data);
        if ($commentsModel->db->affectedRows() > 0)
            echo 'SUCCESS';
        else
            echo 'FAILED';
    }
}
