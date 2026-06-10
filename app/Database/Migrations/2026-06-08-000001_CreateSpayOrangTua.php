<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSpayOrangTua extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'no_hp'      => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'nama_siswa' => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'kelas'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('spay_orang_tua');
    }

    public function down()
    {
        $this->forge->dropTable('spay_orang_tua');
    }
}