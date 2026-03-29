<?php

$files = glob('app/Models/*.php');
foreach ($files as $file) {
    if (basename($file) === 'User.php') continue;
    
    $content = file_get_contents($file);
    if (strpos($content, 'extends Model') !== false) {
        $lines = explode("\n", $content);
        $newLines = [];
        $foundImport = false;
        
        foreach ($lines as $line) {
            // Remove existing imports if they exist to avoid duplicates or broken lines
            if (strpos($line, 'use Illuminate\Database\Eloquent\Model;') !== false) {
                continue; 
            }
            
            $newLines[] = $line;
            
            if (strpos($line, 'namespace App\Models;') !== false && !$foundImport) {
                $newLines[] = "";
                $newLines[] = "use Illuminate\Database\Eloquent\Model;";
                $foundImport = true;
            }
        }
        
        file_put_contents($file, implode("\n", $newLines));
        echo "Fixed $file\n";
    }
}
