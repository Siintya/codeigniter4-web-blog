<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Hermawan\DataTables\DataTable;
use App\Models\ArticleModel;
use App\Models\ArticleCategoryModel;
use App\Models\ArticleMediaModel;
use App\Models\ArticleTagModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;

class Tag extends BaseController
{
    protected $articleModel;
    protected $articleCategoryModel;
    protected $articleMediaModel;
    protected $articleTagModel;
    protected $categoryModel;
    protected $tagModel;
    protected $userModel;
    protected $userRoleModel;
    protected $validation;
    
    function __construct()
    {
        // inisialisasi
        $this->articleModel         = new ArticleModel();
        $this->articleCategoryModel = new ArticleCategoryModel();
        $this->articleMediaModel    = new ArticleMediaModel();
        $this->articleTagModel      = new ArticleTagModel();
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
            'title'      => 'Tags', 
            'currentUrl' => service('uri')->getPath(),
            'userLogin'  => $this->userModel->getById($userLogin['id']),
            'tags'       => $this->tagModel->getData()
        ];
         if ($this->request->isAJAX()) {
            return $this->response->setJSON($data['tags']);
        }
        return view('admin/tags/index', $data);
    }

    public function store()
    {
        //Set rules
        $this->validation->setRules([
            'name'        => [
                'rules'   => 'required|is_unique[tags.name]',
                'errors'  => [
                    'required'  => 'Tag is required.',
                    'is_unique' => 'This tag already exists.'
                ]
            ]
        ]);
        // Validasi input
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }
        if ($this->request->getPost()) {
            $data = [
                'name'          => $this->request->getPost('name'),
                'created_at'    => $this->request->getPost('created_at'),
                'updated_at'    => NULL
            ];
            $inserted = $this->tagModel->create($data);
            if ($inserted) {
                return redirect()->back()->with('success', 'Tag saved successfully!');
            } else {
                return redirect()->back()->withInput()->with('error', 'Failed to saved data');
            }
        }
    }

    public function update($id)
    {
        $userLogin  = $this->session->get('user');
        $data = [
            'title'       => 'Update Tag',  
            'currentUrl'  => service('uri')->getPath(),
            'userLogin'   => $this->userModel->getById($userLogin['id']),
            'tag'         => $this->tagModel->getId($id),
            'article_tag' => $this->articleTagModel->getByTagId($id),
            'articles'    => $this->articleModel->getAll(),
        ];
        $currentData            = $data['tag'];

        $data['is_used'] = array();
        foreach ($data['articles'] as $article) {
            $is_used = $this->articleTagModel->checkArticleUsage($article['id'], $id); 
            
            $data['is_used'][$article['id']] = $is_used;
        }

        // Check if all articles are used
        $all_used = array_filter($data['is_used']); 
        if (count($all_used) === count($data['articles'])) {
            $data['all_articles_used'] = true; 
        } else {
            $data['all_articles_used'] = false;
        }
        
        if ($this->request->getPost()) {
            $newData = [ 'name'  => $this->request->getPost('name') ];
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
            $updated = $this->tagModel->updated($id, $newData);
    
            if ($updated) {
                return redirect()->to('tags/update/'. $id)->with('success', 'Tag updated successfully!');
            } else {
                return redirect()->to('tags/update/'. $id)->withInput()->with('error', 'Failed to updated tag');
            }
        }
        return view('admin/tags/update', $data);
    }

    public function delete($id)
    {
        $deleted = $this->tagModel->deleted($id);
        if ($deleted) {
            return redirect()->back()->with('success', 'Tag deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to deleted tag');
        }
    }
}
