<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Article extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title'      => 'Artikel Pertama',
                'users_id'   => 3, 
                'content'    => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
                'slug'       => 'artikel-pertama',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'      => 'Artikel Kedua',
                'users_id'   => 3, 
                'content'    => 'Ini adalah konten artikel kedua',
                'slug'       => 'artikel-kedua',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data ke dalam tabel articles
        $this->db->table('articles')->insertBatch($data);
    }
}
