<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Intervention\Image\ImageManagerStatic as Image;
use Hermawan\DataTables\DataTable;
use App\Models\ArticleModel;
use App\Models\ArticleCategoryModel;
use App\Models\ArticleMediaModel;
use App\Models\ArticleTagModel;
use App\Models\CategoryModel;
use App\Models\TagModel;
use App\Models\UserModel;
use App\Models\UserRoleModel;
use DateTime;

class Article extends BaseController
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

    public function __construct()
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

        $this->session              = \Config\Services::session();
        $this->validation           = \Config\Services::validation();
    }

    public function index()
    {
        helper('text');
        $userLogin  = $this->session->get('user');
        $data = [
            'title'           => 'Articles',  
            'currentUrl'      => service('uri')->getPath(),
            'userLogin'       => $this->userModel->getById($userLogin['id']),
            'articles'        => $this->articleModel->getData(),
            'categories'      => $this->categoryModel->getData(),
            'data_categories' => $this->categoryModel->getAll(),
            'data_tags'       => $this->tagModel->getAll(),
            'categories'      => $this->categoryModel->getAll(),
            'tags'            => $this->tagModel->getAll()
        ];
        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data['articles']);
        }
        return view('admin/articles/index', $data);
    }

    public function show($slug)
    {
        $userLogin  = $this->session->get('user');
        $article    = $this->articleModel->getBySlug($slug);
        $data = [
            'title'      => $article['title'],
            'currentUrl' => service('uri')->getPath(),
            'userLogin'  => $this->userModel->getById($userLogin['id']),
            'article'    => $article,
            'categories' => $this->articleCategoryModel->getByArticleId($article['id']),
            'tags'       => $this->articleTagModel->getByArticleId($article['id']),
            'media'      => $this->articleMediaModel->getByArticleId($article['id'])
        ];
        return view('admin/articles/show', $data);
    }

    public function store()
    {
        // dd($this->request->getPost());
        $this->validation->setRules([
            'title'      => [
                'rules'  => 'required|is_unique[pages.title]',
                'errors' => [
                    'required'  => 'Title is required',
                    'is_unique' => 'This title already exists'
                ]
            ],
            'slug'       => [
                'rules'  => 'required',
                'errors' => ['required' => 'Slug is required']
            ],
            'content'    => [
                'rules'  => 'required',
                'errors' => ['required' => 'Content is required']
            ],
            'image'      => [
                'rules'  => 'uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Please upload an image',
                    'max_size' => 'The image size must not exceed 1 MB',
                    'is_image' => 'Please upload a valid image file',
                    'mime_in'  => 'Only .jpg, .jpeg, and .png files are allowed',
                ]
            ],
            'tag'        => [
                'rules'  => 'required',
                'errors' => ['required' => 'Tag is required']
            ],
        ]);
        if (!$this->validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errorsArticle', $this->validation->getErrors());
        }

        if ($this->request->getPost()) {
            $imageFile = $this->request->getFile('image');
            $imageData = file_get_contents($imageFile->getTempName());
            $userLogin = $this->session->get('user');
            $dataArticle = [
                'title'      => $this->request->getPost('title'),
                'users_id'   => $userLogin['id'],
                'content'    => $this->request->getPost('content'),
                'status'     => $this->request->getPost('status'),
                'slug'       => $this->request->getPost('slug'),
                'image'      => $imageData,
                'created_at' => $this->request->getPost('created_at'),
                'updated_at' => null
            ];
            $createdArticle = $this->articleModel->create($dataArticle);
            if ($createdArticle) {
                $articleID    = $this->articleModel->getInsertID();
                $dataCategory = [
                    'articles_id'   => $articleID,
                    'categories_id' => $this->request->getPost('category'),
                    'created_at'    => $this->request->getPost('created_at'),
                    'updated_at'    => null
                ];
                $saveCategory = $this->articleCategoryModel->create($dataCategory);

                $tags       = $this->request->getPost('tag');
                if (is_string($tags)) {
                    $tagIDs    = explode(',', $tags);
                    $tagsArray = array_map('intval', $tagIDs);
                } else {
                    $tagsArray = array_map('intval', $tags);
                }

                $saveTag = true;
                foreach ($tagsArray as $tag) {
                    $dataTag = [
                        'articles_id' => $articleID,
                        'tags_id'     => $tag,
                        'created_at'  => $this->request->getPost('created_at'),
                        'updated_at'  => null
                    ];
                    $saveTag = $this->articleTagModel->create($dataTag);
                    if (!$saveTag) {
                        return false;
                    }
                }

                if ($saveCategory && $saveTag) {
                    return redirect()->back()->with('success', "Articles with title ". $dataArticle['title'] ." has been saved successfully!");
                } else {
                    return redirect()->back()->with('error', 'Failed to save categories & tags data');
                }

            } else {
                return redirect()->back()->with('error', 'Failed to insert article');
            }
        }        
    }

    public function update($id)
    {
        $userLogin  = $this->session->get('user');
        $data = [
            'title'             => 'Update Article',
            'currentUrl'        => service('uri')->getPath(),
            'userLogin'         => $this->userModel->getById($userLogin['id']),
            'article'           => $this->articleModel->getById($id),
            'articles_category' => $this->articleCategoryModel->getByArticleId($id),
            'articles_media'    => $this->articleMediaModel->getByArticleId($id),
            'articles_tag'      => $this->articleTagModel->getByArticleId($id),
            'categories'        => $this->categoryModel->getAll(),
            'tags'              => $this->tagModel->getAll()
        ];
        if (!$data['article']) {
            return redirect()->back()->with('error', 'Article not found.');
        }  
        $currentData = $data['article'];
        
        if ($this->request->getPost()) {
            // dd($this->request->getPost());
            $imageFile = $this->request->getFile('image');
            $imageData = null;
            
            if ($imageFile && $imageFile->isValid() && $imageFile->getSize() > 0) {
                $imageData = file_get_contents($imageFile->getTempName());
            } else {
                $imageData = $currentData['image'];
            }
            
            $newArticle = [
                'title'   => $this->request->getPost('title'),
                'content' => $this->request->getPost('content'),
                'slug'    => $this->request->getPost('slug'),
                'image'   => $imageData,
                'status'  => $this->request->getPost('status') === null ? 'private' : $this->request->getPost('status'),
            ];
            // Check for changes in each field
            $isChanged = false;
            foreach ($newArticle as $key => $value) {
                if ($currentData[$key] != $value) {
                    $isChanged = true;
                    break;
                }
            }

            $newCategories = $this->request->getPost('category');
            if (!is_array($newCategories)) {
                $newCategories = [$newCategories];
            }
            $existingCategories = array_column($data['articles_category'], 'categories_id');
            
            $tags      = $this->request->getPost('tag');
            if (!is_array($tags)) {
                $tags = [$tags];
            }
            $tagArray = array_map('intval', $tags); 
            $existingTags   = array_column($data['articles_tag'], 'tags_id');
            if (array_diff($existingCategories, $newCategories) || 
                array_diff($newCategories, $existingCategories) ||
                array_diff($existingTags, $tagArray) || 
                array_diff($tagArray, $existingTags)) {
                    $isChanged = true;
            }
            if (!$isChanged) {
                return redirect()->back()->with('info', 'No updates were made.');
            }
            // Update data article
            $newArticle['updated_at'] = $this->request->getPost('updated_at');
            $updated = $this->articleModel->updated($id, $newArticle);
            
            if ($updated) {
                // update categories
                $categoryData = [
                    'articles_id'   => $id,
                    'categories_id' => $this->request->getPost('category'),
                    'updated_at'    => $this->request->getPost('updated_at'),
                ];
                // *delete 
                $this->articleCategoryModel->deleteByArticles($id);
                // *insert new
                $this->articleCategoryModel->create($categoryData);

                // update tags
                // delete
                $this->articleTagModel->deleteByArticles($id);
                $tagIDs     = explode(',', is_array($tags));
                $tagsArray  = array_map('intval', $tagIDs);

                $success = true;
                $success = true;
                foreach ($tagArray as $tagId) {
                    if (in_array($tagId, array_column($data['tags'], 'id'))) {
                        $tagData = [
                            'articles_id' => $id,
                            'tags_id'     => $tagId,
                            'updated_at'  => $newArticle['updated_at'],
                        ];
                        $this->articleTagModel->create($tagData);
                        if (!$success) {
                            return false;
                        }
                    }
                }
                if ($success) {
                    return redirect()->back()->with('success', 'Article has been updated successfully!');
                } else {
                    return redirect()->back()->withInput()->with('error', 'Failed to update article');
                }
            }
        }
    
        return view('admin/articles/update', $data);
    }
    
    public function delete($id)
    {
        $deleted = $this->articleModel->deleted($id);
        
        if ($deleted) {
            return redirect()->to(previous_url() . '#article')->with('success', 'Article deleted successfully!');
        } else {
            return redirect()->to(previous_url() . '#article')->with('error', 'Failed to deleted article');
        }
    }

    public function deleteMedia($id)
    {
        $media = $this->articleMediaModel->getById($id);
        if ($media) {
            // dd($media);
            $articlesId = $media['article_id'];
            $deleted = $this->articleMediaModel->deleted($id);
        
            if ($deleted) {
                return redirect()->to('articles/update/' . $articlesId . '#articleMedia')->with('success-media', 'The media in this article has been successfully deleted!');
            } else {
                return redirect()->to('articles/update/' . $articlesId . '#articleMedia')->with('error-media', 'Failed to deleted media in this article');
            }
        }
    }
}
