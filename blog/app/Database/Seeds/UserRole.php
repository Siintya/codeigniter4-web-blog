<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserRole extends Seeder
{
    public function run()
    {
        $data = [
            'name'          => 'Admin',
            'description'   => 'to manage data article in blog, page menu about us & contact, and users',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];
	    $this->db->table('users_roles')->insert($data);
    }
}
