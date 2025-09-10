<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attributes = ['email' => 'ahmed@moi.com'];
        $data = [
            'name' => 'ahmed',
            'password' => Hash::make('password'),
        ];
        // Only include role if the column exists in the current database
        if (Schema::hasColumn('users', 'role')) {
            $data['role'] = 'admin';
        }
        User::updateOrCreate($attributes, $data);
    }
}
