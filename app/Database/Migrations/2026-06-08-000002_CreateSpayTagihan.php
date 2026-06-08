<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSpayTagihan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'auto_increment' => true],
            'orang_tua_id' => ['type' => 'INT'],
            'judul'        => ['type' => 'VARCHAR', 'constraint' => 200],
            'nominal'      => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'batas_bayar'  => ['type' => 'DATE', 'null' => true],
            'keterangan'   => ['type' => 'TEXT', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('orang_tua_id', 'spay_orang_tua', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('spay_tagihan');
    }

    public function down()
    {
        $this->forge->dropTable('spay_tagihan');
    }
}