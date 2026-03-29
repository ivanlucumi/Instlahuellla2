<?php
$files = glob('app/Models/*.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    $hasExtendsModel = strpos($content, 'extends Model') !== false;
    $hasUseModel = strpos($content, 'use Illuminate\Database\Eloquent\Model;') !== false;
    
    echo "Checking $file: Extends=" . ($hasExtendsModel ? 'Yes' : 'No') . ", HasUse=" . ($hasUseModel ? 'Yes' : 'No') . "\n";
    
    if ($hasExtendsModel && !$hasUseModel) {
        echo "!!! CRITICAL: $file is missing Model import\n";
    }
}
