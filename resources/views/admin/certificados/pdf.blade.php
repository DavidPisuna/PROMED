<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado - Evaluación Médica Ocupacional</title>

    {{-- Bootstrap 4 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #000;
            line-height: 1.2;
            margin: 0;
            padding: 10px;
        }

        .certificado-title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
            text-transform: uppercase;
            text-decoration: underline;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin: 15px 0 8px 0;
            text-transform: uppercase;
        }

        .table-form {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            border: 1px solid #000;
        }

        .table-form td, .table-form th {
            border: 1px solid #000;
            padding: 5px 8px;
            vertical-align: middle;
            text-align: center;
        }

        .table-form th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 10px;
        }

        .table-form .field-label {
            background-color: #f8f9fa;
            font-weight: bold;
            text-align: left;
            width: 30%;
        }

        .table-form .field-value {
            text-align: left;
            width: 70%;
        }

        .checkbox-group {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin: 10px 0;
            padding: 8px;
            border: 1px solid #000;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .checkbox-square {
            width: 12px;
            height: 12px;
            border: 1px solid #000;
            display: inline-block;
        }

        .checkbox-checked {
            background-color: #000;
        }

        .observaciones-box {
            border: 1px solid #000;
            padding: 10px;
            margin: 10px 0;
            min-height: 60px;
        }

        .recomendaciones-box {
            border: 1px solid #000;
            padding: 10px;
            margin: 10px 0;
            min-height: 40px;
        }

        .declaracion {
            border: 1px solid #000;
            padding: 10px;
            margin: 15px 0;
            font-size: 10px;
            text-align: justify;
            background-color: #f9f9f9;
        }

        .firma-section {
            margin-top: 30px;
        }

        .firma-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .firma-table td {
            border: 1px solid #000;
            padding: 20px 5px 5px 5px;
            text-align: center;
            vertical-align: top;
        }

        .firma-label {
            font-size: 10px;
            font-weight: bold;
            margin-top: 15px;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mt-3 {
            margin-top: 15px;
        }

        .page-break {
            page-break-before: always;
        }

        .no-data {
            color: #666;
            font-style: italic;
        }
        <style>
    .section-title {
        background-color: #d9d9ff; /* Morado claro de la cabecera */
        font-weight: bold;
        padding: 5px;
        border: 1px solid #000;
        text-transform: uppercase;
        font-size: 10pt;
    }

    .tabla-aptitud {
        width: 100%;
        border-collapse: collapse;
        margin-top: 5px;
    }

    .tabla-aptitud td {
        border: 1px solid #000;
        padding: 4px;
        text-align: center;
        font-size: 8pt;
        font-weight: bold;
    }

    .bg-verde {
        background-color: #ccffcc; /* Verde claro de la imagen */
        width: 20%; /* Ajusta el ancho de las etiquetas */
    }

    .celda-marca {
        width: 5%; /* Espacio pequeño para la X */
        background-color: #ffffff;
        font-family: Arial, sans-serif;
    }
    <style>
    /* Contenedor principal de la sección B */
    .table-generales {
        width: 100%;
        border: 1px solid #000;
        border-collapse: collapse;
        margin-top: -1px; /* Para unir con el título de sección */
    }

    .table-generales td {
        padding: 10px;
        vertical-align: middle;
    }

    .label-text {
        font-weight: bold;
        font-size: 9pt;
    }

    /* Estilo para los cuadros de Fecha (aaaa mm dd) */
    .table-fecha {
        border-collapse: collapse;
        display: inline-table;
    }

    .box-date {
        border: 1px solid #000;
        width: 40px;
        height: 20px;
        text-align: center;
        font-size: 9pt;
    }

    .sub-label-date td {
        font-size: 7pt;
        text-align: center;
        padding: 0 !important;
        font-weight: normal;
    }

    /* Estilo para los cuadros de Evaluación */
    .table-evaluacion {
        width: 100%;
        border-collapse: collapse;
    }

    .table-evaluacion td {
        padding: 2px 5px !important;
        font-size: 8pt;
    }

    .box-check {
        border: 1px solid #000;
        width: 60px; /* Ancho del recuadro blanco según imagen */
        height: 18px;
        text-align: center;
        background-color: #fff;
    }
</style>

   
</head>
<body>

<div class="container-fluid">
    
    <!-- Título del Certificado -->
    <div class="certificado-title">CERTIFICADO - EVALUACIÓN MÉDICA OCUPACIONAL</div>

    <!-- Sección A: DATOS DEL ESTABLECIMIENTO - DATOS DEL USUARIO -->
    <div class="section-title">A. DATOS DEL ESTABLECIMIENTO - DATOS DEL USUARIO</div>
    
    <table class="table-form">
        <tr>
            <th>INSTITUCIÓN DEL SISTEMA</th>
            <th>RUC</th>
            <th>CIIU</th>
            <th>ESTABLECIMIENTO / CENTRO DE TRABAJO</th>
            <th>NÚMERO DE FORMULARIO</th>
            <th>NÚMERO DE ARCHIVO</th>
        </tr>
        <tr>
            <td>{{ $certificado->empresa->nombre ?? 'N/A' }}</td>
            <td>{{ $certificado->empresa->ruc ?? 'N/A' }}</td>
            <td>{{ $certificado->empresa->ciiu ?? 'N/A' }}</td>
            <td>{{ $certificado->empresa->direccion ?? 'N/A' }}</td>
            <td>{{ $certificado->id }}</td>
            <td>{{ $certificado->id }}</td>
        </tr>
    </table>

    <table class="table-form">
        <tr>
            <th>PRIMER APELLIDO</th>
            <th>SEGUNDO APELLIDO</th>
            <th>PRIMER NOMBRE</th>
            <th>SEGUNDO NOMBRE</th>
            <th>SEXO</th>
            <th>PUESTO DE TRABAJO (CIUO)</th>
        </tr>
        <tr>
            <td>{{ $certificado->paciente->primer_apellido ?? 'N/A' }}</td>
            <td>{{ $certificado->paciente->segundo_apellido ?? 'N/A' }}</td>
            <td>{{ $certificado->paciente->primer_nombre ?? 'N/A' }}</td>
            <td>{{ $certificado->paciente->segundo_nombre ?? 'N/A' }}</td>
            <td>{{ ucfirst($certificado->paciente->sexo ?? 'N/A') }}</td>
            <td>{{ $certificado->puesto ?? 'No especificado' }}</td>
        </tr>
    </table>

    <!-- Sección B: DATOS GENERALES -->
   <div class="section-title">B. DATOS GENERALES</div>

        <div class="declaracion">
        <table class="table-generales">
            <tr>
                <td width="20%" class="label-text">FECHA DE EMISIÓN:</td>
                <td width="80%">
                    <table class="table-fecha">
                        <tr>
                            <td class="box-date">{{ $certificado->fecha_emision ? $certificado->fecha_emision->format('Y') : '' }}</td>
                            <td class="box-date">{{ $certificado->fecha_emision ? $certificado->fecha_emision->format('m') : '' }}</td>
                            <td class="box-date">{{ $certificado->fecha_emision ? $certificado->fecha_emision->format('d') : '' }}</td>
                        </tr>
                        <tr class="sub-label-date">
                            <td>aaaa</td>
                            <td>mm</td>
                            <td>dd</td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td class="label-text">EVALUACIÓN:</td>
                <td>
                    <table class="table-evaluacion">
                        <tr>
                            <td>INGRESO</td>
                            <td class="box-check">{{ $certificado->tipo == 'ingreso' ? 'X' : '' }}</td>
                            
                            <td>PERIÓDICO</td>
                            <td class="box-check">{{ $certificado->tipo == 'periodica' ? 'X' : '' }}</td>
                            
                            <td>REINTEGRO</td>
                            <td class="box-check">{{ $certificado->tipo == 'reintegro' ? 'X' : '' }}</td>
                            
                            <td>RETIRO</td>
                            <td class="box-check">{{ $certificado->tipo == 'retiro' ? 'X' : '' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>                    
        </div>
    <!-- Sección C: APTITUD MÉDICA PARA EL TRABAJO -->
    <div class="section-title">C. APTITUD MÉDICA PARA EL TRABAJO</div>

    <div style="margin-bottom: 5px; font-size: 9pt;">
        Después de la valoración médica ocupacional se certifica que la persona en mención, es calificada como:
    </div>

        <table class="tabla-aptitud">
            <tr>
                <td class="bg-verde">APTO</td>
                <td class="celda-marca">{{ $certificado->aptitud == 'apto' ? 'X' : '' }}</td>
                
                <td class="bg-verde">APTO EN OBSERVACIÓN</td>
                <td class="celda-marca">{{ $certificado->aptitud == 'apto en observacion' ? 'X' : '' }}</td>
                
                <td class="bg-verde">APTO CON LIMITACIONES</td>
                <td class="celda-marca">{{ $certificado->aptitud == 'apto con limitacion' ? 'X' : '' }}</td>
                
                <td class="bg-verde">NO APTO</td>
                <td class="celda-marca">{{ $certificado->aptitud == 'no apto' ? 'X' : '' }}</td>
            </tr>
        </table>
        <br>
        <table class="table-form">
                <tr>
                    <td class="field-label">Detalles de Observaciones</td>
                    <td class="field-value">
                        @if($certificado->observa_aptitud)
                            <div class="recomendaciones-box">
                                {{ $certificado->observa_aptitud }}
                            </div>
                        @else
                            <div class="recomendaciones-box no-data">
                                No se registran recomendaciones
                            </div>
                        @endif
                    </td>
                </tr>
            </table>
    <!-- Línea separadora -->
    <div style="border-bottom: 1px solid #000; margin: 15px 0;"></div>

    <!-- Sección D: RECOMENDACIONES/OBSERVACIONES -->
    <div class="section-title">D. RECOMENDACIONES/OBSERVACIONES</div>
    
    <table class="table-form">
        <tr>
            <td class="field-label">Descripción</td>
            <td class="field-value">
                @if($certificado->descripcion_reco)
                    <div class="recomendaciones-box">
                        {{ $certificado->descripcion_reco }}
                    </div>
                @else
                    <div class="recomendaciones-box no-data">
                        No se registran recomendaciones
                    </div>
                @endif
            </td>
        </tr>
        <tr>
            <td class="field-label">Observación:</td>
            <td class="field-value">
                @if($certificado->observa_reco)
                    <div class="observaciones-box">
                        {{ $certificado->observa_reco }}
                    </div>
                @else
                    <div class="observaciones-box no-data">
                        No se registran observaciones específicas
                    </div>
                @endif
            </td>
        </tr>
    </table>

    <!-- Declaración -->
    <div class="declaracion">
        <strong>Con este documento certifico que el trabajador se ha sometido a la evaluación médica requerida para 
        @php
            $tipoDeclaracion = [
                'ingreso' => 'el ingreso',
                'periodica' => 'la ejecución',
                'reintegro' => 'el reingreso',
                'retiro' => 'el retiro'
            ];
        @endphp
        {{ $tipoDeclaracion[$certificado->tipo] ?? 'la evaluación' }} 
        al puesto laboral y se le ha informado sobre los riesgos relacionados con el trabajo emitiendo recomendaciones relacionadas con su estado de salud.</strong><br><br>
        
        La presente certificación se expide con base en el formulario de Evaluación Ocupacional, el cual tiene carácter de confidencial.
    </div>

    <!-- Sección E: DATOS DEL PROFESIONAL -->

    <div class="section-title page-break-avoid">E: DATOS DEL PROFESIONAL</div>
    <table class="table-form">
        <tr>
            <th width="25%">NOMBRE Y APELLIDO</th>
            <th width="25%">CÓDIGO MÉDICO</th>
            <th width="25%">FIRMA Y SELLO</th>
            <th width="25%">F. FIRMA DEL USUARIO  {{ $certificado->paciente->primer_apellido ?? 'N/A' }} <br>
            {{ $certificado->paciente->primer_nombre ?? 'N/A' }}
            </th>
        </tr>
        <tr>
            <td class="text-center">
                 {{ $certificado->doctor->nombres ?? $certificado->doctor->primer_nombre ?? 'N/A' }} <br>
                {{ $certificado->doctor->apellidos ?? $certificado->doctor->primer_apellido ?? '' }}
            </td>
            <td class="text-center">{{ $certificado->doctor->numero_licencia ?? 'N/A' }}</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
    </table>

</body>
</html>