<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{

    protected $table = 'settings';
    protected $primaryKey = 'setting_name';

    public function getData($filter, $sortBy, $pageNo, $pageSize)
    {
        $result = $this->builder()->select('*')
            ->where('(1=1) ' . $filter)
            ->orderBy($sortBy)
            ->limit($pageNo, $pageSize)
            ->get()->getResult();
        return $result;
    }
   

    public function addData($data)
    {
        $this->builder()->insert($data);
    }
    public function updateData($data)
    {
        $this->builder()->where('setting_name', $data['setting_name'])->update($data);
    }
   
}
