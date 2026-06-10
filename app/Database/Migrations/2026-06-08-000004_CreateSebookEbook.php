<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeBookEbook extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'judul'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'deskripsi'  => ['type' => 'TEXT', 'null' => true],
            'penulis'    => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'kategori'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'cover'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'file_path'  => ['type' => 'VARCHAR', 'constraint' => 255],
            'kelas'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_by' => ['type' => 'INT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('sebook_ebook');
    }

    public function down()
    {
        $this->forge->dropTable('sebook_ebook');
    }
}