<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Utility;
use App\Models\GalleryModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Gallery extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to(base_url() . '/' . index_page() . '/admin/login');
        }
        $params = [
            'page_title' => lang('Default.gallery'),
            'menu_id' => 'gallery'
        ];
        if ($_SESSION['user_level'] >= 1)
            return view('admin/admin_gallery', $params);
        else
            return view('unauthorized_access');
    }

    public function get()
    {
        $post = $this->request->getPost('postdata');
        $postdata = json_decode($post);
        $galleryModel = new GalleryModel();
        $filt = [];
        $data['galleries'] = $galleryModel->builder()
            ->select('*')
            ->orderBy('gallery_name')
            ->limit(PAGE_SIZE, $post->pn * PAGE_SIZE)
            ->get()->getResult();
        $data['records'] = $galleryModel->builder()->select('*')->countAllResults();
        return $this->respond($data);
    }

    public function update()
    {
        $post = $this->request->getPost('postdata');
        $json = json_decode($post);
        $today = new Time('now');
        $galleryModel = new GalleryModel();
        $utility = new Utility();

        $data = [
            'gallery_id' => empty($json->id) ? $utility->guid() : $json->id,
            'gallery_name' => $json->name,
            'gallery_desc' => $json->desc,
            'gallery_items' => $json->items,
            'gallery_modified' => $today->toDateTimeString()
        ];
        if (empty($json->id)) {
            $galleryModel->builder()->insert($data);
        } else {
            $galleryModel->builder()
                ->where('gallery_id', $json->id)->update($data);
        }
        if ($galleryModel->db->affectedRows() > 0)
            echo 'SUCCESS';
        else
            echo 'FAILED';
    }

    public function delete() {
        $post = json_decode($this->request->getPost('postdata'));
        $galleryModel = new GalleryModel();
        $gallery = $galleryModel->builder()
            ->select('*')
            ->where('gallery_id', $post->id)
            ->get()->getResult();
        $images = json_decode($gallery[0]->gallery_items);
        foreach($images as $image) {
            unlink(WRITEPATH . 'uploads/gallery/' . $image->image);
        }
        $galleryModel->builder()->where('gallery_id', $post->id)->delete();
        if ($galleryModel->db->affectedRows() > 0)
            echo 'SUCCESS';
        else
            echo 'FAILED';
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

    public function uploadGallery()
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
            $file_name = 'gallery' . $now->toLocalizedString('yyyyMMddHHmmss') . '.' . $file->getClientExtension();
            $file->move(WRITEPATH . 'uploads/gallery', $file_name);
            $image->withFile(WRITEPATH . 'uploads/gallery/' . $file_name)
                ->withResource()
                ->save(WRITEPATH . 'uploads/gallery/' . $file_name, 60);
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
                'max_size[userfile, 1024]',
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

    public function logoUpload()
    {
        $image = \Config\Services::image();
        $now = new Time();
        $isValid = $this->validate([
            'userfile' => [
                'uploaded[userfile]',
                'mime_in[userfile, image/jpg,image/jpeg,image/gif,image/png]',
                'max_size[userfile, 1024]',
            ],
        ]);
        if ($isValid) {
            $file = $this->request->getFile('userfile');
            $file_name = 'logo.' . $file->getClientExtension();
            $file->move(WRITEPATH . 'uploads', $file_name, true);
            $image->withFile(WRITEPATH . 'uploads/' . $file_name)
                ->fit(100, 100, 'center')
                ->save(WRITEPATH . 'uploads/' . 'logo.' . $file->getClientExtension());
            echo $file_name;
        }
    }
}
