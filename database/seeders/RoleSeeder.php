<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'admin' 
            ],
            [ 
                'id' => 2,
                'name' => 'gues' 
            ],
            [
                'id' => 3,
                'name' => 'user' 
            ],
        ];
        foreach($roles as $role) {
            Role::create($role);
        }
    }
}
