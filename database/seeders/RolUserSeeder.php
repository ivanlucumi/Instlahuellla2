<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\RolUser;

class RolUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RolUser::updateOrCreate(
            [
                'rol_id' => 1,
                'user_id' => 200
            ]
        );
        RolUser::updateOrCreate(
            [
                'rol_id' => 2,
                'user_id' => 2
            ]
        );
        RolUser::updateOrCreate(
            [
                'rol_id' => 3,
                'user_id' => 3
            ]
        );
        RolUser::updateOrCreate(
            [
                'rol_id' => 4,
                'user_id' => 4
            ]
        );
    }
}
