<?php

namespace App\Models;

use CodeIgniter\Model;

class PostsModel extends Model
{

    protected $table = 'posts';
    protected $primaryKey = 'post_id';

    public function getData($filter, $sortBy, $pageSize, $offSet)
    {
        $result = $this->builder()->select('posts.*, categories.cg_name')
            ->join('categories', 'categories.cg_id = posts.post_cg_id', 'left')
            ->where('(1=1) ' . $filter)
            ->orderBy($sortBy)
            ->limit($pageSize, $offSet)
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

    public function getArchived()
    {
        $result = $this->builder()->select('YEAR(post_modified) year, MONTH(post_modified) as month, count(*) as nposts')
            ->groupBy('1,2')
            ->get()->getResult();
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
