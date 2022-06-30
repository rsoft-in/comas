<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CommentsModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Utility;

class Comments extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url() . '/' . index_page() . '/admin/login');
        }

        $params = [
            'page_title' => lang('Default.comments'),
            'menu_id' => 'comments'
        ];
        return view('admin/admin_categories', $params);
    }

    public function getComments()
    {
        $post = json_decode($this->request->getPost('postdata'));
        // $postdata = json_decode($post);
        $commentsModel = new CommentsModel();
        $filter = [];
        if (isset($post->qry)) {
            $filter['cmt_post_id'] = $post->qry;
        } else {
            return;
        }
        $data['comments'] = $commentsModel->getData($filter, $post->sort, PAGE_SIZE, $post->pn * PAGE_SIZE);
        $data['records'] = $commentsModel->getDataCount($filter);
        return $this->respond($data);
    }
    
    public function update()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $commentsModel = new CommentsModel();
        $utility = new Utility();

        $data = [
            'cmt_id' => empty($json->id) ? $utility->guid() : $json->id,
            'cmt_post_id' => $json->post_id,
            'cmt_date' => $today->toDateTimeString(),
            'cmt_user_id' => $json->user_id,
            'cmt_text' => $json->text,
            'cmt_published' =>  $json->published
        ];
        if (empty($json->id)) {
            $commentsModel->builder()->insert($data);
        } else {
            $commentsModel->builder()
                ->where('cmt_id', $json->id)->update($data);
        }
        if ($commentsModel->db->affectedRows() > 0)
            echo 'SUCCESS';
        else
            echo 'FAILED';
    }

    public function togglePublish()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $data = [
            'cmt_id' =>  $json->id,
            'cmt_published' =>  $json->val
        ];
        $commentsModel = new CommentsModel;
        $commentsModel->togglePublish($data);
        echo 'SUCCESS';
    }
    
    public function delete()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $commentsModel = new CommentsModel;
        $commentsModel->deleteData($json->id);
        echo 'SUCCESS';
    }
}
