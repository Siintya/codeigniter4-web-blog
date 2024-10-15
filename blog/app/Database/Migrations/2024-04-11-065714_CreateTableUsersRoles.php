<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUsersRoles extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [ 
                'type'              =>'INT',
                'contstraint'       => 5,
                'unsigned'          => true,
                'auto_increment'    => true
            ],
            'name' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255
            ],
            'description' => [
                'type'              => 'TEXT',
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
        $this->forge->createTable('users_roles', TRUE);
    }

    public function down()
    {
        $this->forge->dropTable('users_roles');
    }
}
