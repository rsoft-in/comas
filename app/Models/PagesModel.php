<?php

namespace App\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{

    protected $table = 'pages';
    protected $primaryKey = 'page_id';

    public function getData($filter, $sortBy, $pageNo, $pageSize)
    {
        $result = $this->builder()->select('pages.*, categories.cg_name')
            ->join('categories', 'categories.cg_id = pages.page_cg_id', 'left')
            ->where($filter)
            ->orderBy($sortBy)
            ->limit($pageNo, $pageSize)
            ->get()->getResult();
        return $result;
    }
    public function getDataCount($filter)
    {
        $result = $this->builder()->select('pages.*')
            ->where($filter)
            ->countAllResults();
        return $result;
    }
    public function getLinks()
    {
        $result = $this->builder()->select('page_id, page_title, page_url_slug')
            ->where('page_published = 1 ')
            ->orderBy('page_order')
            ->get()->getResult();
        return $result;
    }

    public function gePageByUrlSlug($page_url_slug)
    {
        $result = $this->builder()->select('pages.*, categories.cg_name')
            ->join('categories', 'categories.cg_id = pages.page_cg_id', 'left')
            ->where('page_published = 1')
            ->where('page_url_slug', $page_url_slug)
            ->get()->getResult();
        return $result;
    }

    public function addData($data)
    {
        $this->builder()->insert($data);
    }
    public function updateData($data)
    {
        $this->builder()->where('page_id', $data['page_id'])->update($data);
    }
    public function deleteData($page_id)
    {
        $this->builder()->where('page_id', $page_id)->delete();
    }
}
