<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Boletín Transición</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 11px; margin: 0; padding: 0; color: #333; }
        .header { text-align: center; margin-bottom: 20px; padding-top: 10px; }
        .logo { position: absolute; left: 30px; top: 15px; width: 100px; }
        .inst-name { font-size: 22px; color: #00AEEF; font-weight: bold; margin-bottom: 2px; font-family: 'Times New Roman', serif; italic; }
        .inst-info { font-size: 10px; line-height: 1.2; font-weight: bold; color: #00AEEF; }
        .boletin-title { font-size: 14px; font-weight: bold; margin-top: 25px; font-family: 'Comic Sans MS', cursive, sans-serif; }
        
        .student-box { border: 2px solid #00AEEF; padding: 10px; margin-bottom: 20px; border-radius: 8px; }
        .student-box table { width: 100%; }
        .label { font-weight: bold; text-transform: uppercase; font-size: 10px; color: #000; }
        
        .matrix-table { width: 100%; border-collapse: collapse; margin-top: 10px; page-break-inside: auto; }
        .matrix-table th, .matrix-table td { border: 1px solid #00AEEF; padding: 6px; text-align: left; }
        .matrix-table th { background-color: #f0f8ff; font-size: 10px; text-transform: uppercase; color: #000; }
        .text-center { text-align: center; }
        .dim-header { background-color: #00AEEF; color: white; font-weight: bold; padding: 6px; text-align: center; font-size: 12px; }

        .observation-row { margin-top: 20px; border: 2px solid #00AEEF; padding: 15px; border-radius: 8px; }
        .signature-box { margin-top: 60px; width: 100%; }
        .signature-line { width: 220px; border-top: 2px solid #000; text-align: center; display: inline-block; padding-top: 5px; font-weight: bold; }
        
        .footer-legend { margin-top: 15px; font-size: 9px; font-style: italic; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('storage/colegio/logo_huella.png') }}" class="logo" onerror="this.style.display='none'">
        <div class="inst-name">Institución Educativa</div>
        <div class="inst-name" style="margin-top: -5px;">Técnica Agropecuaria "La Huella"</div>
        <div class="inst-info">
            Resolución 07790-del 30 de agosto del-2013<br>
            CÓDIGO DANE 219142000506<br>
            RESGUARDO INDÍGENA DE HUELLAS CALOTO<br>
            MUNICIPIO DE CALOTO CAUCA<br>
            NIT: 900718652-1
        </div>

        <div class="boletin-title">BOLETIN DESCRIPTIVO DE LAS NIÑAS Y NIÑOS DEL</div>
        <div style="font-size: 18px; font-weight: bold; margin: 5px 0;">GRADO {{ strtoupper($estudiante->gradoAcademico->nombre_grado) }}</div>
        <div style="font-size: 16px; margin-bottom: 5px;">AÑO LECTIVO {{ $anho->nombre_anho_escolar }}</div>
        <div style="font-size: 14px; font-weight: bold;">{{ strtoupper($periodo->nombre_periodo) }} EPOCA (SAAKHELU)</div>
    </div>

    <div class="student-box">
        <table cellspacing="0" cellpadding="0">
            <tr>
                <td width="15%" class="label">Estudiante:</td>
                <td width="55%" style="font-size: 13px; font-weight: bold;">{{ strtoupper($estudiante->user->name) }}</td>
                <td width="10%" class="label">Código:</td>
                <td width="20%" style="font-weight: bold;">{{ $estudiante->codigo_estudiante }}</td>
            </tr>
            <tr>
                <td class="label" style="padding-top: 8px;">Grado/Curso:</td>
                <td style="padding-top: 8px; font-weight: bold;">{{ $estudiante->gradoAcademico->nombre_grado }} - {{ $estudiante->gradoAcademico->curso->nombre_curso }}</td>
                <td class="label" style="padding-top: 8px;">Sede:</td>
                <td style="padding-top: 8px; font-weight: bold;">{{ $estudiante->gradoAcademico->sede->nombre_sede }}</td>
            </tr>
        </table>
    </div>

    @foreach($criterios as $asignatura => $logros)
        <table class="matrix-table">
            <thead>
                <tr>
                    <th colspan="2" class="dim-header">{{ strtoupper($asignatura) }}</th>
                    <th width="40" class="text-center">S</th>
                    <th width="40" class="text-center">A</th>
                    <th width="40" class="text-center">N</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logros as $l)
                    @php $val = $calificaciones[$l->id] ?? ''; @endphp
                    <tr>
                        <td width="25" class="text-center fw-bold">{{ $loop->iteration }}.</td>
                        <td style="font-size: 11px; line-height: 1.3;">{{ $l->nombre_criterio }}</td>
                        <td class="text-center fw-bold" style="font-size: 14px;">@if($val == 'SIEMPRE') X @endif</td>
                        <td class="text-center fw-bold" style="font-size: 14px;">@if($val == 'ALGUNAS_VECES') X @endif</td>
                        <td class="text-center fw-bold" style="font-size: 14px;">@if($val == 'NUNCA') X @endif</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    <div class="observation-row">
        <div class="label" style="margin-bottom: 8px; text-decoration: underline;">Fortalezas y Observaciones del Director de Grado:</div>
        <div style="font-size: 12px; line-height: 1.6; text-align: justify; min-height: 120px;">
            {{ $observacion->observacion ?? 'No se registraron observaciones adicionales para este periodo.' }}
        </div>
    </div>

    <div class="footer-legend">
        Leyenda de Calificación: S (Siempre) | A (Algunas veces) | N (Nunca)
    </div>

    <div class="signature-box">
        <table width="100%">
            <tr>
                <td class="text-center" width="50%">
                    <div class="signature-line">
                        {{ strtoupper($estudiante->gradoAcademico->docente->user->name ?? 'Firma Director de Grado') }}<br>
                        <span style="font-size: 10px; font-weight: normal;">Director(a) de Grado</span>
                    </div>
                </td>
                <td class="text-center" width="50%">
                    <div class="signature-line">
                        {{ strtoupper($institucion->rector->name ?? 'Firma Rectoría') }}<br>
                        <span style="font-size: 10px; font-weight: normal;">Rector(a)</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
