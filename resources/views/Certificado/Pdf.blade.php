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
            line-height: 1.3;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            position: relative;
        }

        .logo {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
        }

        .header-text {
            display: inline-block;
            width: 80%;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .header p {
            margin: 3px 0;
            font-size: 12px;
            font-weight: normal;
        }

        .sub-header {
            text-align: center;
            margin-bottom: 20px;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 8px 0;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 15px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 4px 0;
            font-size: 13px;
        }

        .label {
            font-weight: bold;
            width: 180px;
        }

        .grades-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .grades-table th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
            font-size: 12px;
        }

        .grades-table td {
            padding: 6px;
            border: 1px solid #000;
            text-align: center;
            font-size: 13px;
        }

        .subject-col {
            text-align: left !important;
            font-weight: bold;
        }

        .scale-table {
            width: 100%;
            margin-top: 25px;
            font-size: 12px;
            border-collapse: collapse;
        }

        .scale-table th {
            text-align: left;
            padding-bottom: 8px;
        }

        .scale-table td {
            width: 25%;
        }

        .observations {
            margin-top: 40px;
        }

        .observations p {
            margin: 0;
            font-weight: bold;
            font-size: 14px;
        }

        .line {
            border-bottom: 1px solid #000;
            height: 20px;
            margin-bottom: 8px;
        }

        .footer-sign {
            margin-top: 25px;
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }
    </style>
</head>

