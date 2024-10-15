<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableArticlesMedia extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'constraint'        => 5,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'articles_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'filename' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'filetype' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'null'              => false,
            ],
            'image' => [
                'type'              => 'LONGBLOB',
                'null'              => true
            ],
            'created_at' => [
                'type'              => 'datetime',
                'null'              => true,
            ],
            'updated_at' => [
                'type'              => 'datetime',
                'null'              => true,
            ]
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('articles_id', 'articles', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('articles_media', TRUE);
    }

    public function down()
    {
        $this->forge->dropForeignKey('articles_media', 'articles_id');
        $this->forge->dropTable('articles_media');
    }
}
