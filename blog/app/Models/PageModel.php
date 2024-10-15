<?php

namespace App\Models;

use CodeIgniter\Model;
class PageModel extends Model
{
    protected $table            = 'pages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'title', 
        'users_id',  
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
    protected $contentModel;

    public function __construct() 
    {
        $this->pageContentModel     = new PageContentModel();
        $this->contentModel         = new ContentModel();
    }
    // DataTables
    public function getAll()
    {
        $query = $this->join('users', 'users.id = pages.users_id')
                       ->select([
                            'pages.id',
                            'pages.title',
                            'pages.content',
                            'pages.slug',
                            'pages.created_at',
                            'pages.updated_at',
                            'users.id as user_id',
                            'users.username as author'
                        ])
                        ->get();
        return $query->getResultArray();
    }
    public function getBySlug($data)
    {
        $query = $this->join('users', 'users.id = pages.users_id')
                      ->select([
                            'pages.id',
                            'pages.title',
                            'pages.content',
                            'pages.slug',
                            'pages.created_at',
                            'pages.updated_at',
                            'pages.image',
                            'users.username as author'
                        ])
                      ->where('pages.slug', $data)
                      ->get();
        return $query->getRowArray();
    }
    public function getById($data)
    {
        $query = $this->join('users', 'users.id = pages.users_id')
                      ->select([
                            'pages.id',
                            'pages.title',
                            'pages.content',
                            'pages.slug',
                            'pages.created_at',
                            'pages.updated_at',
                            'pages.image',
                            'users.id as user_id',
                            'users.username as username'
                        ])
                      ->where('pages.id', $data)
                      ->get();
        return $query->getRowArray();
    }
    public function getByUser($data)
    {
        $query = $this->where('users_id', $data)->get();

        return $query->getRowArray();
    }
    public function is_unique_title_except_current($title, $id)
    {
        $page = $this->where('title', $title)
                     ->where('id !=', $id)
                     ->get()
                     ->getFirstRow('array'); // Specify the return type as 'array'
        return $page === null;
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

        // contents
        $pages_contents = $this->pageContentModel->getByPages($id);
        if (!empty($pages_contents)) {
            // pages_contents
            $contents = $this->contentModel->getById($pages_contents[0]['contents_id']);

            if ($contents) {   
                $this->contentModel->where('id',  $contents['id'])->delete();
            }
        }
        
        if ($pages_contents) {   
            $this->pageContentModel->where('pages_id', $id)->delete();
        }

        return $this->where('id', $id)->delete();
    }
}
