<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OwnerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('owners')->insert([
            'name' => '1987Haus Admin',
            'email' => '1987haus@gmail.com',
            'password' => hash('sha256', '1987haus'), 
        ]);
    }
}