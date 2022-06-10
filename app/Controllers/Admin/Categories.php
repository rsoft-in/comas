<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriesModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Utility;

class Categories extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }

    public function index()
    {
        $params = [
            'page_title' => lang('Default.Category'),
            'menu_id' => 'categories'
        ];
        return view('admin/admin_categories', $params);
    }

    public function getcategories()
    {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $categoriesModel = new CategoriesModel();
        $filt = "";

        $data['categories'] = $categoriesModel->getcategories($filt, $postdata->sort, $postdata->ps, $postdata->pn * $postdata->ps);
        $data['records'] = $categoriesModel->getcategoriesCount($filt);
        return $this->respond($data);
    }

    public function addcategories()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $categoriesModel = new CategoriesModel();
        $utility = new Utility();
        $data = [
            'cg_id' => $utility->guid(),
            'cg_name' => $json->cg_name,
            'cg_desc' => $json->cg_desc,
            'cg_modified' => $today->toDateTimeString()
        ];
        $categoriesModel->addcategories($data);
        echo 'SUCCESS';
    }
    public function updatecategories()
    {
        $post = $this->request->getPost('postdata');
        $html = $this->request->getPost('ed');
        $json = json_decode($post);
        $today = new Time('now');
        $categoriesModel = new CategoriesModel;
        $data = [
             'cg_id' =>  $json->cg_id,
            'cg_name' => $json->cg_name,
            'cg_desc' => $json->cg_desc,
            'cg_modified' => $today->toDateTimeString()
        ];
        $categoriesModel->updatecategories($data);
        echo 'SUCCESS';
    }
    public function deletecategories()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $categoriesModel = new CategoriesModel;
        $categoriesModel->deletecategories($json->cg_id);
        echo 'SUCCESS';
    }
}
