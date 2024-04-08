<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        $admin = new User(
            [
                'name' => 'Collin',
                'email' => 'example@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'rolle' => 'admin'
            ]
        );
        $admin->save();
    }
}
