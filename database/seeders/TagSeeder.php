<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            [
                'name' => 'php',
                'thumbnail' => 'php.png',
                'slug' => 'php',
            ],
            [
                'name' => 'javascript',
                'thumbnail' => 'javascript.png',
                'slug' => 'javascript',
            ],
            [
                'name' => 'vue',
                'thumbnail' => 'vue.png',
                'slug' => 'vue',
            ],
            [
                'name' => 'mysql',
                'thumbnail' => 'mysql.png',
                'slug' => 'mysql',
            ],
            [
                'name' => 'laravel',
                'thumbnail' => 'laravel.png',
                'slug' => 'laravel',
            ],
            [
                'name' => 'react',
                'thumbnail' => 'react.png',
                'slug' => 'react',
            ],
            [
                'name' => 'python',
                'thumbnail' => 'python.png',
                'slug' => 'python',
            ],
            [
                'name' => 'c#',
                'thumbnail' => 'c-sharp.png',
                'slug' => 'c#',
            ],
            [
                'name' => 'html',
                'thumbnail' => 'html.png',
                'slug' => 'html',
            ],
            [
                'name' => 'css',
                'thumbnail' => 'css.png',
                'slug' => 'css',
            ],
        ];
        foreach($tags as $tag) {
            Tag::create($tag);
        }
    }
}