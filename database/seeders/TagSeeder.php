<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert 10 random tags
        for ($i = 0; $i < 10; $i++) {
            $name = Str::random(10); // Generate a random name
            $slug = Str::slug($name); // Generate a slug from the name
            DB::table('tags')->insert([
                'name' => $name,
                'slug' => $slug,
            ]);
        }
    }
}