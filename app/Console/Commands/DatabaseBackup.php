<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:backup-db';
    protected $description = 'Realiza un respaldo de la base de datos si hubo cambios en las últimas 24 horas.';

    public function handle()
    {
        $this->info('Iniciando proceso de backup...');

        // 1. Verificar si hubo cambios en las últimas 24 horas
        $cambios = \App\Models\Audit::where('created_at', '>=', now()->subDay())->exists();

        if (!$cambios) {
            $this->info('No se detectaron cambios en las últimas 24 horas. Backup omitido.');
            return 0;
        }

        // 2. Preparar variables de entorno
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        $backupDir = storage_path('app/backups');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $filename = "db_backup_" . date('Y-m-d_H-i-s') . ".sql";
        $filePath = $backupDir . DIRECTORY_SEPARATOR . $filename;

        // 3. Ejecutar mysqldump
        // En Windows (Laragon), mysqldump suele estar en el PATH o se puede llamar directamente.
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($host),
            escapeshellarg($database),
            escapeshellarg($filePath)
        );

        $this->info("Ejecutando volcado a: {$filename}");
        
        $result = null;
        $output = [];
        exec($command, $output, $result);

        if ($result === 0) {
            $this->info("¡Backup completado con éxito! Guardado en: storage/app/backups/{$filename}");
            
            // Limpiar backups antiguos (más de 30 días)
            $this->cleanupOldBackups($backupDir);
            
            return 0;
        } else {
            $this->error("Error al ejecutar mysqldump. Código de error: " . $result);
            return 1;
        }
    }

    protected function cleanupOldBackups($dir)
    {
        $files = glob($dir . '/*.sql');
        $now = time();
        $days = 30;

        foreach ($files as $file) {
            if (is_file($file)) {
                if ($now - filemtime($file) >= $days * 24 * 60 * 60) {
                    unlink($file);
                }
            }
        }
    }
}
