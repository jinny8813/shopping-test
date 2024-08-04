<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Categories extends Seeder
{
    public function run()
    {
        //seed some user fake data.
        $now   = date("Y-m-d H:i:s");

        $data = [
            [
                "c_name"=> "example_parent_category",
                "c_parent_id"=> null,
                "created_at"=> $now,
                "updated_at"=> $now,
            ],
            [
                "c_name"=> "example_child_category",
                "c_parent_id"=> 1,
                "created_at"=> $now,
                "updated_at"=> $now,
            ],
        ];

        $this->db->table('Categories')->insertBatch($data);
    }
}
