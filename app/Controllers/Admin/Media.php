<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class Media extends BaseController
{
    public function index()
    {
        echo 'INVALID REQUEST';
    }

    public function uploadImage()
    {
        $isValid = $this->validate([
            'userfile' => [
                'uploaded[userfile]',
                'mime_in[userfile, image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[userfile, 1024]',
            ],
        ]);
        $image = \Config\Services::image();
        $now = new Time();
        if ($isValid) {
            $file = $this->request->getFile('userfile');
            $file_name = 'post' . $now->toLocalizedString('yyyyMMddHHmm') . '.' . $file->getClientExtension();
            $file->move(WRITEPATH . 'uploads', $file_name);
            $image->withFile(WRITEPATH . 'uploads/' . $file_name)
                ->withResource()
                ->save(WRITEPATH . 'uploads/' . $file_name, 25);
            echo $file_name;
        }
    }

    public function profileImage()
    {
        $image = \Config\Services::image();
        $now = new Time();
        $isValid = $this->validate([
            'userfile' => [
                'uploaded[userfile]',
                'mime_in[userfile, image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[userfile, 4098]',
            ],
        ]);
        if ($isValid) {
            $file = $this->request->getFile('userfile');
            $file_name = 'profile' . $now->toLocalizedString('yyyyMMddHHmm') . '.' . $file->getClientExtension();
            $file->move(WRITEPATH . 'uploads', $file_name, true);
            $image->withFile(WRITEPATH . 'uploads/' . $file_name)
                ->fit(100, 100, 'center')
                ->save(WRITEPATH . 'uploads/' . str_replace('.' . $file->getClientExtension(), '_thumb.' . $file->getClientExtension(), $file_name));
            echo $file_name;
        }
    }
}
