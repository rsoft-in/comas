<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostsModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Utility;

class Posts extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $params = [
            'page_title' => lang('Default.Posts'),
            'menu_id' => 'posts'
        ];
        return view('admin/admin_categories', $params);
    }

    public function getPosts()
    {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $postsModel = new PostsModel();
        $filt = "";
        $data['posts'] = $postsModel->getData($filt, $postdata->sort, PAGE_SIZE, $postdata->pn * PAGE_SIZE);
        $data['records'] = $postsModel->getDataCount($filt);
        return $this->respond($data);
    }

    public function addPost()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $postsModel = new PostsModel();
        $utility = new Utility();
        $data = [
            'post_id' => $utility->guid(),
            'post_title' => $json->p_title,
            'post_content' => $json->p_content,
            'post_published' => $json->p_published,
            'post_cg_id' => $json->p_cg_id,
            'post_author_id' => $json->p_author_id,
            'post_modified' => $today->toDateTimeString()
        ];
        $postsModel->addData($data);
        echo 'SUCCESS';
    }
    public function updatePost()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $postsModel = new PostsModel;
        $data = [
            'post_id' =>  $json->id,
            'post_title' => $json->p_title,
            'post_content' => $json->p_content,
            'post_published' => $json->p_published,
            'post_cg_id' => $json->p_cg_id,
            'post_author_id' => $json->p_author_id,
            'post_modified' => $today->toDateTimeString()
        ];
        $postsModel->updateData($data);
        echo 'SUCCESS';
    }
    public function deletePost()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $postsModel = new PostsModel;
        $postsModel->deleteData($json->id);
        echo 'SUCCESS';
    }
}
