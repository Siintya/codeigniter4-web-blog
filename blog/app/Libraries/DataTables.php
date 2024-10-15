<?php

namespace App\Libraries;

class DataTables
{
    protected $table;
    protected $primaryKey = 'id'; // Primary key dari tabel
    protected $columns = []; // Daftar kolom yang ditampilkan
    protected $model;

    public function __construct($table, $model)
    {
        $this->table    = $table;
        $this->model    = $model;
        $this->columns  = $this->model->allowedFields;
    }

    public function getData()
    {
        $request = service('request');
        $length = $request->getPost('length');
        $start = $request->getPost('start');
        // $searchValue = $request->getPost('search')['value'];
        $searchValue = isset($request->getPost('search')['value']) ? $request->getPost('search')['value'] : '';


        $orderColumn = $request->getPost('order');
        $order = !empty($orderColumn) ? $this->columns[$orderColumn[0]['column']] : '';
        $dir = !empty($orderColumn) ? $orderColumn[0]['dir'] : '';

        // $dir = $request->getPost('order')[0]['dir'];
        $length = $request->getPost('length');
        $start = $request->getPost('start');

        // Handle null values
        $length = ($length !== null) ? (int) $length : 0;
        $start = ($start !== null) ? (int) $start : 0;

        $query = $this->model->select('*')
            ->like('title', $searchValue)
            ->orderBy($order, $dir)
            ->findAll($length, $start);

        $totalFiltered = $this->model->select('*')
            ->like('title', $searchValue)
            ->countAllResults();

        $data = [];

        if (!empty($query)) {
            foreach ($query as $row) {
                $data[] = $row;
            }
        }

        $response = [
            'draw' => intval($request->getPost('draw')),
            'recordsTotal' => $this->model->countAll(),
            'recordsFiltered' => $totalFiltered,
            'data' => $data,
        ];

        return json_encode($response);
    }
}
