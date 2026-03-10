<?php

use App\Models\User;
use App\Models\RolUser;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

function exportToSeeder($modelClass, $seederName, $fileName) {
    echo "Exporting $modelClass...\n";
    $records = $modelClass::all()->toArray();
    $export = var_export($records, true);

    // Fix namespace and escaping if needed
    $namespaceModel = str_replace('\\', '\\\\', $modelClass);

    $content = "<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\n\nclass $seederName extends Seeder\n{\n    public function run(): void\n    {\n        \$data = $export;\n\n        foreach (\$data as \$row) {\n            \\$namespaceModel::updateOrCreate(['id' => \$row['id']], \$row);\n        }\n    }\n}\n";

    file_put_contents(__DIR__ . "/database/seeders/$fileName", $content);
    echo "Generated $fileName\n";
}

// Para RolUser no usamos 'id' como clave única primaria usualmente, sino el par rol_id, user_id
// Pero el modelo RolUser podría no tener 'id' auto-increment.
// Vamos a ver la estructura de rol_user.

exportToSeeder(User::class, 'UserSeeder', 'UserSeeder.php');

// Custom export for RolUser
echo "Exporting RolUser...\n";
$rolUsers = DB::table('rol_user')->get()->toArray();
$rolUsersArray = json_decode(json_encode($rolUsers), true);
$exportRolUsers = var_export($rolUsersArray, true);

$contentRolUser = "<?php\n\nnamespace Database\\Seeders;\n\nuse Illuminate\\Database\\Seeder;\n\nclass RolUserSeeder extends Seeder\n{\n    public function run(): void\n    {\n        \$data = $exportRolUsers;\n\n        foreach (\$data as \$row) {\n            \\App\\Models\\RolUser::updateOrCreate(\n                ['rol_id' => \$row['rol_id'], 'user_id' => \$row['user_id']],\n                \$row\n            );\n        }\n    }\n}\n";

file_put_contents(__DIR__ . "/database/seeders/RolUserSeeder.php", $contentRolUser);
echo "Generated RolUserSeeder.php\n";

echo "Seeder regeneration complete.\n";
