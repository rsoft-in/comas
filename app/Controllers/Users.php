<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UsersModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Utility;

class Users extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $params = [
            'page_title' => lang('Default.users'),
            'menu_id' => 'users'
        ];
        return view('admin/admin_categories', $params);
    }

    public function getUsers()
    {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $usersModel = new UsersModel();
        $filt = "";
        $data['users'] = $usersModel->getData($filt, $postdata->sort, PAGE_SIZE, $postdata->pn * PAGE_SIZE);
        $data['records'] = $usersModel->getDataCount($filt);
        return $this->respond($data);
    }

    public function addUsers()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $usersModel = new UsersModel();
        $utility = new Utility();
        $data = [
            'user_id' => $utility->guid(),
            'user_name' => $json->p_title,
            'user_fullname' => $json->p_content,
            'user_email' => $json->p_published,
            'user_inactive' => $json->p_cg_id,
            'user_modified' => $today->toDateTimeString()
        ];
        $usersModel->addData($data);
        echo 'SUCCESS';
    }
    public function updateUsers()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $usersModel = new UsersModel;
        $data = [
            'user_id' =>  $json->id,
            'user_name' => $json->p_title,
            'user_fullname' => $json->p_content,
            'user_email' => $json->p_published,
            'user_inactive' => $json->p_cg_id,
            'user_modified' => $today->toDateTimeString()
        ];
        $usersModel->updateData($data);
        echo 'SUCCESS';
    }
    public function deleteUsers()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $usersModel = new UsersModel;
        $usersModel->deleteData($json->id);
        echo 'SUCCESS';
    }
}
