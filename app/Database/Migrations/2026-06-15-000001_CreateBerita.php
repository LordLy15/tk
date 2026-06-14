<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBerita extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'judul'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'konten'      => ['type' => 'TEXT'],
            'gambar'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'kategori'    => ['type' => 'ENUM', 'constraint' => ['Berita', 'Kegiatan'], 'default' => 'Berita'],
            'tanggal'     => ['type' => 'DATE', 'null' => true],
            'penulis'     => ['type' => 'VARCHAR', 'constraint' => 100, 'default' => 'Administrator'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('berita');
    }

    public function down()
    {
        $this->forge->dropTable('berita');
    }
}
