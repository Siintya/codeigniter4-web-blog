<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableTags extends Migration
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
            'name' => [
                'type'              => 'INT',
                'constraint'        => 255,
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
        $this->forge->createTable('tags', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('tags');
    }
}
