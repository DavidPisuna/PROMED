@extends('adminlte::page')

@section('title', 'Registros de Paciente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">

    <h1 class="text-primary mb-0">
                <i class="fas fa-file-medical"></i> FORMULARIO DE EVALUACIÓN MÉDICA OCUPACIONAL
            </h1>
        {{-- Botón volver con JavaScript --}}
        
        <a href="{{ url('/admin/pacientes/'.$registro->paciente_id.'/registros') }}"
            class="btn btn-pastel-gray mr-3"
            title="Volver a registros del paciente">
            <i class="fas fa-arrow-left mr-2"></i> Volver
        </a>


            
        {{-- Botón PDF --}}
        <a href="{{ route('admin.registros.pdf', $registro->id) }}" 
           class="btn btn-danger" 
           target="_blank">
            <i class="fas fa-file-pdf"></i> Imprimir PDF
        </a>
    </div>
@stop

@section('content')
    
    {{-- A. DATOS DEL ESTABLECIMIENTO - DATOS DEL USUARIO --}}
    <div class="card card-pastel-primary shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-blue text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-user mr-2"></i>A. DATOS DEL ESTABLECIMIENTO - DATOS DEL USUARIO
            </h5>
            <span class="badge badge-pastel-light">Historia Clínica: {{ $registro->id }}</span>
        </div>
        <div class="card-body">
            {{-- Información de la Empresa --}}
            <div class="card card-pastel-info mb-4">
                <div class="card-header bg-pastel-light">
                    <h6 class="card-title mb-0 text-pastel-blue">
                        <i class="fas fa-building mr-1"></i>Datos del Establecimiento
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @php
                            $infoEmpresa = [
                                [
                                    'icon' => 'hospital',
                                    'label' => 'INSTITUCIÓN DEL SISTEMA', 
                                    'value' => $registro->empresa->nombre,
                                    'color' => 'pastel-blue'
                                ],
                                [
                                    'icon' => 'id-card',
                                    'label' => 'RUC', 
                                    'value' => $registro->empresa->ruc,
                                    'color' => 'pastel-purple'
                                ],
                                [
                                    'icon' => 'industry',
                                    'label' => 'CIIU', 
                                    'value' => $registro->empresa->ciiu,
                                    'color' => 'pastel-green'
                                ],
                                [
                                    'icon' => 'briefcase',
                                    'label' => 'ESTABLECIMIENTO / CENTRO DE TRABAJO', 
                                    'value' => $registro->empresa->nombre,
                                    'color' => 'pastel-orange'
                                ],
                                [
                                    'icon' => 'file-medical',
                                    'label' => 'NÚMERO DE HISTORIA CLÍNICA', 
                                    'value' => $registro->id,
                                    'color' => 'pastel-red'
                                ],
                                [
                                    'icon' => 'archive',
                                    'label' => 'NÚMERO DE ARCHIVO', 
                                    'value' => 1,
                                    'color' => 'pastel-muted'
                                ],
                            ];
                        @endphp

                        @foreach($infoEmpresa as $item)
                            <div class="col-md-4 col-lg-2 mb-3">
                                <div class="text-center p-3 border rounded bg-pastel-light h-100 d-flex flex-column justify-content-center">
                                    <i class="fas fa-{{ $item['icon'] }} fa-2x text-{{ $item['color'] }} mb-2"></i>
                                    <small class="text-muted d-block">{{ $item['label'] }}</small>
                                    <strong class="text-dark">{{ $item['value'] }}</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Información del Paciente --}}
            <div class="card card-pastel-success">
                <div class="card-header bg-pastel-light">
                    <h6 class="card-title mb-0 text-pastel-green">
                        <i class="fas fa-user-injured mr-1"></i>Datos del Paciente
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @php
                            $infoPaciente = [
                                [
                                    'icon' => 'id-badge',
                                    'label' => 'PRIMER APELLIDO', 
                                    'value' => $registro->paciente->primer_apellido,
                                    'color' => 'pastel-blue'
                                ],
                                [
                                    'icon' => 'id-badge',
                                    'label' => 'SEGUNDO APELLIDO', 
                                    'value' => $registro->paciente->segundo_apellido,
                                    'color' => 'pastel-blue'
                                ],
                                [
                                    'icon' => 'user',
                                    'label' => 'PRIMER NOMBRE', 
                                    'value' => $registro->paciente->primer_nombre,
                                    'color' => 'pastel-purple'
                                ],
                                [
                                    'icon' => 'user',
                                    'label' => 'SEGUNDO NOMBRE', 
                                    'value' => $registro->paciente->segundo_nombre,
                                    'color' => 'pastel-purple'
                                ],
                                [
                                    'icon' => 'star',
                                    'label' => 'ATENCIÓN PRIORITARIA', 
                                    'value' => $registro->atencion_prioritaria ?? 'N/A',
                                    'color' => $registro->atencion_prioritaria ? 'pastel-orange' : 'pastel-muted'
                                ],
                                [
                                    'icon' => 'venus-mars',
                                    'label' => 'SEXO', 
                                    'value' => $registro->paciente->sexo,
                                    'color' => $registro->paciente->sexo == 'F' ? 'pastel-pink' : 'pastel-blue'
                                ],
                                [
                                    'icon' => 'birthday-cake',
                                    'label' => 'FECHA DE NACIMIENTO', 
                                    'value' => $registro->paciente->fecha_nacimiento->format('d/m/Y'),
                                    'color' => 'pastel-green'
                                ],
                                [
                                    'icon' => 'calendar-alt',
                                    'label' => 'EDAD', 
                                    'value' => ($registro->paciente->edad ?? 'N/A') . ' años',
                                    'color' => 'pastel-purple'
                                ],
                                [
                                    'icon' => 'tint',
                                    'label' => 'GRUPO SANGUÍNEO', 
                                    'value' => $registro->paciente->grupo_sanguineo,
                                    'color' => 'pastel-red'
                                ],
                                [
                                    'icon' => 'hand-paper',
                                    'label' => 'LATERALIDAD', 
                                    'value' => $registro->paciente->lateralidad,
                                    'color' => 'pastel-orange'
                                ],
                                [
                                    'icon' => 'id-card',
                                    'label' => 'CÉDULA DE IDENTIDAD', 
                                    'value' => $registro->paciente->cedula_identidad,
                                    'color' => 'pastel-blue'
                                ],
                            ];
                        @endphp

                        @foreach($infoPaciente as $item)
                            <div class="col-md-4 col-lg-2 mb-3">
                                <div class="text-center p-3 border rounded bg-pastel-light h-100">
                                    <i class="fas fa-{{ $item['icon'] }} fa-2x text-{{ $item['color'] }} mb-2"></i>
                                    <small class="text-muted d-block">{{ $item['label'] }}</small>
                                    <strong class="text-dark">{{ $item['value'] }}</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- B. MOTIVO DE CONSULTA --}}
    <div class="card card-pastel-info shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-blue text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-file-medical-alt mr-2"></i>B. MOTIVO DE CONSULTA
            </h5>
            <span class="badge badge-pastel-light text-capitalize">{{ $registro->tipo }}</span>
        </div>
        <div class="card-body">
            <div class="row">
                @php
                    $motivoConsulta = [
                        [
                            'icon' => 'briefcase',
                            'label' => 'Puesto de Trabajo CIUO',
                            'value' => $registro->puesto ?? '—'
                        ],
                        [
                            'icon' => 'calendar-check',
                            'label' => 'Fecha de Atención',
                            'value' => optional($registro->created_at)->format('d/m/Y H:i')
                        ],
                        [
                            'icon' => 'stethoscope',
                            'label' => 'Tipo de registro',
                            'value' => ucfirst($registro->tipo)
                        ],
                        [
                            'icon' => 'calendar-day',
                            'label' => match($registro->tipo) {
                                'ingreso' => 'Fecha de Ingreso',
                                'periodica' => 'Fecha de Evaluación',
                                'reintegro' => 'Fecha de Reintegro',
                                'retiro' => 'Fecha de Retiro',
                                default => 'Fecha de Registro'
                            },
                            'value' => match($registro->tipo) {
                                'ingreso' => optional($registro->fecha_ingreso)->format('d/m/Y'),
                                'periodica' => optional($registro->fecha_periodica)->format('d/m/Y'),
                                'reintegro' => optional($registro->fecha_reintegro)->format('d/m/Y'),
                                'retiro' => optional($registro->fecha_retiro)->format('d/m/Y'),
                                default => optional($registro->created_at)->format('d/m/Y'),
                            }
                        ],
                    ];
                @endphp

                @foreach($motivoConsulta as $item)
                    <div class="col-md-3 mb-3">
                        <div class="text-center p-3 border rounded bg-pastel-light shadow-soft">
                            <i class="fas fa-{{ $item['icon'] }} fa-2x text-pastel-blue mb-2"></i>
                            <small class="text-muted d-block">{{ $item['label'] }}</small>
                            <strong class="text-dark">{{ $item['value'] ?? '—' }}</strong>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($registro->observaciones)
                <div class="mt-3">
                    <div class="alert alert-pastel-orange">
                        <i class="fas fa-eye mr-2"></i>
                        <strong>Observaciones:</strong> {{ $registro->observaciones }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- C. ANTECEDENTES PERSONALES --}}
    <div class="card card-pastel-warning shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-orange text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-notes-medical mr-2"></i>C. ANTECEDENTES PERSONALES
            </h5>
            <div>
                @if($registro->antecedentePatologico)
                    <span class="badge badge-pastel-green">Registrado</span>
                @else
                    <span class="badge badge-pastel-muted">No registrado</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            {{-- Antecedentes Patológicos --}}
            <div class="card card-pastel-warning mb-4">
                <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0 text-pastel-orange">
                        <i class="fas fa-history mr-1"></i>Antecedentes Patológicos
                    </h6>
                    <div>
                        @if($registro->antecedentePatologico)
                            <a href="{{ route('admin.antecedentes_patologicos.edit', $registro->antecedentePatologico) }}" class="btn btn-pastel-orange btn-sm">
                                <i class="fas fa-edit mr-1"></i>Editar
                            </a>
                        @else
                            <a href="{{ route('admin.antecedentes_patologicos.create', $registro) }}" class="btn btn-pastel-green btn-sm">
                                <i class="fas fa-plus mr-1"></i>Crear
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($registro->antecedentePatologico)
                        <div class="row">
                            @php
                                $antecedentes = [
                                    ['icon' => 'stethoscope', 'label' => 'ANTECEDENTES CLÍNICOS Y QUIRÚRGICOS', 'value' => $registro->antecedentePatologico->antecedente_app ?? 'Ninguno'],
                                    ['icon' => 'users', 'label' => 'ANTECEDENTES FAMILIARES', 'value' => $registro->antecedentePatologico->antecedente_apqx ?? 'Ninguno'],
                                    ['icon' => 'tint', 'label' => 'Autoriza transfusiones', 'value' => $registro->antecedentePatologico->autoriza_transfusiones ? 'Sí' : 'No'],
                                    ['icon' => 'pills', 'label' => 'Tratamiento hormonal', 'value' => $registro->antecedentePatologico->tratamiento_hormonal_si_no ? 'Sí' : 'No'],
                                ];

                                if($registro->antecedentePatologico->tratamiento_hormonal_si_no) {
                                    $antecedentes[] = ['icon' => 'file-medical', 'label' => 'Descripción tratamiento hormonal', 'value' => $registro->antecedentePatologico->tratamiento_hormonal_descripcion ?? 'Ninguna'];
                                }
                            @endphp

                            @foreach($antecedentes as $item)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-{{ $item['icon'] }} text-pastel-orange mr-2 mt-1"></i>
                                        <div>
                                            <small class="text-muted d-block">{{ $item['label'] }}</small>
                                            <strong>{{ $item['value'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history fa-2x text-pastel-muted mb-3"></i>
                            <p class="text-muted">No hay antecedentes patológicos registrados.</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Antecedentes Gineco-Obstétricos (mujeres) --}}
            @if($registro->paciente->sexo === 'F')
                <div class="card card-pastel-info mb-4">
                    <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0 text-pastel-blue">
                            <i class="fas fa-female mr-1"></i>Antecedentes Gineco-Obstétricos
                        </h6>
                        <div>
                            @if($registro->antecedenteGineco)
                                <a href="{{ route('admin.antecedentes_gineco_obstetricos.edit', $registro->antecedenteGineco) }}" class="btn btn-pastel-blue btn-sm">
                                    <i class="fas fa-edit mr-1"></i>Editar
                                </a>
                            @else
                                <a href="{{ route('admin.antecedentes_gineco_obstetricos.create', $registro) }}" class="btn btn-pastel-green btn-sm">
                                    <i class="fas fa-plus mr-1"></i>Crear
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if($registro->antecedenteGineco)
                            <div class="row mb-4">
                                @php
                                    $gineco = [
                                        ['icon' => 'calendar', 'label' => 'Fecha Última Menstruación', 'value' => $registro->antecedenteGineco->fecha_ultima_menstruacion ? \Carbon\Carbon::parse($registro->antecedenteGineco->fecha_ultima_menstruacion)->format('d/m/Y') : 'N/A'],
                                        ['icon' => 'baby', 'label' => 'Gestas', 'value' => $registro->antecedenteGineco->gestas ?? '0'],
                                        ['icon' => 'baby-carriage', 'label' => 'Partos', 'value' => $registro->antecedenteGineco->partos ?? '0'],
                                        ['icon' => 'procedures', 'label' => 'Cesáreas', 'value' => $registro->antecedenteGineco->cesareas ?? '0'],
                                        ['icon' => 'heart-broken', 'label' => 'Abortos', 'value' => $registro->antecedenteGineco->abortos ?? '0'],
                                    ];

                                    // Planificación familiar
                                    if($registro->antecedenteGineco->planificacion_si) {
                                        $gineco[] = ['icon' => 'shield-alt', 'label' => 'Planificación Familiar', 'value' => 'Sí (' . ($registro->antecedenteGineco->planificacion_cual ?? 'Ninguno') . ')'];
                                    } elseif($registro->antecedenteGineco->planificacion_no) {
                                        $gineco[] = ['icon' => 'shield-alt', 'label' => 'Planificación Familiar', 'value' => 'No'];
                                    } elseif($registro->antecedenteGineco->planificacion_no_responde) {
                                        $gineco[] = ['icon' => 'shield-alt', 'label' => 'Planificación Familiar', 'value' => 'No responde'];
                                    } else {
                                        $gineco[] = ['icon' => 'shield-alt', 'label' => 'Planificación Familiar', 'value' => 'N/A'];
                                    }
                                @endphp

                                @foreach($gineco as $item)
                                    <div class="col-md-4 mb-3">
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-{{ $item['icon'] }} text-pastel-blue mr-2 mt-1"></i>
                                            <div>
                                                <small class="text-muted d-block">{{ $item['label'] }}</small>
                                                <strong>{{ $item['value'] }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Exámenes en tabla --}}
                            @if($registro->antecedenteGineco->examenes->count())
                                <div class="mt-3">
                                    <h6 class="text-pastel-blue">
                                        <i class="fas fa-vials mr-1"></i>Exámenes Realizados
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover">
                                            <thead class="table-pastel-blue">
                                                <tr class="text-center">
                                                    <th><i class="fas fa-vial mr-1"></i>Examen</th>
                                                    <th><i class="fas fa-clock mr-1"></i>Tiempo (meses)</th>
                                                    <th><i class="fas fa-file-medical-alt mr-1"></i>Resultado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($registro->antecedenteGineco->examenes as $examen)
                                                    <tr>
                                                        <td>{{ $examen->examen_realizado }}</td>
                                                        <td class="text-center">{{ $examen->tiempo_meses ?? 'N/A' }}</td>
                                                        <td>{{ $examen->resultado ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="fas fa-vials fa-2x text-pastel-muted mb-2"></i>
                                    <p class="text-muted">No hay exámenes registrados.</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-female fa-2x text-pastel-muted mb-3"></i>
                                <p class="text-muted">No hay antecedentes gineco-obstétricos registrados.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Antecedentes Reproductivos Masculinos (hombres) --}}
            @if($registro->paciente->sexo === 'M')
                <div class="card card-pastel-primary mb-4">
                    <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0 text-pastel-purple">
                            <i class="fas fa-mars mr-1"></i>Antecedentes Reproductivos Masculinos
                        </h6>
                        <div>
                            @if($registro->antecedenteMasculino)
                                <a href="{{ route('admin.antecedentes_masculinos.edit', $registro->antecedenteMasculino) }}" class="btn btn-pastel-purple btn-sm">
                                    <i class="fas fa-edit mr-1"></i>Editar
                                </a>
                            @else
                                <a href="{{ route('admin.antecedentes_masculinos.create', $registro) }}" class="btn btn-pastel-green btn-sm">
                                    <i class="fas fa-plus mr-1"></i>Crear
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        @if($registro->antecedenteMasculino)
                            <div class="row mb-4">
                                @php
                                    $planificacion = $registro->antecedenteMasculino->planificacion_si ? 'Sí (' . ($registro->antecedenteMasculino->planificacion_cual ?? 'Ninguno') . ')' :
                                                    ($registro->antecedenteMasculino->planificacion_no ? 'No' : ($registro->antecedenteMasculino->planificacion_no_responde ? 'No responde' : 'N/A'));
                                @endphp
                                <div class="col-md-6">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-shield-alt text-pastel-purple mr-2 mt-1"></i>
                                        <div>
                                            <small class="text-muted d-block">Método planificación familiar</small>
                                            <strong>{{ $planificacion }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Exámenes masculinos en tabla --}}
                            @if($registro->antecedenteMasculino->examenes->count())
                                <div class="mt-3">
                                    <h6 class="text-pastel-purple">
                                        <i class="fas fa-vials mr-1"></i>Exámenes Realizados
                                    </h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered table-hover">
                                            <thead class="table-pastel-purple">
                                                <tr class="text-center">
                                                    <th><i class="fas fa-vial mr-1"></i>Examen</th>
                                                    <th><i class="fas fa-clock mr-1"></i>Tiempo (meses)</th>
                                                    <th><i class="fas fa-file-medical-alt mr-1"></i>Resultado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($registro->antecedenteMasculino->examenes as $examen)
                                                    <tr>
                                                        <td>{{ $examen->examen_realizado }}</td>
                                                        <td class="text-center">{{ $examen->tiempo_meses ?? 'N/A' }}</td>
                                                        <td>{{ $examen->resultado ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="text-center py-3">
                                    <i class="fas fa-vials fa-2x text-pastel-muted mb-2"></i>
                                    <p class="text-muted">No hay exámenes registrados.</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-mars fa-2x text-pastel-muted mb-3"></i>
                                <p class="text-muted">No hay antecedentes reproductivos masculinos registrados.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- CONSUMO DE SUSTANCIAS Y ESTILO DE VIDA --}}
            <div class="card card-pastel-danger">
                <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center">
                    <h6 class="card-title mb-0 text-pastel-red">
                        <i class="fas fa-smoking mr-1"></i>CONSUMO DE SUSTANCIAS Y ESTILO DE VIDA
                    </h6>
                    <div>
                        @if($registro->consumoSustancia)
                            <a href="{{ route('admin.consumos.edit', $registro->consumoSustancia) }}" class="btn btn-pastel-red btn-sm">
                                <i class="fas fa-edit mr-1"></i>Editar
                            </a>
                        @else
                            <a href="{{ route('admin.consumos.create', $registro) }}" class="btn btn-pastel-green btn-sm">
                                <i class="fas fa-plus mr-1"></i>Registrar
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if($registro->consumoSustancia)
                        {{-- Consumo de Sustancias --}}
                        <h6 class="text-pastel-red mb-3">
                            <i class="fas fa-wine-bottle mr-1"></i>Consumo de Sustancias
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover">
                                <thead class="table-pastel-red">
                                    <tr class="text-center">
                                        <th><i class="fas fa-capsules mr-1"></i>Consumo</th>
                                        <th><i class="fas fa-info-circle mr-1"></i>Detalle</th>
                                        <th><i class="fas fa-clock mr-1"></i>Tiempo de Consumo</th>
                                        <th><i class="fas fa-calendar-times mr-1"></i>Tiempo de Abstinencia</th>
                                        <th><i class="fas fa-comment-medical mr-1"></i>Observaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sustancias = [
                                            ['nombre' => 'Tabaco', 'estado' => $registro->consumoSustancia->tabaco_estado, 'tiempo' => $registro->consumoSustancia->tabaco_tiempo_consumo, 'abstinencia' => $registro->consumoSustancia->tabaco_tiempo_abstinencia, 'cual' => ''],
                                            ['nombre' => 'Alcohol', 'estado' => $registro->consumoSustancia->alcohol_estado, 'tiempo' => $registro->consumoSustancia->alcohol_tiempo_consumo, 'abstinencia' => $registro->consumoSustancia->alcohol_tiempo_abstinencia, 'cual' => ''],
                                            ['nombre' => 'Otras Sustancias', 'estado' => $registro->consumoSustancia->otras_sustancias_estado, 'tiempo' => $registro->consumoSustancia->otras_sustancias_tiempo_consumo, 'abstinencia' => $registro->consumoSustancia->otras_sustancias_tiempo_abstinencia, 'cual' => $registro->consumoSustancia->otras_sustancias_cual],
                                        ];
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
                                </tbody>
                            </table>
                        </div>

                        {{-- Estilo de Vida --}}
                        <h6 class="text-pastel-green mt-4 mb-3">
                            <i class="fas fa-running mr-1"></i>Estilo de Vida
                        </h6>
                        @if($registro->actividadesFisicas->count())
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover">
                                    <thead class="table-pastel-green">
                                        <tr class="text-center">
                                            <th><i class="fas fa-dumbbell mr-1"></i>Actividad</th>
                                            <th><i class="fas fa-clock mr-1"></i>Tiempo (min)</th>
                                            <th><i class="fas fa-sync-alt mr-1"></i>Frecuencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registro->actividadesFisicas as $actividad)
                                            <tr>
                                                <td>{{ $actividad->actividad_fisica_cual }}</td>
                                                <td class="text-center">{{ $actividad->actividad_fisica_tiempo ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $actividad->actividad_fisica_frecuencia ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-pastel-info">
                                <i class="fas fa-info-circle mr-2"></i>No hay actividades físicas registradas.
                            </div>
                        @endif

                        {{-- Medicaciones Habituales --}}
                        <h6 class="text-pastel-orange mt-4 mb-3">
                            <i class="fas fa-pills mr-1"></i>Medicaciones Habituales
                        </h6>
                        @if($registro->medicacionesHabituales->count())
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered table-hover">
                                    <thead class="table-pastel-orange">
                                        <tr class="text-center">
                                            <th><i class="fas fa-medkit mr-1"></i>Medicación</th>
                                            <th><i class="fas fa-balance-scale mr-1"></i>Cantidad</th>
                                            <th><i class="fas fa-check-circle mr-1"></i>Toma Actualmente</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($registro->medicacionesHabituales as $med)
                                            <tr>
                                                <td>{{ $med->medicacion_habitual_cual }}</td>
                                                <td class="text-center">{{ $med->medicacion_habitual_cantidad ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <span class="badge {{ $med->toma_medicacion_habitual ? 'badge-pastel-green' : 'badge-pastel-muted' }}">
                                                        {{ $med->toma_medicacion_habitual ? 'Sí' : 'No' }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-pastel-info">
                                <i class="fas fa-info-circle mr-2"></i>No hay medicaciones registradas.
                            </div>
                        @endif

                        {{-- Observaciones Generales --}}
                        @if($registro->consumoSustancia->observaciones)
                            <div class="mt-4">
                                <h6 class="text-pastel-blue">
                                    <i class="fas fa-comment-medical mr-1"></i>Observaciones Generales
                                </h6>
                                <div class="alert alert-pastel-info">
                                    {{ $registro->consumoSustancia->observaciones }}
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-smoking fa-2x text-pastel-muted mb-3"></i>
                            <p class="text-muted">No hay consumo de sustancias registrado.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- D. ENFERMEDAD O PROBLEMA ACTUAL --}}
    <div class="card card-pastel-muted shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-muted text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-heartbeat mr-2"></i>D. ENFERMEDAD O PROBLEMA ACTUAL
            </h5>
            <span class="badge badge-pastel-light">Estado Actual</span>
        </div>
        <div class="card-body">
            @if($registro->constanteVital && $registro->constanteVital->enfermedad_actual)
                <div class="alert alert-pastel-info">
                    <i class="fas fa-stethoscope mr-2"></i>
                    <strong>Descripción:</strong> {{ $registro->constanteVital->enfermedad_actual }}
                </div>
            @else
                <div class="text-center py-3">
                    <i class="fas fa-heartbeat fa-2x text-pastel-muted mb-2"></i>
                    <p class="text-muted">No se ha registrado enfermedad o problema actual.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- E. CONSTANTES VITALES Y ANTROPOMETRÍA --}}
    <div class="card card-pastel-success shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-green text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-heartbeat mr-2"></i>E. CONSTANTES VITALES Y ANTROPOMETRÍA
            </h5>
            <div>
                @if($registro->constanteVital)
                    <span class="badge badge-pastel-green">Registrado</span>
                    <a href="{{ route('admin.constantes_vitales.edit', $registro->constanteVital) }}" class="btn btn-pastel-light btn-sm ml-2">
                        <i class="fas fa-edit mr-1"></i>Editar
                    </a>
                @else
                    <span class="badge badge-pastel-muted">No registrado</span>
                    <a href="{{ route('admin.constantes_vitales.create', $registro) }}" class="btn btn-pastel-green btn-sm ml-2">
                        <i class="fas fa-plus mr-1"></i>Registrar
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
            @if($registro->constanteVital)
                <div class="row">
                    {{-- Constantes Vitales --}}
                    <div class="col-md-6">
                        <div class="card card-pastel-info mb-4">
                            <div class="card-header bg-pastel-light">
                                <h6 class="card-title mb-0 text-pastel-blue">
                                    <i class="fas fa-heartbeat mr-1"></i>Constantes Vitales
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    @php
                                        $constantesVitales = [
                                            ['icon' => 'thermometer-half', 'label' => 'Temperatura', 'value' => $registro->constanteVital->temperatura, 'unit' => '°C'],
                                            ['icon' => 'tachometer-alt', 'label' => 'Presión Arterial', 'value' => $registro->constanteVital->presion_arterial, 'unit' => 'mmHg'],
                                            ['icon' => 'heart', 'label' => 'Frecuencia Cardíaca', 'value' => $registro->constanteVital->frecuencia_cardiaca, 'unit' => 'Lat/min'],
                                            ['icon' => 'wind', 'label' => 'Frecuencia Respiratoria', 'value' => $registro->constanteVital->frecuencia_respiratoria, 'unit' => 'fr/min'],
                                            ['icon' => 'lungs', 'label' => 'Saturación O₂', 'value' => $registro->constanteVital->saturacion_oxigeno, 'unit' => '%'],
                                        ];
                                    @endphp

                                    @foreach($constantesVitales as $constante)
                                        <div class="col-6 mb-3">
                                            <div class="p-3 border rounded bg-pastel-light">
                                                <i class="fas fa-{{ $constante['icon'] }} fa-2x text-pastel-blue mb-2"></i>
                                                <small class="text-muted d-block">{{ $constante['label'] }}</small>
                                                <strong class="text-dark">{{ $constante['value'] ?? 'N/A' }}</strong>
                                                <small class="text-muted">{{ $constante['unit'] }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Antropometría --}}
                    <div class="col-md-6">
                        <div class="card card-pastel-warning">
                            <div class="card-header bg-pastel-light">
                                <h6 class="card-title mb-0 text-pastel-orange">
                                    <i class="fas fa-weight mr-1"></i>Antropometría
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    @php
                                        $antropometria = [
                                            ['icon' => 'weight', 'label' => 'Peso', 'value' => $registro->constanteVital->peso, 'unit' => 'Kg'],
                                            ['icon' => 'ruler-vertical', 'label' => 'Talla', 'value' => $registro->constanteVital->talla, 'unit' => 'cm'],
                                            ['icon' => 'calculator', 'label' => 'IMC', 'value' => $registro->constanteVital->imc, 'unit' => 'kg/m²'],
                                            ['icon' => 'chart-bar', 'label' => 'Categoría IMC', 'value' => $registro->constanteVital->categoria_imc, 'unit' => ''],
                                            ['icon' => 'ruler-combined', 'label' => 'Perímetro Abdominal', 'value' => $registro->constanteVital->perimetro_abdominal, 'unit' => 'cm'],
                                        ];
                                    @endphp

                                    @foreach($antropometria as $item)
                                        <div class="col-6 mb-3">
                                            <div class="p-3 border rounded bg-pastel-light">
                                                <i class="fas fa-{{ $item['icon'] }} fa-2x text-pastel-orange mb-2"></i>
                                                <small class="text-muted d-block">{{ $item['label'] }}</small>
                                                <strong class="text-dark">{{ $item['value'] ?? 'N/A' }}</strong>
                                                @if($item['unit'])
                                                    <small class="text-muted">{{ $item['unit'] }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-heartbeat fa-2x text-pastel-muted mb-3"></i>
                    <p class="text-muted">No hay constantes vitales registradas.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- F. EXAMENES FÍSICOS --}}
    <div class="card card-pastel-info shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-blue text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-stethoscope mr-2"></i> F. EXÁMENES FÍSICOS
            </h5>
            <div>
                @if($registro->examenesFisicos && $registro->examenesFisicos->count())
                    <span class="badge badge-pastel-light text-pastel-blue">Registrado</span>
                    <a href="{{ route('admin.examenes_fisicos.edit', $registro) }}" class="btn btn-pastel-light btn-sm ml-2">
                        <i class="fas fa-edit mr-1"></i> Editar
                    </a>
                @else
                    <span class="badge badge-pastel-muted">No registrado</span>
                    <a href="{{ route('admin.examenes_fisicos.create', $registro) }}" class="btn btn-pastel-green btn-sm ml-2">
                        <i class="fas fa-plus mr-1"></i> Registrar
                    </a>
                @endif
            </div>
        </div>

        <div class="card-body bg-pastel-light">
            @if($registro->examenesFisicos && $registro->examenesFisicos->count())
                <div class="row" id="examenes-container">
                    @php
                        $examenesAgrupados = $registro->examenesFisicos->groupBy('region');
                        $regionesDisplay = [
                            'piel' => ['nombre' => 'Piel y Faneras', 'color' => 'pastel-blue'],
                            'ojos' => ['nombre' => 'Ojos', 'color' => 'pastel-blue'],
                            'oido' => ['nombre' => 'Oído', 'color' => 'pastel-blue'],
                            'orofaringe' => ['nombre' => 'Orofaringe', 'color' => 'pastel-blue'],
                            'nariz' => ['nombre' => 'Nariz', 'color' => 'pastel-blue'],
                            'cuello' => ['nombre' => 'Cabeza y Cuello', 'color' => 'pastel-blue'],
                            'torax_mamas' => ['nombre' => 'Tórax - Mamas', 'color' => 'pastel-green'],
                            'torax_organos' => ['nombre' => 'Tórax - Órganos', 'color' => 'pastel-green'],
                            'abdomen' => ['nombre' => 'Abdomen', 'color' => 'pastel-orange'],
                            'columna' => ['nombre' => 'Columna', 'color' => 'pastel-purple'],
                            'pelvis' => ['nombre' => 'Pelvis', 'color' => 'pastel-purple'],
                            'extremidades' => ['nombre' => 'Extremidades', 'color' => 'pastel-red'],
                            'neurologico' => ['nombre' => 'Neurológico', 'color' => 'pastel-muted']
                        ];
                    @endphp

                    @foreach($examenesAgrupados as $region => $examenesRegion)
                        @if(isset($regionesDisplay[$region]))
                            <div class="col-md-6 col-lg-4 mb-4">
                                <div class="card region-card h-100 shadow-soft">
                                    <div class="card-header bg-{{ $regionesDisplay[$region]['color'] }} text-white py-2">
                                        <h6 class="mb-0">
                                            <i class="fas fa-clipboard-check me-1"></i> 
                                            {{ $regionesDisplay[$region]['nombre'] }}
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($examenesRegion as $examen)
                                            @if($examen->valor)
                                                <div class="examen-item mb-3">
                                                    <div class="d-flex align-items-start">
                                                        <i class="fas fa-check-circle text-pastel-green mt-1 me-2"></i>
                                                        <div>
                                                            <strong class="text-capitalize">
                                                                {{ ucfirst(str_replace('_', ' ', $examen->item)) }}
                                                            </strong>
                                                            @if($examen->observacion)
                                                                <div>
                                                                    <small class="text-muted">
                                                                        <em>Observación:</em> {{ $examen->observacion }}
                                                                    </small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-clipboard-list fa-3x text-pastel-muted mb-3"></i>
                    <p class="text-muted">No se han registrado exámenes físicos para este paciente.</p>
                    <a href="{{ route('admin.examenes_fisicos.create', $registro) }}" class="btn btn-pastel-blue">
                        <i class="fas fa-plus mr-1"></i> Registrar Exámenes Físicos
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- G. FACTORES DE RIESGO DEL TRABAJO ACTUAL --}}
    <div class="card card-pastel-warning shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-orange text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-briefcase mr-2"></i>G. FACTORES DE RIESGO DEL TRABAJO ACTUAL         
            </h5>
            @if($registro->puestos->count())
                <a href="{{ route('admin.puestos.create', $registro->id) }}" class="btn btn-pastel-green btn-sm">
                    <i class="fas fa-plus mr-1"></i> Agregar Puesto
                </a>
            @endif
        </div>

        <div class="card-body">
            @if($registro->puestos->count())
                @foreach($registro->puestos as $puesto)
                    <div class="card card-pastel-info mb-4">
                        <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0 text-pastel-blue">
                                <i class="fas fa-user-tie mr-1"></i>{{ $puesto->nombre_puesto }}
                            </h6>
                            <div>
                                <a href="{{ route('admin.puestos.edit', [$registro->id, $puesto->id]) }}" 
                                class="btn btn-pastel-blue btn-sm me-1">
                                    <i class="fas fa-edit mr-1"></i> Editar
                                </a>
                                <button type="button" class="btn btn-pastel-red btn-sm btn-delete-puesto" 
                                        data-puesto-id="{{ $puesto->id }}" 
                                        data-puesto-nombre="{{ $puesto->nombre_puesto }}"
                                        data-registro-id="{{ $registro->id }}">
                                    <i class="fas fa-trash-alt mr-1"></i> Eliminar
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            @if($puesto->actividades->count())
                                @foreach($puesto->actividades as $actividad)
                                    <div class="card card-pastel-primary mb-3">
                                        <div class="card-header bg-pastel-light">
                                            <h6 class="card-title mb-0 text-pastel-purple">
                                                <i class="fas fa-tasks mr-1"></i>{{ $actividad->nombre_actividad }}
                                            </h6>
                                        </div>
                                        
                                        <div class="card-body">
                                            @if($actividad->factoresRiesgo->count())
                                                <div class="row">
                                                    @foreach($actividad->factoresRiesgo->groupBy('categoria') as $categoria => $factores)
                                                        @php
                                                    $color = match($categoria) {
                                                        'quimicos' => 'primary',
                                                        'fisicos' => 'success',
                                                        'biologicos' => 'warning',
                                                        'ergonomicos' => 'danger',
                                                        'psicosociales' => 'info',
                                                        'mecanicos' => 'secondary',
                                                        'seguridad' => 'purple',
                                                        'higiene' => 'blue',
                                                        default => 'light'
                                                    };
                                                    
                                                    $icono = match($categoria) {
                                                        'quimicos' => 'flask',
                                                        'fisicos' => 'bolt',
                                                        'biologicos' => 'biohazard',
                                                        'ergonomicos' => 'chair',
                                                        'psicosociales' => 'brain',
                                                        'mecanicos' => 'cogs',
                                                        'seguridad' => 'shield-alt',
                                                        'higiene' => 'hands-wash',
                                                        default => 'exclamation-triangle'
                                                    };
                                                    
                                                    $badgeColor = match($color) {
                                                        'primary' => 'pastel-blue',
                                                        'success' => 'pastel-green',
                                                        'warning' => 'pastel-orange',
                                                        'danger' => 'pastel-red',
                                                        'info' => 'pastel-purple',
                                                        'secondary' => 'pastel-muted',
                                                        default => 'pastel-light'
                                                    };
                                                @endphp
                                                        <div class="col-md-6 col-lg-4 mb-3">
                                                            <div class="card border-{{ $badgeColor }} h-100">
                                                                <div class="card-header bg-{{ $badgeColor }} text-white py-2">
                                                                    <h6 class="card-title mb-0">
                                                                        <i class="fas fa-{{ $icono }} mr-1"></i>
                                                                        {{ str_replace('_', ' ', ucfirst($categoria)) }}
                                                                    </h6>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="d-flex flex-wrap gap-1">
                                                                        @foreach($factores as $factor)
                                                                            <span class="badge bg-pastel-light text-dark border mb-1 px-2 py-1" 
                                                                                style="font-size:0.8em;">
                                                                                {{ $factor->factor_riesgo }}
                                                                            </span>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="alert alert-pastel-light text-center py-3">
                                                    <i class="fas fa-exclamation-circle text-pastel-muted mr-2"></i>
                                                    <span class="text-muted">No hay factores de riesgo registrados para esta actividad.</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-pastel-orange text-center py-3">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <span>No hay actividades registradas para este puesto.</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                {{-- Botón para agregar más puestos --}}
                <div class="text-center mt-4">
                    <a href="{{ route('admin.puestos.create', $registro->id) }}" class="btn btn-pastel-green">
                        <i class="fas fa-plus mr-1"></i> Agregar Otro Puesto
                    </a>
                </div>

            @else
                {{-- Estado cuando no hay puestos registrados --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-briefcase fa-3x text-pastel-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">No hay puestos de trabajo registrados</h5>
                    <p class="text-muted mb-4">Comience registrando el primer puesto de trabajo del paciente.</p>
                    <a href="{{ route('admin.puestos.create', $registro->id) }}" class="btn btn-pastel-blue btn-lg">
                        <i class="fas fa-plus mr-2"></i> Registrar Primer Puesto
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- Centros de Trabajo --}}
    <div class="card card-pastel-info shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-blue text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-building mr-2"></i>H. ACTIVIDAD LABORAL/ INCIDENTES/ACCIDENTES / ENFERMEDADES OCUPACIONALES
            </h5>
            <a href="{{ route('admin.centros_trabajos.create', $registro->id) }}" class="btn btn-pastel-green btn-sm">
                <i class="fas fa-plus mr-1"></i> Agregar Centro
            </a>
        </div>

        <div class="card-body">
            @if($registro->centros && $registro->centros->count())
                @foreach($registro->centros as $centro)
                    <div class="card card-pastel-primary mb-4">
                        <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0 text-pastel-purple">
                                <i class="fas fa-building mr-1"></i>{{ $centro->nombre_centro_trabajo }}
                            </h6>
                            <div class="btn-group">
                                <a href="{{ route('admin.centros_trabajos.show', [$registro->id, $centro->id]) }}" 
                                class="btn btn-pastel-blue btn-sm" title="Ver detalles">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.centros_trabajos.edit', [$registro->id, $centro->id]) }}" 
                                class="btn btn-pastel-purple btn-sm" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-pastel-red btn-sm btn-delete-centro" 
                                        data-centro-id="{{ $centro->id }}" 
                                        data-centro-nombre="{{ $centro->nombre_centro_trabajo }}"
                                        data-registro-id="{{ $registro->id }}"
                                        title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            {{-- Información Básica en Cuadrícula --}}
                            <div class="row mb-4">
                                @php
                                    $infoBasica = [
                                        [
                                            'icon' => 'briefcase',
                                            'label' => 'Tipo de Trabajo', 
                                            'value' => ucfirst($centro->tipo_trabajo),
                                            'color' => 'pastel-blue'
                                        ],
                                        [
                                            'icon' => 'clock',
                                            'label' => 'Tiempo de Trabajo', 
                                            'value' => $centro->tiempo_trabajo ?? 'No especificado',
                                            'color' => 'pastel-purple'
                                        ],
                                        [
                                            'icon' => 'calendar-day',
                                            'label' => 'Fecha Calificación IESS', 
                                            'value' => $centro->fecha_calificacion ? $centro->fecha_calificacion->format('d/m/Y') : 'No aplica',
                                            'color' => $centro->fecha_calificacion ? 'pastel-green' : 'pastel-muted'
                                        ],
                                    ];
                                @endphp

                                @foreach($infoBasica as $item)
                                    <div class="col-md-4 mb-3">
                                        <div class="text-center p-3 border rounded bg-pastel-light h-100">
                                            <i class="fas fa-{{ $item['icon'] }} fa-2x text-{{ $item['color'] }} mb-2"></i>
                                            <small class="text-muted d-block">{{ $item['label'] }}</small>
                                            <strong class="text-dark">{{ $item['value'] }}</strong>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Situaciones Laborales en Cuadrícula --}}
                            <h6 class="text-pastel-purple mb-3">
                                <i class="fas fa-exclamation-triangle mr-1"></i>Situaciones Laborales
                            </h6>
                            <div class="row mb-4">
                                @php
                                    $situaciones = [
                                        [
                                            'icon' => 'ambulance',
                                            'label' => 'Incidente',
                                            'value' => $centro->incidente ? 'Sí' : 'No',
                                            'color' => $centro->incidente ? 'pastel-red' : 'pastel-green'
                                        ],
                                        [
                                            'icon' => 'car-crash',
                                            'label' => 'Accidente',
                                            'value' => $centro->accidente ? 'Sí' : 'No',
                                            'color' => $centro->accidente ? 'pastel-red' : 'pastel-green'
                                        ],
                                        [
                                            'icon' => 'stethoscope',
                                            'label' => 'Enfermedad Profesional',
                                            'value' => $centro->enfermedad_profesional ? 'Sí' : 'No',
                                            'color' => $centro->enfermedad_profesional ? 'pastel-red' : 'pastel-green'
                                        ],
                                        [
                                            'icon' => 'file-medical',
                                            'label' => 'Calificado IESS',
                                            'value' => $centro->calificado_iess ? 'Sí' : 'No',
                                            'color' => $centro->calificado_iess ? 'pastel-blue' : 'pastel-muted'
                                        ],
                                    ];
                                @endphp

                                @foreach($situaciones as $item)
                                    <div class="col-md-3 mb-3">
                                        <div class="text-center p-3 border rounded bg-pastel-light h-100">
                                            <i class="fas fa-{{ $item['icon'] }} fa-2x text-{{ $item['color'] }} mb-2"></i>
                                            <small class="text-muted d-block">{{ $item['label'] }}</small>
                                            <span class="badge bg-{{ $item['color'] }}">{{ $item['value'] }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Actividades Desempeñadas --}}
                            @if($centro->actividades_desempenadas)
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="alert alert-pastel-orange">
                                        <i class="fas fa-tasks mr-2"></i>
                                        <strong>Actividades Desempeñadas:</strong> {{ $centro->actividades_desempenadas }}
                                    </div>
                                </div>
                            </div>
                            @endif

                            {{-- Información Adicional --}}
                            <div class="row">
                                @if($centro->especificar)
                                <div class="col-md-6">
                                    <div class="alert alert-pastel-info">
                                        <i class="fas fa-clipboard-list mr-2"></i>
                                        <strong>Especificaciones:</strong> {{ $centro->especificar }}
                                    </div>
                                </div>
                                @endif

                                @if($centro->observaciones)
                                <div class="col-md-6">
                                    <div class="alert alert-pastel-muted">
                                        <i class="fas fa-sticky-note mr-2"></i>
                                        <strong>Observaciones:</strong> {{ $centro->observaciones }}
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

            @else
                {{-- Estado cuando no hay centros de trabajo --}}
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-building fa-3x text-pastel-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">No hay centros de trabajo registrados</h5>
                    <p class="text-muted mb-4">Comience registrando el primer centro de trabajo del paciente.</p>
                    <a href="{{ route('admin.centros_trabajos.create', $registro->id) }}" class="btn btn-pastel-blue btn-lg">
                        <i class="fas fa-plus mr-2"></i> Registrar Primer Centro
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- I. ACTIVIDADES EXTRA LABORALES --}}
    <div class="card card-pastel-info shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-blue text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-tasks mr-2"></i>I. ACTIVIDADES EXTRA LABORALES 
            </h5>
            <a href="{{ route('admin.actividades_extras.create', $registro->id) }}" class="btn btn-pastel-green btn-sm">
                <i class="fas fa-plus mr-1"></i> Agregar Actividad
            </a>
        </div>

        <div class="card-body">
            @if($registro->actividadesExtras->count())
                <div class="row">
                    @foreach($registro->actividadesExtras as $actividad)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card card-pastel-primary h-100">
                                <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center py-2">
                                    <h6 class="card-title mb-0 text-pastel-purple">
                                        <i class="fas fa-running mr-1"></i>ACTIVIDADES
                                    </h6>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.actividades_extras.edit', [$registro->id, $actividad->id]) }}" 
                                        class="btn btn-pastel-purple btn-sm" title="Editar actividad">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-pastel-red btn-sm btn-delete-actividad" 
                                                data-actividad-id="{{ $actividad->id }}"
                                                data-actividad-tipo="{{ $actividad->tipo_actividad }}"
                                                data-registro-id="{{ $registro->id }}"
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="text-center">
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
                                        <i class="fas fa-{{ $iconoActividad }} fa-3x text-pastel-blue mb-3"></i>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Tipo de Actividad</small>
                                            <strong class="text-dark">{{ $actividad->tipo_actividad }}</strong>
                                        </div>

                                        @if($actividad->fecha)
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-calendar-alt mr-1"></i>Fecha
                                            </small>
                                            <strong class="text-dark">{{ $actividad->fecha->format('d/m/Y') }}</strong>
                                        </div>
                                        @endif

                                        @if($actividad->duracion)
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-clock mr-1"></i>Duración
                                            </small>
                                            <strong class="text-dark">{{ $actividad->duracion }}</strong>
                                        </div>
                                        @endif

                                        @if($actividad->frecuencia)
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-sync-alt mr-1"></i>Frecuencia
                                            </small>
                                            <strong class="text-dark">{{ $actividad->frecuencia }}</strong>
                                        </div>
                                        @endif

                                        <div class="mt-3">
                                            <span class="badge badge-pastel-green">
                                                <i class="fas fa-check-circle mr-1"></i>Activa
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if($actividad->descripcion || $actividad->observaciones)
                                <div class="card-footer bg-transparent">
                                    <small class="text-muted">
                                        @if($actividad->descripcion)
                                        <i class="fas fa-file-alt mr-1"></i>Con descripción
                                        @endif
                                        @if($actividad->observaciones)
                                        <i class="fas fa-sticky-note mr-1 ml-2"></i>Con observaciones
                                        @endif
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-tasks fa-3x text-pastel-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">No hay actividades extras registradas</h5>
                    <p class="text-muted mb-4">Registre las actividades deportivas, recreativas o culturales del paciente.</p>
                    <a href="{{ route('admin.actividades_extras.create', $registro->id) }}" class="btn btn-pastel-blue btn-lg">
                        <i class="fas fa-plus mr-2"></i> Registrar Primera Actividad
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- J. RESULTADOS DE EXÁMENES GENERALES Y ESPECÍFICOS DE ACUERDO AL RIESGO Y PUESTO DE TRABAJO (IMAGEN, LABORATORIO Y OTROS) --}}
    <div class="card card-pastel-primary shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-blue text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-vials mr-2"></i>J. RESULTADOS DE EXÁMENES GENERALES Y ESPECÍFICOS DE ACUERDO AL RIESGO Y PUESTO DE TRABAJO (IMAGEN, LABORATORIO Y OTROS)
            </h5>
            <a href="{{ route('admin.resultados_examenes.create', $registro->id) }}" class="btn btn-pastel-green">
                <i class="fas fa-plus mr-2"></i> Agregar Nuevo Resultado
            </a>
        </div>

        <div class="card-body">
            @if ($registro->resultadosExamenes->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-vials fa-3x text-pastel-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">No hay resultados de exámenes registrados</h5>
                    <p class="text-muted mb-4">Comience registrando los primeros resultados de exámenes del paciente.</p>
                    <a href="{{ route('admin.resultados_examenes.create', $registro->id) }}" class="btn btn-pastel-blue btn-lg">
                        <i class="fas fa-plus mr-2"></i> Registrar Primer Resultado
                    </a>
                </div>
            @else
                <div class="row">
                    @foreach ($registro->resultadosExamenes as $resultado)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card card-pastel-info h-100">
                                <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center py-2">
                                    <h6 class="card-title mb-0 text-pastel-blue">
                                        <i class="fas fa-flask mr-1"></i>{{ Str::limit($resultado->nombre_examen, 25) }}
                                    </h6>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.resultados_examenes.show', [$registro->id, $resultado->id]) }}" 
                                        class="btn btn-pastel-blue btn-sm" title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.resultados_examenes.edit', [$registro->id, $resultado->id]) }}" 
                                        class="btn btn-pastel-purple btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-pastel-red btn-sm btn-delete-resultado" 
                                                data-resultado-id="{{ $resultado->id }}"
                                                data-resultado-nombre="{{ $resultado->nombre_examen }}"
                                                data-registro-id="{{ $registro->id }}"
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="text-center">
                                        @php
                                            $iconoExamen = match(true) {
                                                str_contains(strtolower($resultado->nombre_examen), 'sangre') => 'tint',
                                                str_contains(strtolower($resultado->nombre_examen), 'orina') => 'vial',
                                                str_contains(strtolower($resultado->nombre_examen), 'rayos') => 'x-ray',
                                                str_contains(strtolower($resultado->nombre_examen), 'eco') => 'wave-square',
                                                str_contains(strtolower($resultado->nombre_examen), 'tomografía') => 'lungs',
                                                str_contains(strtolower($resultado->nombre_examen), 'resonancia') => 'magnet',
                                                default => 'flask'
                                            };
                                        @endphp
                                        <i class="fas fa-{{ $iconoExamen }} fa-3x text-pastel-purple mb-3"></i>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Nombre del Examen</small>
                                            <strong class="text-dark">{{ $resultado->nombre_examen }}</strong>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-calendar-alt mr-1"></i>Fecha del Examen
                                            </small>
                                            <strong class="text-dark">{{ $resultado->fecha_examen->format('d/m/Y') }}</strong>
                                        </div>

                                        @if($resultado->tipo_examen)
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-tag mr-1"></i>Tipo de Examen
                                            </small>
                                            <strong class="text-dark">{{ $resultado->tipo_examen }}</strong>
                                        </div>
                                        @endif

                                        <div class="mb-3">
                                            <small class="text-muted d-block">Resultado</small>
                                            <div class="resultado-preview">
                                                <strong class="text-dark">{{ Str::limit($resultado->resultados, 80) }}</strong>
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            @php
                                                $estadoColor = 'pastel-muted';
                                                $estadoTexto = 'Registrado';
                                                $resultadoLower = strtolower($resultado->resultados);
                                                
                                                if (str_contains($resultadoLower, 'normal') || str_contains($resultadoLower, 'negativo') || str_contains($resultadoLower, 'dentro de parámetros')) {
                                                    $estadoColor = 'pastel-green';
                                                    $estadoTexto = 'Normal';
                                                } elseif (str_contains($resultadoLower, 'anormal') || str_contains($resultadoLower, 'positivo') || str_contains($resultadoLower, 'alterado')) {
                                                    $estadoColor = 'pastel-red';
                                                    $estadoTexto = 'Anormal';
                                                } elseif (str_contains($resultadoLower, 'pendiente') || str_contains($resultadoLower, 'en proceso')) {
                                                    $estadoColor = 'pastel-orange';
                                                    $estadoTexto = 'Pendiente';
                                                }
                                            @endphp
                                            <span class="badge badge-{{ $estadoColor }}">
                                                <i class="fas fa-{{ $estadoColor == 'pastel-green' ? 'check-circle' : ($estadoColor == 'pastel-red' ? 'exclamation-triangle' : 'info-circle') }} mr-1"></i>
                                                {{ $estadoTexto }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if($resultado->observaciones || $resultado->laboratorio)
                                <div class="card-footer bg-transparent">
                                    <small class="text-muted">
                                        @if($resultado->laboratorio)
                                        <i class="fas fa-hospital mr-1"></i>{{ Str::limit($resultado->laboratorio, 20) }}
                                        @endif
                                        @if($resultado->observaciones)
                                        <i class="fas fa-sticky-note mr-1 ml-2"></i>Con observaciones
                                        @endif
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- K. DIAGNÓSTICO --}}
    <div class="card card-pastel-success shadow-soft mb-4">
        <div class="card-header bg-gradient-pastel-green text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-notes-medical mr-2"></i>K. DIAGNÓSTICO PRE:PRESUNTIVO DEF: DEFINITIVO
            </h5>
            <a href="{{ route('admin.diagnosticos.create', $registro->id) }}" class="btn btn-pastel-green">
                <i class="fas fa-plus mr-2"></i> Agregar Nuevo Diagnóstico
            </a>
        </div>

        <div class="card-body">
            @if ($registro->diagnosticos->isEmpty())
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-notes-medical fa-3x text-pastel-muted"></i>
                    </div>
                    <h5 class="text-muted mb-3">No hay diagnósticos registrados</h5>
                    <p class="text-muted mb-4">Comience registrando los primeros diagnósticos del paciente.</p>
                    <a href="{{ route('admin.diagnosticos.create', $registro->id) }}" class="btn btn-pastel-green btn-lg">
                        <i class="fas fa-plus mr-2"></i> Registrar Primer Diagnóstico
                    </a>
                </div>
            @else
                <div class="row">
                    @foreach ($registro->diagnosticos as $diagnostico)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card 
                                @php
                                    echo match($diagnostico->tipo_diagnostico) {
                                        'principal' => 'card-pastel-red',
                                        'secundario' => 'card-pastel-orange',
                                        'diferencial' => 'card-pastel-info',
                                        default => 'card-pastel-primary'
                                    };
                                @endphp
                                h-100">
                                <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center py-2">
                                    <h6 class="card-title mb-0 
                                        @php
                                            echo match($diagnostico->tipo_diagnostico) {
                                                'principal' => 'text-pastel-red',
                                                'secundario' => 'text-pastel-orange',
                                                'diferencial' => 'text-pastel-blue',
                                                default => 'text-pastel-purple'
                                            };
                                        @endphp">
                                        <i class="fas 
                                            @php
                                                echo match($diagnostico->tipo_diagnostico) {
                                                    'principal' => 'fa-star',
                                                    'secundario' => 'fa-star-half-alt',
                                                    'diferencial' => 'fa-question-circle',
                                                    default => 'fa-stethoscope'
                                                };
                                            @endphp
                                            mr-1"></i>
                                        {{ Str::limit($diagnostico->descripcion, 25) }}
                                    </h6>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.diagnosticos.show', [$registro->id, $diagnostico->id]) }}" 
                                        class="btn btn-pastel-blue btn-sm" title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.diagnosticos.edit', [$registro->id, $diagnostico->id]) }}" 
                                        class="btn btn-pastel-purple btn-sm" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-pastel-red btn-sm btn-delete-diagnostico" 
                                                data-diagnostico-id="{{ $diagnostico->id }}"
                                                data-diagnostico-descripcion="{{ $diagnostico->descripcion }}"
                                                data-registro-id="{{ $registro->id }}"
                                                title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="text-center">
                                        @php
                                            $iconoColor = match($diagnostico->tipo_diagnostico) {
                                                'principal' => 'text-pastel-red',
                                                'secundario' => 'text-pastel-orange',
                                                'diferencial' => 'text-pastel-blue',
                                                default => 'text-pastel-purple'
                                            };
                                        @endphp
                                        <i class="fas 
                                            @php
                                                echo match($diagnostico->tipo_diagnostico) {
                                                    'principal' => 'fa-diagnoses',
                                                    'secundario' => 'fa-clipboard-list',
                                                    'diferencial' => 'fa-search',
                                                    default => 'fa-stethoscope'
                                                };
                                            @endphp
                                            fa-3x {{ $iconoColor }} mb-3"></i>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted d-block">Código CIE-10</small>
                                            <strong class="text-dark badge badge-pastel-muted font-monospace">{{ $diagnostico->cie10 }}</strong>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted d-block">Descripción</small>
                                            <strong class="text-dark diagnostico-descripcion">{{ Str::limit($diagnostico->descripcion, 80) }}</strong>
                                        </div>

                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-tag mr-1"></i>Tipo de Diagnóstico
                                            </small>
                                            @php
                                                $badgeColor = match($diagnostico->tipo_diagnostico) {
                                                    'principal' => 'pastel-red',
                                                    'secundario' => 'pastel-orange',
                                                    'diferencial' => 'pastel-blue',
                                                    default => 'pastel-purple'
                                                };
                                            @endphp
                                            <span class="badge badge-{{ $badgeColor }} text-capitalize">
                                                {{ $diagnostico->tipo_diagnostico }}
                                            </span>
                                        </div>

                                        @if($diagnostico->fecha_diagnostico)
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-calendar-alt mr-1"></i>Fecha
                                            </small>
                                            <strong class="text-dark">{{ $diagnostico->fecha_diagnostico->format('d/m/Y') }}</strong>
                                        </div>
                                        @endif

                                        <div class="mt-3">
                                            @php
                                                $estadoColor = 'pastel-green';
                                                $estadoTexto = 'Activo';
                                                $estadoIcono = 'check-circle';
                                                
                                                if ($diagnostico->estado === 'confirmado') {
                                                    $estadoColor = 'pastel-green';
                                                    $estadoTexto = 'Confirmado';
                                                    $estadoIcono = 'check-double';
                                                } elseif ($diagnostico->estado === 'sospecha') {
                                                    $estadoColor = 'pastel-orange';
                                                    $estadoTexto = 'Sospecha';
                                                    $estadoIcono = 'question-circle';
                                                } elseif ($diagnostico->estado === 'descartado') {
                                                    $estadoColor = 'pastel-muted';
                                                    $estadoTexto = 'Descartado';
                                                    $estadoIcono = 'times-circle';
                                                }
                                            @endphp
                                            <span class="badge badge-{{ $estadoColor }}">
                                                <i class="fas fa-{{ $estadoIcono }} mr-1"></i>
                                                {{ $estadoTexto }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                @if($diagnostico->observaciones || $diagnostico->tratamiento_asociado)
                                <div class="card-footer bg-transparent">
                                    <small class="text-muted">
                                        @if($diagnostico->tratamiento_asociado)
                                        <i class="fas fa-pills mr-1"></i>Con tratamiento
                                        @endif
                                        @if($diagnostico->observaciones)
                                        <i class="fas fa-sticky-note mr-1 ml-2"></i>Con observaciones
                                        @endif
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- L. APTITUD MÉDICA PARA EL TRABAJO --}}
    <div class="card card-pastel-info mb-4">
        <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0 text-pastel-blue">
                <i class="fas fa-user-md mr-1"></i>L. APTITUD MÉDICA PARA EL TRABAJO
            </h6>
            <div>
                <a href="{{ route('admin.aptitudes_medicas.create', $registro->id) }}" class="btn btn-pastel-green btn-sm">
                    <i class="fas fa-plus mr-1"></i>{{ $registro->aptitudesMedicas->count() ? 'Agregar' : 'Crear' }}
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($registro->aptitudesMedicas->count())
                @foreach($registro->aptitudesMedicas as $aptitud)
                    <div class="mb-4 p-3 border rounded bg-pastel-light">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-pastel-purple mb-0">
                                Aptitud: 
                                @if($aptitud->aptitud == 'apto') 
                                    <span class="text-pastel-green">Apto</span>
                                @elseif($aptitud->aptitud == 'apto_observacion') 
                                    <span class="text-pastel-orange">Apto con Observación</span>
                                @elseif($aptitud->aptitud == 'apto_limitaciones') 
                                    <span class="text-pastel-orange">Apto con Limitaciones</span>
                                @else 
                                    <span class="text-pastel-red">No Apto</span> 
                                @endif
                            </h6>
                            <div class="btn-group">
                                <a href="{{ route('admin.aptitudes_medicas.edit', [$registro->id, $aptitud->id]) }}" 
                                class="btn btn-pastel-purple btn-sm me-1">
                                    <i class="fas fa-edit mr-1"></i>Editar
                                </a>
                                <button type="button" class="btn btn-pastel-red btn-sm btn-delete-aptitud" 
                                        data-aptitud-id="{{ $aptitud->id }}"
                                        data-aptitud-tipo="{{ $aptitud->aptitud }}"
                                        data-registro-id="{{ $registro->id }}">
                                    <i class="fas fa-trash-alt mr-1"></i>Eliminar
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            @php
                                $datosAptitud = [
                                    [
                                        'icon' => 'calendar-alt', 
                                        'label' => 'Fecha de Registro', 
                                        'value' => $aptitud->created_at->format('d/m/Y H:i')
                                    ],
                                ];

                                if($aptitud->observaciones) {
                                    $datosAptitud[] = [
                                        'icon' => 'eye', 
                                        'label' => 'Observaciones', 
                                        'value' => $aptitud->observaciones
                                    ];
                                }

                                if($aptitud->recomendaciones_tratamiento) {
                                    $datosAptitud[] = [
                                        'icon' => 'stethoscope', 
                                        'label' => 'Recomendaciones / Tratamiento', 
                                        'value' => $aptitud->recomendaciones_tratamiento
                                    ];
                                }

                                $datosAptitud[] = [
                                    'icon' => 'history', 
                                    'label' => 'Última Actualización', 
                                    'value' => $aptitud->updated_at->format('d/m/Y H:i')
                                ];
                            @endphp

                            @foreach($datosAptitud as $item)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-{{ $item['icon'] }} text-pastel-blue mr-2 mt-1"></i>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">{{ $item['label'] }}</small>
                                            <strong class="text-dark">{{ $item['value'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-4">
                    <i class="fas fa-user-md fa-2x text-pastel-muted mb-3"></i>
                    <p class="text-muted">No hay aptitudes médicas registradas.</p>
                    <a href="{{ route('admin.aptitudes_medicas.create', $registro->id) }}" class="btn btn-pastel-green mt-2">
                        <i class="fas fa-plus mr-1"></i> Registrar Primera Aptitud
                    </a>
                </div>
            @endif
        </div>
    </div>

    {{-- N. RETIRO (evaluación) --}}
    <div class="card card-pastel-muted mb-4">
        <div class="card-header bg-pastel-light d-flex justify-content-between align-items-center">
            <h6 class="card-title mb-0 text-pastel-muted">
                <i class="fas fa-clipboard-check mr-1"></i>N.RETIRO (evaluación) 
            </h6>
            <div>
                <a href="{{ route('admin.retiros_evaluaciones.create', $registro->id) }}" class="btn btn-pastel-green btn-sm">
                    <i class="fas fa-plus mr-1"></i>{{ $registro->retirosEvaluaciones->count() ? 'Agregar' : 'Crear' }}
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($registro->retirosEvaluaciones->count())
                @foreach($registro->retirosEvaluaciones as $evaluacion)
                    <div class="mb-4 p-3 border rounded bg-pastel-light">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-pastel-purple mb-0">
                                Evaluación: 
                                @if($evaluacion->se_realiza_evaluacion)
                                    <span class="text-pastel-green">Realizada</span>
                                @else
                                    <span class="text-pastel-red">No realizada</span>
                                @endif
                            </h6>
                            <div class="btn-group">
                                <a href="{{ route('admin.retiros_evaluaciones.edit', [$registro->id, $evaluacion->id]) }}" 
                                class="btn btn-pastel-purple btn-sm me-1">
                                    <i class="fas fa-edit mr-1"></i>Editar
                                </a>
                                <button type="button" class="btn btn-pastel-red btn-sm btn-delete-evaluacion" 
                                        data-evaluacion-id="{{ $evaluacion->id }}"
                                        data-evaluacion-estado="{{ $evaluacion->se_realiza_evaluacion ? 'realizada' : 'no_realizada' }}"
                                        data-registro-id="{{ $registro->id }}">
                                    <i class="fas fa-trash-alt mr-1"></i>Eliminar
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            @php
                                $datosEvaluacion = [
                                    [
                                        'icon' => 'clipboard-check', 
                                        'label' => 'Estado de Evaluación', 
                                        'value' => $evaluacion->se_realiza_evaluacion ? 'Realizada' : 'No realizada',
                                        'color' => $evaluacion->se_realiza_evaluacion ? 'text-pastel-green' : 'text-pastel-red'
                                    ],
                                    [
                                        'icon' => 'stethoscope', 
                                        'label' => 'Condición salud relacionada', 
                                        'value' => $evaluacion->condicion_salud_relacionada ? 'Sí' : 'No',
                                        'color' => $evaluacion->condicion_salud_relacionada ? 'text-pastel-orange' : 'text-pastel-green'
                                    ],
                                    [
                                        'icon' => 'calendar-alt', 
                                        'label' => 'Fecha de Registro', 
                                        'value' => $evaluacion->created_at->format('d/m/Y H:i'),
                                        'color' => 'text-dark'
                                    ],
                                ];

                                if($evaluacion->observaciones) {
                                    $datosEvaluacion[] = [
                                        'icon' => 'eye', 
                                        'label' => 'Observaciones', 
                                        'value' => $evaluacion->observaciones,
                                        'color' => 'text-dark'
                                    ];
                                }

                                $datosEvaluacion[] = [
                                    'icon' => 'history', 
                                    'label' => 'Última Actualización', 
                                    'value' => $evaluacion->updated_at->format('d/m/Y H:i'),
                                    'color' => 'text-dark'
                                ];
                            @endphp

                            @foreach($datosEvaluacion as $item)
                                <div class="col-md-6 mb-3">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-{{ $item['icon'] }} text-pastel-muted mr-2 mt-1"></i>
                                        <div class="flex-grow-1">
                                            <small class="text-muted d-block">{{ $item['label'] }}</small>
                                            <strong class="{{ $item['color'] }}">{{ $item['value'] }}</strong>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($evaluacion->observaciones && strlen($evaluacion->observaciones) > 100)
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="alert alert-pastel-info py-2">
                                    <strong><i class="fas fa-info-circle mr-1"></i>Observaciones completas:</strong>
                                    <p class="mb-0 small">{{ $evaluacion->observaciones }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                @endforeach
            @else
                <div class="text-center py-4">
                    <i class="fas fa-clipboard-check fa-2x text-pastel-muted mb-3"></i>
                    <p class="text-muted">No hay evaluaciones médicas registradas.</p>
                    <a href="{{ route('admin.retiros_evaluaciones.create', $registro->id) }}" class="btn btn-pastel-green mt-2">
                        <i class="fas fa-plus mr-1"></i> Registrar Primera Evaluación
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Formularios de eliminación ocultos -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@stop

@section('css')
<style>
    /* Paleta de Colores Pasteles */
    :root {
        --pastel-blue: #A8D8EA;
        --pastel-blue-dark: #97c9db;
        --pastel-green: #B6E2D3;
        --pastel-green-dark: #a5d1c2;
        --pastel-orange: #FFD3B6;
        --pastel-orange-dark: #e6bea4;
        --pastel-purple: #CAB8FF;
        --pastel-purple-dark: #b9a6e6;
        --pastel-pink: #F8C8DC;
        --pastel-red: #FFB7B7;
        --pastel-red-dark: #e6a5a5;
        --pastel-yellow: #FCE38A;
        --pastel-light: #F9F7F7;
        --pastel-muted: #D6D6D6;
        --pastel-secondary: #E3E3E3;
    }

    /* Gradientes Pasteles */
    .bg-gradient-pastel-blue {
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-blue-dark)) !important;
    }
    
    .bg-gradient-pastel-green {
        background: linear-gradient(135deg, var(--pastel-green), var(--pastel-green-dark)) !important;
    }
    
    .bg-gradient-pastel-orange {
        background: linear-gradient(135deg, var(--pastel-orange), var(--pastel-orange-dark)) !important;
    }
    
    .bg-gradient-pastel-purple {
        background: linear-gradient(135deg, var(--pastel-purple), var(--pastel-purple-dark)) !important;
    }
    
    .bg-gradient-pastel-muted {
        background: linear-gradient(135deg, var(--pastel-muted), #c9c9c9) !important;
    }

    /* Colores de texto */
    .text-pastel-blue { color: var(--pastel-blue) !important; }
    .text-pastel-green { color: var(--pastel-green) !important; }
    .text-pastel-orange { color: var(--pastel-orange) !important; }
    .text-pastel-purple { color: var(--pastel-purple) !important; }
    .text-pastel-pink { color: var(--pastel-pink) !important; }
    .text-pastel-red { color: var(--pastel-red) !important; }
    .text-pastel-yellow { color: var(--pastel-yellow) !important; }
    .text-pastel-muted { color: var(--pastel-muted) !important; }

    /* Fondos */
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-green { background-color: var(--pastel-green) !important; }
    .bg-pastel-orange { background-color: var(--pastel-orange) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    .bg-pastel-pink { background-color: var(--pastel-pink) !important; }
    .bg-pastel-red { background-color: var(--pastel-red) !important; }
    .bg-pastel-yellow { background-color: var(--pastel-yellow) !important; }
    .bg-pastel-light { background-color: var(--pastel-light) !important; }
    .bg-pastel-muted { background-color: var(--pastel-muted) !important; }
    .bg-pastel-secondary { background-color: var(--pastel-secondary) !important; }

    /* Botones Pastel */
    .btn-pastel-primary {
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-blue-dark));
        border: none;
        color: white !important;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-pastel-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(168, 216, 234, 0.4);
        color: white !important;
    }

    .btn-pastel-success, .btn-pastel-green {
        background: linear-gradient(135deg, var(--pastel-green), var(--pastel-green-dark));
        border: none;
        color: white !important;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-pastel-success:hover, .btn-pastel-green:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(182, 226, 211, 0.4);
    }

    .btn-pastel-info, .btn-pastel-blue {
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-blue-dark));
        border: none;
        color: white !important;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-pastel-warning, .btn-pastel-orange {
        background: linear-gradient(135deg, var(--pastel-orange), var(--pastel-orange-dark));
        border: none;
        color: white !important;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-pastel-danger, .btn-pastel-red {
        background: linear-gradient(135deg, var(--pastel-red), var(--pastel-red-dark));
        border: none;
        color: white !important;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-pastel-purple {
        background: linear-gradient(135deg, var(--pastel-purple), var(--pastel-purple-dark));
        border: none;
        color: white !important;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .btn-pastel-light {
        background-color: var(--pastel-light);
        border: 1px solid #e0e0e0;
        color: #666 !important;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-pastel-light:hover {
        background-color: #f0f0f0;
        transform: translateY(-2px);
    }

    /* Badges Pastel */
    .badge-pastel-blue { 
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-blue-dark));
        color: white !important;
    }
    
    .badge-pastel-green { 
        background: linear-gradient(135deg, var(--pastel-green), var(--pastel-green-dark));
        color: white !important;
    }
    
    .badge-pastel-orange { 
        background: linear-gradient(135deg, var(--pastel-orange), var(--pastel-orange-dark));
        color: white !important;
    }
    
    .badge-pastel-purple { 
        background: linear-gradient(135deg, var(--pastel-purple), var(--pastel-purple-dark));
        color: white !important;
    }
    
    .badge-pastel-red { 
        background: linear-gradient(135deg, var(--pastel-red), var(--pastel-red-dark));
        color: white !important;
    }
    
    .badge-pastel-light { 
        background-color: var(--pastel-light);
        color: #666 !important;
        border: 1px solid #e0e0e0;
    }
    
    .badge-pastel-muted { 
        background-color: var(--pastel-muted);
        color: #666 !important;
    }

    /* Cards Pastel */
    .card-pastel-primary {
        border: none;
        border-radius: 12px;
        border-top: 4px solid var(--pastel-blue);
    }
    
    .card-pastel-success {
        border: none;
        border-radius: 12px;
        border-top: 4px solid var(--pastel-green);
    }
    
    .card-pastel-warning {
        border: none;
        border-radius: 12px;
        border-top: 4px solid var(--pastel-orange);
    }
    
    .card-pastel-info {
        border: none;
        border-radius: 12px;
        border-top: 4px solid var(--pastel-blue);
    }
    
    .card-pastel-danger {
        border: none;
        border-radius: 12px;
        border-top: 4px solid var(--pastel-red);
    }
    
    .card-pastel-muted {
        border: none;
        border-radius: 12px;
        border-top: 4px solid var(--pastel-muted);
    }

    .shadow-soft {
        box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
    }

    /* Alertas Pastel */
    .alert-pastel-info {
        background-color: var(--pastel-blue);
        border-color: var(--pastel-blue-dark);
        color: #1565C0;
    }
    
    .alert-pastel-success {
        background-color: var(--pastel-green);
        border-color: var(--pastel-green-dark);
        color: #2E7D32;
    }
    
    .alert-pastel-warning {
        background-color: var(--pastel-orange);
        border-color: var(--pastel-orange-dark);
        color: #EF6C00;
    }
    
    .alert-pastel-danger {
        background-color: var(--pastel-red);
        border-color: var(--pastel-red-dark);
        color: #C62828;
    }
    
    .alert-pastel-light {
        background-color: var(--pastel-light);
        border-color: #e0e0e0;
        color: #666;
    }
    
    .alert-pastel-muted {
        background-color: var(--pastel-muted);
        border-color: #c9c9c9;
        color: #666;
    }

    /* Tablas Pastel */
    .table-pastel-blue thead {
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-blue-dark)) !important;
        color: white;
    }
    
    .table-pastel-green thead {
        background: linear-gradient(135deg, var(--pastel-green), var(--pastel-green-dark)) !important;
        color: white;
    }
    
    .table-pastel-orange thead {
        background: linear-gradient(135deg, var(--pastel-orange), var(--pastel-orange-dark)) !important;
        color: white;
    }
    
    .table-pastel-purple thead {
        background: linear-gradient(135deg, var(--pastel-purple), var(--pastel-purple-dark)) !important;
        color: white;
    }
    
    .table-pastel-red thead {
        background: linear-gradient(135deg, var(--pastel-red), var(--pastel-red-dark)) !important;
        color: white;
    }

    /* Efectos hover */
    .btn, .card {
        transition: all 0.3s ease;
    }
    
    .btn:hover, .card:hover {
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .btn-group {
            flex-direction: column;
        }
        
        .btn-group .btn {
            margin-bottom: 2px;
            border-radius: 6px !important;
        }
    }
    .btn-pastel-gray {
    background: linear-gradient(135deg, #E3E3E3, #D6D6D6);
    border: none;
    color: #666 !important;
    border-radius: 8px;
    font-weight: 600;
    padding: 8px 16px;
    transition: all 0.3s ease;
}

.btn-pastel-gray:hover {
    background: linear-gradient(135deg, #D6D6D6, #C9C9C9);
    transform: translateY(-2px);
    color: #666 !important;
    text-decoration: none;
}

.btn-pastel-secondary {
    background: linear-gradient(135deg, var(--pastel-secondary), #d6d6d6);
    border: none;
    color: #666 !important;
    border-radius: 6px;
    transition: all 0.3s ease;
}
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteForm = document.getElementById('deleteForm');
    
    // Función general para eliminar - CORREGIDA
    function confirmDelete(itemType, itemId, itemName, registroId, deleteUrl = null) {
        let url = deleteUrl;
        
        if (!url) {
            // Construir URL basada en el tipo de elemento - URLs CORREGIDAS
            switch(itemType) {
                case 'puesto':
                    url = `/admin/registros/${registroId}/puestos/${itemId}`;
                    break;
                case 'centro':
                    url = `/admin/registros/${registroId}/centros_trabajos/${itemId}`;
                    break;
                case 'actividad':
                    url = `/admin/registros/${registroId}/actividades_extras/${itemId}`;
                    break;
                case 'resultado':
                    url = `/admin/registros/${registroId}/resultados-examenes/${itemId}`; // CORREGIDO: con guión
                    break;
                case 'diagnostico':
                    url = `/admin/registros/${registroId}/diagnosticos/${itemId}`;
                    break;
                case 'aptitud':
                    url = `/admin/registros/${registroId}/aptitudes_medicas/${itemId}`;
                    break;
                case 'evaluacion':
                    url = `/admin/registros/${registroId}/retiros_evaluaciones/${itemId}`;
                    break;
                default:
                    console.error('Tipo de elemento no reconocido:', itemType);
                    return;
            }
        }

        console.log('URL de eliminación:', url); // Para debug

        Swal.fire({
            title: `¿Eliminar ${itemType}?`,
            html: `Está a punto de eliminar:<br><strong>"${itemName}"</strong><br><small class="text-muted">Esta acción no se puede deshacer.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FFB7B7',
            cancelButtonColor: '#A8D8EA',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#F9F7F7'
        }).then((result) => {
            if (result.isConfirmed) {
                // Configurar y enviar el formulario
                deleteForm.action = url;
                console.log('Enviando formulario a:', deleteForm.action); // Para debug
                deleteForm.submit();
            }
        });
    }

    // Configurar eventos para todos los botones de eliminar
    document.querySelectorAll('.btn-delete-puesto').forEach(button => {
        button.addEventListener('click', function() {
            const puestoId = this.getAttribute('data-puesto-id');
            const puestoNombre = this.getAttribute('data-puesto-nombre');
            const registroId = this.getAttribute('data-registro-id');
            confirmDelete('puesto', puestoId, puestoNombre, registroId);
        });
    });

    document.querySelectorAll('.btn-delete-centro').forEach(button => {
        button.addEventListener('click', function() {
            const centroId = this.getAttribute('data-centro-id');
            const centroNombre = this.getAttribute('data-centro-nombre');
            const registroId = this.getAttribute('data-registro-id');
            confirmDelete('centro', centroId, centroNombre, registroId);
        });
    });

    document.querySelectorAll('.btn-delete-actividad').forEach(button => {
        button.addEventListener('click', function() {
            const actividadId = this.getAttribute('data-actividad-id');
            const actividadTipo = this.getAttribute('data-actividad-tipo');
            const registroId = this.getAttribute('data-registro-id');
            confirmDelete('actividad', actividadId, `Actividad ${actividadTipo}`, registroId);
        });
    });

    document.querySelectorAll('.btn-delete-resultado').forEach(button => {
        button.addEventListener('click', function() {
            const resultadoId = this.getAttribute('data-resultado-id');
            const resultadoNombre = this.getAttribute('data-resultado-nombre');
            const registroId = this.getAttribute('data-registro-id');
            confirmDelete('resultado', resultadoId, resultadoNombre, registroId);
        });
    });

    document.querySelectorAll('.btn-delete-diagnostico').forEach(button => {
        button.addEventListener('click', function() {
            const diagnosticoId = this.getAttribute('data-diagnostico-id');
            const diagnosticoDescripcion = this.getAttribute('data-diagnostico-descripcion');
            const registroId = this.getAttribute('data-registro-id');
            confirmDelete('diagnostico', diagnosticoId, diagnosticoDescripcion, registroId);
        });
    });

    document.querySelectorAll('.btn-delete-aptitud').forEach(button => {
        button.addEventListener('click', function() {
            const aptitudId = this.getAttribute('data-aptitud-id');
            const aptitudTipo = this.getAttribute('data-aptitud-tipo');
            const registroId = this.getAttribute('data-registro-id');
            confirmDelete('aptitud', aptitudId, `Aptitud ${aptitudTipo}`, registroId);
        });
    });

    document.querySelectorAll('.btn-delete-evaluacion').forEach(button => {
        button.addEventListener('click', function() {
            const evaluacionId = this.getAttribute('data-evaluacion-id');
            const evaluacionEstado = this.getAttribute('data-evaluacion-estado');
            const registroId = this.getAttribute('data-registro-id');
            confirmDelete('evaluacion', evaluacionId, `Evaluación ${evaluacionEstado}`, registroId);
        });
    });

    // Tooltips
    $('[title]').tooltip();

    // Efectos hover suaves
    $('.btn, .card').hover(
        function() {
            $(this).css('transform', 'translateY(-2px)');
        },
        function() {
            $(this).css('transform', 'translateY(0)');
        }
    );
});

function goBack() {
    const previousUrl = "{{ url()->previous() }}";
    const currentUrl = "{{ url()->current() }}";
    const defaultUrl = "{{ route('admin.pacientes.vistaIndividual', $registro->paciente_id) }}";
    
    // Si la página anterior es la misma que la actual, ir a la URL por defecto
    if (previousUrl === currentUrl || previousUrl === "{{ url('/') }}") {
        window.location.href = defaultUrl;
    } else {
        window.location.href = previousUrl;
    }
}

// SweetAlert para mensajes de sesión
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        position: 'top-end',
        toast: true,
        background: '#B6E2D3',
        iconColor: '#2e7d32'
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        timer: 4000,
        showConfirmButton: true,
        background: '#FFB7B7',
        iconColor: '#c62828'
    });
@endif
</script>
@stop