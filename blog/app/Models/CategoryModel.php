<?php

namespace App\Models;

use CodeIgniter\Model;
class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'slug', 'description', 'created_at', 'updated_at'];

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

    public function getTotal()
    {
        return $this->countAllResults();
    }
    public function getAll()
    {
        return $this->findAll();
    }
    // DataTables
    public function getData()
    {
        $query = $this->select(['id','name','slug','created_at','updated_at'])
                      ->get();
        return $query->getResultArray();
    }
    public function getId($data)
    {
        $query = $this->where('id', $data)->get();
        return $query->getRowArray();
    }
    // create new category
    public function create($data) 
    {
        return $this->insert($data);
    }
    // update exists category
    public function updated($id, $data)
    {
        return $this->update($id, $data);
    }
    // delete exists category
    public function deleted($id)
    {
        return $this->delete($id);
    }
}
