<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Products extends Seeder
{
    public function run()
    {
        //seed some user fake data.
        $now   = date("Y-m-d H:i:s");

        $data = [
            [
                "p_name"=> "computer2",
                "p_description"=> "the computer",
                "p_price"=> "300",
                "p_stock"=> "10",
                "p_image"=> "computer url",
                "p_type"=> "main",
                "c_id" => "1",
                "created_at"=> $now,
                "updated_at"=> $now,
            ],
            [
                "p_name"=> "computer1",
                "p_description"=> "the computer",
                "p_price"=> "300",
                "p_stock"=> "10",
                "p_image"=> "computer url",
                "p_type"=> "main",
                "c_id" => "2",
                "created_at"=> $now,
                "updated_at"=> $now,
            ],
        ];

        $this->db->table('Products')->insertBatch($data);
    }
}
