<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{


    public function run(): void
    {
        DB::table('users')->insert([
                'name' => 'Admin',
                'lastname' => 'User',
                'username' => 'admin',
                'role' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'bio' => 'The super admin of the platform.',
                'profile_pic' => null,
                'banner_pic' => null,
        ]);

        DB::table('users')->insert([
                'name' => 'User',
                'lastname' => 'Test',
                'username' => 'Test User',
                'role' => 'user',
                'subscribe' => '0',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678'),
                'bio' => 'Just a regular fan.',
                'profile_pic' => null,
                'banner_pic' => null,
                'weblink' => 'www.user.com',
        ]);

        DB::table('users')->insert([
                'name' => 'John',
                'lastname' => 'Doe',
                'username' => 'john_doe',
                'role' => 'user',
                'subscribe' => '0',
                'email' => 'john@gmail.com',
                'password' => Hash::make('12345678'),
                'bio' => 'Just a regular fan.',
                'profile_pic' => null,
                'banner_pic' => null,
                'weblink' => 'www.user.com',
        ]);
    }


}
