<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

$tables = [
    'users' => ['App\Models\User', 'UserSeeder'],
    'rol' => ['App\Models\Rol', 'RolSeeder'],
    'rol_user' => [null, 'RolUserSeeder'], // Pivot
    'sedes' => ['App\Models\Sede', 'SedeSeeder'],
    'hilos' => ['App\Models\Hilo', 'HiloSeeder'],
    'asignaturas' => ['App\Models\Asignatura', 'AsignaturaSeeder'],
    'cursos' => ['App\Models\Curso', 'CursoSeeder'],
    'docentes' => ['App\Models\Docente', 'DocenteSeeder'],
    'grado_academicos' => ['App\Models\GradoAcademico', 'GradoAcademicoSeeder'],
    'acudientes' => ['App\Models\Acudiente', 'AcudienteSeeder'],
    'estudiantes' => ['App\Models\Estudiante', 'EstudianteSeeder'],
    'anho_escolar' => ['App\Models\AnhoEscolar', 'AnhoEscolarSeeder'],
    'periodo_academicos' => ['App\Models\PeriodoAcademico', 'PeriodoAcademicoSeeder'],
    'matriculados' => ['App\Models\Matriculado', 'MatriculadoSeeder'],
    'asignatura_grado_docente' => [null, 'AsignaturaGradoDocenteSeeder'], // Pivot
    'menu' => ['App\Models\Menu', 'MenuSeeder'],
];

foreach ($tables as $tableName => $info) {
    echo "Processing table: $tableName...\n";
    $modelClass = $info[0];
    $seederName = $info[1];
    
    $records = DB::table($tableName)->get()->toArray();
    $recordsArray = json_decode(json_encode($records), true);
    
    // Chunk records if too large (to avoid PHP memory limits or huge files)
    // Actually, let's keep it simple first.
    
    $export = var_export($recordsArray, true);
    
    $content = "<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse Illuminate\\Support\Facades\\DB;\n\nclass $seederName extends Seeder\n{\n    public function run(): void\n    {\n";
    
    if ($modelClass) {
        $content .= "        \$data = $export;\n\n";
        $content .= "        foreach (\$data as \$row) {\n";
        $content .= "            \\$modelClass::updateOrCreate(['id' => \$row['id']], \$row);\n";
        $content .= "        }\n";
    } else {
        // Pivot or no model
        $content .= "        DB::table('$tableName')->truncate();\n";
        $content .= "        \$data = $export;\n\n";
        $content .= "        foreach (\$data as \$chunk) {\n";
        $content .= "             DB::table('$tableName')->insert(\$chunk);\n";
        $content .= "        }\n";
        // Wait, insert() takes an array of arrays or single array.
        // Let's use a more robust way for pivots.
    }
    
    $content = "<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\nuse Illuminate\\Support\Facades\\DB;\n";
    if ($modelClass) $content .= "use $modelClass;\n";
    $content .= "\nclass $seederName extends Seeder\n{\n    public function run(): void\n    {\n";
    
    if ($modelClass) {
        $content .= "        \$data = $export;\n\n";
        $content .= "        foreach (\$data as \$row) {\n";
        $content .= "            " . class_basename($modelClass) . "::updateOrCreate(['id' => \$row['id']], \$row);\n";
        $content .= "        }\n";
    } else {
        $content .= "        DB::table('$tableName')->truncate();\n";
        $content .= "        \$data = $export;\n\n";
        $content .= "        foreach (array_chunk(\$data, 100) as \$chunk) {\n";
        $content .= "            DB::table('$tableName')->insert(\$chunk);\n";
        $content .= "        }\n";
    }
    
    $content .= "    }\n}\n";
    
    file_put_contents(__DIR__ . "/database/seeders/$seederName.php", $content);
    echo "Generated $seederName.php\n";
}

echo "All seeders generated successfully.\n";
