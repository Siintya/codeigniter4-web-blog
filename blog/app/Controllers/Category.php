<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use App\Models\ArticleModel;
use App\Models\ArticleCategoryModel;
use App\Models\ArticleMediaModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;

class Category extends BaseController
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
            'title'      => 'Categories',  
            'currentUrl' => service('uri')->getPath(),
            'userLogin'  => $this->userModel->getById($userLogin['id']),
            'categories' => $this->categoryModel->getData()
        ];
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data['categories']);
        }
        
        return view('admin/categories/index', $data);
    }
    public function store()
    {
        //Set rules
        $this->validation->setRules([
            'name'        => [
                'rules'   => 'required|is_unique[categories.name]',
                'errors'  => [
                    'required'  => 'Category is required.',
                    'is_unique' => 'This category already exists.'
                ]
            ],
            'description' => [
                'rules'   => 'required',
                'errors'  => ['required' => 'Description is required.']
            ],
            'slug'        => [
                'rules'   => 'required',
                'errors'  => ['required' => 'Slug is required.']
            ]
        ]);

        // Validasi input
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }
        if ($this->request->getPost()) {

            $data = [
                'name'          => $this->request->getPost('name'),
                'slug'          => $this->request->getPost('slug'),
                'description'   => $this->request->getPost('description'),
                'created_at'    => $this->request->getPost('created_at'),
                'updated_at'    => null
            ];

            $created = $this->categoryModel->create($data);
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
            'title'               => 'Update Category',  
            'currentUrl'          => service('uri')->getPath(),
            'userLogin'           => $this->userModel->getById($userLogin['id']),
            'category'            => $this->categoryModel->getId($id),
            'articles_categories' => $this->articleCategoryModel->getByCategories($id),
            'articles'            => $this->articleModel->getAll()
        ];
    
        $data['is_used'] = array();
        foreach ($data['articles'] as $article) {
            $is_used = $this->articleCategoryModel->checkArticleUsage($article['id'], $id); // Pastikan cara mengakses properti 'id' dari objek artikel yang benar
            
            $data['is_used'][$article['id']] = $is_used;
        }

        // Check if all articles are used
        $all_used = array_filter($data['is_used']); 
        if (count($all_used) === count($data['articles'])) {
            $data['all_articles_used'] = true; 
        } else {
            $data['all_articles_used'] = false;
        }
        // Get current data
        $currentData = $data['category'];
    
        if ($this->request->getPost()) {
            // dd($this->request->getPost());
            // Get data from POST request
            $newData = [
                'name'         => $this->request->getPost('name'),
                'slug'         => $this->request->getPost('slug'),
                'description'  => $this->request->getPost('description')
            ];
            // dd($newData);
            
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
            $newData['updated_at'] = $this->request->getPost('updated_at');
            $updated = $this->categoryModel->updated($id, $newData);
    
            if ($updated) {
                return redirect()->back()->with('success', 'Category has been updated successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to update category');
            }
        }
    
        return view('admin/categories/update', $data);
    }

    public function delete($id)
    {
        $deleted = $this->categoryModel->deleted($id);
        if ($deleted) {
            return redirect()->back()->with('success', 'Category deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to deleted category');
        }
    }
}
