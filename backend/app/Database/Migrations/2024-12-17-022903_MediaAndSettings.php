<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MediaAndSettings extends Migration
{
    public function up()
    {
        // 系統設定表
        $this->forge->addField([
            'setting_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'comment' => '設定類型: faq,about,terms等'
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'content' => [
                'type' => 'LONGTEXT',
                'null' => true,
                'comment' => 'HTML內容'
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default' => 'active'
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('setting_id', true);
        $this->forge->createTable('settings');

        // 媒體資源表
        $this->forge->addField([
            'media_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'related_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'related_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'media_type' => [
                'type' => 'ENUM',
                'constraint' => ['image', 'video'],
                'default' => 'image'
            ],
            'file_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'original_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'file_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'file_size' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'video_url' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'thumbnail_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true
            ]
        ]);
        $this->forge->addKey('media_id', true);
        $this->forge->addKey(['related_id', 'related_type']);
        $this->forge->createTable('media');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
        $this->forge->dropTable('media');
    }
}