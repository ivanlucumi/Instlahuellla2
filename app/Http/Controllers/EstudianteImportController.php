<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Estudiante;
use App\Models\MatriculaFinal;
use App\Models\GradoAcademico;
use App\Models\Rol;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EstudianteImportController extends Controller
{
    public function index()
    {
        return view('Estudiante.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // Skip header
        fgetcsv($handle, 1000, ";"); // Assuming semicolon delimiter as per common Latin American Excel exports

        $importedCount = 0;
        $errors = [];
        $line = 1;

        DB::beginTransaction();
        try {
            $studentRole = Rol::where('nombre', 'ESTUDIANTE')->first();
            
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                $line++;
                // Image structure:
                // 0: GRADO (TEXTO)
                // 1: NOMBRE1
                // 2: NOMBRE2
                // 3: APELLIDO1
                // 4: APELLIDO2
                // 5: DOC
                // 6: TIPODOC
                // 7: GENERO
                // 8: FECHA_NACI
                // 9: GRADO (ID)
                // 10: SEDE (ID)
                // 11: AÑO      
                // 12: CURSO

                if (count($data) < 12) {
                    $errors[] = "Línea $line: No tiene suficientes columnas.";
                    continue;
                }

                $gradoTxt = $data[0];
                $n1 = $data[1];
                $n2 = $data[2];
                $a1 = $data[3];
                $a2 = $data[4];
                $doc = $data[5];
                $tipoDoc = $data[6];
                $genero = $data[7];
                $fechaNaci = $data[8];
                $gradoId = $data[9];
                $sedeId = $data[10];
                $anho = $data[11];
                $curso = $data[12];

                if (empty($doc)) continue;

                // Find Director (Docente) of the Grade
                $grado = GradoAcademico::find($gradoId);
                $directorId = $grado ? $grado->docente_id : auth()->id();

                // 1. Create User
                $fullName = trim("$n1 $n2 $a1 $a2");
                $email = $doc . "@instlahuella.edu.co"; // Or as required
                
                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => $fullName,
                        'genero' => (strtoupper($genero) == 'MASCULINO') ? 'Masculino' : 'Femenino',
                        'password' => Hash::make($doc),
                    ]
                );
                

                if ($studentRole && !$user->hasRol('ESTUDIANTE')) {
                    $user->roles()->attach($studentRole->id);
                }

                // 2. Create Estudiante
                $estudiante = Estudiante::updateOrCreate(
                    ['numero_identificacion_estudiante' => $doc],
                    [
                        'user_id' => $user->id,
                        'codigo_estudiante' => $doc,
                        'fecha_nacimiento_estudiante' => $fechaNaci,
                        'genero_estudiante' => $user->genero,
                        'tipo_identificacion_estudiante' => $tipoDoc,
                        'acudiente_id' => 1, // Default 1111111111
                        'grado_academico_id' => $gradoId,
                        'estado_estudiante' => 1,
                        'email_estudiante' => $email,
                    ]
                );
                

                // 3. Matricula Final Record
                $Matricula= MatriculaFinal::updateOrCreate(
                    [
                        'documento_estudiante' => $doc,
                        'ano_lectivo' => $anho,
                        'id_grado' => $gradoId
                    ],
                    [
                        'id_sede' => $sedeId,
                        'curso' => $curso,
                        'fecha' => now(),
                        'estado' => 'Matriculado',
                        'id_profesor' => $directorId,
                        'documento_acudiente' => '1111111111',
                        'parentezco_acudiente' => 'Otro'
                    ]
                );

               // DD($user,$estudiante,$Matricula);

                $importedCount++;
            }

            DB::commit();
            fclose($handle);

            return redirect()->back()->with('swal', [
                'icon' => 'success',
                'title' => 'Importación Completada',
                'text' => "Se han importado/actualizado $importedCount estudiantes."
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            return redirect()->back()->with('swal', [
                'icon' => 'error',
                'title' => 'Error en la Importación',
                'text' => $e->getMessage()
            ]);
        }
    }
}
