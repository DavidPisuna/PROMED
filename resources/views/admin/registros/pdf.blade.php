<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Evaluación Médica Ocupacional</title>

    {{-- Bootstrap 4 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- FontAwesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.2;
        }

        .form-title {
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }

        .table-form {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .table-form td, .table-form th {
            border: 1px solid #000;
            padding: 4px 6px;
            vertical-align: middle;
        }

        .table-form th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .field-label {
            font-weight: bold;
            background-color: #f8f9fa;
            padding: 4px 8px;
            white-space: nowrap;
        }

        .field-value {
            padding: 4px 8px;
            width: 100%;
        }

        .checkbox-field {
            text-align: center;
            width: 40px;
        }

        .checkbox-field input[type="checkbox"] {
            transform: scale(0.8);
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .border-all {
            border: 1px solid #000;
        }

        .mb-3 {
            margin-bottom: 15px;
        }

        /* Estilos para evitar cortes en páginas */
        .page-break-avoid {
            page-break-inside: avoid;
        }

        /* Nuevos estilos añadidos */
        .no-data {
            text-align: center;
            padding: 10px;
            color: #666;
            font-style: italic;
            border: 1px solid #ddd;
            margin: 10px 0;
        }

        .positive-finding {
            color: #dc3545;
            font-weight: bold;
            margin-right: 5px;
        }

        .region-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .category-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            margin: 1px;
        }

        .category-primary { background-color: #007bff; color: white; }
        .category-success { background-color: #28a745; color: white; }
        .category-danger { background-color: #dc3545; color: white; }
        .category-warning { background-color: #ffc107; color: black; }
        .category-info { background-color: #17a2b8; color: white; }

        .factors-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .factor-item {
            background-color: #e9ecef;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }

        .check-icon {
            color: #28a745;
            margin-right: 3px;
        }

        .check-si {
            color: #28a745;
            font-weight: bold;
        }

        .check-no {
            color: #dc3545;
            font-weight: bold;
        }

        .badge-iess {
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }

        .badge-no-iess {
            background-color: #6c757d;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }

        .small-text {
            font-size: 10px;
        }

        .activity-type {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .exam-name {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .tipo-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
        }

        .tipo-success { background-color: #28a745; color: white; }
        .tipo-warning { background-color: #ffc107; color: black; }
        .tipo-danger { background-color: #dc3545; color: white; }
        .tipo-info { background-color: #17a2b8; color: white; }
        .tipo-primary { background-color: #007bff; color: white; }

        .aptitud-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .aptitud-success { background-color: #28a745; color: white; }
        .aptitud-warning { background-color: #ffc107; color: black; }
        .aptitud-orange { background-color: #fd7e14; color: white; }
        .aptitud-danger { background-color: #dc3545; color: white; }

        .evaluacion-badge, .salud-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }

        .evaluacion-success { background-color: #28a745; color: white; }
        .evaluacion-danger { background-color: #dc3545; color: white; }
        .salud-success { background-color: #28a745; color: white; }
        .salud-warning { background-color: #ffc107; color: black; }

        .no-data-small {
            color: #6c757d;
            font-style: italic;
        }

        .observaciones-cell {
            font-size: 10px;
            line-height: 1.3;
        }

        .centro-separator {
            margin: 15px 0;
            border-bottom: 1px dashed #ccc;
        }

        .activity-section {
            margin-bottom: 15px;
        }

        .table-part {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    
    <!-- Título del formulario -->
    <div class="form-title">FORMULARIO DE EVALUACIÓN MÉDICA OCUPACIONAL</div>

    <!-- Sección A: DATOS DEL ESTABLECIMIENTO - DATOS DEL USUARIO -->
    <div class="section-title page-break-avoid">A. DATOS DEL ESTABLECIMIENTO - DATOS DEL USUARIO</div>
    
    <table class="table-form">
        <tr>
            <th>INSTITUCIÓN DEL SISTEMA</th>
            <th>RUC</th>
            <th>CRU</th>
            <th>ESTABLECIMIENTO / CENTRO DE TRABAJO</th>
            <th>NÚMERO DE HISTORIA CLÍNICA</th>
            <th>NÚMERO DE ARCHIVO</th>
        </tr>
        <tr>
            <td class="text-center">{{ $registro->empresa->nombre ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->empresa->ruc ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->empresa->ciiu ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->empresa->nombre ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->id }}</td>
            <td class="text-center">1</td>
        </tr>
    </table>

    <table class="table-form">
        <tr>
            <th>PRIMER APELLIDO</th>
            <th>SEGUNDO APELLIDO</th>
            <th>PRIMER NOMBRE</th>
            <th>SEGUNDO NOMBRE</th>
        </tr>
        <tr>
            <td class="text-center">{{ $registro->paciente->primer_apellido ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->paciente->segundo_apellido ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->paciente->primer_nombre ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->paciente->segundo_nombre ?? 'N/A' }}</td>
        </tr>
    </table>

    <table class="table-form">
        <tr>
            <th>ATENCIÓN PRIORITARIA</th>
            <th>SEXO</th>
            <th>FECHA DE NACIMIENTO</th>
            <th>GRUPO SANGUÍNEO</th>
            <th>LATERALIDAD</th>
        </tr>
        <tr>
            <td class="text-center">{{ $registro->atencion_prioritaria ?? 'N/A' }}</td>
            <td class="text-center">
                @if(isset($registro->paciente->sexo))
                    @if(strtolower($registro->paciente->sexo) == 'hombre')
                        ✓ Hombre
                    @elseif(strtolower($registro->paciente->sexo) == 'mujer')
                        ✓ Mujer
                    @else
                        {{ $registro->paciente->sexo }}
                    @endif
                @else
                    N/A
                @endif
            </td>
            <td class="text-center">
                @if(isset($registro->paciente->fecha_nacimiento))
                    {{ \Carbon\Carbon::parse($registro->paciente->fecha_nacimiento)->format('d/m/Y') }}
                @else
                    N/A
                @endif
            </td>
            <td class="text-center">{{ $registro->paciente->grupo_sanguineo ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->paciente->lateralidad ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- Sección B: MOTIVO DE CONSULTA -->
    <div class="section-title page-break-avoid">B. MOTIVO DE CONSULTA</div>
    <table class="table-form">
        <tr>
            <th>Puesto de Trabajo CIUO</th>
            <th>RUC Fecha de Atención aaaa/mm/dd</th>
        </tr>
        <tr>
            <td class="text-center">{{ $registro->puesto ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->created_at->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <table class="table-form">
        <tr>
            <th>Fecha de Ingreso al trabajo aaaa/mm/dd</th>
            <th>Fecha de Reintegro aaaa/mm/dd</th>
            <th>Fecha del Último día laboral/salida aaaa/mm/dd</th>
        </tr>
        <tr>
            <td class="text-center">{{ $registro->fecha_ingreso ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->fecha_reintegro ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->fecha_retiro ?? 'N/A' }}</td>
        </tr>
    </table>

    <table class="table-form">
        <tr>
            <th>Observación</th>
        </tr>
        <tr>
            <td class="text-center">{{ $registro->observaciones ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- C. ANTECEDENTES PERSONALES-->
    <div class="section-title page-break-avoid">C. ANTECEDENTES PERSONALES</div>
    
    <table class="table-form">
        <tr>
            <th>ANTECEDENTES CLÍNICOS Y QUIRÚRGICOS</th>
            <td class="text-center">{{ $registro->antecedentePatologico->antecedente_app ?? 'N/A' }}</td>
        </tr> 
    </table>

    <table class="table-form">
        <tr>
            <th>ANTECEDENTES FAMILIARES</th>
            <td class="text-center">{{ $registro->antecedentePatologico->antecedente_apqx ?? 'N/A' }}</td>
        </tr>   
    </table>

    <h5>Condición especial para las atenciones de urgencia, emergencia y tratamiento médico (referido por el paciente).</h5>
    <table class="table-form">
        <tr>
            <th>En caso de requerir transfusiones autoriza:</th>
            <th>Se encuentra bajo algún tratamiento hormonal</th>
            <th>¿Cuál describir?</th>
        </tr>
        <tr>
            <td class="text-center">{{ isset($registro->antecedentePatologico->autoriza_transfusiones) ? ($registro->antecedentePatologico->autoriza_transfusiones ? 'Sí' : 'No') : 'N/A' }}</td>
            <td class="text-center">{{ isset($registro->antecedentePatologico->tratamiento_hormonal_si_no) ? ($registro->antecedentePatologico->tratamiento_hormonal_si_no ? 'Sí' : 'No') : 'N/A' }}</td>
            <td class="text-center">
                @if(isset($registro->antecedentePatologico->tratamiento_hormonal_si_no) && $registro->antecedentePatologico->tratamiento_hormonal_si_no)
                    {{ $registro->antecedentePatologico->tratamiento_hormonal_descripcion ?? 'Sin descripción' }}
                @else
                    ―
                @endif
            </td>
        </tr>
    </table>

    <h4>ANTECEDENTES GINECO OBSTÉTRICOS</h4>
    <table class="table-form">
        <tr>
            <th>FECHA DE LA ULTIMA MENSTRUACIÓN</th>
            <th>GESTAS</th>
            <th>PARTOS</th>
            <th>CESÁREAS</th>
            <th>ABORTOS</th>
            <th>MÉTODO DE PLANIFICACION FAMILIAR</th>
        </tr>
        <tr>
            <td class="text-center">{{ isset($registro->antecedenteGineco->fecha_ultima_menstruacion) ? \Carbon\Carbon::parse($registro->antecedenteGineco->fecha_ultima_menstruacion)->format('Y/m/d') : 'N/A' }}</td>
            <td class="text-center">{{ $registro->antecedenteGineco->gestas ?? '0' }}</td>
            <td class="text-center">{{ $registro->antecedenteGineco->partos ?? '0' }}</td>
            <td class="text-center">{{ $registro->antecedenteGineco->cesareas ?? '0' }}</td>
            <td class="text-center">{{ $registro->antecedenteGineco->abortos ?? '0' }}</td>
            <td class="text-center">
                @if(isset($registro->antecedenteGineco))
                    @if($registro->antecedenteGineco->planificacion_si)
                        Sí @if($registro->antecedenteGineco->planificacion_cual) ({{ $registro->antecedenteGineco->planificacion_cual }}) @endif
                    @elseif($registro->antecedenteGineco->planificacion_no)
                        No
                    @elseif($registro->antecedenteGineco->planificacion_no_responde)
                        No responde
                    @else
                        N/A
                    @endif
                @else
                    N/A
                @endif
            </td>
        </tr>
    </table>

    {{-- EXÁMENES REALIZADOS --}}
    <table class="table-form">
        <tr>
            <th>EXAMENES REALIZADOS (¿CUAL?)</th>
            <th>TIEMPO (años)</th>
            <th>Registrar resultado únicamente si interfiere con la actividad laboral y previa autorización del titular</th>
        </tr>
        @if(isset($registro->antecedenteGineco) && $registro->antecedenteGineco->examenes->count())
            @foreach($registro->antecedenteGineco->examenes as $examen)
                <tr>
                    <td>{{ $examen->examen_realizado ?? 'N/A' }}</td>
                    <td class="text-center">{{ $examen->tiempo_meses ?? '―' }}</td>
                    <td>{{ $examen->resultado ?? '―' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center">―</td>
                <td class="text-center">―</td>
                <td class="text-center">―</td>
            </tr>
        @endif
    </table>

    <h4>ANTECEDENTES REPRODUCTIVOS MASCULINOS</h4>
    <table class="table-form">
        <tr>
            <th>MÉTODO DE PLANIFICACIÓN FAMILIAR</th>
            <td class="text-center">
                @if(isset($registro->antecedenteMasculino))
                    @php
                        $planificacion = 'N/A';
                        if($registro->antecedenteMasculino->planificacion_si) {
                            $planificacion = 'Sí (' . ($registro->antecedenteMasculino->planificacion_cual ?? 'Ninguno') . ')';
                        } elseif($registro->antecedenteMasculino->planificacion_no) {
                            $planificacion = 'No';
                        } elseif($registro->antecedenteMasculino->planificacion_no_responde) {
                            $planificacion = 'No responde';
                        }
                    @endphp
                    {{ $planificacion }}
                @else
                    N/A
                @endif
            </td>
        </tr> 
    </table>

    <table class="table-form">
        <tr>
            <th>EXÁMENES REALIZADOS ¿CUAL?</th>
            <th>TIEMPO años</th>
            <th>Registrar resultado únicamente si interfiere con la actividad laboral y previa autorización del titular</th>
        </tr>
        @if(isset($registro->antecedenteMasculino) && $registro->antecedenteMasculino->examenes->count())
            @foreach($registro->antecedenteMasculino->examenes as $examen)
                <tr>
                    <td class="text-center">{{ $examen->examen_realizado ?? 'N/A' }}</td>
                    <td class="text-center">{{ $examen->tiempo_meses ?? 'N/A' }}</td>
                    <td class="text-center">{{ $examen->resultado ?? 'N/A' }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
                <td class="text-center">N/A</td>
            </tr>
        @endif
    </table>

    <h4>CONSUMO DE SUSTANCIAS</h4>
    <table class="table-form">
        <thead>
            <tr class="text-center">
                <th>Consumo</th>
                <th>Detalle</th>
                <th>Tiempo de Consumo</th>
                <th>Tiempo de Abstinencia</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sustancias = [];
                if(isset($registro->consumoSustancia)) {
                    $sustancias = [
                        ['nombre' => 'Tabaco', 'estado' => $registro->consumoSustancia->tabaco_estado ?? 'No consume', 'tiempo' => $registro->consumoSustancia->tabaco_tiempo_consumo ?? null, 'abstinencia' => $registro->consumoSustancia->tabaco_tiempo_abstinencia ?? null, 'cual' => ''],
                        ['nombre' => 'Alcohol', 'estado' => $registro->consumoSustancia->alcohol_estado ?? 'No consume', 'tiempo' => $registro->consumoSustancia->alcohol_tiempo_consumo ?? null, 'abstinencia' => $registro->consumoSustancia->alcohol_tiempo_abstinencia ?? null, 'cual' => ''],
                        ['nombre' => 'Otras Sustancias', 'estado' => $registro->consumoSustancia->otras_sustancias_estado ?? 'No consume', 'tiempo' => $registro->consumoSustancia->otras_sustancias_tiempo_consumo ?? null, 'abstinencia' => $registro->consumoSustancia->otras_sustancias_tiempo_abstinencia ?? null, 'cual' => $registro->consumoSustancia->otras_sustancias_cual ?? ''],
                    ];
                }
            @endphp

            @foreach($sustancias as $sustancia)
                @if(strtolower($sustancia['estado']) != 'no consume' && strtolower($sustancia['estado']) != 'no')
                    <tr>
                        <td><strong>{{ $sustancia['nombre'] }}</strong></td>
                        <td class="text-capitalize">{{ $sustancia['estado'] }}</td>
                        <td class="text-center">{{ $sustancia['tiempo'] ?? 'N/A' }} meses</td>
                        <td class="text-center">{{ $sustancia['abstinencia'] ?? 'N/A' }} meses</td>
                        <td>{{ $sustancia['cual'] ?: '-' }}</td>
                    </tr>
                @endif
            @endforeach

            @if(empty(array_filter($sustancias, function($s) { return strtolower($s['estado']) != 'no consume' && strtolower($s['estado']) != 'no'; })))
                <tr>
                    <td colspan="5" class="text-center">No se registra consumo de sustancias</td>
                </tr>
            @endif
        </tbody>
    </table>

    <h4>ESTILO DE VIDA</h4>
    @if(isset($registro->actividadesFisicas) && $registro->actividadesFisicas->count())
        <table class="table-form">
            <thead>
                <tr class="text-center">
                    <th>Actividad</th>
                    <th>Tiempo (min)</th>
                    <th>Frecuencia</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registro->actividadesFisicas as $actividad)
                    <tr>
                        <td>{{ $actividad->actividad_fisica_cual ?? 'N/A' }}</td>
                        <td class="text-center">{{ $actividad->actividad_fisica_tiempo ?? 'N/A' }}</td>
                        <td class="text-center">{{ $actividad->actividad_fisica_frecuencia ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p class="text-muted">No hay actividades físicas registradas.</p>
        </div>
    @endif

    <h4>CONDICION PREEXISTENTE</h4>
    @if(isset($registro->medicacionesHabituales) && $registro->medicacionesHabituales->count())
        <table class="table-form">
            <thead>
                <tr class="text-center">
                    <th>MEDICACIÓN HABITUAL</th>
                    <th>CANTIDAD</th>
                    <th>TOMA ACTUALMENTE</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registro->medicacionesHabituales as $med)
                    <tr>
                        <td>{{ $med->medicacion_habitual_cual ?? 'N/A' }}</td>
                        <td class="text-center">{{ $med->medicacion_habitual_cantidad ?? 'N/A' }}</td>
                        <td class="text-center">{{ $med->toma_medicacion_habitual ? 'Sí' : 'No' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p class="text-muted">No hay medicaciones registradas.</p>
        </div>
    @endif

    <table class="table-form">
        <tr>
            <th>Observación</th>
            <td class="text-center">{{ $registro->consumoSustancia->observaciones ?? 'N/A' }}</td>
        </tr> 
    </table>

    <!-- D. ENFERMEDAD O PROBLEMA ACTUAL-->
    <div class="section-title page-break-avoid">D. ENFERMEDAD O PROBLEMA ACTUAL</div>
    <table class="table-form">
        <tr>
            <th>Descripción</th>
            <td class="text-center">{{ $registro->constanteVital->enfermedad_actual ?? 'N/A' }}</td> 
        </tr>
    </table>

    <!-- E. CONSTANTES VITALES Y ANTROPOMETRÍA -->
    <div class="section-title page-break-avoid">E. CONSTANTES VITALES Y ANTROPOMETRÍA</div>
    <table class="table-form">
        <tr>
            <th>TEMPERATURA (°C)</th>  
            <th>PRESIÓN ARTERIAL (mmHg)</th>  
            <th>FRECUENCIA CARDIACA (Lat/min)</th>  
            <th>FRECUENCIA RESPIRATORIA (fr/min)</th>  
            <th>SATURACIÓN DE OXÍGENO (O2%)</th>    
        </tr>
        <tr>
            <td class="text-center">{{ $registro->constanteVital->temperatura ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->constanteVital->presion_arterial ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->constanteVital->frecuencia_cardiaca ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->constanteVital->frecuencia_respiratoria ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->constanteVital->saturacion_oxigeno ?? 'N/A' }}</td>
        </tr>
    </table>

    <table class="table-form">
        <tr>
            <th>PESO (Kg)</th>  
            <th>TALLA (cm)</th>  
            <th>ÍNDICE DE MASA CORPORAL (kg/m2)</th> 
            <th>Categoría IMC</th>   
            <th>PERÍMETRO ABDOMINAL (cm)</th>    
        </tr>
        <tr>
            <td class="text-center">{{ $registro->constanteVital->peso ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->constanteVital->talla ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->constanteVital->imc ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->constanteVital->categoria_imc ?? 'N/A' }}</td>
            <td class="text-center">{{ $registro->constanteVital->perimetro_abdominal ?? 'N/A' }}</td>
        </tr>
    </table>

    <!-- F. EXAMEN FÍSICO REGIONAL -->
    <div class="section-title page-break-avoid">F. EXAMEN FÍSICO REGIONAL</div>
    @if(isset($registro->examenesFisicos) && $registro->examenesFisicos->count())
        @php
            // Agrupar exámenes por región
            $examenesAgrupados = $registro->examenesFisicos->groupBy('region');
            
            // Mapeo de regiones a nombres display
            $regionesDisplay = [
                'piel' => 'Piel y Faneras',
                'ojos' => 'Ojos',
                'oido' => 'Oído',
                'orofaringe' => 'Orofaringe',
                'nariz' => 'Nariz',
                'cuello' => 'Cabeza y Cuello',
                'torax_mamas' => 'Tórax - Mamas',
                'torax_organos' => 'Tórax - Órganos',
                'abdomen' => 'Abdomen',
                'columna' => 'Columna',
                'pelvis' => 'Pelvis',
                'extremidades' => 'Extremidades',
                'neurologico' => 'Neurológico'
            ];

            // Mapeo de items a nombres display
            $itemsDisplay = [
                'cicatrices' => 'Cicatrices',
                'piel_faneras' => 'Piel y faneras',
                'parpados' => 'Párpados',
                'conjuntivas' => 'Conjuntivas',
                'pupilas' => 'Pupilas',
                'cornea' => 'Córnea',
                'motilidad' => 'Motilidad',
                'conducto_auditivo' => 'Conducto auditivo',
                'pabellon' => 'Pabellón',
                'timpanos' => 'Tímpanos',
                'labios' => 'Labios',
                'lengua' => 'Lengua',
                'faringe' => 'Faringe',
                'amigdalas' => 'Amígdalas',
                'dentadura' => 'Dentadura',
                'tabique' => 'Tabique',
                'cornetes' => 'Cornetes',
                'mucosas' => 'Mucosas',
                'senos_paranasales' => 'Senos paranasales',
                'tiroides_masas' => 'Tiroides y masas',
                'movilidad' => 'Movilidad',
                'mamas' => 'Mamas',
                'pulmones' => 'Pulmones',
                'corazon' => 'Corazón',
                'parrilla_costal' => 'Parrilla costal',
                'visceras' => 'Vísceras',
                'pared_abdominal' => 'Pared abdominal',
                'flexibilidad' => 'Flexibilidad',
                'desviacion' => 'Desviación',
                'dolor' => 'Dolor',
                'pelvis' => 'Pelvis',
                'genitales' => 'Genitales',
                'vascular' => 'Vascular',
                'miembros_superiores' => 'Miembros superiores',
                'miembros_inferiores' => 'Miembros inferiores',
                'fuerza' => 'Fuerza',
                'sensibilidad' => 'Sensibilidad',
                'marcha' => 'Marcha',
                'reflejos' => 'Reflejos'
            ];

            $hallazgosPositivos = $registro->examenesFisicos->where('valor', true);
        @endphp

        @if($hallazgosPositivos->count())
            <table class="table-form">
                <thead>
                    <tr>
                        <th width="25%">Región Anatómica</th>
                        <th width="30%">Componente Evaluado</th>
                        <th width="45%">Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hallazgosPositivos->groupBy('region') as $region => $examenesRegion)
                        @if(isset($regionesDisplay[$region]))
                            @php
                                $rowspan = $examenesRegion->count();
                                $firstRow = true;
                            @endphp
                            
                            @foreach($examenesRegion as $examen)
                                <tr>
                                    @if($firstRow)
                                        <td rowspan="{{ $rowspan }}" class="region-header">
                                            {{ $regionesDisplay[$region] }}
                                        </td>
                                        @php $firstRow = false; @endphp
                                    @endif
                                    
                                    <td>
                                        <span class="positive-finding">✓</span>
                                        {{ $itemsDisplay[$examen->item] ?? ucfirst(str_replace('_', ' ', $examen->item)) }}
                                    </td>
                                    
                                    <td>
                                        @if($examen->observacion)
                                            <div class="observacion">
                                                {{ $examen->observacion }}
                                            </div>
                                        @else
                                            <span style="color: #27ae60; font-size: 9px;">Sin observaciones específicas</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-data">
                <p>No se registraron hallazgos positivos en el examen físico.</p>
            </div>
        @endif
    @else
        <div class="no-data">
            <p>No se han registrado exámenes físicos para este paciente.</p>
        </div>
    @endif

    <!-- G. PUESTOS DE TRABAJO Y FACTORES DE RIESGO -->
    <div class="section-title page-break-avoid">G. PUESTOS DE TRABAJO Y FACTORES DE RIESGO</div>

    @if(isset($registro->puestos) && $registro->puestos->count())
        @foreach($registro->puestos as $puesto)
            <table class="table-form">
                <tr>
                    <th>PUESTO DE TRABAJO</th>
                    <td class="text-center">{{ $puesto->nombre_puesto ?? 'N/A' }}</td>
                </tr> 
            </table>

            @if($puesto->actividades->count())
                @foreach($puesto->actividades as $actividad)
                    <div class="activity-section">
                        <table class="table-form">
                            <tr>
                                <th>ACTIVIDADES DESEMPEÑADAS:</th>
                                <td class="text-center">{{ $actividad->nombre_actividad ?? 'N/A' }}</td>
                            </tr> 
                        </table>

                        @if($actividad->factoresRiesgo->count())
                            <table class="table-form">
                                <thead>
                                    <tr>
                                        <th width="25%">Categoría</th>
                                        <th width="75%">ACTIVIDADES IMPORTANTES DENTRO DE LA JORNADA LABORAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($actividad->factoresRiesgo->groupBy('categoria') as $categoria => $factores)
                                        <tr>
                                            <td class="category-cell">
                                                @php
                                                    // Función simplificada para colores
                                                    $color = match($categoria) {
                                                        'fisicos' => 'primary',
                                                        'quimicos' => 'danger', 
                                                        'biologicos' => 'success',
                                                        'ergonomicos' => 'warning',
                                                        'psicosociales' => 'info',
                                                        default => 'secondary'
                                                    };
                                                    
                                                    $icono = match($categoria) {
                                                        'fisicos' => 'volume-up',
                                                        'quimicos' => 'flask',
                                                        'biologicos' => 'biohazard',
                                                        'ergonomicos' => 'user-injured',
                                                        'psicosociales' => 'brain',
                                                        default => 'exclamation-triangle'
                                                    };
                                                @endphp
                                                <span class="category-badge category-{{ $color }}">
                                                    <i class="fas fa-{{ $icono }}"></i>
                                                    {{ str_replace('_', ' ', ucfirst($categoria)) }}
                                                </span>
                                            </td>
                                            <td class="factors-cell">
                                                <div class="factors-list">
                                                    @foreach($factores as $factor)
                                                        <span class="factor-item">
                                                            <span class="check-icon">✓</span>
                                                            {{ $factor->factor_riesgo ?? 'N/A' }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="no-data">
                                <i class="fas fa-exclamation-circle"></i>
                                No hay factores de riesgo registrados para esta actividad.
                            </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="no-data">
                    <i class="fas fa-info-circle"></i>
                    No hay actividades registradas para este puesto.
                </div>
            @endif
            
            @if(!$loop->last)
                <div class="page-break-avoid" style="margin-bottom: 20px; border-bottom: 1px dashed #ccc; padding-bottom: 15px;"></div>
            @endif
        @endforeach
    @else
        <div class="no-data">
            <i class="fas fa-briefcase"></i>
            No hay puestos de trabajo registrados para este paciente.
        </div>
    @endif

    <!-- H. ACTIVIDAD LABORAL/ INCIDENTES/ACCIDENTES / ENFERMEDADES OCUPACIONALES -->        
    <div class="section-title page-break-avoid">H. ACTIVIDAD LABORAL/ INCIDENTES/ACCIDENTES / ENFERMEDADES OCUPACIONALES</div>

    @if(isset($registro->centros) && $registro->centros->count())
        @foreach($registro->centros as $centro)
            <div class="centro-section">
                <table class="table-form">
                    <tr>
                        <th>CENTRO DE TRABAJO:</th>
                        <td class="text-center">{{ $centro->nombre_centro_trabajo ?? 'N/A' }}</td>
                    </tr> 
                </table>

                <div class="table-part">
                    <table class="table-form">
                        <thead>
                            <tr>
                                <th width="40%">ACTIVIDADES QUE DESEMPEÑABA</th>
                                <th width="20%">TIPO TRABAJO</th>
                                <th width="20%">TIEMPO DE TRABAJO</th>
                                <th width="20%">CALIFICACIÓN IESS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="small-text">
                                    {{ $centro->actividades_desempenadas ?? 'No especificado' }}
                                </td>
                                <td class="text-center">
                                    {{ ucfirst($centro->tipo_trabajo ?? 'N/A') }}
                                </td>
                                <td class="text-center">
                                    {{ $centro->tiempo_trabajo ?? 'N/A' }}
                                </td>
                                <td class="text-center">
                                    @if($centro->calificado_iess)
                                        <span class="badge-iess">CALIFICADO IESS</span>
                                        @if($centro->fecha_calificacion)
                                            <br><small>{{ \Carbon\Carbon::parse($centro->fecha_calificacion)->format('d/m/Y') }}</small>
                                        @endif
                                    @else
                                        <span class="badge-no-iess">NO CALIFICADO</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="table-part">
                    <table class="table-form">
                        <thead>
                            <tr>
                                <th width="15%">INCIDENTE</th>
                                <th width="15%">ACCIDENTE</th>
                                <th width="20%">ENF. PROFESIONAL</th>
                                <th width="20%">FECHA CALIFICACIÓN</th>
                                <th width="30%">INFORMACIÓN ADICIONAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    @if($centro->incidente)
                                        <span class="check-si">SÍ</span>
                                    @else
                                        <span class="check-no">NO</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($centro->accidente)
                                        <span class="check-si">SÍ</span>
                                    @else
                                        <span class="check-no">NO</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($centro->enfermedad_profesional)
                                        <span class="check-si">SÍ</span>
                                    @else
                                        <span class="check-no">NO</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($centro->fecha_calificacion)
                                        {{ \Carbon\Carbon::parse($centro->fecha_calificacion)->format('d/m/Y') }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="small-text">
                                    @if($centro->especificar)
                                        <strong>Especificar:</strong> {{ $centro->especificar }}
                                    @endif
                                    @if($centro->observaciones)
                                        @if($centro->especificar)<br>@endif
                                        <strong>Obs:</strong> {{ $centro->observaciones }}
                                    @endif
                                    @if(!$centro->especificar && !$centro->observaciones)
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if(!$loop->last)
                <div class="centro-separator"></div>
            @endif
        @endforeach
    @else
        <div class="no-data">
            <i class="fas fa-building"></i>
            No hay centros de trabajo registrados para este paciente.
        </div>
    @endif

    <!-- I. ACTIVIDADES EXTRA LABORALES -->    
    <div class="section-title page-break-avoid">I. ACTIVIDADES EXTRA LABORALES</div>

    @if(isset($registro->actividadesExtras) && $registro->actividadesExtras->count())
        <table class="table-form">
            <thead>
                <tr>
                    <th width="15%">Tipo de Actividad</th>
                    <th width="10%">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registro->actividadesExtras as $actividad)
                    @php
                        $iconoActividad = match($actividad->tipo_actividad) {
                            'Deporte' => 'futbol',
                            'Ejercicio' => 'dumbbell',
                            'Recreación' => 'gamepad',
                            'Cultural' => 'palette',
                            'Voluntariado' => 'hands-helping',
                            default => 'running'
                        };
                    @endphp
                    
                    <tr>
                        <td class="activity-type-cell">
                            <div class="activity-type">
                                <i class="fas fa-{{ $iconoActividad }}"></i>
                                {{ $actividad->tipo_actividad ?? 'N/A' }}
                            </div>
                        </td>
                        
                        <td class="text-center">
                            @if($actividad->fecha)
                                {{ \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y') }}
                            @else
                                <span class="no-data-small">N/A</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <i class="fas fa-tasks"></i>
            No hay actividades extra laborales registradas para este paciente.
        </div>
    @endif

    <!-- J. RESULTADOS DE EXÁMENES GENERALES Y ESPECÍFICOS -->   
    <div class="section-title page-break-avoid">J. RESULTADOS DE EXÁMENES GENERALES Y ESPECÍFICOS DE ACUERDO AL RIESGO Y PUESTO DE TRABAJO (IMAGEN, LABORATORIO Y OTROS)</div>

    @if(isset($registro->resultadosExamenes) && $registro->resultadosExamenes->count())
        <table class="table-form">
            <thead>
                <tr>
                    <th width="20%">Nombre del Examen</th>
                    <th width="10%">Fecha</th>
                    <th width="30%">Resultados</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registro->resultadosExamenes as $resultado)
                    @php
                        $iconoExamen = match(true) {
                            str_contains(strtolower($resultado->nombre_examen ?? ''), 'sangre') => 'tint',
                            str_contains(strtolower($resultado->nombre_examen ?? ''), 'orina') => 'vial',
                            str_contains(strtolower($resultado->nombre_examen ?? ''), 'rayos') => 'x-ray',
                            str_contains(strtolower($resultado->nombre_examen ?? ''), 'eco') => 'wave-square',
                            str_contains(strtolower($resultado->nombre_examen ?? ''), 'tomografía') => 'lungs',
                            str_contains(strtolower($resultado->nombre_examen ?? ''), 'resonancia') => 'magnet',
                            default => 'flask'
                        };
                    @endphp
                    
                    <tr>
                        <td class="exam-name-cell">
                            <div class="exam-name">
                                <i class="fas fa-{{ $iconoExamen }}"></i>
                                {{ $resultado->nombre_examen ?? 'N/A' }}
                            </div>
                        </td>
                        
                        <td class="text-center">
                            @if($resultado->fecha_examen)
                                {{ \Carbon\Carbon::parse($resultado->fecha_examen)->format('d/m/Y') }}
                            @else
                                <span class="no-data-small">N/A</span>
                            @endif
                        </td>
                        
                        <td class="resultados-text">
                            @if($resultado->resultados)
                                {{ $resultado->resultados }}
                            @else
                                <span class="no-data-small">No disponible</span>
                            @endif
                        </td>
                    </tr>
                    
                    @if($resultado->observaciones)
                    <tr class="observaciones-row">
                        <td colspan="3" class="observaciones-cell">
                            <strong>Observaciones:</strong> {{ $resultado->observaciones }}
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <i class="fas fa-vials"></i>
            No hay resultados de exámenes registrados para este paciente.
        </div>
    @endif

    <!-- K. DIAGNÓSTICO -->  
    <div class="section-title page-break-avoid">K. DIAGNÓSTICO      PRE:PRESUNTIVO DEF: DEFINITIVO</div>

    @if(isset($registro->diagnosticos) && $registro->diagnosticos->count())
        <table class="table-form">
            <thead>
                <tr>
                    <th width="10%">CIE-10</th>
                    <th width="25%">Descripción</th>
                    <th width="12%">Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registro->diagnosticos as $diagnostico)
                    @php
                        $tipoColor = match($diagnostico->tipo_diagnostico) {
                            'principal' => 'danger',
                            'secundario' => 'warning',
                            'diferencial' => 'info',
                            default => 'primary'
                        };
                        
                        $tipoIcono = match($diagnostico->tipo_diagnostico) {
                            'principal' => 'star',
                            'secundario' => 'star-half-alt',
                            'diferencial' => 'question-circle',
                            default => 'stethoscope'
                        };
                    @endphp
                    
                    <tr>
                        <td class="text-center">
                            <strong>{{ $diagnostico->cie10 ?? 'N/A' }}</strong>
                        </td>
                        
                        <td class="descripcion-cell">
                            <div class="diagnostico-descripcion">
                                {{ $diagnostico->descripcion ?? 'N/A' }}
                            </div>
                        </td>
                        
                        <td class="text-center">
                            <span class="tipo-badge tipo-{{ $tipoColor }}">
                                <i class="fas fa-{{ $tipoIcono }}"></i>
                                {{ ucfirst($diagnostico->tipo_diagnostico) }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <i class="fas fa-notes-medical"></i>
            No hay diagnósticos registrados para este paciente.
        </div>
    @endif

    <!-- L. APTITUDES MÉDICAS -->  
    <div class="section-title page-break-avoid">L. APTITUDES MÉDICAS</div>

    @if(isset($registro->aptitudesMedicas) && $registro->aptitudesMedicas->count())
        <table class="table-form">
            <thead>
                <tr>
                    <th width="20%">Estado de Aptitud</th>    
                    <th width="25%">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registro->aptitudesMedicas as $aptitud)
                    @php
                        $aptitudColor = match($aptitud->aptitud) {
                            'apto' => 'success',
                            'apto_observacion' => 'warning',
                            'apto_limitaciones' => 'orange',
                            default => 'danger'
                        };
                        
                        $aptitudTexto = match($aptitud->aptitud) {
                            'apto' => 'APTO',
                            'apto_observacion' => 'APTO CON OBSERVACIÓN',
                            'apto_limitaciones' => 'APTO CON LIMITACIONES',
                            default => 'NO APTO'
                        };
                        
                        $aptitudIcono = match($aptitud->aptitud) {
                            'apto' => 'check-circle',
                            'apto_observacion' => 'exclamation-circle',
                            'apto_limitaciones' => 'minus-circle',
                            default => 'times-circle'
                        };
                    @endphp
                    
                    <tr>
                        <td class="text-center">
                            <span class="aptitud-badge aptitud-{{ $aptitudColor }}">
                                <i class="fas fa-{{ $aptitudIcono }}"></i>
                                {{ $aptitudTexto }}
                            </span>
                        </td>
                        
                        <td class="observaciones-cell">
                            @if($aptitud->observaciones)
                                {{ $aptitud->observaciones }}
                            @else
                                <span class="no-data-small">Sin observaciones</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <i class="fas fa-user-md"></i>
            No hay aptitudes médicas registradas para este paciente.
        </div>
    @endif

    <!-- M. RECOMENDACIONES Y/O TRATAMIENTO-->  
    <div class="section-title page-break-avoid">M. RECOMENDACIONES Y/O TRATAMIENTO</div>

    @if(isset($registro->aptitudesMedicas) && $registro->aptitudesMedicas->count())
        <table class="table-form">
            <thead>
                <tr>
                    <th width="25%">Descripción:</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registro->aptitudesMedicas as $aptitud)
                    <tr>
                        <td class="recomendaciones-cell">
                            @if($aptitud->recomendaciones_tratamiento)
                                {{ $aptitud->recomendaciones_tratamiento }}
                            @else
                                <span class="no-data-small">No especificado</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <i class="fas fa-user-md"></i>
            No hay aptitudes médicas registradas para este paciente.
        </div>
    @endif

    <!-- N. RETIRO (evaluación) -->  
    <div class="section-title page-break-avoid">N. RETIRO (evaluación)</div>

    @if(isset($registro->retirosEvaluaciones) && $registro->retirosEvaluaciones->count())
        <table class="table-form">
            <thead>
                <tr>
                    <th width="20%">Estado Evaluación</th>
                    <th width="20%">Condición Salud</th>
                    <th width="30%">Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registro->retirosEvaluaciones as $evaluacion)
                    @php
                        $evaluacionColor = $evaluacion->se_realiza_evaluacion ? 'success' : 'danger';
                        $evaluacionTexto = $evaluacion->se_realiza_evaluacion ? 'SÍ' : 'NO';
                        $evaluacionIcono = $evaluacion->se_realiza_evaluacion ? 'check-circle' : 'times-circle';
                        
                        $saludColor = $evaluacion->condicion_salud_relacionada ? 'warning' : 'success';
                        $saludTexto = $evaluacion->condicion_salud_relacionada ? 'SÍ' : 'NO';
                        $saludIcono = $evaluacion->condicion_salud_relacionada ? 'exclamation-triangle' : 'check-circle';
                    @endphp
                    
                    <tr>
                        <td class="text-center">
                            <span class="evaluacion-badge evaluacion-{{ $evaluacionColor }}">
                                <i class="fas fa-{{ $evaluacionIcono }}"></i>
                                {{ $evaluacionTexto }}
                            </span>
                        </td>
                        
                        <td class="text-center">
                            <span class="salud-badge salud-{{ $saludColor }}">
                                <i class="fas fa-{{ $saludIcono }}"></i>
                                {{ $saludTexto }}
                            </span>
                        </td>
                        
                        <td class="observaciones-cell">
                            @if($evaluacion->observaciones)
                                {{ $evaluacion->observaciones }}
                            @else
                                <span class="no-data-small">Sin observaciones</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <i class="fas fa-clipboard-check"></i>
            No hay evaluaciones de retiro registradas para este paciente.
        </div>
    @endif

    <!-- O. DATOS DEL PROFESIONAL-->
    <div class="section-title page-break-avoid">O. DATOS DEL PROFESIONAL</div>
    <table class="table-form">
        <tr>
            <th>NOMBRES Y APELLIDOS DEL PROFESIONAL</th>
            <th>CÓDIGO MEDICO</th>
            <th>FIRMA Y SELLO</th>
            <th>P. FIRMA DEL TRABAJADOR</th>
        </tr>
        <tr>
            <td class="text-center">
                <br>{{ $registro->doctor->primer_nombre ?? 'N/A' }} {{ $registro->doctor->segundo_nombre ?? '' }}<br> 
                {{ $registro->doctor->primer_apellido ?? 'N/A' }} {{ $registro->doctor->segundo_apellido ?? '' }}<br><br>
            </td>
            <td class="text-center">{{ $registro->doctor->numero_licencia ?? 'N/A' }}</td>
            <td class="text-center"></td>
            <td class="text-center"></td>
        </tr>
    </table>

</div>

</body>
</html>