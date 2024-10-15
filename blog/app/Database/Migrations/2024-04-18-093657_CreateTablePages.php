<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePages extends Migration
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
            'title' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
                'unique'            => true
            ],
            'users_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'content' => [
                'type'              => 'TEXT',
                'null'              => false,
            ],
            'slug' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
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
        $this->forge->addForeignKey('users_id', 'users', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('pages', TRUE);
    }

    public function down()
    {
        $this->forge->dropForeignKey('pages', 'users_id');
        $this->forge->dropTable('pages');
    }
}
