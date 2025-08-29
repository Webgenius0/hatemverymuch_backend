<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // other seeders...
        ]);
<<<<<<< HEAD
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test Admin',
        //     'email' => 'admin@admin.com',
        //     'password' => '12345678',
        // ]);
        // $roles = ['fans', 'creator', 'admin'];

        // foreach ($roles as $roleName) {
        //     Role::firstOrCreate(['name' => $roleName]);
        // }
=======

>>>>>>> 32c7546a4e8da50d913b3fa44d208c5056e5ef2a
    }
}
