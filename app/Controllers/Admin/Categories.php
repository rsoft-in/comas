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

    public function index()
    {
        $params = [
            'page_title' => lang('Default.categories'),
            'menu_id' => 'categories'
        ];
        return view('admin/admin_categories', $params);
    }

    public function getCategories()
    {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $categoriesModel = new CategoriesModel();
        $filt = [];
        $data['categories'] = $categoriesModel->getData($filt, $postdata->sort, PAGE_SIZE, $postdata->pn * PAGE_SIZE);
        $data['records'] = $categoriesModel->getDataCount($filt);
        return $this->respond($data);
    }

    public function addCategory()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $categoriesModel = new CategoriesModel();
        $utility = new Utility();
        $data = [
            'cg_id' => $utility->guid(),
            'cg_name' => $json->name,
            'cg_desc' => $json->desc,
            'cg_modified' => $today->toDateTimeString()
        ];
        $categoriesModel->addData($data);
        echo 'SUCCESS';
    }
    public function updateCategory()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $categoriesModel = new CategoriesModel;
        $data = [
            'cg_id' =>  $json->id,
            'cg_name' => $json->name,
            'cg_desc' => $json->desc,
            'cg_modified' => $today->toDateTimeString()
        ];
        $categoriesModel->updateData($data);
        echo 'SUCCESS';
    }
    public function deleteCategory()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $categoriesModel = new CategoriesModel;
        $categoriesModel->deleteData($json->id);
        echo 'SUCCESS';
    }
}
