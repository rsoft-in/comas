<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PostsModel;
use CodeIgniter\API\ResponseTrait;

class Posts extends BaseController
{
    use ResponseTrait;

    public function index($post_urlslug = "")
    {

        $params = [
            'page_title' => lang('Default.posts'),
            'menu_id' => 'posts'
        ];
        return view('admin/admin_posts', $params);
    }


}
