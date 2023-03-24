<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Khai Nguyenx',
        //     'email' => 'khainguyenx@gmail.com'
        // ]);
        // $roles = [
        //     [
        //         'name' => 'admin',
        //         'created_at' => now(),
        //     ],
        //     [
        //         'name' => 'user',
        //         'created_at' => now(),
        //     ]
        // ];

        // DB::table('roles')->insert($roles);
        // DB::table('user_roles')->insert([
        //     'user_id' => 1,
        //     'role_id' => 1
        // ]);
        // for ($i = 0; $i < 10; $i++) {
        //     $name = Str::random(10); // Generate a random name
        //     $slug = Str::slug($name); // Generate a slug from the name
        //     DB::table('tags')->insert([
        //         'name' => $name,
        //         'slug' => $slug,
        //     ]);
        // }
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
    }
}
