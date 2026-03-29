<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Get the current order of "Grados Académicos"
$gradoAcademico = \DB::table('menu')
    ->where('nombre', 'Institución')
    ->where('nombre_submenu', 'Grados Académicos')
    ->first();
    
$targetOrder = $gradoAcademico ? ((int)$gradoAcademico->orden) + 1 : 99;

// Move all Grado Cero items into Institucion
$items = \DB::table('menu')->where('nombre', 'Grado Cero')->get();
foreach($items as $item) {
    if (!$item->nombre_submenu) {
        // Parent menu stub itself, can be deleted or ignored.
        \DB::table('menu')->where('id', $item->id)->delete();
        continue;
    }
    
    // Shift others down
    \DB::table('menu')
        ->where('nombre', 'Institución')
        ->where('orden', '>=', $targetOrder)
        ->update(['orden' => \DB::raw('orden + 1')]);
        
    \DB::table('menu')->where('id', $item->id)->update([
        'nombre' => 'Institución',
        'orden' => $targetOrder
    ]);
    
    $targetOrder++;
}

echo "Moved " . count($items) . " items.\n";

$allInstitucion = \DB::table('menu')->where('nombre', 'Institución')->orderBy('orden')->get();
foreach($allInstitucion as $m) {
    echo "- " . $m->nombre_submenu . " (Orden: " . $m->orden . ")\n";
}
