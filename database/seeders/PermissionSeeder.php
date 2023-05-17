<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'name' => 'write-articles',
                'guard_name' => 'web',
            ],
            [
                'id' => 2,
                'name' => 'edit-articles',
                'guard_name' => 'web',
            ],
            [
                'id' => 3,
                'name' => 'delete-articles',
                'guard_name' => 'web',
            ],
            [
                'id' => 4,
                'name' => 'write-draft',
                'guard_name' => 'web',
            ],
            [
                'id' => 5,
                'name' => 'edit-draft',
                'guard_name' => 'web',
            ],
            [
                'id' => 6,
                'name' => 'write-question',
                'guard_name' => 'web',
            ],
            [
                'id' => 7,
                'name' => 'edit-question',
                'guard_name' => 'web',
            ],
            [
                'id' => 8,
                'name' => 'delete-question',
                'guard_name' => 'web',
            ],
            [
                'id' => 9,
                'name' => 'write-draft-question',
                'guard_name' => 'web',
            ],
            [
                'id' => 10,
                'name' => 'edit-draft-question',
                'guard_name' => 'web',
            ],
            [
                'id' => 11,
                'name' => 'write-comment',
                'guard_name' => 'web',
            ],
            [
                'id' => 12,
                'name' => 'write-report',
                'guard_name' => 'web',
            ],
            [
                'id' => 13,
                'name' => 'delete-report',
                'guard_name' => 'web',
            ],
            [
                'id' => 14,
                'name' => 'follow-tag',
                'guard_name' => 'web',
            ],
            [
                'id' => 15,
                'name' => 'unfollow-tag',
                'guard_name' => 'web',
            ],
        ]);

        DB::table('role_has_permissions')->insert([
            [
                'permission_id' => 1,
                'role_id' => 3,
            ],
            [
                'permission_id' => 2,
                'role_id' => 3,
            ],
            [
                'permission_id' => 3,
                'role_id' => 3,
            ],
            [
                'permission_id' => 4,
                'role_id' => 3,
            ],
            [
                'permission_id' => 5,
                'role_id' => 3,
            ],
            [
                'permission_id' => 6,
                'role_id' => 3,
            ],
            [
                'permission_id' => 7,
                'role_id' => 3,
            ],
            [
                'permission_id' => 8,
                'role_id' => 3,
            ],
            [
                'permission_id' => 9,
                'role_id' => 3,
            ],
            [
                'permission_id' => 10,
                'role_id' => 3,
            ],
            [
                'permission_id' => 11,
                'role_id' => 3,
            ],
            [
                'permission_id' => 12,
                'role_id' => 3,
            ],
            [
                'permission_id' => 13,
                'role_id' => 3,
            ],
            [
                'permission_id' => 14,
                'role_id' => 3,
            ],
            [
                'permission_id' => 15,
                'role_id' => 3,
            ],
        ]);
    }
}
