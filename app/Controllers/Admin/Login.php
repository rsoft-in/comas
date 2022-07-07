<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Controllers\PublicSiteController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Encrypter;
use App\Models\UsersModel;
use CodeIgniter\Cookie\Cookie;
use DateTime;

class Login extends PublicSiteController
{
    use ResponseTrait;

    public function index()
    {
        $session = session();
        if ($session->has('comas_logged')) {
            return redirect()->to(base_url() . '/admin/dashboard');
        }

        $params = [
            'page_title' => lang('Default.login'),
            'menu_id' => 'login'
        ];
        $cookie = explode(",", get_cookie('comas_user'));
        if (isset($cookie)) {
            $params['user'] = $cookie;
        } else {
            $params['user'] = ['', ''];
        }
        return view('admin/admin_login', $params);
    }

    public function checkUser()
    {
        $post = json_decode($this->request->getPost('postdata'));
        $encrypter = new Encrypter();
        $usersModel = new UsersModel();
        $session = session();
        $users = $usersModel->getByUserName($post->user);

        if (sizeof($users) == 1) {
            $user = $users[0];
            if (
                $encrypter->encrypt($post->pwd) == $user->user_pwd
                && $user->user_inactive == 0
            ) {
                $sessionData = [
                    'comas_logged' => true,
                    'user_id' => $user->user_id,
                    'user_name' => $user->user_name,
                    'user_fullname' => $user->user_fullname,
                    'user_level' => $user->user_level
                ];
                $session->set($sessionData);
                if ($post->rem)
                    set_cookie('comas_user', $post->user . "," . $post->pwd, 2592000);
                else
                    delete_cookie('comas_user');

                echo 'true';
            } else echo 'false';
        } else {
            echo 'Invalid User';
        }
    }

    public function signout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url() . '/admin/login');
    }
}
