<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Test',
                'email' => 'admin@admin.com',
                'password' => bcrypt('password123'),
                'email_verified_at' => now(),
            ],
        ];
        foreach($users as $user){
            User::updateOrCreate([
                'email' => $user['email']
            ],[
                'password' => $user['password'],
                'name' => $user['name'],
                'email_verified_at' => $user['email_verified_at'],
            ]);
        }
    }
}
