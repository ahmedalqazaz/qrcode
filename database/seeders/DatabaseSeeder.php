<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'ahmed',
            'email' => 'ahmed@moi.com',
        ]);

        // Create an initial admin user (if not exists)
        $this->call(\Database\Seeders\AdminUserSeeder::class);
    }
}
