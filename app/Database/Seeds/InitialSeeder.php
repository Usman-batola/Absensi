<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialSeeder extends Seeder
{
    public function run()
    {
        // Seed Users
        $userModel = new \App\Models\UserModel();
        
        $users = [
            [
                'name' => 'Admin System',
                'email' => 'admin@test.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin'
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@test.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role' => 'user'
            ],
            [
                'name' => 'Ani Wijaya',
                'email' => 'ani@test.com',
                'password' => password_hash('user123', PASSWORD_DEFAULT),
                'role' => 'user'
            ],
        ];
        
        foreach ($users as $user) {
            $userModel->insert($user);
        }

        // Seed Lokasi
        $lokasiModel = new \App\Models\LokasiModel();
        
        $lokasi = [
            [
                'name' => 'Kantor Pusat Jakarta',
                'latitude' => -6.200000,
                'longitude' => 106.816666,
                'radius' => 100
            ],
            [
                'name' => 'Cabang Bandung',
                'latitude' => -6.914744,
                'longitude' => 107.609810,
                'radius' => 150
            ],
            [
                'name' => 'Cabang Surabaya',
                'latitude' => -7.250445,
                'longitude' => 112.768845,
                'radius' => 150
            ]
        ];
        
        foreach ($lokasi as $l) {
            $lokasiModel->insert($l);
        }

        // Seed Lokasi User (assign lokasi ke user)
        $lokasiUserModel = new \App\Models\LokasiUserModel();
        
        $lokasiUsers = [
            ['user_id' => 2, 'lokasi_id' => 1], // Budi di Kantor Pusat
            ['user_id' => 3, 'lokasi_id' => 2], // Ani di Cabang Bandung
        ];
        
        foreach ($lokasiUsers as $lu) {
            $lokasiUserModel->insert($lu);
        }

        echo "Initial seeding completed!";
    }
}
