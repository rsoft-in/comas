<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommentsModel;
use App\Models\PagesModel;
use App\Models\PostsModel;
use App\Models\UsersModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url() . '/' . index_page() . '/admin/login');
        }
        $session_user = $_SESSION['user_fullname'];

        $params = [
            'page_title' => lang('Default.dashboard'),
            'menu_id' => 'dashboard',
            'user_name' => $session_user
        ];
        $pagesModel = new PagesModel();
        $pageCount = $pagesModel->builder()->countAllResults();
        $params['page_count'] = $pageCount;

        $postsModel = new PostsModel();
        $postCount = $postsModel->builder()->countAllResults();
        $params['post_count'] = $postCount;

        $usersModel = new UsersModel();
        $userCount = $usersModel->builder()->countAllResults();
        $params['user_count'] = $userCount;

        $commentsModel = new CommentsModel();
        $commentCount = $commentsModel->builder()->where(['cmt_published' => 0])->countAllResults();
        $params['comment_count'] = $commentCount;

        return view('admin/admin_home', $params);
    }
}
