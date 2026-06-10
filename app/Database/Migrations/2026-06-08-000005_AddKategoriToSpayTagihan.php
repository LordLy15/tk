<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKategoriToSpayTagihan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('spay_tagihan', [
            'kategori' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('spay_tagihan', 'kategori');
    }
}