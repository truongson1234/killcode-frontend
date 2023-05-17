<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list_user = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'avatar' => 'admin.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'gues',
                'email' => 'gues@gmail.com',
                'avatar' => 'gues.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Nguyễn Phú Khải',
                'email' => 'khainguyenx@gmail.com',
                'avatar' => 'user2.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Nguyễn Chí Trường Sơn',
                'email' => 'sonnguci@gmail.com',
                'avatar' => 'user3.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Đào Gia Khải',
                'email' => 'khainguci@gmail.com',
                'avatar' => 'user4.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Dương Quỳnh Trang',
                'email' => 'trangquynh@gmail.com',
                'avatar' => 'user5.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Billie Eilish',
                'email' => 'billie@gmail.com',
                'avatar' => 'user6.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Lisa',
                'email' => 'lisa@gmail.com',
                'avatar' => 'user7.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Rose',
                'email' => 'rose@gmail.com',
                'avatar' => 'user8.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Gái Alime',
                'email' => 'alime@gmail.com',
                'avatar' => 'user9.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Yuna Ogura',
                'email' => 'yuna@gmail.com',
                'avatar' => 'user10.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Remu Suzumori',
                'email' => 'remu@gmail.com',
                'avatar' => 'user11.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
            [
                'name' => 'Nguyễn Ngọc Trinh',
                'email' => 'ngoctrinh89@gmail.com',
                'avatar' => 'user12.png',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ],
        ];

        foreach($list_user as $user) {
            $newRole = User::create($user);
            if($user['email'] == 'admin@gmail.com') {
                $newRole->assignRole('admin');
            }
            if($user['email'] == 'gues@gmail.com') {
                $newRole->assignRole('gues');
            } else {
                $newRole->assignRole('user');
            }
        }
    }
}
