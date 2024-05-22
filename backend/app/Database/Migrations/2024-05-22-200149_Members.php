<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Members extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'm_id'           => [
                'type'           => 'INT',
                'constraint'     => 10,
                'auto_increment' => true,
                'unsigned'       => true
            ],
            'm_email'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false
            ],
            'm_password'     => [
                'type'           => 'VARCHAR',
                'constraint'     => 245,
                'null'           => false
            ],
            'm_gmail'        => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true
            ],
            'm_line'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true
            ],
            'm_fb'           => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true
            ],
            'm_name'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => true
            ],
            'm_phone'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => true
            ],
            "created_at"      => [
                'type'           => 'datetime'
            ],
            "updated_at"      => [
                'type'           => 'datetime'
            ],
            "deleted_at"      => [
                'type'           => 'datetime',
                'null'           => true
            ]
        ]);

        $this->forge->addKey('m_id', true);
        $this->forge->createTable('Members');
    }

    public function down()
    {
        if ($this->db->tableExists('Members')) {
            $this->forge->dropTable('Members');
        }
    }
}
