<?php

namespace App\Models;

use CodeIgniter\Model;

class PostsModel extends Model
{

    protected $table = 'posts';
    protected $primaryKey = 'post_id';

    public function getData($filter, $sortBy, $pageNo, $pageSize)
    {
        $result = $this->builder()->select('*')
            ->where('(1=1) ' . $filter)
            ->orderBy($sortBy)
            ->limit($pageNo, $pageSize)
            ->get()->getResult();
        return $result;
    }
    public function getDataCount($filter)
    {
        $result = $this->builder()->select('*')
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
        $this->builder()->where('post_id', $data['post_id'])->update($data);
    }
    public function deleteData($post_id)
    {
        $this->builder()->where('post_id', $post_id)->delete();
    }
}
