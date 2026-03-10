<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RolSeeder::class,
            RolUserSeeder::class,
            SedeSeeder::class,
            HiloSeeder::class,
            AsignaturaSeeder::class,
            CursoSeeder::class,
            DocenteSeeder::class,
            GradoAcademicoSeeder::class,
            AcudienteSeeder::class,
            EstudianteSeeder::class,
            AnhoEscolarSeeder::class,
            PeriodoAcademicoSeeder::class,
            MatriculadoSeeder::class,
            AsignaturaGradoDocenteSeeder::class,
            MenuSeeder::class,
        ]);

        /*User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
