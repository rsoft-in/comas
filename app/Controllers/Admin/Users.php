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
        if ($_SESSION['user_level'] >= 3)
            return view('admin/admin_users', $params);
        else
            return view('unauthorized_access');
    }

    public function getUsers()
    {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $encrypter = new Encrypter();
        $usersModel = new UsersModel();
        $filt = [];
        $data['users'] = $usersModel->getData($filt, $postdata->sort, PAGE_SIZE, $postdata->pn * PAGE_SIZE);
        $data['records'] = $usersModel->getDataCount($filt);
        for ($i=0; $i < sizeof($data['users']); $i++) { 
            $data['users'][$i]->user_pwd = $encrypter->decrypt($data['users'][$i]->user_pwd);
        }
        return $this->respond($data);
    }

    public function update()
    {
        $encrypter = new Encrypter();
        $post = json_decode($this->request->getPost('postdata'));
        $about = $this->request->getPost('ed');
        $today = new Time('now');
        $usersModel = new UsersModel();
        $utility = new Utility();

        $data = [
            'user_id' => empty($post->u_id) ? $utility->guid() : $post->u_id,
            'user_name' => $post->u_name,
            'user_pwd' => $encrypter->encrypt($post->u_pwd),
            'user_fullname' => $post->u_fullname,
            'user_image' => $post->u_image,
            'user_email' => $post->u_email,
            'user_about' => $about,
            'user_level' => $post->u_level,
            'user_inactive' => $post->u_inactive,
            'user_modified' => $today->toDateTimeString()
        ];
        if (empty($post->u_id)) {
            $usersModel->builder()->insert($data);
        } else {
            $usersModel->builder()
                ->where('user_id', $post->u_id)->update($data);
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
