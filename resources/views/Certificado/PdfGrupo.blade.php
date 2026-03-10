<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificados Grupales</title>
    <style>
        .page-break {
            page-break-after: always;
        }
        .page-break:last-child {
            page-break-after: avoid;
        }
    </style>
</head>
<body>
    @foreach($bulkData as $data)
        <div class="page-break">
            @include('Certificado.Pdf', [
                'estudiante'       => $data['estudiante'],
                'grado_solicitado' => $data['grado_solicitado'],
                'notas'            => $data['notas'],
                'matricula'        => $data['matricula'],
                'anho_lectivo'     => $data['anho_lectivo'],
                'fecha'            => $fecha
            ])
        </div>
    @endforeach
</body>
</html>
