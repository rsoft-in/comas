<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{

    protected $table = 'settings';
    protected $primaryKey = 'setting_name';

    public function getDataByName($setting_name)
    {
        $result = $this->builder()->select('*')
            ->where('setting_name', $setting_name)
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
