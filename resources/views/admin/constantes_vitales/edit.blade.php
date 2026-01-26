@extends('adminlte::page')

@section('title', 'Editar Constantes Vitales')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap p-2">
    <div>
        <h1 class="text-pastel-purple font-weight-bold mb-0">
            <i class="fas fa-file-signature mr-2"></i>Actualización de Constantes
        </h1>
        <p class="text-muted mb-0">Gestión de parámetros clínicos y antropometría</p>
    </div>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm hover-lift">
        <i class="fas fa-chevron-left mr-1"></i> Regresar al Expediente
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-5">
    
    {{-- 🔹 HEADER DE PACIENTE: ESTILO COMPACTO Y ELEGANTE --}}
    <div class="card shadow-sm border-0 mb-4 overflow-hidden" style="border-radius: 15px;">
        <div class="row no-gutters">
            <div class="col-md-1 bg-pastel-purple d-flex align-items-center justify-content-center p-3">
                <i class="fas fa-user-injured fa-2x text-white"></i>
            </div>
            <div class="col-md-11">
                <div class="card-body py-3">
                    <div class="row text-center text-md-left">
                        <div class="col-md-4 border-right-md">
                            <label class="small text-uppercase text-muted font-weight-bold mb-0">Paciente</label>
                            <div class="h6 font-weight-bold text-dark text-uppercase mb-0">
                                {{ $registro->paciente->primer_nombre }} {{ $registro->paciente->primer_apellido }}
                            </div>
                        </div>
                        <div class="col-md-3 border-right-md">
                            <label class="small text-uppercase text-muted font-weight-bold mb-0">Identificación</label>
                            <div class="h6 font-weight-bold mb-0">{{ $registro->paciente->cedula_identidad }}</div>
                        </div>
                        <div class="col-md-2 border-right-md text-center">
                            <label class="small text-uppercase text-muted font-weight-bold mb-0">Edad</label>
                            <div><span class="badge badge-pill bg-pastel-purple-light px-3">{{ \Carbon\Carbon::parse($registro->paciente->fecha_nacimiento)->age }} años</span></div>
                        </div>
                        <div class="col-md-3 text-center">
                            <label class="small text-uppercase text-muted font-weight-bold mb-0">Fecha de Registro</label>
                            <div class="h6 font-weight-bold mb-0">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.constantes_vitales.update', $constanteVital) }}" method="POST" id="constantesForm">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- 🔹 COLUMNA IZQUIERDA: SIGNOS VITALES --}}
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 pt-4">
                        <h5 class="font-weight-bold text-primary"><i class="fas fa-heartbeat mr-2"></i>Signos Vitales</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @php
                                $campos = [
                                    ['name' => 'temperatura', 'label' => 'Temperatura', 'icon' => 'thermometer-half', 'color' => 'info', 'unit' => '°C'],
                                    ['name' => 'presion_arterial', 'label' => 'Presión Arterial', 'icon' => 'tint', 'color' => 'danger', 'unit' => 'mmHg'],
                                    ['name' => 'frecuencia_cardiaca', 'label' => 'Frec. Cardíaca', 'icon' => 'heartbeat', 'color' => 'success', 'unit' => 'LPM'],
                                    ['name' => 'frecuencia_respiratoria', 'label' => 'Frec. Respiratoria', 'icon' => 'wind', 'color' => 'primary', 'unit' => 'RPM'],
                                    ['name' => 'saturacion_oxigeno', 'label' => 'Saturación O₂', 'icon' => 'lungs', 'color' => 'warning', 'unit' => '%'],
                                ];
                            @endphp

                            @foreach($campos as $c)
                            <div class="col-md-6 mb-4">
                                <div class="p-3 border rounded-lg bg-light-hover transition-all">
                                    <label class="small font-weight-bold text-uppercase text-{{ $c['color'] }}">
                                        <i class="fas fa-{{ $c['icon'] }} mr-1"></i> {{ $c['label'] }}
                                    </label>
                                    <div class="input-group">
                                        <input type="{{ $c['name'] == 'presion_arterial' ? 'text' : 'number' }}" 
                                               step="0.1" name="{{ $c['name'] }}" 
                                               class="form-control form-control-lg border-0 bg-transparent text-uppercase font-weight-bold" 
                                               value="{{ old($c['name'], $constanteVital->{$c['name']}) }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-transparent border-0 font-weight-bold text-muted">{{ $c['unit'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- EVALUACIÓN --}}
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                    <div class="card-body">
                        <label class="font-weight-bold text-muted text-uppercase mb-3">
                            <i class="fas fa-notes-medical mr-2 text-primary"></i>Enfermedad o Problema Actual
                        </label>
                        <textarea name="enfermedad_actual" class="form-control border-0 bg-light text-uppercase p-3" 
                                  rows="5" style="border-radius: 12px;" 
                                  placeholder="DESCRIBA LOS HALLAZGOS CLÍNICOS...">{{ old('enfermedad_actual', $constanteVital->enfermedad_actual) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- 🔹 COLUMNA DERECHA: ANTROPOMETRÍA Y ACCIONES --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 mb-4 bg-pastel-blue-light" style="border-radius: 15px;">
                    <div class="card-header bg-transparent border-0 pt-4 text-center">
                        <h5 class="font-weight-bold text-dark text-uppercase">Antropometría</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold">PESO (KG)</label>
                            <input type="number" step="0.1" id="pesoInput" name="peso" class="form-control form-control-lg shadow-sm border-0" value="{{ $constanteVital->peso }}" style="border-radius: 10px;">
                        </div>
                        <div class="form-group mb-4">
                            <label class="small font-weight-bold">TALLA (CM)</label>
                            <input type="number" step="0.1" id="tallaInput" name="talla" class="form-control form-control-lg shadow-sm border-0" value="{{ $constanteVital->talla }}" style="border-radius: 10px;">
                        </div>

                        <div class="text-center p-3 mb-4 rounded-lg" style="background: rgba(255,255,255,0.5); border: 2px dashed #fff;">
                            <label class="small font-weight-bold text-muted mb-1 d-block text-uppercase">Índice de Masa Corporal</label>
                            <h2 class="font-weight-bold text-primary mb-0" id="imcText">-</h2>
                            <input type="hidden" name="imc" id="imcInput" value="{{ $constanteVital->imc }}">
                            <span class="badge px-3 py-2 mt-2 text-uppercase" id="imcBadge">-</span>
                            <input type="hidden" name="categoria_imc" id="categoriaImcInput" value="{{ $constanteVital->categoria_imc }}">
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-bold">PERÍMETRO ABDOMINAL (CM)</label>
                            <input type="number" step="0.1" name="perimetro_abdominal" class="form-control shadow-sm border-0" value="{{ $constanteVital->perimetro_abdominal }}" style="border-radius: 10px;">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-warning btn-block btn-lg shadow font-weight-bold hover-lift py-3" style="border-radius: 12px;">
                    <i class="fas fa-sync-alt mr-2"></i> ACTUALIZAR FICHA
                </button>
                <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-link btn-block text-muted mt-2">Cancelar cambios</a>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
    /* Estilos Pastel y Modernos */
    .bg-pastel-purple { background: linear-gradient(135deg, #6a1b9a, #8e24aa); }
    .bg-pastel-purple-light { background-color: #f3e5f5; color: #7b1fa2; }
    .bg-pastel-blue-light { background-color: #e3f2fd; }
    .text-pastel-purple { color: #6a1b9a; }
    .btn-pastel-gray { background-color: #f8f9fa; color: #6c757d; border: 1px solid #dee2e6; border-radius: 10px; }
    
    .bg-light-hover:hover { background-color: #f1f3f5; }
    .transition-all { transition: all 0.3s ease; }
    
    /* Efecto de elevación para botones */
    .hover-lift:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.12); }
    
    .border-right-md { border-right: 1px solid #eee; }
    @media (max-width: 768px) { .border-right-md { border-right: none; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 10px; } }

    /* Inputs estilo minimalista */
    .form-control:focus { box-shadow: none; border-color: #6a1b9a; }
    input[type=number]::-webkit-inner-spin-button, input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }

    /* Mayúsculas forzadas visualmente */
    .text-uppercase { text-transform: uppercase; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // 1. FORZAR MAYÚSCULAS EN TIEMPO REAL
        $(document).on('input', 'input[type="text"], textarea', function() {
            let start = this.selectionStart;
            let end = this.selectionEnd;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(start, end);
        });

        const pesoInput = $('#pesoInput');
        const tallaInput = $('#tallaInput');
        const imcInput = $('#imcInput');
        const imcText = $('#imcText');
        const imcBadge = $('#imcBadge');
        const catInput = $('#categoriaImcInput');

        function calcularIMC() {
            let peso = parseFloat(pesoInput.val());
            let talla = parseFloat(tallaInput.val()) / 100;
            
            if (peso > 0 && talla > 0) {
                let imc = (peso / (talla * talla)).toFixed(1);
                imcInput.val(imc);
                imcText.text(imc);

                let badgeClass = 'badge-success';
                let categoria = 'PESO NORMAL';

                if (imc < 18.5) { badgeClass = 'badge-warning'; categoria = 'BAJO PESO'; }
                else if (imc >= 25 && imc < 30) { badgeClass = 'badge-warning'; categoria = 'SOBREPESO'; }
                else if (imc >= 30) { badgeClass = 'badge-danger'; categoria = 'OBESIDAD'; }

                imcBadge.removeClass('badge-success badge-warning badge-danger').addClass(badgeClass).text(categoria);
                catInput.val(categoria);
            }
        }

        pesoInput.on('input', calcularIMC);
        tallaInput.on('input', calcularIMC);
        calcularIMC(); // Inicial al cargar

        // CONFIRMACIÓN
        $('#constantesForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Guardar actualización?',
                text: "Los datos del paciente serán actualizados permanentemente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#ffc107',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Revisar'
            }).then((result) => {
                if (result.isConfirmed) { this.submit(); }
            });
        });
    });
</script>
@stop