<?php

namespace App\Models;

use CodeIgniter\Model;

class PostsModel extends Model
{

    protected $table = 'posts';
    protected $primaryKey = 'post_id';

    public function getData($filter, $sortBy, $pageSize, $offSet)
    {
        $result = $this->builder()->select('posts.*, categories.cg_name, COUNT(comments.cmt_id) as ncomments')
            ->join('categories', 'categories.cg_id = posts.post_cg_id', 'left')
            ->join('comments', 'comments.cmt_post_id = posts.post_id', 'left')
            ->groupBy('posts.post_id')
            ->where($filter)
            ->orderBy($sortBy)
            ->limit($pageSize, $offSet)
            ->get()->getResult();
        return $result;
    }

    public function getDataCount($filter)
    {
        $result = $this->builder()->select('*')
            ->where($filter)
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

    public function getDataById($post_id)
    {
        $result = $this->builder()->select('posts.*, categories.cg_name, COUNT(comments.cmt_id) as ncomments')
            ->join('categories', 'categories.cg_id = posts.post_cg_id', 'left')
            ->join('comments', 'comments.cmt_post_id = posts.post_id', 'left')
            ->groupBy('posts.post_id')
            ->where('post_published = 1')
            ->where('post_id', $post_id)
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

    public function updateVisited($post_id)
    {
        $this->builder()->where('post_id', $post_id)->increment('post_visited');
    }

    public function deleteData($post_id)
    {
        $this->builder()->where('post_id', $post_id)->delete();
    }
}
