<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Session\Session;
use App\Models\UserModel;
use Config\Services;

class Auth extends Controller
{
    protected $validation;
    protected $config;

    /**
     * @var Session
     */
    protected $session;
    protected $userModel;

    public function __construct()
    {
        $this->session      = service('session');
        $this->validation   = Services::validation();
        $this->config       = config('Auth');
        $this->userModel    = new UserModel();
    }

    public function login()
    {
        $data = [
            'title'     => 'Login',
            'config'    => $this->config,
            // 'password'  => password_hash('password123', PASSWORD_DEFAULT),
        ];
        return view('auth/login', $data);
    }

    public function attemptLogin()
    {
        $rules = [
            'username' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Username is required.']
            ],
            'password' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Password is required.']
            ]
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata("error", $this->validator->getErrors());
            return redirect()->back();
        }

        // Get input values
        $login      = $this->request->getVar('username');
        $password   = $this->request->getVar('password');

        // Determine credential type
        $user = $this->userModel->getData($login);
        if (!$user) {
            session()->setFlashdata("error", ['username' => 'Username is wrong! Please try again.']);
            return redirect()->back();
        }

        if (!password_verify($password, $user['password'])) {
            session()->setFlashdata("error", ['password' => 'Password is wrong! Please try again.']);
            return redirect()->back();
        }
        $this->userModel->updatedStatus($user['id'], 'online');
        $userData = [
            'username'      => $user['username'],
            'id'            => $user['id'],
            'isLoggedIn'    => true,
        ];
        $this->session->set('user', $userData);

        if ($this->session->has('user')) {
            return redirect()->to('dashboard');
        }
    }

    public function register()
    {
        $data = ['title' => 'Register'];

        if ($this->request->getPost()) {
            // dd($this->request->getPost());
            $this->validation->setRules([
                'username'   => [
                    'rules'  => 'required',
                    'errors' => ['required' => 'Username is required.']
                ],
                'email'      => [
                    'rules'  => 'required|valid_email',
                    'errors' => [
                        'required'      => 'Email is required.',
                        'valid_email'   => 'Email must be a valid email address.'
                    ]
                ],
                'phone'      => [
                    'rules'  => 'required',
                    'errors' => ['required' => 'Phone number is required.']
                ],
                'address'    => [
                    'rules'  => 'required',
                    'errors' => ['required' => 'Address is required.']
                ],
            ]);

            if (!$this->validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }
            $data = [
                'username'       => $this->request->getPost('username'),
                'fullname'       => null,
                'users_roles_id' => 1,
                'email'          => $this->request->getPost('email'),
                'password'       => password_hash('password123', PASSWORD_DEFAULT),
                'no_telp'        => $this->request->getPost('phone'),
                'address'        => $this->request->getPost('address'),
                'gender'         => $this->request->getPost('gender'),
                'religion'       => null,
                'statuses'       => 'offline',
                'image'          => null,
                'created_at'     => $this->request->getPost('created_at')
            ];
            $created = $this->userModel->create($data);
    
            if ($created) {
                return redirect()->to('login')->with('success', 'Congratulation ! You have been successfully registered, please login in here.');
            } else {
                return redirect()->back()->withInput()->with('error', 'Sorry! you failed to registered.');
            }
        }

        return view('auth/register', $data);
    }
    
    public function logout()
    {
        if ($this->session->has('user') && $this->session->get('user')['isLoggedIn']) {
            $userId = $this->session->get('user')['id'];
            $this->userModel->updatedStatus($userId, 'offline');
            $this->session->destroy();
        }
        
        return redirect()->to(site_url('login'));
    }

    protected function _render(string $view, array $data = [])
    {
        return view($view, $data);
    }
}
