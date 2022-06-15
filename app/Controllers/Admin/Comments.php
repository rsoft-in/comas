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
        $params = [
            'page_title' => lang('Default.comments'),
            'menu_id' => 'comments'
        ];
        return view('admin/admin_categories', $params);
    }

    public function getComments()
    {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $commentsModel = new CommentsModel();
        $filt = "";
        $data['comments'] = $commentsModel->getData($filt, $postdata->sort, PAGE_SIZE, $postdata->pn * PAGE_SIZE);
        $data['records'] = $commentsModel->getDataCount($filt);
        return $this->respond($data);
    }

    public function addComments()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $commentsModel = new CommentsModel();
        $utility = new Utility();
        $data = [
            'cmt_id' => $utility->guid(),
            'cmt_post_id' => $json->post_id,
            'cmt_date' => $today->toDateTimeString(),
            'cmt_user_id' => $json->user_id,
            'cmt_published' =>  $json->published
        ];
        $commentsModel->addData($data);
        echo 'SUCCESS';
    }
    public function updateComments()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $commentsModel = new CommentsModel;
        $data = [
            'cmt_id' =>  $json->id,
            'cmt_post_id' => $json->post_id,
            'cmt_date' =>$today->toDateTimeString(),
            'cmt_user_id' => $json->user_id,
            'cmt_published' =>  $json->published
        ];
        $commentsModel->updateData($data);
        echo 'SUCCESS';
    }
    public function deleteComments()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $commentsModel = new CommentsModel;
        $commentsModel->deleteData($json->id);
        echo 'SUCCESS';
    }
}
