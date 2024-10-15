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

class ArticleTag extends BaseController
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

    public function store($id) 
    {
        $dataReq = [
            'article'    => $this->request->getPost('article'),
            'created_at' => $this->request->getPost('created_at'),
        ];
        if (empty($dataReq['article'])) {
            session()->setFlashdata('error_modal', 'add_');
            return redirect()->to('tags/update/'. $id . '#articleTag')->with('error', "Sorry, you can't add more because all articles have been used.");
        }
        $data = [
            'articles_id' => $dataReq['article'],
            'tags_id'     => $id,
            'created_at'  => $dataReq['created_at'],
            'updated_at'  => null
        ];
        $inserted = $this->articleTagModel->create($data);
        if ($inserted) {
            return redirect()->to('tags/update/'. $id . '#articleTag')->with('success', 'Article added in this tag successfully');
        } else {
            return redirect()->to('tags/update/'. $id . '#articleTag')->withInput()->with('error', 'Failed to added article in this tag');
        }
    }

    public function delete($id)
    {
        $articleTags = $this->articleTagModel->getById($id);

        if (!$articleTags) {
            return redirect()->to('tags')->with('error', 'Article tag not found.');
        }
    
        $deleted = $this->articleTagModel->deleted($id);
    
        if ($deleted) {
            return redirect()->to('tags/update/'. $articleTags['tag_id'] .'#articleTag')->with('success', 'Article deleted in this tag successfully.');
        } else {
            return redirect()->to('tags/update/'. $articleTags['tag_id'] .'#articleTag')->withInput()->with('error', 'Failed to deleted article');
        }
    }
}
