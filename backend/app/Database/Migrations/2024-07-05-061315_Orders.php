<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Orders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'o_id'           => [
                'type'           => 'INT',
                'constraint'     => 10,
                'auto_increment' => true,
                'unsigned'       => true
            ],
            'm_id'        => [
                'type'           => 'INT',
                'constraint'     => 10,
                'null'           => false
            ],
            'o_trade_number'     => [
                'type'           => 'VARCHAR',
                'constraint'     => 245,
                'null'           => false
            ],
            'o_total'        => [
                'type'           => 'INT',
                'constraint'     => 10,
                'null'           => false
            ],
            'o_status'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 45,
                'null'           => false
            ],
            'o_name'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => false
            ],
            'o_phone'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 20,
                'null'           => false
            ],
            'o_address'         => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false
            ],
            'o_product_arr'      => [
                'type'           => 'TEXT',
                'constraint'     => 1000,
                'null'           => false
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

        $this->forge->addKey('o_id', true);
        $this->forge->createTable('Orders');
    }

    public function down()
    {
        $this->forge->dropTable('Orders');
    }
}
