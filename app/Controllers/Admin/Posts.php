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
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url() . '/' . index_page() . '/admin/login');
        }

        $params = [
            'page_title' => lang('Default.posts'),
            'menu_id' => 'posts'
        ];
        if ($_SESSION['user_level'] >= 1)
            return view('admin/admin_posts', $params);
        else
            return view('unauthorized_access');
    }

    public function getPosts()
    {
        $post = json_decode($this->request->getPost('postdata'));
        $postsModel = new PostsModel();
        $filt = [];
        if (isset($post->qry)) {
            $filt = "post_title LIKE '%" . $post->qry . "%' OR post_content LIKE '%" . $post->qry . "%' OR post_tags LIKE '%" . $post->qry . "%'";
        }
        $data['posts'] = $postsModel->getData($filt, $post->sort, PAGE_SIZE, $post->pn * PAGE_SIZE);
        $data['records'] = $postsModel->getDataCount($filt);
        return $this->respond($data);
    }

    public function update()
    {
        $session = session();
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $html = $this->request->getPost('ed');
        $today = new Time('now');
        $postsModel = new PostsModel();
        $utility = new Utility();

        $data = [
            'post_id' => empty($json->p_id) ? $utility->guid() : $json->p_id,
            'post_title' => $json->p_title,
            'post_content' => $html,
            'post_published' => $json->p_published,
            'post_feature_img' => $json->p_fimage,
            'post_cg_id' => $json->p_cgid,
            'post_tags' => $json->p_tags,
            'post_author_id' => $_SESSION['user_id'],
            'post_modified' => $today->toDateTimeString()
        ];
        if (empty($json->p_id)) {
            $postsModel->builder()->insert($data);
        } else {
            $postsModel->builder()
                ->where('post_id', $json->p_id)->update($data);
        }
        if ($postsModel->db->affectedRows() > 0)
            echo 'SUCCESS';
        else
            echo 'FAILED';
    }

    public function delete()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $postsModel = new PostsModel;
        $postsModel->deleteData($json->id);
        echo 'SUCCESS';
    }
}
