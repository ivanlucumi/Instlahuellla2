<?php
$files = glob('app/Models/*.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    if (strpos($content, 'extends Model') !== false && strpos($content, 'use Illuminate\Database\Eloquent\Model;') === false) {
        echo $file . " is missing Model import\n";
    }
}
