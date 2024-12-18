<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MediaSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'related_id' => 1,
                'related_type' => 'setting',
                'media_type' => 'image',
                'file_name' => 'sample.jpg',
                'original_name' => 'sample.jpg',
                'file_path' => 'uploads/2024/03/sample.jpg',
                'file_type' => 'image/jpeg',
                'file_size' => 102400
            ]
        ];

        $this->db->table('media')->insertBatch($data);
    }
}