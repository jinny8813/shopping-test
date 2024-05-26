<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CartItems extends Seeder
{
    public function run()
    {
        //seed some user fake data.
        $now   = date("Y-m-d H:i:s");

        $data = [
            [
                "m_id"=> "1",
                "p_id"=> "2",
                "ci_quantity"=> "2",
                "created_at"=> $now,
                "updated_at"=> $now,
            ],
        ];

        $this->db->table('CartItems')->insertBatch($data);
    }
}
