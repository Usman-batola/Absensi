<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLokasiUserTable extends Migration
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
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', false, true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lokasi_id', 'lokasi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lokasi_user');
    }

    public function down()
    {
        $this->forge->dropTable('lokasi_user');
    }
}
