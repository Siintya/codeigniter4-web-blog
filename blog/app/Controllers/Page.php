<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Controller;
use App\Libraries\DataTables;
use Hermawan\DataTables\DataTable;
use App\Models\ArticleModel;
use App\Models\ArticleMediaModel;
use App\Models\UserModel;
use App\Models\TagModel;
use App\Models\CategoryModel;
use App\Models\ContentModel;
use App\Models\PageModel;
use App\Models\PageContentModel;
use DateTime;

class Page extends BaseController
{
    protected $validation;
    protected $articleModel;
    protected $articleMediaModel;
    protected $userModel;
    protected $tagModel;
    protected $categoryModel;
    protected $contentModel;
    protected $pageModel;
    protected $pageContentModel;


    function __construct()
    {
        $this->validation        = \Config\Services::validation();

        $this->articleModel      = new ArticleModel();
        $this->articleMediaModel = new ArticleMediaModel();
        $this->userModel         = new UserModel();
        $this->tagModel          = new TagModel();
        $this->categoryModel     = new CategoryModel();
        $this->contentModel      = new ContentModel();
        $this->pageModel         = new PageModel();
        $this->pageContentModel  = new PageContentModel();
    }
    public function index()
    {
        $userLogin  = $this->session->get('user');
        $data = [
            'title'      => 'Pages',
            'currentUrl' => service('uri')->getPath(),
            'userLogin'  => $this->userModel->getById($userLogin['id']),
            'pages'      => $this->pageModel->getAll()
        ];
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data['pages']);
        };
        return view('admin/pages/index', $data);
    }
    public function show($slug)
    {
        $userLogin  = $this->session->get('user');
        $data = [
            'title'         => 'Pages',
            'currentUrl'    => service('uri')->getPath(),
            'userLogin'     => $this->userModel->getById($userLogin['id']),
            'page'          => $this->pageModel->getBySlug($slug)
            
        ];
        return view('admin/pages/show', $data);
    }

    public function store()
    {
        // Set rules
        $this->validation->setRules([
            'title'      => [
                'rules'  => 'required|is_unique[pages.title]',
                'errors' => [
                    'required'  => 'Title is required.',
                    'is_unique' => 'This title already exists.'
                ]
            ],
            'slug'       => [
                'rules'  => 'required',
                'errors' => ['required' => 'Slug is required.']
            ],
            'content'    => [
                'rules'  => 'required',
                'errors' => ['required' => 'Content is required.']
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
        // Validasi input
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        if ($this->request->getPost()) {
            $imageFile      = $this->request->getFile('image');
            // dd($imageFile);
            if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
                $imageData      = file_get_contents($imageFile->getTempName());
            } else {
                $imageData = null;
            }

            $userLogin = $this->session->get('user');
            $data      = [
                'title'      => $this->request->getPost('title'),
                'users_id'   => $userLogin['id'],
                'content'    => $this->request->getPost('content'),
                'slug'       => $this->request->getPost('slug'),
                'image'      => $imageData,
                'created_at' => $this->request->getPost('created_at'),
                'updated_at' => NULL
            ];
            $created = $this->pageModel->create($data);
            if ($created) {
                return redirect()->back()->with('success', 'Data has been saved successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to insert data');
            }
        }
    }

    public function update($id)
    {
        $userLogin  = $this->session->get('user');
        $data = [
            'title'          => 'Update Pages',
            'currentUrl'     => service('uri')->getPath(),
            'userLogin'      => $this->userModel->getById($userLogin['id']),
            'page'           => $this->pageModel->getById($id),
            'pages_contents' => $this->pageContentModel->getByPages($id)
        ];
        $currentData = $data['page'];

        if ($this->request->getPost()) {
            // Set rules with custom callback
            $this->validation->setRules([
                'title-page' => [
                    'label' => 'Title',
                    'rules' => "required|is_unique_title_except_current[$id]",
                    'errors' => [
                        'required' => 'Title is required.',
                        'is_unique_title_except_current' => 'This title already exists for another page.'
                    ]
                ],
                'slug-page' => [
                    'rules'  => 'required',
                    'errors' => ['required' => 'Slug is required.']
                ],
                'content-page' => [
                    'rules'  => 'required',
                    'errors' => ['required' => 'Content is required.']
                ],
                'image-page' => [
                    'rules'  => 'permit_empty|max_size[image-page,1024]|is_image[image-page]|mime_in[image-page,image/jpg,image/jpeg,image/png]',
                    'errors' => [
                        'max_size' => 'The image size must not exceed 1 MB.',
                        'is_image' => 'The file must be an image.',
                        'mime_in'  => 'Only .jpg, .jpeg, and .png files are allowed.',
                    ]
                ],
            ]);

            // Validasi input
            if (!$this->validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
            }

            $imageFile = $this->request->getFile('image-page');
            $imageData = null;

            if ($imageFile && $imageFile->isValid() && $imageFile->getSize() > 0) {
                $imageData = file_get_contents($imageFile->getTempName());
            } else {
                $imageData = $currentData['image'];
            }

            $newData = [
                'title'   => $this->request->getPost('title-page'),
                'content' => $this->request->getPost('content-page'),
                'slug'    => $this->request->getPost('slug-page'),
                'image'   => $imageData,
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

            $newData['updated_at'] = $this->request->getPost('updated_at');
            $updated = $this->pageModel->updated($id, $newData);
            if ($updated) {
                return redirect()->back()->with('success', 'The page updated successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update page');
            }
        }
        return view('admin/pages/update', $data);
    }

    public function delete($id)
    {
        $deleted = $this->pageModel->deleted($id);

        if ($deleted) {
            return redirect()->to('pages')->with('success', 'The page deleted successfully!');
        } else {
            return redirect()->to('pages')->with('error', 'Failed to deleted page');
        } 
    }
}
