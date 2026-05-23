<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoProfilGuruMurid extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('foto_guru', 'guru')) {
            $this->forge->addColumn('guru', [
                'foto_guru' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'pendidikan',
                ],
            ]);
        }

        if (! $this->db->fieldExists('foto_murid', 'murid')) {
            $this->forge->addColumn('murid', [
                'foto_murid' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                    'after' => 'alamat',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('foto_guru', 'guru')) {
            $this->forge->dropColumn('guru', 'foto_guru');
        }

        if ($this->db->fieldExists('foto_murid', 'murid')) {
            $this->forge->dropColumn('murid', 'foto_murid');
        }
    }
}
