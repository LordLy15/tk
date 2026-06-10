<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSpayPembayaran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'auto_increment' => true],
            'tagihan_id'     => ['type' => 'INT'],
            'orang_tua_id'   => ['type' => 'INT'],
            'bukti_bayar'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tanggal_bayar'  => ['type' => 'DATE', 'null' => true],
            'status'         => ['type' => 'ENUM', 'constraint' => ['pending','verified','rejected'], 'default' => 'pending'],
            'catatan_admin'  => ['type' => 'TEXT', 'null' => true],
            'verified_at'    => ['type' => 'DATETIME', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('tagihan_id', 'spay_tagihan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('orang_tua_id', 'spay_orang_tua', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('spay_pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('spay_pembayaran');
    }
}