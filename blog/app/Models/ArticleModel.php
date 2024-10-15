<?php

namespace App\Models;

use CodeIgniter\Model;
class ArticleModel extends Model
{
    protected $table            = 'articles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'title', 
        'users_id', 
        'status', 
        'content', 
        'slug', 
        'image', 
        'created_at', 
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    protected $articleCategoryModel;
    protected $articleMediaModel;
    protected $articleTagModel;

    public function __construct() 
    {
        $this->articleCategoryModel     = new ArticleCategoryModel();
        $this->articleMediaModel        = new ArticleMediaModel();
        $this->articleTagModel          = new ArticleTagModel();
    }

    public function getAll()
    {
        $query = $this->join('users', 'users.id = articles.users_id')
                      ->select('
                            articles.id as id, 
                            articles.title as title,
                            articles.content as content,
                            articles.slug as slug,
                            articles.image as image,
                            articles.created_at as created_at,
                            users.username as username
                        ')
                      ->where('articles.status', 'publish')
                      ->orderBy('articles.created_at', 'DESC')
                      ->get();
        return $query->getResultArray();
    }

    public function getLatest()
    {
        $query = $this->join('users', 'users.id = articles.users_id')
                      ->select('
                            articles.id as id, 
                            articles.title as title,
                            articles.content as content,
                            articles.slug as slug,
                            articles.image as image,
                            articles.created_at as created_at
                        ')
                      ->where('articles.status', 'publish')
                      ->orderBy('articles.created_at', 'DESC')
                      ->limit(5) // Membatasi hasil menjadi 5 artikel terbaru
                      ->get();
        return $query->getResultArray();
    }
    
    public function getRecents($limit, $offset)
    {
        $query = $this->join('users', 'users.id = articles.users_id')
                      ->select('
                            articles.id as id,
                            articles.title as title,
                            articles.content as content,
                            articles.status as status,
                            articles.slug as slug,
                            articles.image as image,
                            articles.created_at as created_at,
                            users.id as user_id,
                            users.username as username,
                            users.image as user_image
                     ')
                     ->orderBy('created_at', 'DESC')
                     ->where('articles.status', 'publish')
                     ->get($limit, $offset);

        return $query->getResultArray();
    }

    public function getArticleCount()
    {
        return $this->where('status', 'publish')->countAllResults();
    }

    public function getTotalArticles()
    {
        return $this->countAllResults();
    }
    // Mengubah nilai dari column users_id menjadi author_name
    public function getArticlesWithUsers()
    {
        $query = $this->select('articles.*, users.username AS author_name')
                      ->join('users', 'users.id = articles.users_id')
                      ->getCompiledSelect();
        return $query;
    }
    // DataTables
    public function getData()
    {
        $query   = $this->join('users', 'users.id = articles.users_id')
                        ->select([
                            'articles.id',
                            'articles.title',
                            'articles.status',
                            'articles.content',
                            'articles.slug',
                            'articles.created_at',
                            'articles.updated_at',
                            'users.id as user_id',
                            'users.username as author'
                        ])
                        ->get();
        return $query->getResultArray();
    }

    public function getById($data)
    {
        $query = $this->join('users', 'users.id = articles.users_id')
                      ->select('
                            articles.id as id,
                            articles.title as title,
                            articles.slug as slug,
                            articles.content as content,
                            articles.status as status,
                            articles.image as image,
                            articles.created_at as created_at,
                            articles.updated_at as updated_at,
                            users.id as user_id,
                            users.username as username,
                            users.image as user_image
                      ')
                      ->where('articles.id', $data)
                      ->get();

        return $query->getRowArray();
    }
    public function getByUser($data)
    {
        $query =  $this->where('users_id', $data)
                       ->get();
        return $query->getResultArray();
    }
    public function getBySlug($data)
    {
        $query = $this->join('users', 'users.id = articles.users_id')
                      ->select('
                            articles.id as id,
                            articles.title as title,
                            articles.slug as slug,
                            articles.content as content,
                            articles.status as status,
                            articles.image as image,
                            articles.created_at as created_at,
                            articles.updated_at as updated_at,
                            users.id as user_id,
                            users.username as username,
                            users.image as user_image
                      ')
                      ->where('articles.slug', $data)
                      ->get();
        return $query->getRowArray();
    }

    public function getByCategories($data)
    {
        $query = $this->join('articles_categories','articles_categories.articles_id = articles.id')
                      ->join('categories', 'categories.id = articles_categories.categories_id')
                      ->where('articles_categories.articles_id', $data)
                      ->select('
                            articles_categories.articles_id as articles_id,
                            categories.id as category_id,
                            categories.name as category_name,
                      ')
                      ->get();
        return $query->getResultArray();
    }
    
    public function getByMedia($data)
    {
        $query = $this->join('articles_media', 'articles_media.articles_id = articles.id')
                      ->where('articles_media.articles_id', $data)
                      ->select('
                            articles.id as articles_id,
                            articles_media.id as id,
                            articles_media.image as image,
                            articles_media.created_at as created_at,
                            articles_media.updated_at as updated_at
                      ')
                      ->get();
        return $query->getResultArray(); 
    }
    public function getByTags($data)
    {
        $query = $this->join('articles_tags','articles_tags.articles_id = articles.id')
                      ->join('tags', 'tags.id = articles_tags.tags_id')
                      ->where('articles_tags.articles_id', $data)
                      ->select('
                            articles_tags.articles_id as articles_id,
                            articles_tags.tags_id as tags_id,
                            tags.name as tags_name
                      ')
                      ->get();
        return $query->getResultArray();
    }

    public function updateStatus($articleId, $status)
    {
        $data = ['status' => $status];
        return $this->update($articleId, $data);
    }

    public function create($data)
    {
        return $this->insert($data);
    }
    
    public function updated($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleted($id)
    {
        // articles_categories
        $categories = $this->articleCategoryModel->getByArticleId($id);
        if ($categories > 0) {
            $this->articleCategoryModel->where('articles_id', $id)->delete();
        }

        // articles_media
        $media = $this->articleMediaModel->getById($id);
        if ($media > 0) {
            $this->articleMediaModel->where('articles_id', $id)->delete();
        }

        // articles_tags
        $tags = $this->articleTagModel->getByArticleId($id);
        if ($tags > 0) {   
            $this->articleMediaModel->where('articles_id', $id)->delete();
        }

        return $this->where('id', $id)->delete();
    }
}
