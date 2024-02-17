<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
                'status' => 'active',
            ],
            [
                'name' => 'penjual',
                'username' => 'penjual',
                'email' => 'penjual@gmail.com',
                'password' => bcrypt('penjual123'),
                'role' => 'seller',
                'status' => 'active',
            ],
            [
                'name' => 'pelanggan',
                'username' => 'pelanggan',
                'email' => 'pelanggan@gmail.com',
                'password' => bcrypt('pelanggan123'),
                'role' => 'customer',
                'status' => 'active',
            ]
        ];

        DB::table('users')->insert($data);
    }
}
