<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleTagModel extends Model
{
    protected $table            = 'articles_tags';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 
        'articles_id', 
        'tags_id', 
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

    public function getById($data)
    {
        $query = $this->join('articles', 'articles.id = articles_tags.articles_id')
                      ->join('users', 'users.id = articles.users_id')
                      ->join('tags', 'tags.id = articles_tags.tags_id')
                      ->where('articles_tags.id', $data)
                      ->select('
                            articles_tags.id AS articles_tags_id,
                            articles.id AS article_id, 
                            articles.title AS article_title,
                            articles.slug AS article_slug,
                            articles.created_at AS created_at,
                            articles.updated_at AS updated_at,
                            tags.id AS tag_id,
                            tags.name AS tag_name,
                            users.id AS user_id,
                            users.username AS username
                        ')
                      ->get();
        return $query->getRowArray();
    }

    public function getByTagId($id)
    {
        $query = $this->join('articles', 'articles.id = articles_tags.articles_id')
                      ->join('users', 'users.id = articles.users_id')
                      ->join('tags', 'tags.id = articles_tags.tags_id')
                      ->where('articles_tags.tags_id', $id)
                      ->select('
                            articles_tags.id AS articles_tags_id,
                            articles_tags.created_at AS articles_tags_created_at,
                            articles_tags.updated_at AS articles_tags_updated_at,
                            articles.id AS article_id, 
                            articles.title AS article_title,
                            articles.slug AS article_slug,
                            tags.id AS tag_id,
                            tags.name as tag_name,
                            users.id AS user_id,
                            users.username AS username
                        ')
                      ->get();

        return $query->getResultArray();
    }

    public function getByArticleId($data)
    {
        $query = $this->join('tags', 'tags.id = articles_tags.tags_id')
                      ->where('articles_tags.articles_id', $data)
                      ->select('
                            articles_tags.articles_id as articles_id,
                            tags.id as tags_id,
                            tags.name as tags_name
                      ')
                    ->get();
        return $query->getResultArray();
    }

    
    public function checkArticleUsage($articlesId, $tagsId)
    {
        $query = $this->where('articles_id', $articlesId)
                      ->where('tags_id', $tagsId)
                      ->countAllResults();

        return ($query > 0);
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
