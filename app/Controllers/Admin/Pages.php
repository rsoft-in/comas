<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PagesModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Libraries\Utility;

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
            'page_title' => lang('Default.pages'),
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
        $html = $this->request->getPost('ed');
        $json = json_decode($post);
        $today = new Time('now');
        $pagesModel = new PagesModel();
        $utility = new Utility();
        $data = [
            'page_id' => $utility->guid(),
            'page_title' => $json->p_title,
            'page_content' => $html,
            'page_url_slug' => $json->p_urlslug,
            'page_order' => $json->p_order,
            'page_feat_image' => $json->p_fimage,
            'page_published' => $json->p_published,
            'page_author_id' => 'admin',
            'page_cg_id' => $json->p_cgid ?? '',
            'page_modified' => $today->toDateTimeString()
        ];
        $pagesModel->addPages($data);
        echo 'SUCCESS';
    }
    public function updatePages()
    {
        $post = $this->request->getPost('postdata');
        $html = $this->request->getPost('ed');
        $json = json_decode($post);
        $today = new Time('now');
        $pagesModel = new PagesModel;
        $data = [
            'page_id' => $json->p_id,
            'page_title' => $json->p_title,
            'page_content' => $html,
            'page_url_slug' => $json->p_urlslug,
            'page_order' => $json->p_order,
            'page_feat_image' => $json->p_fimage,
            'page_published' => $json->p_published,
            'page_author_id' => 'admin',
            'page_cg_id' => $json->p_cgid,
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