<body>
    @php
        $inst = $institucion ?? \App\Models\Institucion::first();
    @endphp
    <div class="header">
        <img src="{{ public_path('panelAdmin/img/LOGOROMBO1.png') }}" class="logo">
        <div class="header-text">
            <h1>{{ strtoupper($inst->nombre_institucion ?? 'INSTITUCIÓN EDUCATIVA TÉCNICA AGROPECUARIA LA HUELLA') }}
            </h1>
            <p>{{ $inst->resolucion_institucion ?? 'Resolución 0434 del 26 de abril del 2004 y 10695 del 30 de diciembre de 2009' }}
            </p>
            <p>CODIGO DANE {{ $inst->codigo_dane ?? '219142000506' }}</p>
            <p>{{ $inst->descripcion_institucion ?? 'RESGUARDO INDIGENA DE HUELLAS CALOTO' }}</p>
            <p>MUNICIPIO DE {{ strtoupper($inst->ciudad_institucion ?? 'CALOTO') }}
                {{ strtoupper($inst->departamento_institucion ?? 'CAUCA') }}
            </p>
            <p>Sede: {{ $matricula->sede->nombre_sede ?? 'C.E.R.M LA HUELLA' }}</p>
        </div>
    </div>

    <div class="sub-header">
        @if(isset($periodo))
            INFORME DE VALORACIONES - {{ strtoupper($periodo->nombre_periodo) }} <br>
        @else
            INFORME VALORATIVO<br>
        @endif
        AÑO LECTIVO: {{ $anho_lectivo }} <br>
        GRADO: {{ strtoupper($grado_solicitado) }}
    </div>

    <table class="info-table">
        <tr>
            <td class="label">Grado:</td>
            <td style="font-weight: bold; font-size: 14px;">{{ strtoupper($grado_solicitado) }}</td>
            <td class="label" style="width: 60px;">Grupo:</td>
            <td style="font-size: 14px; font-weight: bold;">{{ $notas->first()->curso ?? '1' }}</td>
        </tr>
        <tr>
            <td class="label">Nombres y Apellidos Del Estudiante:</td>
            <td colspan="3" style="font-weight: bold; font-size: 15px;">{{ strtoupper($estudiante->user->name) }}</td>
        </tr>
        <tr>
            <td class="label">Documento:</td>
            <td colspan="3" style="font-size: 14px;">{{ $estudiante->numero_identificacion_estudiante }}</td>
        </tr>
    </table>

    <table class="grades-table">
        <thead>
            <tr>
                <th style="width: 45%;">HILOS Y ASIGNATURAS</th>
                <th>&Eacute;POCA-1</th>
                <th>&Eacute;POCA-2</th>
                <th>&Eacute;POCA-3</th>
                <th>&Eacute;POCA-4</th>
                <th>FINAL</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $currentNucleo = null; 
                $hilosAverages = [];
                $notasAgrupadas = collect($notas)->groupBy('nucleo');
                foreach($notasAgrupadas as $nucleo => $notasDelNucleo) {
                    $sumPeriodo1 = 0; $countPeriodo1 = 0;
                    $sumPeriodo2 = 0; $countPeriodo2 = 0;
                    $sumPeriodo3 = 0; $countPeriodo3 = 0;
                    $sumPeriodo4 = 0; $countPeriodo4 = 0;

                    foreach($notasDelNucleo as $n) {
                        // Omitir guiones (-) mostrando, pero sumar valores para el cálculo
                        if($n->nota_per1 > 0) { $sumPeriodo1 += $n->nota_per1; $countPeriodo1++; }
                        if($n->nota_per2 > 0) { $sumPeriodo2 += $n->nota_per2; $countPeriodo2++; }
                        if($n->nota_per3 > 0) { $sumPeriodo3 += $n->nota_per3; $countPeriodo3++; }
                        if($n->nota_per4 > 0) { $sumPeriodo4 += $n->nota_per4; $countPeriodo4++; }
                    }
                    
                    $p1 = $countPeriodo1 > 0 ? ($sumPeriodo1 / $countPeriodo1) : 0;
                    $p2 = $countPeriodo2 > 0 ? ($sumPeriodo2 / $countPeriodo2) : 0;
                    $p3 = $countPeriodo3 > 0 ? ($sumPeriodo3 / $countPeriodo3) : 0;
                    $p4 = $countPeriodo4 > 0 ? ($sumPeriodo4 / $countPeriodo4) : 0;

                    $hilosAverages[$nucleo] = [
                        'per1' => $p1,
                        'per2' => $p2,
                        'per3' => $p3,
                        'per4' => $p4,
                        'definitiva' => ($p1 + $p2 + $p3 + $p4) / 4,
                    ];
                }
            @endphp
            @foreach($notas as $nota)
                @if($nota->nucleo != $currentNucleo)
                    <tr style="background-color: #e6e6e6;">
                        @php $avg = $hilosAverages[$nota->nucleo]; @endphp
                        <td style="text-align: left; padding-left: 10px; font-weight: bold; border-top: 2px solid #000; font-size: 13px;">
                            {{ strtoupper($nota->nucleo) }} <span style="font-size: 10px; font-weight: normal; color: #333;">(PROMEDIO)</span>
                        </td>
                        <td style="font-weight: bold; border-top: 2px solid #000; text-align: center;">{{ $avg['per1'] > 0 ? number_format($avg['per1'], 2) : '-' }}</td>
                        <td style="font-weight: bold; border-top: 2px solid #000; text-align: center;">{{ $avg['per2'] > 0 ? number_format($avg['per2'], 2) : '-' }}</td>
                        <td style="font-weight: bold; border-top: 2px solid #000; text-align: center;">{{ $avg['per3'] > 0 ? number_format($avg['per3'], 2) : '-' }}</td>
                        <td style="font-weight: bold; border-top: 2px solid #000; text-align: center;">{{ $avg['per4'] > 0 ? number_format($avg['per4'], 2) : '-' }}</td>
                        <td style="font-weight: bold; border-top: 2px solid #000; text-align: center;">{{ $avg['definitiva'] > 0 ? number_format($avg['definitiva'], 2) : '-' }}</td>
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
                            $n1 = $nota->nota_per1 > 0 ? $nota->nota_per1 : 0;
                            $n2 = $nota->nota_per2 > 0 ? $nota->nota_per2 : 0;
                            $n3 = $nota->nota_per3 > 0 ? $nota->nota_per3 : 0;
                            $n4 = $nota->nota_per4 > 0 ? $nota->nota_per4 : 0;
                            $def_calculada = ($n1 + $n2 + $n3 + $n4) / 4;
                        @endphp
                        {{ number_format($def_calculada, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $totalDefinitivas = 0;
        $countDefinitivas = 0;
        foreach ($notas as $itemNota) {
            $n1 = $itemNota->nota_per1 > 0 ? $itemNota->nota_per1 : 0;
            $n2 = $itemNota->nota_per2 > 0 ? $itemNota->nota_per2 : 0;
            $n3 = $itemNota->nota_per3 > 0 ? $itemNota->nota_per3 : 0;
            $n4 = $itemNota->nota_per4 > 0 ? $itemNota->nota_per4 : 0;
            
            if ($n1 > 0 || $n2 > 0 || $n3 > 0 || $n4 > 0) {
                $totalDefinitivas += ($n1 + $n2 + $n3 + $n4) / 4;
                $countDefinitivas++;
            }
        }
        $promedioGeneral = $countDefinitivas > 0 ? ($totalDefinitivas / $countDefinitivas) : 0;
    @endphp

    @if($promedioGeneral > 0)
        <table style="width: 100%; margin-bottom: 10px;">
            <tr>
                <td style="text-align: right; font-weight: bold; font-size: 14px;">PROMEDIO GENERAL:
                    {{ number_format($promedioGeneral, 2) }}
                </td>
                <td style="width: 10%;"></td>
            </tr>
        </table>
    @endif

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
            <br>
            <br>
            <br>
            ___________________________________________<br>
            {{ strtoupper($matricula->grado->docente->user->name ?? $matricula->profesor->name ?? 'N/A') }}
            <br> DOCENTE DIRECTOR DEL GRADO ACADEMICO:
        </div>
    </div>
</body>

</html>