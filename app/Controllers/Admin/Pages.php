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

    public function index()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url() . '/' . index_page() . '/admin/login');
        }

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
        $filt = [];
        $data['pages'] = $pagesModel->getData($filt, $postdata->sort, PAGE_SIZE, $postdata->pn * PAGE_SIZE);
        $data['records'] = $pagesModel->getDataCount($filt);
        return $this->respond($data);
    }
    public function getLinks()
    {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $pagesModel = new PagesModel();


        $pages= $pagesModel->getLinks();

        return $this->respond($pages);
    }
    public function update()
    {
        $session = session();
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $html = $this->request->getPost('ed');
        $today = new Time('now');
        $pagesModel = new PagesModel();
        $utility = new Utility();

        $data = [
            'page_id' => empty($json->p_id) ? $utility->guid() : $json->p_id,
            'page_title' => $json->p_title,
            'page_content' => $html,
            'page_url_slug' => $json->p_urlslug,
            'page_order' => $json->p_order,
            'page_feat_image' => $json->p_fimage,
            'page_published' => $json->p_published,
            'page_author_id' => $_SESSION['user_id'],
            'page_cg_id' => $json->p_cgid ?? '',
            'page_modified' => $today->toDateTimeString()
        ];
        if (empty($json->p_id)) {
            $pagesModel->builder()->insert($data);
        } else {
            $pagesModel->builder()
                ->where('page_id', $json->p_id)->update($data);
        }
        if ($pagesModel->db->affectedRows() > 0)
            echo 'SUCCESS';
        else
            echo 'FAILED';
    }
    public function delete()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $pagesModel = new PagesModel;
        $pagesModel->deleteData($json->id);
        echo 'SUCCESS';
    }
}
