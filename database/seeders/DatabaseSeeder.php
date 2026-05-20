<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dcfm.com'],
            [
                'name' => 'Admin Demo',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'requested_role' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'judge@dcfm.com'],
            [
                'name' => 'Judge Demo',
                'password' => Hash::make('password'),
                'role' => 'judge',
                'requested_role' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'lawyer@dcfm.com'],
            [
                'name' => 'Lawyer Demo',
                'password' => Hash::make('password'),
                'role' => 'lawyer',
                'requested_role' => null,
            ]
        );
    }
}