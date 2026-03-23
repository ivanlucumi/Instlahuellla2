<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe Valorativo - {{ $estudiante->user->name }}</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #000;
            line-height: 1.2;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
            position: relative;
        }
        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 70px;
        }
        .header-text {
            display: inline-block;
            width: 80%;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
            font-weight: normal;
        }
        .sub-header {
            text-align: center;
            margin-bottom: 15px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            text-transform: uppercase;
            font-weight: bold;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 2px 0;
        }
        .label {
            font-weight: bold;
            width: 180px;
        }
        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .grades-table th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            padding: 5px;
            border: 1px solid #000;
            text-align: center;
            font-size: 9px;
        }
        .grades-table td {
            padding: 4px;
            border: 1px solid #000;
            text-align: center;
        }
        .subject-col {
            text-align: left !important;
            font-weight: bold;
        }
        .scale-table {
            width: 100%;
            margin-top: 20px;
            font-size: 9px;
            border-collapse: collapse;
        }
        .scale-table th {
            text-align: left;
            padding-bottom: 5px;
        }
        .scale-table td {
            width: 25%;
        }
        .observations {
            margin-top: 30px;
        }
        .observations p {
            margin: 0;
            font-weight: bold;
        }
        .line {
            border-bottom: 1px solid #000;
            height: 15px;
            margin-bottom: 5px;
        }
        .footer-sign {
            margin-top: 15px;
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('panelAdmin/img/LOGOROMBO1.png') }}" class="logo">
        <div class="header-text">
            <h1>CENTRO EDUCATIVO RURAL MIXTO LA HUELLA</h1>
            <p>Resolución 0434 del 26 de abril del 2004 y 10695 del 30 de diciembre de 2009</p>
            <p>CODIGO DANE 219142000506</p>
            <p>RESGUARDO INDIGENA DE HUELLAS CALOTO</p>
            <p>MUNICIPIO DE CALOTO CAUCA</p>
            <p>Sede: {{ $matricula->sede->nombre_sede ?? 'C.E.R.M LA HUELLA' }}</p>
        </div>
    </div>

    <div class="sub-header">
        @if(isset($periodo))
            BOLETÍN DE CALIFICACIONES - {{ strtoupper($periodo->nombre_periodo) }} <br>
        @else
            INFORME VALORATIVO FINAL <br>
        @endif
        AÑO LECTIVO: {{ $anho_lectivo }} <br>
        GRADO: {{ strtoupper($grado_solicitado) }}
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Grado / Nivel:</td>
            <td style="font-weight: bold; font-size: 11px;">{{ strtoupper($grado_solicitado) }}</td>
            <td class="label" style="width: 50px;">Grupo:</td>
            <td>{{ $notas->first()->curso ?? '1' }}</td>
        </tr>
        <tr>
            <td class="label">Nombres y Apellidos Del Estudiante:</td>
            <td colspan="3" style="font-weight: bold; font-size: 12px;">{{ strtoupper($estudiante->user->name) }}</td>
        </tr>
        <tr>
            <td class="label">Documento:</td>
            <td colspan="3">{{ $estudiante->numero_identificacion_estudiante }}</td>
        </tr>
    </table>

    <table class="grades-table">
        <thead>
            <tr>
                <th style="width: 45%;">NUCLEO y ASIGNATURAS</th>
                <th>PER-1</th>
                <th>PER-2</th>
                <th>PER-3</th>
                <th>PER-4</th>
                <th>FINAL</th>
            </tr>
        </thead>
        <tbody>
            @php $currentNucleo = null; @endphp
            @foreach($notas as $nota)
                @if($nota->nucleo != $currentNucleo)
                    <tr style="background-color: #f9f9f9;">
                        <td colspan="6" style="text-align: left; padding-left: 10px; font-weight: bold; border-top: 2px solid #000;">
                            NUCLEO: {{ strtoupper($nota->nucleo) }}
                        </td>
                    </tr>
                    @php $currentNucleo = $nota->nucleo; @endphp
                @endif
                <tr>
                    <td class="subject-col">{{ $nota->nombre_asignatura }}</td>
                    <td>{{ $nota->nota_per1 > 0 ? number_format($nota->nota_per1, 1) : '-' }}</td>
                    <td>{{ $nota->nota_per2 > 0 ? number_format($nota->nota_per2, 1) : '-' }}</td>
                    <td>{{ $nota->nota_per3 > 0 ? number_format($nota->nota_per3, 1) : '-' }}</td>
                    <td>{{ $nota->nota_per4 > 0 ? number_format($nota->nota_per4, 1) : '-' }}</td>
                    <td style="font-weight: bold;">
                        @php
                            $notasValidas = array_filter([$nota->nota_per1, $nota->nota_per2, $nota->nota_per3, $nota->nota_per4], fn($v) => $v > 0);
                            $count = count($notasValidas);
                        @endphp
                        @if($count >= 3)
                            {{ number_format($nota->nota_definitiva, 1) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="scale-table">
        <tr>
            <th colspan="4">ESCALA DE VALORACION NACIONAL:</th>
        </tr>
        <tr>
            <td>Desempeño Superior 4.8 - 5.0</td>
            <td>Desempeño Alto 4.0 - 4.7</td>
            <td>Desempeño Basico 3.0 - 3.9</td>
            <td>Desempeño Bajo 1.0 - 2.9</td>
        </tr>
    </table>

    <div class="observations">
        <p>Observaciones:</p>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
        <div class="footer-sign">
            DOCENTE DIRECTOR DEL GRADO ACADEMICO: {{ strtoupper($matricula->profesor->name ?? 'N/A') }}
        </div>
    </div>
</body>
</html>
