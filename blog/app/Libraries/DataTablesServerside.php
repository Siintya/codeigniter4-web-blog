<?php

namespace App\Libraries;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class DataTablesServerside
{
    protected $db;
    protected $request;
    protected $columns;
    protected $table;

    public function __construct(ConnectionInterface &$db)
    {
        $this->db = &$db;
        $this->request = \Config\Services::request();
    }

    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    public function setColumns($columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function make()
    {
        $builder = $this->db->table($this->table);
        $builder->select($this->columns);

        $builder->limit($this->request->getPost('length'), $this->request->getPost('start'));

        $search = $this->request->getPost('search');
        if (!empty($search['value'])) {
            $builder->groupStart();
            foreach ($this->columns as $column) {
                $builder->orLike($column, $search['value']);
            }
            $builder->groupEnd();
        }

        $recordsTotal = $builder->countAllResults(false);

        $recordsFiltered = $builder->countAllResults();

        $data = $builder->get()->getResultArray();

        return [
            'draw' => 1,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ];
    }
}
