<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{

    protected $table = 'users';
    protected $primaryKey = 'user_id';

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
    public function getByUserName($user_name)
    {
        $result = $this->builder()->select('*')
            ->where('user_name', $user_name)
            ->get()->getResult();
        return $result;
    }

    public function addData($data)
    {
        $this->builder()->insert($data);
    }
    public function updateData($data)
    {
        $this->builder()->where('user_id', $data['user_id'])->update($data);
    }
    public function deleteData($user_id)
    {
        $this->builder()->where('user_id', $user_id)->delete();
    }
}
