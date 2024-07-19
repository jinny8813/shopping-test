<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Members extends Seeder
{
    public function run()
    {
        //seed some user fake data.
        $now   = date("Y-m-d H:i:s");

        $data = [
            [
                "m_email"    => "jinny@gmail.com",
                "m_password" => password_hash("123456", PASSWORD_DEFAULT),
                "m_gmail"    => null,
                "m_line"     => null,
                "m_fb"       => null,
                "m_name"     => null,
                "m_phone"    => null,
                "m_address"  => null,
                "created_at" => $now,
                "updated_at" => $now,
            ],
        ];

        $this->db->table('Members')->insertBatch($data);
    }
}
