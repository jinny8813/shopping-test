<?php
// app/Database/Seeds/AdminSeeder.php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // 建立超級管理員帳號
        $this->db->table('admin')->insert([
            'username' => 'superadmin',
            'password' => password_hash('superadmin123', PASSWORD_DEFAULT),
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => 'super_admin',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        // 建立一般管理員帳號（測試用）
        $this->db->table('admin')->insert([
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'name' => 'Normal Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}