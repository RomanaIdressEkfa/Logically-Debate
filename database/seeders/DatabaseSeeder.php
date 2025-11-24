<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run()
    {
        // Check if admin exists to prevent duplicates
        if (!User::where('email', 'logicallydebate@gmail.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'logicallydebate@gmail.com',
                'password' => Hash::make('logicallydebate'), // Your requested password
                'role' => 'admin',
                'is_approved' => true,
            ]);
        }
    }
}
