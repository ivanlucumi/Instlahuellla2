<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado de Notas - {{ $estudiante->user->name }}</title>
    <style>
        @page {
            margin: 2cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            line-height: 1.4;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 22px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            color: #7f8c8d;
            font-size: 14px;
        }
        .student-info {
            width: 100%;
            margin-bottom: 25px;
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
        }
        .student-info td {
            padding: 4px 0;
        }
        .label {
            font-weight: bold;
            color: #2c3e50;
            width: 120px;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .grades-table th {
            background-color: #2c3e50;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            padding: 10px;
            border: 1px solid #1a252f;
            font-size: 10px;
        }
        .grades-table td {
            padding: 8px 10px;
            border: 1px solid #dcdde1;
            text-align: center;
        }
        .grades-table .subject-name {
            text-align: left;
            font-weight: bold;
            color: #2c3e50;
        }
        .promedio-final {
            background-color: #ecf0f1;
            font-weight: bold;
            color: #2980b9;
        }
        .footer {
            margin-top: 60px;
            width: 100%;
        }
        .signature-box {
            width: 200px;
            border-top: 1px solid #333;
            text-align: center;
            margin: 0 auto;
            padding-top: 10px;
        }
        .date-footer {
            text-align: right;
            margin-top: 20px;
            font-style: italic;
            font-size: 10px;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(0, 0, 0, 0.03);
            z-index: -1;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="watermark">CERTIFICADO</div>

    <div class="header">
        <h1>INSTITUCIÓN EDUCATIVA "LA HUELLA"</h1>
        <p>Departamento de Registro Académico</p>
        <p>Certificado Oficial de Calificaciones</p>
    </div>

    <div class="student-info">
        <table style="width: 100%;">
            <tr>
                <td class="label">Estudiante:</td>
                <td>{{ $estudiante->user->name }}</td>
                <td class="label">Código:</td>
                <td>{{ $estudiante->codigo_estudiante }}</td>
            </tr>
            <tr>
                <td class="label">Grado:</td>
                <td>{{ $estudiante->gradoAcademico->nombre_grado ?? 'N/A' }} - {{ $estudiante->gradoAcademico->bloque ?? '' }}</td>
                <td class="label">Año Escolar:</td>
                <td>{{ $anhoEscolar->nombre_anho_escolar }}</td>
            </tr>
            <tr>
                <td class="label">Tipo ID:</td>
                <td>{{ $estudiante->tipo_identificacion_estudiante }}</td>
                <td class="label">Documento:</td>
                <td>{{ $estudiante->numero_identificacion_estudiante }}</td>
            </tr>
        </table>
    </div>

    <table class="grades-table">
        <thead>
            <tr>
                <th style="width: 40%;">Asignatura</th>
                @foreach($periodos as $periodo)
                    <th>{{ $periodo->nombre_periodo }}</th>
                @endforeach
                <th style="width: 15%;">Promedio Final</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asignaturas as $item)
                <tr>
                    <td class="subject-name">{{ $item['nombre'] }}</td>
                    @foreach($periodos as $periodo)
                        <td>
                            {{ $item['notas'][$periodo->id] ?? '-' }}
                        </td>
                    @endforeach
                    <td class="promedio-final">
                        {{ number_format($item['promedio'], 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f2f2f2;">
                <td colspan="{{ count($periodos) + 1 }}" style="text-align: right; font-weight: bold; padding: 10px;">
                    Promedio General:
                </td>
                <td style="font-weight: bold; font-size: 14px; color: #c0392b;">
                    @php
                        $promedios = collect($asignaturas)->pluck('promedio');
                        $promedioGeneral = $promedios->avg();
                    @endphp
                    {{ number_format($promedioGeneral, 2) }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <div class="signature-box">
                        <p style="margin-bottom: 40px;"></p>
                        <p><strong>SECRETARÍA ACADÉMICA</strong></p>
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="signature-box">
                        <p style="margin-bottom: 40px;"></p>
                        <p><strong>DIRECCIÓN / COORDINACIÓN</strong></p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="date-footer">
        Documento generado el día {{ $fecha }} - Institución Educativa La Huella
    </div>
</body>
</html>
