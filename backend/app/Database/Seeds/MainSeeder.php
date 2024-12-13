<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MainSeeder extends Seeder
{
    public function run()
    {
        // 按照需要的順序調用所有 seeder
        $this->call('Members');
        $this->call('CartItems');
        $this->call('Products');
        $this->call('Categories');
    }
}