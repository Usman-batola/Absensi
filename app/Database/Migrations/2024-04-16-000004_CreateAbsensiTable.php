<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAbsensiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
            ],
            'lokasi_id' => [
                'type' => 'INT',
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'jam_datang' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'jam_pulang' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'foto_datang' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'foto_pulang' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'latitude_datang' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,8',
                'null'       => true,
            ],
            'longitude_datang' => [
                'type'       => 'DECIMAL',
                'constraint' => '11,8',
                'null'       => true,
            ],
            'latitude_pulang' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,8',
                'null'       => true,
            ],
            'longitude_pulang' => [
                'type'       => 'DECIMAL',
                'constraint' => '11,8',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', false, true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lokasi_id', 'lokasi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('absensi');
    }

    public function down()
    {
        $this->forge->dropTable('absensi');
    }
}
