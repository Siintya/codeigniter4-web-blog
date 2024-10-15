<?php

namespace App\Models;

use CodeIgniter\Model;

class PageContentModel extends Model
{
    protected $table            = 'pages_contents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'pages_id', 'contents_id', 'created_at', 'updated_at'];

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

    public function getAllPagesContents()
    {
        return $this->findAll();
    }


    public function getByPages($data)
    {
        $query = $this->join('contents', 'contents.id = pages_contents.contents_id')
                      ->join('pages', 'pages.id = pages_contents.pages_id')
                      ->join('users', 'users.id = pages.users_id')
                      ->where('pages_contents.pages_id', $data)
                      ->select('
                            pages_contents.id as pages_contents_id,
                            pages_contents.pages_id as pages_id,
                            contents.id as contents_id,
                            contents.title as contents_title,
                            contents.content as contents_content,
                            contents.slug as contents_slug,
                            contents.image as contents_image,
                            contents.created_at as contents_created_at,
                            contents.updated_at as contents_updated_at,
                            users.id as user_id,
                            users.username as username
                      ')
                      ->orderBy('pages_contents.created_at', 'DESC')
                      ->get();
        return $query->getResultArray();
    }

    public function getByContents($data)
    {
        $query = $this->where('contents_id', $data)->get();
        return $query->getRowArray();
    }
    public function getPageContentByTitle($data)
    {
        $query = $this->join('pages', 'pages.id = pages_contents.pages_id')
                      ->join('contents', 'contents.id = pages_contents.contents_id')
                      ->join('users', 'users.id = pages.users_id')
                      ->select([
                            'pages_contents.id as pages_contents_id',
                            'pages.id as pages_id',
                            'pages.title as pages_title',
                            'pages.content as pages_content',
                            'pages.slug as pages_slug',
                            'pages.created_at as pages_created_at',
                            'pages.updated_at as pages_updated_at',
                            'pages.image as pages_image',
                            'contents.id as contents_id',
                            'contents.title as contents_title',
                            'contents.content as contents_content',
                            'contents.slug as contents_slug',
                            'contents.created_at as contents_created_at',
                            'contents.updated_at as contents_updated_at',
                            'contents.image as contents_image',
                            'users.username as author'
                      ])
                      ->where('pages.title', $data)
                      ->limit(2)
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
