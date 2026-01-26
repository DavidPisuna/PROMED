@extends('adminlte::page')

@section('title', 'Editar Constantes Vitales')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-primary"><i class="fas fa-edit mr-2"></i> Editar Constantes Vitales</h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    {{-- 🔹 CARD con información del paciente y registro --}}
    <div class="card card-info shadow-sm mb-4">
        <div class="card-header bg-info">
            <h3 class="card-title">
                <i class="fas fa-user mr-2"></i>
                <strong>Información General del Registro</strong>
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box bg-light">
                        <span class="info-box-icon bg-primary"><i class="fas fa-user-injured"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Paciente</span>
                            <span class="info-box-number">
                                {{ $registro->paciente->primer_nombre }} {{ $registro->paciente->primer_apellido }}
                            </span>
                        </div>
                    </div>
                    <p class="ml-4"><strong>Cédula:</strong> {{ $registro->paciente->cedula_identidad ?? '—' }}</p>
                </div>
                <div class="col-md-4">
                    <div class="info-box bg-light">
                        <span class="info-box-icon bg-success"><i class="fas fa-file-medical"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Tipo de Registro</span>
                            <span class="info-box-number">
                                <span class="badge badge-primary text-uppercase">{{ $registro->tipo }}</span>
                            </span>
                        </div>
                    </div>
                    <p class="ml-4"><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-4">
                    <div class="info-box bg-light">
                        <span class="info-box-icon bg-warning"><i class="fas fa-user-md"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Doctor</span>
                            <span class="info-box-number">
                                {{ $registro->doctor->primer_nombre ?? '—' }} {{ $registro->doctor->primer_apellido ?? '' }}
                            </span>
                        </div>
                    </div>
                    <p class="ml-4"><strong>Especialidad:</strong> {{ $registro->doctor->especialidad ?? '—' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-warning shadow-sm">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                <strong>Editando Constantes Vitales</strong>
            </h3>
            <div class="card-tools">
                <span class="badge badge-warning">Editando</span>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.constantes_vitales.update', $constanteVital) }}" method="POST" id="constantesForm">
                @csrf
                @method('PUT')

                {{-- SECCIÓN: SIGNOS VITALES --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline card-primary mb-4">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-heart mr-2"></i>
                                    Signos Vitales
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @php
                                        $signosVitales = [
                                            'temperatura' => [
                                                'icon' => 'thermometer',
                                                'label' => 'Temperatura',
                                                'unidad' => '°C',
                                                'color' => 'info',
                                                'placeholder' => '36.5'
                                            ],
                                            'presion_arterial' => [
                                                'icon' => 'tachometer-alt',
                                                'label' => 'Presión Arterial',
                                                'unidad' => 'mmHg',
                                                'color' => 'danger',
                                                'placeholder' => '120/80'
                                            ],
                                            'frecuencia_cardiaca' => [
                                                'icon' => 'heartbeat',
                                                'label' => 'Frecuencia Cardíaca',
                                                'unidad' => 'lpm',
                                                'color' => 'success',
                                                'placeholder' => '72'
                                            ],
                                            'frecuencia_respiratoria' => [
                                                'icon' => 'wind',
                                                'label' => 'Frecuencia Respiratoria',
                                                'unidad' => 'rpm',
                                                'color' => 'primary',
                                                'placeholder' => '16'
                                            ],
                                            'saturacion_oxigeno' => [
                                                'icon' => 'lungs',
                                                'label' => 'Saturación de Oxígeno',
                                                'unidad' => '%',
                                                'color' => 'warning',
                                                'placeholder' => '98'
                                            ]
                                        ];
                                    @endphp

                                    @foreach($signosVitales as $campo => $config)
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-{{ $config['icon'] }} text-{{ $config['color'] }} mr-1"></i>
                                                {{ $config['label'] }}
                                            </label>
                                            <div class="input-group">
                                                <input type="{{ $campo == 'presion_arterial' ? 'text' : 'number' }}" 
                                                       step="{{ $campo == 'temperatura' ? '0.1' : '1' }}" 
                                                       name="{{ $campo }}" 
                                                       class="form-control" 
                                                       value="{{ old($campo, $constanteVital->$campo) }}" 
                                                       placeholder="{{ $config['placeholder'] }}"
                                                       min="{{ in_array($campo, ['saturacion_oxigeno']) ? '0' : '' }}"
                                                       max="{{ in_array($campo, ['saturacion_oxigeno']) ? '100' : '' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text bg-{{ $config['color'] }} text-white">
                                                        {{ $config['unidad'] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <small class="form-text text-muted">
                                                @switch($campo)
                                                    @case('temperatura')
                                                        Rango normal: 36.1°C - 37.2°C
                                                        @break
                                                    @case('presion_arterial')
                                                        Rango normal: 120/80 mmHg
                                                        @break
                                                    @case('frecuencia_cardiaca')
                                                        Rango normal: 60-100 lpm
                                                        @break
                                                    @case('frecuencia_respiratoria')
                                                        Rango normal: 12-20 rpm
                                                        @break
                                                    @case('saturacion_oxigeno')
                                                        Rango normal: 95-100%
                                                        @break
                                                @endswitch
                                            </small>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: ANTROPOMETRÍA --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card card-outline card-success">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-weight mr-2"></i>
                                    Antropometría
                                </h3>
                                <button type="button" class="btn btn-success btn-sm" id="btnCalcularIMC">
                                    <i class="fas fa-calculator mr-1"></i> Calcular IMC
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    {{-- PESO Y TALLA --}}
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        <i class="fas fa-weight text-success mr-1"></i>
                                                        Peso (kg)
                                                    </label>
                                                    <input type="number" step="0.1" name="peso" id="pesoInput" 
                                                           class="form-control" value="{{ old('peso', $constanteVital->peso) }}" 
                                                           placeholder="Ej: 70.5" min="0" max="300">
                                                    <small class="form-text text-muted">
                                                        Peso corporal en kilogramos
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        <i class="fas fa-ruler-vertical text-info mr-1"></i>
                                                        Talla (cm)
                                                    </label>
                                                    <input type="number" step="0.1" name="talla" id="tallaInput" 
                                                           class="form-control" value="{{ old('talla', $constanteVital->talla) }}" 
                                                           placeholder="Ej: 175" min="0" max="250">
                                                    <small class="form-text text-muted">
                                                        Estatura en centímetros
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- IMC Y CATEGORÍA --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-calculator text-primary mr-1"></i>
                                                IMC (kg/m²)
                                            </label>
                                            <input type="number" step="0.1" name="imc" id="imcInput" 
                                                   class="form-control" value="{{ old('imc', $constanteVital->imc) }}" readonly>
                                            <div class="mt-2">
                                                <span class="badge {{ $constanteVital->categoria_imc ? 'badge-success' : 'badge-secondary' }}" id="imcBadge">
                                                    {{ old('categoria_imc', $constanteVital->categoria_imc) ?: '-' }}
                                                </span>
                                                <small class="form-text" id="imcText">
                                                    {{ $constanteVital->imc ? 'Valor actual del IMC' : 'Ingrese peso y talla para calcular' }}
                                                </small>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-chart-bar text-warning mr-1"></i>
                                                Categoría IMC
                                            </label>
                                            <input type="text" name="categoria_imc" id="categoriaImcInput" 
                                                   class="form-control" value="{{ old('categoria_imc', $constanteVital->categoria_imc) }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                {{-- PERÍMETRO ABDOMINAL --}}
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="fas fa-ruler text-danger mr-1"></i>
                                                Perímetro Abdominal (cm)
                                            </label>
                                            <input type="number" step="0.1" name="perimetro_abdominal" 
                                                   class="form-control" value="{{ old('perimetro_abdominal', $constanteVital->perimetro_abdominal) }}" 
                                                   placeholder="Ej: 85.5" min="0" max="200">
                                            <small class="form-text text-muted">
                                                Medida del perímetro abdominal en centímetros
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: EVALUACIÓN CLÍNICA --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-file-medical mr-2"></i>
                                    Evaluación Clínica
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-stethoscope text-info mr-1"></i>
                                        Enfermedad o Problema Actual
                                    </label>
                                    <textarea name="enfermedad_actual" class="form-control" rows="4" 
                                              placeholder="Describa la enfermedad o problema de salud actual del paciente">{{ old('enfermedad_actual', $constanteVital->enfermedad_actual) }}</textarea>
                                    <small class="form-text text-muted">
                                        Incluya síntomas, tiempo de evolución y características relevantes
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BOTONES DE ACCIÓN --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-footer bg-white d-flex justify-content-between">
                            <div>
                                <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-default">
                                    <i class="fas fa-times mr-1"></i> Cancelar
                                </a>
                            </div>
                            <div>
                                <button type="button" class="btn btn-outline-info mr-2" id="btnCalcularIMC">
                                    <i class="fas fa-calculator mr-1"></i> Recalcular IMC
                                </button>
                                <button type="submit" class="btn btn-warning" id="btnActualizar">
                                    <i class="fas fa-save mr-1"></i> Actualizar Constantes Vitales
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .info-box {
        border-radius: 8px;
        margin-bottom: 10px;
    }
    
    .card-outline {
        border-top: 3px solid;
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 5px;
    }
    
    .input-group-text {
        font-weight: 600;
    }
    
    #imcBadge {
        font-size: 0.9em;
        padding: 0.4em 0.8em;
    }
    
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }
    
    .btn-warning:hover {
        background-color: #e0a800;
        border-color: #d39e00;
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Elementos del DOM
        const pesoInput = $('#pesoInput');
        const tallaInput = $('#tallaInput');
        const imcInput = $('#imcInput');
        const categoriaImcInput = $('#categoriaImcInput');
        const imcBadge = $('#imcBadge');
        const imcText = $('#imcText');

        // Función para calcular IMC
        function calcularIMC() {
            const pesoVal = parseFloat(pesoInput.val());
            const tallaVal = parseFloat(tallaInput.val()) / 100; // Convertir cm a m
            
            if (pesoVal && tallaVal && tallaVal > 0) {
                const valorIMC = pesoVal / (tallaVal * tallaVal);
                imcInput.val(valorIMC.toFixed(1));
                
                // Determinar categoría
                let categoria = '';
                let badgeClass = '';
                let texto = '';
                
                if (valorIMC < 18.5) {
                    categoria = 'Bajo peso';
                    badgeClass = 'badge badge-warning';
                    texto = 'Peso inferior al normal';
                } else if (valorIMC < 25) {
                    categoria = 'Peso normal';
                    badgeClass = 'badge badge-success';
                    texto = 'Peso saludable';
                } else if (valorIMC < 30) {
                    categoria = 'Sobrepeso';
                    badgeClass = 'badge badge-warning';
                    texto = 'Exceso de peso';
                } else if (valorIMC < 35) {
                    categoria = 'Obesidad Grado I';
                    badgeClass = 'badge badge-danger';
                    texto = 'Obesidad moderada';
                } else if (valorIMC < 40) {
                    categoria = 'Obesidad Grado II';
                    badgeClass = 'badge badge-danger';
                    texto = 'Obesidad severa';
                } else {
                    categoria = 'Obesidad Grado III';
                    badgeClass = 'badge badge-dark';
                    texto = 'Obesidad mórbida';
                }
                
                categoriaImcInput.val(categoria);
                imcBadge.removeClass().addClass(badgeClass).text(categoria);
                imcText.text(texto);
                
            } else {
                imcInput.val('');
                categoriaImcInput.val('');
                imcBadge.removeClass().addClass('badge badge-secondary').text('-');
                imcText.text('Ingrese peso y talla para calcular');
            }
        }

        // Event listeners
        pesoInput.on('input', calcularIMC);
        tallaInput.on('input', calcularIMC);
        
        $('#btnCalcularIMC').click(function() {
            calcularIMC();
            if (!pesoInput.val() || !tallaInput.val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Datos incompletos',
                    text: 'Por favor ingrese tanto el peso como la talla',
                    confirmButtonText: 'Entendido'
                });
            } else {
                Swal.fire({
                    icon: 'success',
                    title: 'IMC Calculado',
                    text: 'El Índice de Masa Corporal ha sido recalculado',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });

        // Calcular IMC al cargar si hay datos
        if (pesoInput.val() && tallaInput.val()) {
            calcularIMC();
        }

        // Validación del formulario
        $('#constantesForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Actualizar constantes vitales?',
                html: `Se actualizarán las constantes vitales del paciente<br>
                      <small class="text-muted">Paciente: {{ $registro->paciente->primer_nombre }} {{ $registro->paciente->primer_apellido }}</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return new Promise((resolve) => {
                        setTimeout(() => {
                            resolve();
                        }, 1000);
                    });
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btnActualizar').html('<i class="fas fa-spinner fa-spin mr-1"></i> Actualizando...').prop('disabled', true);
                    $('#constantesForm').off('submit').submit();
                }
            });
        });

        // SweetAlert mensajes
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                html: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
        @endif
        
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '{{ session('error') }}',
                timer: 4000,
                showConfirmButton: true
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Errores en el formulario',
                html: `@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach`,
                confirmButtonText: 'Entendido'
            });
        @endif
    });
</script>
@stop