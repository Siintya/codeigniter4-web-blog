<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Intervention\Image\ImageManagerStatic as Image;
use Hermawan\DataTables\DataTable;
use App\Models\ArticleModel;
use App\Models\ArticleCategoryModel;
use App\Models\ArticleMediaModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use DateTime;

class ArticleMedia extends BaseController
{
    protected $articleModel;

    protected $articleCategoryModel;
    protected $articleMediaModel;
    protected $categoryModel;
    protected $tagModel;
    protected $userModel;
    protected $userRoleModel;
    protected $validation;

    public function __construct()
    {
        // inisialisasi
        $this->articleModel         = new ArticleModel();
        $this->articleCategoryModel = new ArticleCategoryModel();
        $this->articleMediaModel    = new ArticleMediaModel();
        $this->categoryModel        = new CategoryModel();
        $this->tagModel             = new TagModel();
        $this->userModel            = new UserModel();
        $this->userRoleModel        = new UserRoleModel();

        $this->validation           = \Config\Services::validation();
    }

    public function index()
    {
        helper('text');
        $userLogin  = $this->session->get('user');
        $data = [
            'title'      => 'Media', 
            'currentUrl' => service('uri')->getPath(),
            'userLogin'  => $this->userModel->getById($userLogin['id']),
            'media'      => $this->articleMediaModel->getData(),
            'articles'   => $this->articleModel->getAll()
        ];
          
        return view('admin/articles_media/index', $data);
    }

    public function storeModals()
    {
        $articles = $this->articleModel->getAll();
        return json_encode($articles);
    }

    public function store()
    {
        //Set rules
        $this->validation->setRules([
            'article'    => [
                'rules'  => 'required',
                'errors' => ['required' => 'You must add article']
            ],
            'image'      => [
                'rules'  => 'uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Please upload an image.',
                    'max_size' => 'The image size must not exceed 1 MB.',
                    'is_image' => 'Please upload a valid image file.',
                    'mime_in'  => 'Only .jpg, .jpeg, and .png files are allowed.',
                ]
            ],
        ]);
        // Validasi input
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errorsMedia', $this->validation->getErrors());
        }

        // Proses penyimpanan data
        if ($this->request->getPost()) {
            $imageFile = $this->request->getFile('image');
            $imageData = file_get_contents($imageFile->getTempName());
            $data = [
                'articles_id' => $this->request->getPost('article'),
                'captions'    => $this->request->getPost('captions'),
                'filename'    => $imageFile->getClientName(),
                'filetype'    => $imageFile->getClientMimeType(),
                'image'       => $imageData,
                'created_at'  => $this->request->getPost('created_at'),
                'updated_at'  => null
            ];
            $created = $this->articleMediaModel->create($data);
            if ($created) {
                return redirect()->to(previous_url(). '#articleMedia')->with('success','Media saved successfully');
            } else {
                return redirect()->to(previous_url(). '#articleMedia')->with('error', 'Failed saved image');
            }
        }
        
    }

    public function update($id)
    {
        //Set rules
        $this->validation->setRules([
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
            // dd($this->request->getPost());
            $currentData = $this->articleMediaModel->getById($id);
            $imageFile   = $this->request->getFile('image');
            $imageData   = null;
            
            if ($imageFile && $imageFile->isValid() && $imageFile->getSize() > 0) {
                $imageData = file_get_contents($imageFile->getTempName());
            } else {
                $imageData = $currentData['image'];
            }
            
            $newData = [
                'articles_id' => $this->request->getPost('articles'),
                'captions'    => $this->request->getPost('captions'),
                'filename'    => $imageFile->getClientName(),
                'filetype'    => $imageFile->getClientMimeType(),
                'image'       => $imageData,
            ];
            // dd($newArticle);
            // Check for changes in each field
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
            $updated = $this->articleMediaModel->updated($id, $newData);
            if ($updated) {
                return redirect()->to(previous_url(). '#articleMedia')->with('success','Media updated successfully');
            } else {
                return redirect()->to(previous_url(). '#articleMedia')->with('error', 'Failed updated image');
            }
        }
    }
    public function delete($id)
    {
        $deleted = $this->articleMediaModel->deleted($id);
        if ($deleted) { 
            return redirect()->to(previous_url(). '#articleMedia')->with('success', 'Media deleted successfully!');
        }else {
            return redirect()->to(previous_url(). '#articleMedia')->with('error', 'Failed deleted media');
        }
    }
}
