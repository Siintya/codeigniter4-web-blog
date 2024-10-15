<?php

namespace App\Models;

use CodeIgniter\Model;

class MediaModel extends Model
{
    protected $table            = 'articles_media';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'articles_id', 'filename', 'filetype', 'image', 'created_at', 'updated_at'];

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
                            'articles_media.id',
                            'articles_media.filename',
                            'articles_media.filetype',
                            'articles_media.image',
                            'articles_media.created_at',
                            'articles_media.updated_at',
                         ])
                         ->get();
 
         return $query->getResult();
     }
}
