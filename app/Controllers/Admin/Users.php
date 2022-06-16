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
        return view('admin/admin_users', $params);
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

    public function addUser()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $usersModel = new UsersModel();
        $utility = new Utility();
        $data = [
            'user_id' => $utility->guid(),
            'user_name' => $json->u_name,
            'user_pwd' => $json->u_pwd,
            'user_fullname' => $json->u_fullname,
            'user_email' => $json->u_email,
            'user_inactive' => $json->u_inactive,
            'user_modified' => $today->toDateTimeString()
        ];
        $usersModel->addData($data);
        echo 'SUCCESS';
    }

    public function updateUser()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $usersModel = new UsersModel;
        $data = [
            'user_id' =>  $json->u_id,
            'user_name' => $json->u_name,
            'user_pwd' => $json->u_pwd,
            'user_fullname' => $json->u_fullname,
            'user_email' => $json->u_email,
            'user_inactive' => $json->u_inactive,
            'user_modified' => $today->toDateTimeString()
        ];
        $usersModel->updateData($data);
        echo 'SUCCESS';
    }

    public function deleteUser()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $usersModel = new UsersModel;
        $usersModel->deleteData($json->id);
        echo 'SUCCESS';
    }
}