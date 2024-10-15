<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleCategoryModel extends Model
{
    protected $table            = 'articles_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 
        'categories_id', 
        'articles_id', 
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

    // get data
    public function getById($data)
    {
        $query = $this->join('articles', 'articles.id = articles_categories.articles_id')
                      ->join('users', 'users.id = articles.users_id')
                      ->join('categories', 'categories.id = articles_categories.categories_id')
                      ->where('articles_categories.id', $data)
                      ->select('
                            articles_categories.id AS articles_categories_id,
                            articles.id AS article_id, 
                            articles.title AS article_title,
                            articles.slug AS article_slug,
                            articles.created_at AS created_at,
                            articles.updated_at AS updated_at,
                            categories.id AS category_id,
                            categories.name AS category_name,
                            users_id AS user_id,
                            users.username AS username
                        ')
                      ->get();
                      
        return $query->getRowArray();
    }
    public function getByArticleId($data)
    {
        $query = $this->join('categories', 'categories.id = articles_categories.categories_id')
                      ->where('articles_categories.articles_id', $data)
                      ->select('
                            articles_categories.articles_id as articles_id,
                            categories.id as categories_id,
                            categories.name as categories_name
                      ')
                    ->get();
        return $query->getResultArray();
    }

    public function getByCategoryId($data)
    {
        $query = $this->join('articles', 'articles.id = articles_categories.articles_id')
                      ->join('users', 'users.id = articles.users_id')
                      ->join('categories', 'categories.id = articles_categories.categories_id')
                      ->where('articles_categories.categories_id', $data)
                      ->select('
                            articles.id AS article_id, 
                            articles.title AS article_title,
                            articles.slug AS article_slug,
                            articles.created_at AS created_at,
                            articles.updated_at AS updated_at,
                            categories.id AS category_id,
                            categories.name AS category_name,
                            users_id AS user_id,
                            users.username AS username
                        ')
                      ->get();
                      
        return $query->getResultArray();
    }
    
    public function checkArticleUsage($articlesId, $categoriesId)
    {
        $query = $this->where('articles_id', $articlesId)
                      ->where('categories_id', $categoriesId)
                      ->countAllResults();

        return ($query > 0);
    }

    public function getByCategories($data)
    {
        $query = $this->join('articles','articles.id = articles_categories.articles_id')
                      ->join('users', 'users.id = articles.users_id')
                      ->join('categories', 'categories.id = articles_categories.categories_id')
                      ->where('articles_categories.categories_id', $data)
                      ->select('
                            articles_categories.id as articles_categories_id,
                            articles.id as articles_id,
                            articles.title as articles_title,
                            articles.slug as articles_slug,
                            articles.created_at as articles_created_at,
                            articles.updated_at as articles_updated_at,
                            categories.id as categories_id,
                            categories.name as categories_name,
                            users.id as users_id,
                            users.username as username
                      ')
                      ->get();
        return $query->getResultArray();
    }

    public function create($data)
    {
        return $this->insert($data);
    }

    public function updated($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleted($data)
    {
        return $this->delete($data);
    }

    public function deleteByArticles($data)
    {
        return $this->where('articles_id', $data)->delete();
    }
    
}
