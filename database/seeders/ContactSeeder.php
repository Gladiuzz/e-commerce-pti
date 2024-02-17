<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
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
                'address' => '795 Folsom Ave, Suite 600 San Francisco, CA 94107 P: (123) 456-7890',
                'phone' => '(123) 456-7890',
                'description' => 'Consectetur adipisicing elit. Aut eaque, totam corporis laboriosam veritatis quis ad perspiciatis, totam corporis laboriosam veritatis, consectetur adipisicing elit quos non quis ad perspiciatis, totam corporis ea,',
                'mail' => 'pasarTani@mail.com',
            ],
        ];

        DB::table('contacts')->insert($data);
    }
}
