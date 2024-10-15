<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableArticlesCategories extends Migration
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
            'categories_id' => [
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
        $this->forge->addForeignKey('categories_id', 'categories', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('articles_categories', TRUE);
    }

    public function down()
    {
        $this->forge->dropForeignKey('articles_categories', 'articles_id');
        $this->forge->dropForeignKey('articles_categories', 'categories_id');
        $this->forge->dropTable('articles_categories');
    }
}
