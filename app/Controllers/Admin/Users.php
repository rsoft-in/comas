<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Encrypter;
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
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url() . '/' . index_page() . '/admin/login');
        }

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
        $filt = [];
        $data['users'] = $usersModel->getData($filt, $postdata->sort, PAGE_SIZE, $postdata->pn * PAGE_SIZE);
        $data['records'] = $usersModel->getDataCount($filt);
        return $this->respond($data);
    }

    public function update()
    {
        $encrypter = new Encrypter();
        $post = $this->request->getPost('postdata');
        $about = $this->request->getPost('ed');
        $json = json_decode($post);
        $today = new Time('now');
        $usersModel = new UsersModel();
        $utility = new Utility();

        $data = [
            'user_id' => empty($json->u_id) ? $utility->guid() : $json->u_id,
            'user_name' => $json->u_name,
            'user_pwd' => $encrypter->encrypt($json->u_pwd),
            'user_fullname' => $json->u_fullname,
            'user_email' => $json->u_email,
            'user_about' => $about,
            'user_inactive' => $json->u_inactive,
            'user_modified' => $today->toDateTimeString()
        ];
        if (empty($json->u_id)) {
            $usersModel->builder()->insert($data);
        } else {
            $usersModel->builder()
                ->where('user_id', $json->u_id)->update($data);
        }
        if ($usersModel->db->affectedRows() > 0)
            echo 'SUCCESS';
        else
            echo 'FAILED';
    }

    public function delete()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $usersModel = new UsersModel;
        $usersModel->deleteData($json->id);
        echo 'SUCCESS';
    }
}
