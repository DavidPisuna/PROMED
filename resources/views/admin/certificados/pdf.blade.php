<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado Médico Ocupacional - {{ $certificado->id }}</title>
    <style>
        /* Configuraciones de página */
        @page { margin: 1cm; }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
            margin: 0;
            padding: 0;
        }

        /* Encabezado Estilizado */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #A8D8EA;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .certificado-title {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            text-align: right;
            text-transform: uppercase;
        }

        .empresa-logo {
            font-size: 20px;
            font-weight: bold;
            color: #A8D8EA;
        }

        /* Secciones */
        .section-header {
            background-color: #f8f9fa;
            padding: 5px 10px;
            border-left: 4px solid #CAB8FF;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
            text-transform: uppercase;
            font-size: 11px;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table-data th {
            background-color: #f2f2f2;
            color: #666;
            font-size: 8px;
            text-align: left;
            padding: 4px 8px;
            border: 0.5px solid #eee;
            text-transform: uppercase;
        }

        .table-data td {
            padding: 6px 8px;
            border: 0.5px solid #eee;
            font-size: 10px;
        }

        /* Sistema de Checkboxes Moderno */
        .box-container {
            width: 100%;
            margin-bottom: 15px;
        }

        .check-item {
            display: inline-block;
            width: 23%; /* 4 por fila */
            padding: 5px;
        }

        .square {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid #333;
            vertical-align: middle;
            margin-right: 5px;
        }

        .checked {
            background-color: #CAB8FF;
            border-color: #CAB8FF;
        }

        .label-text {
            vertical-align: middle;
            font-size: 9px;
        }

        /* Cajas de texto */
        .content-box {
            border: 1px solid #eee;
            background-color: #fcfcfc;
            padding: 10px;
            min-height: 40px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .declaracion {
            font-style: italic;
            font-size: 9px;
            color: #777;
            text-align: justify;
            border-top: 1px solid #eee;
            padding-top: 10px;
            margin-top: 20px;
        }

        /* Firmas */
        .signature-table {
            width: 100%;
            margin-top: 50px;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 80%;
            margin: 0 auto 5px auto;
        }

        .signature-text {
            font-size: 9px;
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            color: #bbb;
            border-top: 0.5px solid #eee;
            padding-top: 5px;
        }

        .badge-aptitud {
            padding: 3px 8px;
            background-color: #fdf3d8;
            border: 1px solid #f9e1a1;
            border-radius: 3px;
            font-weight: bold;
            color: #856404;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="empresa-logo">
                {{ $certificado->empresa->nombre ?? 'CENTRO MÉDICO' }}
            </td>
            <td class="certificado-title">
                Certificado Médico<br>
                <span style="font-size: 10px; color: #999;">ID: {{ str_pad($certificado->id, 6, '0', STR_PAD_LEFT) }}</span>
            </td>
        </tr>
    </table>

    <div class="section-header">1. Información del Establecimiento y Usuario</div>
    <table class="table-data">
        <tr>
            <th width="50%">Razón Social Empresa</th>
            <th width="25%">RUC</th>
            <th width="25%">CIIU</th>
        </tr>
        <tr>
            <td>{{ strtoupper($certificado->empresa->razon_social ?? $certificado->empresa->nombre) }}</td>
            <td>{{ $certificado->empresa->ruc ?? 'N/A' }}</td>
            <td>{{ $certificado->empresa->ciiu ?? 'N/A' }}</td>
        </tr>
    </table>

    <table class="table-data">
        <tr>
            <th width="60%">Apellidos y Nombres del Paciente</th>
            <th width="20%">Cédula</th>
            <th width="20%">Género</th>
        </tr>
        <tr>
            <td style="font-weight: bold;">
                {{ strtoupper($certificado->paciente->primer_apellido) }} {{ strtoupper($certificado->paciente->segundo_apellido) }} 
                {{ strtoupper($certificado->paciente->primer_nombre) }} {{ strtoupper($certificado->paciente->segundo_nombre) }}
            </td>
            <td>{{ $certificado->paciente->cedula_identidad }}</td>
            <td>{{ ucfirst($certificado->paciente->sexo) }}</td>
        </tr>
        <tr>
            <th colspan="2">Puesto de Trabajo</th>
            <th>Fecha Emisión</th>
        </tr>
        <tr>
            <td colspan="2">{{ strtoupper($certificado->puesto ?? 'NO ESPECIFICADO') }}</td>
            <td>{{ optional($certificado->fecha_emision)->format('d/m/Y') }}</td>
        </tr>
    </table>

    <div class="section-header">2. Tipo de Evaluación y Aptitud</div>
    <div class="box-container" style="border: 1px solid #eee; padding: 10px; border-radius: 5px;">
        @php $tipos = ['INGRESO', 'PERIODICA', 'REINTEGRO', 'RETIRO']; @endphp
        @foreach($tipos as $t)
            <div class="check-item">
                <div class="square {{ strtoupper($certificado->tipo) == $t ? 'checked' : '' }}"></div>
                <span class="label-text">{{ $t }}</span>
            </div>
        @endforeach
    </div>

    <div class="mb-2" style="font-weight: bold; margin-bottom: 5px;">Resultado de Aptitud:</div>
    <div class="box-container" style="border: 1px solid #eee; padding: 10px; border-radius: 5px; background-color: #fcfcfc;">
        @php 
            $aptitudes = [
                'APTO' => 'APTO', 
                'APTO EN OBSERVACION' => 'EN OBSERVACIÓN', 
                'APTO CON LIMITACION' => 'CON LIMITACIÓN', 
                'NO APTO' => 'NO APTO'
            ]; 
        @endphp
        @foreach($aptitudes as $val => $label)
            <div class="check-item">
                <div class="square {{ strtoupper($certificado->aptitud) == $val ? 'checked' : '' }}"></div>
                <span class="label-text">{{ $label }}</span>
            </div>
        @endforeach
         @if($certificado->observa_aptitud)
            <p>
                <strong>Observaciones:</strong><br>
                {{ $certificado->observa_aptitud }}
            </p>
        @endif

    </div>
    

    <div class="section-header">3. Recomendaciones y Observaciones</div>
    <div style="font-weight: bold; color: #777; margin-bottom: 3px;">RECOMENDACIONES:</div>
    <div class="content-box">
        {{ $certificado->descripcion_reco ?? 'No se registran recomendaciones médicas.' }}
    </div>

    <div style="font-weight: bold; color: #777; margin-bottom: 3px;">OBSERVACIONES DE APTITUD:</div>
    <div class="content-box">
        {{ $certificado->observa_aptitud ?? 'Sin observaciones adicionales.' }}
    </div>

    <div class="declaracion">
        Certifico que el trabajador arriba mencionado se ha sometido a la evaluación médica ocupacional correspondiente. 
        Se le ha informado los resultados y las recomendaciones pertinentes para el cuidado de su salud en relación con sus funciones laborales. 
        Este documento es un resumen de la evaluación que consta en el expediente clínico confidencial.
    </div>

    <table class="signature-table">
        <tr>
            <td width="50%">
                <div class="signature-line"></div>
                <div class="signature-text">
                    <strong>DR. {{ strtoupper($certificado->doctor->primer_nombre) }} {{ strtoupper($certificado->doctor->primer_apellido) }}</strong><br>
                    {{ $certificado->doctor->especialidad ?? 'MEDICINA DEL TRABAJO' }}<br>
                    Reg: {{ $certificado->doctor->codigo_medico ?? 'N/A' }}
                </div>
            </td>
        </tr>
    </table>

</body>
</html>