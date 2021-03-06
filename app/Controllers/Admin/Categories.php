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
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url() . '/' . index_page() . '/admin/login');
        }

        $params = [
            'page_title' => lang('Default.categories'),
            'menu_id' => 'categories'
        ];
        if ($_SESSION['user_level'] >= 3)
            return view('admin/admin_categories', $params);
        else
            return view('unauthorized_access');
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

    public function update()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $categoriesModel = new CategoriesModel();
        $utility = new Utility();

        $data = [
            'cg_id' => empty($json->id) ? $utility->guid() : $json->id,
            'cg_name' => $json->name,
            'cg_desc' => $json->desc,
            'cg_modified' => $today->toDateTimeString()
        ];
        if (empty($json->id)) {
            $categoriesModel->builder()->insert($data);
        } else {
            $categoriesModel->builder()
                ->where('cg_id', $json->id)->update($data);
        }
        if ($categoriesModel->db->affectedRows() > 0)
            echo 'SUCCESS';
        else
            echo 'FAILED';
    }

    public function delete()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $categoriesModel = new CategoriesModel;
        $categoriesModel->deleteData($json->id);
        echo 'SUCCESS';
    }
}
