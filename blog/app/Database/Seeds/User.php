<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {
        $data = [
            'username'      => 'devi23',
            'users_roles_id' => 1,
            'password'      => password_hash('kl4mpokl3g!', PASSWORD_DEFAULT),
            'fullname'      => 'Devi Putri Lestari',
            'email'         => 'devi.putriL@gmail.com',
            'religion'      => 'islam',
            'gender'        => 'wanita',
            'no_telp'       => '0867298424',
            'address'       => 'Jatiasih, Kota Bekasi Jawa Barat',
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'deleted_at'    => date('Y-m-d H:i:s'),
        ];
	    $this->db->table('users')->insert($data);
    }
}
