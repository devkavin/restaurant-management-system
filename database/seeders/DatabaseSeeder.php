<?php

namespace Database\Seeders;

use App\Models\Concession;
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
        $this->call(PermissionSeeder::class);
        $this->call(ConcessionsSeeder::class);
        Concession::factory(1000)->create();
        $this->createAdminUser();
        $this->createStaffUser();
        User::factory(50)->create()->each(function ($user) {
            // default role is Staff
            $user->assignRole('Staff');
        });
    }

    private function createAdminUser(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('Admin');
    }

    private function createStaffUser(): void
    {
        $user = User::create([
            'name' => 'Staff User',
            'email' => 'staff@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('Staff');
    }
}
