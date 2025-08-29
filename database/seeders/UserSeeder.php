<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'lastname' => 'User',
                'username' => 'admin',
                'role' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('12345678'),
                'bio' => 'The super admin of the platform.',
                'profile_pic' => null,
                'banner_pic' => null,
                'email_verified_at' => now(),
            ],
            [
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
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Jane',
                'lastname' => 'Smith',
                'username' => 'jane_smith',
                'role' => 'user',
                'subscribe' => '0',
                'email' => 'jane@gmail.com',
                'password' => Hash::make('12345678'),
                'bio' => 'Creative content user.',
                'profile_pic' => null,
                'banner_pic' => null,
                'weblink' => 'www.user.com',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Alice',
                'lastname' => 'Wonder',
                'username' => 'alice_wonder',
                'role' => 'user',
                'subscribe' => '0',
                'email' => 'alice@gmail.com',
                'password' => Hash::make('12345678'),
                'bio' => 'Love to follow users.',
                'profile_pic' => null,
                'banner_pic' => null,
                'weblink' => 'www.user.com',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Bob',
                'lastname' => 'Builder',
                'username' => 'bob_builder',
                'role' => 'user',
                'subscribe' => '1',
                'email' => 'bob@gmail.com',
                'password' => Hash::make('12345678'),
                'bio' => 'Building content daily.',
                'profile_pic' => null,
                'banner_pic' => null,
                'weblink' => 'www.user.com',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

    }
}
