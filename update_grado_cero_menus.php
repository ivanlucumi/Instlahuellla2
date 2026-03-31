<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Menu;

// 1. IDs identified as "Grado Cero" are 40, 41, 42 (from previous research)
$ids = [40, 41, 42];
$roles = [1, 3, 7]; // SuperAdmin, Rector, Secretario

echo "Restricting and duplicating Grado Cero menus...\n";

// Update originals to role 1 (SuperAdmin)
Menu::whereIn('id', $ids)->update(['rol_id' => 1]);

// Clone for roles 3 and 7
foreach ([3, 7] as $rolId) {
    echo "Cloning for Role ID: $rolId\n";
    foreach ($ids as $id) {
        $original = Menu::find($id);
        if ($original) {
            $clone = $original->replicate();
            $clone->rol_id = $rolId;
            $clone->save();
        }
    }
}

echo "Done.\n";
