<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Member extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'm_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'm_email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'unique' => true,
            ],
            'm_password' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'm_gmail' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'm_line' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'm_fb' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'm_name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'm_phone' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'm_adress' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'm_role' => [
                'type' => 'ENUM',
                'constraint' => ['admin', 'member'],
                'default' => 'member',
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'reset_token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'reset_token_expires' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('m_id', true);
        $this->forge->createTable('member');
    }

    public function down()
    {
        $this->forge->dropTable('member');
    }
}