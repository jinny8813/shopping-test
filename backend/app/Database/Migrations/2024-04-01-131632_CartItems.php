<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CartItems extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'ci_id'              => [
                'type'           => 'INT',
                'constraint'     => 10,
                'auto_increment' => true,
                'unsigned'       => true
            ],
            'm_id'               => [
                'type'           => 'INT',
                'constraint'     => 10,
                'null'           => false
            ],
            'p_id'               => [
                'type'           => 'INT',
                'constraint'     => 10,
                'null'           => false
            ],
            'ci_quantity'        => [
                'type'           => 'INT',
                'constraint'     => 10,
                'null'           => false
            ],
            "created_at"         => [
                'type'           => 'datetime'
            ],
            "updated_at"         => [
                'type'           => 'datetime'
            ],
            "deleted_at"         => [
                'type'           => 'datetime',
                'null'           => true
            ]
        ]);

        $this->forge->addKey('ci_id', true);
        $this->forge->createTable('CartItems');
    }

    public function down()
    {
        //
    }
}
