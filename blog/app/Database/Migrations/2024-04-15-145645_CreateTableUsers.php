<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTableUsers extends Migration
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
            'username' => [
                'type'              => 'VARCHAR',
                'constraint'        => 25,
                'unique'            => true
            ],
            'users_roles_id' => [
                'type'              => 'INT',
                'constraint'        => 11,
                'unsigned'          => true,
                'null'              => true,
            ],
            'password'  => [
                'type'              => 'VARCHAR',
                'constraint'        => 255
            ],
            'fullname'  => [
                'type'              => 'VARCHAR',
                'constraint'        => 255
            ],
            'email' => [
                'type'              => 'VARCHAR',
                'constraint'        => 25,
                'unique'            => true
            ],
            'religion' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'gender' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'no_telp' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'address' => [
                'type'              => 'TEXT'
            ],
            'token' => [
                'type'              => 'VARCHAR',
                'constraint'        => 25,
            ],
            'last_login timestamp default now()',
            'created_at' => [
                'type'              => 'datetime',
                'null'              => true,
            ],
            'updated_at' => [
                'type'              => 'datetime',
                'null'              => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'        => true,
                'default'     => null,
            ],
        ]);
        $this->forge->addKey('id', TRUE);
        $this->forge->addForeignKey('users_roles_id', 'users_roles', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('users', TRUE);
    }

    public function down()
    {
        $this->forge->dropForeignKey('users', 'users_roles_id');
        $this->forge->dropTable('users');
    }
}
