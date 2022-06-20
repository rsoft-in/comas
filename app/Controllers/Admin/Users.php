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

    public function checkUser()
    {
        $encrypter = \Config\Services::encrypter();
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $usersModel = new UsersModel();
        $users = $usersModel->getByUserName($json->user);
        $plainText  = 'This is a plain-text message!';
        $ciphertext = $encrypter->encrypt($plainText);

        // Outputs: This is a plain-text message!
        echo $encrypter->decrypt($ciphertext);
        if (sizeof($users) == 1) {
            $user = $users[0];
            // if ($encrypter->encrypt($json->pwd) == $user->user_pwd)
            //     echo 'true';
            // else echo 'false';
            // var_dump($user);
            // echo $encrypter->decrypt($user->user_pwd);
        } else {
            echo 'Invalid User';
        }
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
        $encrypter = \Config\Services::encrypter();
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $usersModel = new UsersModel();
        $utility = new Utility();
        $data = [
            'user_id' => $utility->guid(),
            'user_name' => $json->u_name,
            'user_pwd' => $encrypter->encrypt($json->u_pwd),
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
        $encrypter = \Config\Services::encrypter();
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $usersModel = new UsersModel;
        $data = [
            'user_id' =>  $json->u_id,
            'user_name' => $json->u_name,

            'user_fullname' => $json->u_fullname,
            'user_email' => $json->u_email,
            'user_inactive' => $json->u_inactive,
            'user_modified' => $today->toDateTimeString()
        ];
        if ($json->pwd_new) {
            $data['user_pwd'] = $encrypter->encrypt($json->u_pwd);
        }
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
