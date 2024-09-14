<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class StoreInfo extends Migration
{
    public function up()
    {
        $this->forge->addField([

            's_id'           => [
                'type'           => 'INT',
                'constraint'     => 10,
                'auto_increment' => true,
                'unsigned'       => true
            ],
            's_name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false
            ],
            'p_description'      => [
                'type'           => 'TEXT',
                'constraint'     => 500,
                'null'           => false
            ],
            'p_image'           => [
                'type'           => 'VARCHAR',
                'constraint'     => 245,
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

        $this->forge->addKey('s_id', true);
        $this->forge->createTable('StoreInfo');
    }

    public function down()
    {
        $this->forge->dropTable('StoreInfo');
    }
}
