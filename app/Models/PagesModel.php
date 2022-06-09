<?php

namespace App\Models;

use CodeIgniter\Model;

class PagesModel extends Model
{

    protected $table = 'pages';
    protected $primaryKey = 'page_id';

    public function getPages($filter, $sortBy, $pageNo, $pageSize)
    {
        $result = $this->builder()->select('*')
            ->where('(1=1) ' . $filter)
            ->orderBy($sortBy)
            ->limit($pageNo, $pageSize)
            ->get()->getResult();
        return $result;
    }
    public function getPagesCount($filter)
    {
        $result = $this->builder()->select('pages.*')
            ->where('(1=1) ' . $filter)           
            ->countAllResults();
        return $result;
    }

    public function addPages($data)
    {
        $this->builder()->insert($data);
    }
    public function updatePages($data)
    {
        $this->builder()->where('page_id', $data['page_id'])->update($data);
    }
    public function deletePages($page_id)
    {
        $this->builder()->where('page_id', $page_id)->delete();
    }
}
