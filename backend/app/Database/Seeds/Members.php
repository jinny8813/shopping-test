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
//
            ],
        ];

        $this->db->table('Members')->insertBatch($data);
    }
}
