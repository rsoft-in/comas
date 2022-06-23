<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentsModel extends Model
{

    protected $table = 'comments';
    protected $primaryKey = 'cmt_id';

    public function getData($filter, $sortBy, $pageNo, $pageSize)
    {
        $result = $this->builder()->select('*')
            ->where($filter)
            ->orderBy($sortBy)
            ->limit($pageNo, $pageSize)
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

    public function addData($data)
    {
        $this->builder()->insert($data);
    }
    public function updateData($data)
    {
        $this->builder()->where('cmt_id', $data['cmt_id'])->update($data);
    }
    public function togglePublish($data)
    {
        $this->builder()->where('cmt_id', $data['cmt_id'])->update($data);
    }

    public function deleteData($cmt_id)
    {
        $this->builder()->where('cmt_id', $cmt_id)->delete();
    }
}
