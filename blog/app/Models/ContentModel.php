<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentModel extends Model
{
    protected $table            = 'contents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id', 
        'title', 
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

    protected $pageContentModel;

    public function __construct() 
    {
        $this->pageContentModel     = new PageContentModel();
    }
    public function getById($data)
    {
        $query = $this->where('id', $data)
                      ->get();
        return $query->getRowArray();
    }
    public function getContentByPages($slug)
    {
        $query = $this->join('pages_contents', 'pages_contents.contents_id = contents.id')
                      ->join('pages', 'pages.id = pages_contents.pages_id')
                      ->select('
                            contents.id as contents_id,
                            contents.title as contents_title,
                            contents.content as contents_content,
                            contents.slug as contents_slug,
                            contents.image as contents_image,
                            contents.created_at as contents_created_at,
                            contents.updated_at as contents_updated_at,
                        ')
                      ->where('pages.slug', $slug)
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
        // pages_contents
        $pages_contents = $this->pageContentModel->getByContents($id);
        if ($pages_contents > 0) {   
            $this->pageContentModel->where('contents_id', $id)->delete();
        }

        return $this->where('id', $id)->delete();
    }
}
