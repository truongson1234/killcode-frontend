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
        for ($i = 0; $i < 10; $i++) {
            $name = Str::random(10); // Generate a random name
            $slug = Str::slug($name); // Generate a slug from the name
            DB::table('tags')->insert([
                'name' => $name,
                'slug' => $slug,
            ]);
        }
        $this->call(RoleSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(PostStatusSeeder::class);
    }
}
