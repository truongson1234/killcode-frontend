<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        \App\Models\User::factory()->create([
            'name' => 'Khai Nguyenx',
            'email' => 'khainguyenx@gmail.com'
        ]);
        $roles = [
            [
                'name' => 'admin',
                'created_at' => now(),
            ],
            [
                'name' => 'user',
                'created_at' => now(),
            ]
        ];

        DB::table('roles')->insert($roles);
        DB::table('user_roles')->insert([
            'user_id' => 1,
            'role_id' => 1
        ]);
    }
}
