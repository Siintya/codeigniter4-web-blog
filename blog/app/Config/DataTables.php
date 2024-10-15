<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Datatables extends BaseConfig
{
    public $debug = false; // Aktifkan mode debug
    public $searchDelay = 1000; // Penundaan pencarian dalam milidetik
    public $autoFilter = true; // Aktifkan filter otomatis
    public $globalSearch = true; // Aktifkan pencarian global
    public $scrollX = true; // Aktifkan scroll horizontal
    public $scrollCollapse = true; // Aktifkan scroll collapse
    public $responsive = true; // Aktifkan desain responsif
    public $language = [
        'processing' => 'Memproses...',
        'lengthMenu' => 'Tampilkan _MENU_ data per halaman',
        'zeroRecords' => 'Tidak ada data yang ditemukan',
        'info' => 'Menampilkan _START_ hingga _END_ dari _TOTAL_ data',
        'infoEmpty' => 'Menampilkan 0 hingga 0 dari 0 data',
        'infoFiltered' => '(difilter dari _MAX_ data total)',
        'search' => 'Cari:',
        'emptyTable' => 'Tidak ada data di tabel ini',
        'loading' => 'Memuat...',
        'paginate' => [
            'first' => 'Pertama',
            'previous' => 'Sebelumnya',
            'next' => 'Selanjutnya',
            'last' => 'Terakhir'
        ],
        'aria' => [
            'sortAscending' => ': Aktifkan pengurutan naik',
            'sortDescending' => ': Aktifkan pengurutan turun'
        ]
    ];
}
