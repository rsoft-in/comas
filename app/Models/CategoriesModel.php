<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriesModel extends Model
{

    protected $table = 'categories';
    protected $primaryKey = 'cg_id';

    public function getCategories($filter, $sortBy, $pageNo, $pageSize)
    {
        $result = $this->builder()->select('*')
            ->where('(1=1) ' . $filter)
            ->orderBy($sortBy)
            ->limit($pageNo, $pageSize)
            ->get()->getResult();
        return $result;
    }
    public function getCategoriesCount($filter)
    {
        $result = $this->builder()->select('*')
            ->where('(1=1) ' . $filter)           
            ->countAllResults();
        return $result;
    }

    public function addCategories($data)
    {
        $this->builder()->insert($data);
    }
    public function updateCategories($data)
    {
        $this->builder()->where('cg_id', $data['cg_id'])->update($data);
    }
    public function deleteCategories($cg_id)
    {
        $this->builder()->where('cg_id', $cg_id)->delete();
    }
}
