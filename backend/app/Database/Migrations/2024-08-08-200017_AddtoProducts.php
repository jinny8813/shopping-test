<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddtoProducts extends Migration
{
    public function up()
    {
        $fields = [
            'c_id'      => [
                'type'           => 'INT',
                'constraint'     => 10,
                'null'           => true
            ],
        ];

        $this->forge->addColumn('Products', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('Products', 'c_id');
    }
}
