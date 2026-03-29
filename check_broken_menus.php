<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Ensure we have access to the Route facade
use Illuminate\Support\Facades\Route;
use App\Models\Menu;

$menus = Menu::all();
$broken = [];

foreach ($menus as $m) {
    if ($m->url && !Route::has($m->url)) {
        $broken[] = [
            'id' => $m->id,
            'nombre' => $m->nombre,
            'url' => $m->url,
            'submenu' => $m->nombre_submenu
        ];
    }
}

echo json_encode($broken, JSON_PRETTY_PRINT);
