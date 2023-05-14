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
                'describe' => 'Được public lên hệ thống',
                'is_default' => true,
            ],
            [
                'name' => 'Bản nháp',
                'describe' => 'Bài viết được lưu dưới dạng bản nháp, không public lên hệ thống',
                'is_default' => true,
            ],
            [
                'name' => 'Vi phạm',
                'describe' => 'Bài viết đang vi phạm quy định của trang và không được public lên hệ thống',
                'is_default' => true,
            ]
        ]);
    }
}
