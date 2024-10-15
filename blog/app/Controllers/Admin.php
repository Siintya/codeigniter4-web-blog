<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use App\Models\ArticleModel;
use App\Models\ArticleMediaModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use App\Models\PageModel;

// use App\Config\Log;

class Admin extends BaseController
{
    protected $articleModel;
    protected $articleMediaModel;
    protected $categoryModel;
    protected $tagModel;
    protected $userModel;
    protected $userRoleModel;
    protected $pageModel;
    protected $validation;

    public function __construct()
    {
        $this->articleModel      = new ArticleModel();
        $this->articleMediaModel = new ArticleMediaModel();
        $this->userModel         = new UserModel();
        $this->userRoleModel     = new UserRoleModel();
        $this->tagModel          = new TagModel();
        $this->categoryModel     = new CategoryModel();
        $this->pageModel         = new PageModel();

        $this->validation        = \Config\Services::validation();
    }

    public function index()
    {
        helper('text');
        $userLogin  = $this->session->get('user');
        $data = [
            'title'      => 'Users', 
            'currentUrl' => service('uri')->getPath(),
            'userLogin'  => $this->userModel->getById($userLogin['id'])
        ];
        
        $data['users'] = $this->userModel->getAll();
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        }
    
        return view('admin/users/index', $data);
    }
    
    public function dashboard()
    {
        helper('text');
        $userLogin  = $this->session->get('user');
        $data = [
            'title'            => 'Dashboard',
            'currentUrl'       => service('uri')->getPath(),
            'userLogin'        => $this->userModel->getById($userLogin['id']),
            'total_users'      => $this->userModel->getTotalUsers(),
            'total_articles'   => $this->articleModel->getTotalArticles(),
            'total_categories' => $this->categoryModel->getTotal(),
            'total_tags'       => $this->tagModel->getTotal(),
            'total_media'      => $this->articleMediaModel->getTotalMedia(),
            'online_users'     => $this->userModel->getOnlineUsers(),
            'categories'       => $this->categoryModel->getAll(),
            'tags'             => $this->tagModel->getAll(),
            // 'latest_users'      => $this->userModel->getLatestUsers()
        ];

        $page   = $this->request->getVar('page') ?? 1;
        $limit  = 5;
        $offset = ($page - 1) * $limit;
        // Initialize pagination
        $pager  = \Config\Services::pager();
        $total = $this->articleModel->getArticleCount();

        $data['latests_articles'] = $this->articleModel->getRecents($limit, $offset);
        $data['pager']            = $this->articleModel->pager;
        $data['pager_links']      = $pager->makeLinks($page, $limit, $total, 'pagination');
        // $data['pager_links']      = $pager->links('default_full', 'pagination');
        // dd($data['latests_articles']);
        return view('admin/dashboard', $data);
    }

    public function getUsers()
    {
        if ($this->request->isAJAX()) {
            $users = $this->userModel->getLatestUsers();
            $data = [];

            foreach ($users as $index => $user) {
                $data[] = [
                    'no'            => $index + 1,
                    'username'      => $user['username'],
                    'status'        => $user['status'],
                    'roles'         => $user['roles'],
                    'email'         => $user['email'],
                    'date_created'  => $user['created_at'],
                    'last_modified' => $user['updated_at'],
                    'actions'       => '<div class="text-center">
                                            <a href="'. base_url("users/update/") . $user['id'] .'" class="text-primary me-3">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-id="'. $user['id'] .'">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </div>',
                ];
            }
            return $this->response->setJSON(['data' => $data]);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }
    }

    public function store()
    {
        $this->validation->setRules([
            'username'   => [
                'rules'  => 'required|is_unique[users.username]',
                'errors' => [
                    'required'  => 'Username is required.',
                    'is_unique' => 'Username already exists'
                ]
            ],
            'fullname'   => [
                'rules'  => 'required',
                'errors' => ['required' => 'Fullname is required']
            ],
            'email'      => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'      => 'Email is required',
                    'valid_email'   => 'Email must be a valid email address'
                ]
            ],
            'no_telp'    => [
                'rules'  => 'required',
                'errors' => ['required' => 'No. Telephone is required']
            ],
            'address'    =>  [
                'rules'  => 'required',
                'errors' => ['required' => 'Address is required']
            ],
        ]);
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errorsUser', $this->validation->getErrors());
        }
        if ($this->request->getPost()) {
            // check username
            $roleId = $this->request->getPost('roles');
            $roles  = $this->userRoleModel->getRoles($roleId);
            // dd($roles['id']);
            $data = [
                'username'       => $this->request->getPost('username'),
                'fullname'       => $this->request->getPost('fullname'),
                'users_roles_id' => $roles['id'],
                'password'       => password_hash('password123', PASSWORD_DEFAULT),
                'status'         => 'offline',
                'email'          => $this->request->getPost('email'),
                'no_telp'        => $this->request->getPost('no_telp'),
                'address'        => $this->request->getPost('address'),
                'gender'         => $this->request->getPost('gender'),
                'religion'       => $this->request->getPost('religion'),
                'created_at'     => $this->request->getPost('created_at'),
                'updated_at'     => null
            ];
            // dd($data);

            $inserted = $this->userModel->create($data);
            // dd($inserted);
            if ($inserted) {
                return redirect()->back()->with('success', 'New User with username '.$inserted['username'].' has been saved successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to insert data');
            }
        }
        
    }
  
    public function update($id)
    {
        $userLogin  = $this->session->get('user');
        $data = [
            'title'      => 'Update User',
            'currentUrl' => service('uri')->getPath(),
            'userLogin'  => $this->userModel->getById($userLogin['id']),
            'user'       => $this->userModel->getById($id),
        ];

        if (!$data['user']) {
            return redirect()->back()->with('info','Data not found');
        }
    
        if ($this->request->getPost()) {
            $this->validation->setRules([
                'username'   => [
                    'rules'  => 'required',
                    'errors' => [
                        'required'  => 'Username is required.',
                    ]
                ],
                'fullname'   => [
                    'rules'  => 'required',
                    'errors' => ['required' => 'Fullname is required.']
                ],
                'email'      => [
                    'rules'  => 'required|valid_email',
                    'errors' => [
                        'required'      => 'Email is required.',
                        'valid_email'   => 'Email must be a valid email address.'
                    ]
                ],
                'no_telp'    => [
                    'rules'  => 'required',
                    'errors' => ['required' => 'No.Telpon is required.']
                ],
                'address'    =>  [
                    'rules'  => 'required',
                    'errors' => ['required' => 'Address is required.']
                ],
                'image'      => [
                    'rules'  => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'max_size' => 'The image size must not exceed 1 MB.',
                        'is_image' => 'Please upload a valid image file.',
                        'mime_in'  => 'Only .jpg, .jpeg, and .png files are allowed.',
                    ]
                ],
            ]);

            if (!$this->validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }

            $currentData = $data['user'];
            $imageFile = $this->request->getFile('image');
            $imageData = null;
            
            if ($imageFile && $imageFile->isValid() && $imageFile->getSize() > 0) {
                $imageData = file_get_contents($imageFile->getTempName());
            } else {
                $imageData = $currentData['image'];
            }
            
            $newData = [
                'username'       => $this->request->getPost('username'),
                'fullname'       => $this->request->getPost('fullname'),
                'users_roles_id' => $this->request->getPost('roles'),
                'email'          => $this->request->getPost('email'),
                'no_telp'        => $this->request->getPost('no_telp'),
                'address'        => $this->request->getPost('address'),
                'gender'         => $this->request->getPost('gender'),
                'religion'       => $this->request->getPost('religion'),
                'status'         => $this->request->getPost('status') === null ? 'offline' : $this->request->getPost('status'),
                'image'          => $imageData,
            ];
            
            $isChanged = false;
            foreach ($newData as $key => $value) {
                if ($currentData[$key] != $value) {
                    $isChanged = true;
                    break;
                }
            }
    
            if (!$isChanged) {
                return redirect()->back()->with('info', 'No changes were made.');
            }
            
            // update data user
            $newData['updated_at'] = date('Y-m-d H:i:s');
            $updated = $this->userModel->updated($id, $newData);
    
            if ($updated) {
                return redirect()->back()->with('success', 'User has been updated successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update user');
            }
        }
      
        return view('admin/users/update', $data);
    }

    public function delete($id)
    {
        $session = session();
        $deletedRows = $this->userModel->deleted($id);
    
        if ($deletedRows > 0) {
            if ($session->has('logged_in') && $session->get('id') == $id) {
                return redirect()->to('login')->with('success', 'Your account has been deleted successfully');
            } else {
                return redirect()->to(previous_url() . '#user')->with('success', 'User deleted successfully');
            }
        } else {
            return redirect()->back()->with('error', 'Failed to delete user');
        }
    }
}
