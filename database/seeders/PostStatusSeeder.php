<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('post_statuses')->insert([
            [
                'name' => 'Công khai',
                'describe' => 'Tất cả mọi người',
                'is_default' => true,
            ],
            [
                'name' => 'Riêng tư',
                'describe' => 'Chỉ mình tôi',
                'is_default' => true,
            ],
            [
                'name' => 'Vi phạm',
                'describe' => 'Bài viết đang vi phạm quy định của trang',
                'is_default' => true,
            ]
        ]);
    }
}
