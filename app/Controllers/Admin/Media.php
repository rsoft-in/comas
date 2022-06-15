<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Media extends BaseController
{
    public function index()
    {
        echo 'INVALID REQUEST';
    }

    public function uploadImage()
    {
        helper(['form', 'url']);

        $isValid = $this->validate([
            'userfile' => [
                'uploaded[userfile]',
                'mime_in[userfile, image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[userfile, 4098]',
            ],
        ]);

        if ($isValid) {
            $file = $this->request->getFile('userfile');
            $file->move(WRITEPATH . 'uploads');
            echo $file->getClientName();
        }
    }
}
