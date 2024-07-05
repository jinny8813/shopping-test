<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Products extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'p_id'           => [
                'type'           => 'INT',
                'constraint'     => 10,
                'auto_increment' => true,
                'unsigned'       => true
            ],
            'p_name'       => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => false
            ],
            'p_description'      => [
                'type'           => 'TEXT',
                'constraint'     => 500,
                'null'           => false
            ],
            'p_price'           => [
                'type'           => 'INT',
                'constraint'     => 10,
                'null'           => false
            ],
            'p_stock'           => [
                'type'           => 'INT',
                'constraint'     => 10,
                'null'           => false
            ],
            'p_image'           => [
                'type'           => 'VARCHAR',
                'constraint'     => 245,
                'null'           => true
            ],
            'p_type'           => [
                'type'           => 'VARCHAR',
                'constraint'     => 45,
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

        $this->forge->addKey('p_id', true);
        $this->forge->createTable('Products');
    }

    public function down()
    {
        $this->forge->dropTable('Products');
    }
}
