<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_users')->insert(
            [
                'name' => 'admin_cuan',
                'email' => 'admin@cuan.com',
                'password' => bcrypt('pass.cuan123'),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
