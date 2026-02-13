<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['id' => 200],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@sistema.com',
                'password' => Hash::make('password123')
            ]
        );

        User::updateOrCreate(
            ['id' => 2],
            [
                'name' => 'Estudiante',
                'email' => 'estudiante@sistema.com',
                'password' => Hash::make('password123')
            ]
        );

        User::updateOrCreate(
            ['id' => 3],
            [
                'name' => 'Rector',
                'email' => 'rector@sistema.com',
                'password' => Hash::make('password123')
            ]
        );
        User::updateOrCreate(
            ['id' => 4],
            [
                'name' => 'Docente',
                'email' => 'docente@sistema.com',
                'password' => Hash::make('password123')
            ]
        );
    }
}
