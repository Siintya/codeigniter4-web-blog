<?php

namespace App\Models;

use CodeIgniter\Model;
class TagModel extends Model
{
    protected $table            = 'tags';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'name', 'created_at', 'deleted_at'];

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

    public function getAll()
    {
        return $this->findAll();
    }

    public function getTotal()
    {
        return $this->countAllResults();
    }
    // DataTables
    public function getData()
    {
        $query = $this->select('id, name, created_at, updated_at')
                      ->get();
        return $query->getResultArray();
    }
    public function create($data) 
    {
        return $this->insert($data);
    }
    public function getId($data)
    {
        return $this->find($data);
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
