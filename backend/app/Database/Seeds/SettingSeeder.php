<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'type' => 'about',
                'title' => '關於我們',
                'content' => '<h1>關於我們</h1><p>這是一段示範文字...</p>',
                'status' => 'active',
                'sort_order' => 1
            ],
            [
                'type' => 'faq',
                'title' => '常見問題',
                'content' => '<h1>常見問題</h1><p>Q1: 這是問題...</p>',
                'status' => 'active',
                'sort_order' => 2
            ]
        ];

        $this->db->table('settings')->insertBatch($data);
    }
}