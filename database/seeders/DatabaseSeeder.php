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
        $tags = [
            [
                'name' => 'php',
                'slug' => 'php'
            ],
            [
                'name' => 'javascript',
                'slug' => 'javascript'
            ],
            [
                'name' => 'vue',
                'slug' => 'vue'
            ],
            [
                'name' => 'mysql',
                'slug' => 'mysql'
            ],
            [
                'name' => 'laravel',
                'slug' => 'laravel'
            ],
            [
                'name' => 'react',
                'slug' => 'react'
            ],
            [
                'name' => 'python',
                'slug' => 'python'
            ],
            [
                'name' => 'c#',
                'slug' => 'c#'
            ],
            [
                'name' => 'html',
                'slug' => 'html'
            ],
            [
                'name' => 'css',
                'slug' => 'css'
            ],
        ];
        for ($i = 0; $i < count($tags); $i++) {
            $name = $tags[$i]['name']; 
            $slug = Str::slug($tags[$i]['slug']);
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
