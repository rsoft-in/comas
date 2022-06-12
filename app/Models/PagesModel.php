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
            ->where('(1=1) ' . $filter)
            ->orderBy($sortBy)
            ->limit($pageNo, $pageSize)
            ->get()->getResult();
        return $result;
    }
    public function getDataCount($filter)
    {
        $result = $this->builder()->select('pages.*')
            ->where('(1=1) ' . $filter)
            ->countAllResults();
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
