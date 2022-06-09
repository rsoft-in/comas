<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\PagesModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;


class Pages extends BaseController
{
    use ResponseTrait;
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }

    public function index()
    {
        $params = [
            'page_title' => lang('App.pages'),
            'menu_id' => 'pages'
        ];
        return view('admin/admin_pages', $params);
    }

    public function getPages()
    {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $pagesModel = new PagesModel();
        $filt = "";
        $data['pages'] = $pagesModel->getPages($filt, $postdata->sort, $postdata->ps, $postdata->pn * $postdata->ps);
        $data['records'] = $pagesModel->getPagesCount($filt);
        return $this->respond($data);
    }

    public function addPages()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $pagesModel = new PagesModel();
        $data = [
            'page_id' => $json->page_id,
            'page_title' => $json->page_title,
            'page_url_slug' => $json->page_url_slug,
            'page_order' => $json->page_order,
            'page_feat_image' => $json->page_feat_image,
            'page_published' => $json->page_published,
            'page_author_id' => $json->page_author_id,
            'page_cg_id' => $json->page_cg_id,
            'page_modified' => $today->toDateTimeString()
        ];
        $pagesModel->addPages($data);
        echo 'SUCCESS';
    }
    public function updatePages()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $pagesModel = new PagesModel;
        $data = [
            'page_id' => $json->page_id,
            'page_title' => $json->page_title,
            'page_url_slug' => $json->page_url_slug,
            'page_order' => $json->page_order,
            'page_feat_image' => $json->page_feat_image,
            'page_published' => $json->page_published,
            'page_author_id' => $json->page_author_id,
            'page_cg_id' => $json->page_cg_id,
            'page_modified' => $today->toDateTimeString()
        ];
        $pagesModel->updatePages($data);
        echo 'SUCCESS';
    }
    public function deletePages()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $pagesModel = new PagesModel;
        $pagesModel->deletePages($json->page_id);
        echo 'SUCCESS';
    }
}
