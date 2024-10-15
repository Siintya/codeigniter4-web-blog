<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableArticlesTags extends Migration
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
            'tags_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'created_at' => [
                'type'              => 'datetime',
                'null'              => true,
            ],
            'updated_at' => [
                'type'              => 'datetime',
                'null'              => true,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('articles_id', 'articles', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('tags_id', 'tags', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('articles_tags', TRUE);
    }

    public function down()
    {
        $this->forge->dropForeignKey('articles_tags', 'articles_id');
        $this->forge->dropForeignKey('articles_tags', 'tags_id');
        $this->forge->dropTable('articles_tags');
    }
}
