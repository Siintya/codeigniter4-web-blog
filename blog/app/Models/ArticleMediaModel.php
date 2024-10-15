<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleMediaModel extends Model
{
    protected $table            = 'articles_media';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 
        'articles_id',
        'captions', 
        'filename', 
        'filetype', 
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
    
    public function getTotalMedia()
    {
        return $this->countAllResults();
    }
     // DataTables
     public function getData()
     {
        $query   = $this->join('articles', 'articles.id = articles_media.articles_id')
                         ->select([
                            'articles.title as title',
                            'articles.slug as slug',
                            'articles_media.id as id',
                            'articles_media.articles_id as articles_id',
                            'articles_media.captions as captions',
                            'articles_media.filename as filename',
                            'articles_media.filetype as filetype',
                            'articles_media.image as image',
                            'articles_media.created_at as created_at',
                            'articles_media.updated_at as updated_at',
                         ])
                         ->findAll();
 
        return $query;
     }
     public function getById($data)
     {
         $query = $this->join('articles', 'articles.id = articles_media.articles_id')
                       ->select('
                             articles.title as article_title,
                             articles.slug as article_slug,
                             articles_media.id as id,
                             articles_media.articles_id as articles_id,
                             articles_media.captions as captions,
                             articles_media.filename as filename,
                             articles_media.filetype as filetype,
                             articles_media.image as image,
                             articles_media.created_at as created_at,
                             articles_media.updated_at as updated_at,
                       ')
                       ->where('articles_media.id', $data)
                       ->get();
                       
         return $query->getRowArray();
     }
     public function getByArticleId($data)
     {
         $query = $this->join('articles', 'articles.id = articles_media.articles_id')
                       ->where('articles_media.articles_id', $data)
                       ->select('
                             articles.id as articles_id,
                             articles_media.id as media_id,
                             articles_media.captions as media_captions,
                             articles_media.filename as media_filename,
                             articles_media.filetype as media_filetype,
                             articles_media.image as media_image,
                             articles_media.created_at as media_created_at,
                             articles_media.updated_at as media_updated_at
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

    public function deleted($id)
    {
        return $this->delete($id);
    }
}
