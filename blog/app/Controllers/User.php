<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userLogin  = $this->session->get('user');
        $data   = [
            'title'      => 'Profile',
            'currentUrl' => service('uri')->getPath(),
            'userLogin'  => $this->userModel->getById($userLogin['id'])
        ];
        return view('auth/profile/index', $data);
    }

    public function update()
    {  
        $userLogin   = $this->session->get('user');
        $currentData = $this->userModel->getById($userLogin['id']);
        $imageFile   = $this->request->getFile('image');
        $imageData   = null;
    
        if ($imageFile && $imageFile->isValid() && $imageFile->getSize() > 0) {
            // Baca data gambar jika ada file yang diupload
            $imageData = file_get_contents($imageFile->getTempName());
        } else {
            // Gunakan data gambar lama jika tidak ada file yang diupload
            $imageData = $currentData['image'];
        }
        $newData = [
            'username' => $this->request->getPost('username'),
            'fullname' => $this->request->getPost('fullname'),
            'email'    => $this->request->getPost('email'),
            'no_telp'  => $this->request->getPost('no_telp'),
            'address'  => $this->request->getPost('address'),
            'gender'   => $this->request->getPost('gender'),
            'religion' => $this->request->getPost('religion'),
            'image'    => $imageData
        ];
        // Check for changes in each field
        $isChanged = false;
        foreach ($newData as $key => $value) {
            if ($currentData[$key] != $value) {
                $isChanged = true;
                break;
            }
        }

        if (!$isChanged) {
            // No changes made, notify user
            return redirect()->back()->with('info', 'No changes were made.');
        }
        // update data user
        $newData['updated_at'] = date('Y-m-d H:i:s');
        
        $updated = $this->userModel->updated($userLogin['id'], $newData);
        if ($updated) {
            return redirect()->back()->with('success', 'Profile updated successfully!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update profile');
        }
    }
}
