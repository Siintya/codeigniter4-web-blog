<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $validation;
    function __construct()
    {
        $this->userModel = new UserModel();
        $this->validation = \Config\Services::validation();
    }
    public function login()
    {
        $data['title'] = 'Login';
        if($this->request->getPost()){
            $rules = [
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Username harus diisi!'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password harus diisi!'
                    ]
                ]
            ];
            if (!$this->validate($rules)) {
                session()->setFlashdata("warning", $this->validation->getErrors());
                return redirect();
            }

            // get input value 
            $username    = $this->request->getVar('username');
            $password    = $this->request->getVar('password');
            $remember_me = $this->request->getVar('remember_me');

            $dataAccount = $this->userModel->getData($username);
            // var_dump($dataAccount);

            // validasi
            if($dataAccount){
                if (password_verify($password, $dataAccount['password'])) {
                    return redirect()->to('admin/index');
                }else{
                    $err[] = "Password Salah! Silahkan coba lagi.";
                    session()->setFlashdata('username', $username);
                    session()->setFlashdata('warning', $err);
                    return redirect()->to("auth/login");
                }
            }else{
                $err[] = "Username Salah! Silakan coba lagi";
                session()->setFlashdata('warning', $err);
                return redirect()->to("auth/login");
            }
        }
        return view('auth/login', $data);
    }
    public function attemptLogin()
    {
        // Custom logic for attempting login
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('auth/login');
    }
}
