@extends('adminlte::page')

@section('title', 'Editar Constantes Vitales')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>ACTUALIZAR CONSTANTES VITALES
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-circle mr-2"></i>Información del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre del Paciente</small>
                    <span class="h6 font-weight-bold text-dark text-uppercase">
                        {{ $registro->paciente->primer_nombre }} {{ $registro->paciente->primer_apellido }}
                    </span>
                </div>
                <div class="col-md-2 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">ID Registro</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">#{{ $registro->id }}</span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Edad / Fecha</small>
                    <span class="text-dark font-weight-bold text-uppercase">{{ \Carbon\Carbon::parse($registro->paciente->fecha_nacimiento)->age }} AÑOS</span>
                    <small class="d-block text-secondary">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</small>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico Responsable</small>
                    <span class="text-dark font-weight-500">DR. {{ strtoupper($registro->doctor->primer_apellido ?? 'N/A') }}</span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.constantes_vitales.update', $constanteVital) }}" method="POST" id="constantesForm">
        @csrf
        @method('PUT')

        {{-- SECCIÓN EVALUACIÓN --}}
        <div class="row mb-4">
            <div class="col-12">
                <label class="form-label font-weight-bold text-pastel-blue">
                    <i class="fas fa-stethoscope mr-1"></i> OBSERVACIONES O ENFERMEDAD ACTUAL
                </label>
                <textarea name="enfermedad_actual" class="form-control form-control-pastel shadow-sm text-uppercase" 
                          rows="3" placeholder="DESCRIBA LOS HALLAZGOS...">{{ old('enfermedad_actual', $constanteVital->enfermedad_actual) }}</textarea>
            </div>
        </div>

        {{-- 🔹 FORMULARIO DE CONSTANTES VITALES --}}
        <div class="card card-pastel shadow-lg">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0 font-weight-bold text-pastel-blue text-uppercase">
                    <i class="fas fa-clipboard-list mr-2"></i>Edición de Signos y Antropometría
                </h5>
            </div>
            
            <div class="card-body">
                {{-- SECCIÓN 1: SIGNOS VITALES --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-pastel-purple font-weight-bold mb-3 border-bottom pb-2 text-uppercase">
                            <i class="fas fa-heart mr-2"></i>Signos Vitales
                        </h6>
                    </div>
                    @php
                        $signosVitales = [
                            'temperatura' => ['icon' => 'thermometer-half', 'unit' => '°C', 'color' => 'text-info', 'id' => 'tempIn'],
                            'presion_arterial' => ['icon' => 'tachometer-alt', 'unit' => 'mmHg', 'color' => 'text-danger', 'id' => 'presionIn'],
                            'frecuencia_cardiaca' => ['icon' => 'heartbeat', 'unit' => 'lpm', 'color' => 'text-success', 'id' => 'fcIn'],
                            'frecuencia_respiratoria' => ['icon' => 'wind', 'unit' => 'rpm', 'color' => 'text-primary', 'id' => 'frIn'],
                            'saturacion_oxigeno' => ['icon' => 'lungs', 'unit' => '%', 'color' => 'text-warning', 'id' => 'satIn'],
                        ];
                    @endphp

                    @foreach($signosVitales as $key => $data)
                    <div class="col-md-4 col-sm-6 mb-3">
                        <label class="form-label font-weight-bold small text-uppercase">
                            <i class="fas fa-{{ $data['icon'] }} {{ $data['color'] }} mr-1"></i> {{ str_replace('_', ' ', $key) }}
                        </label>
                        <div class="input-group shadow-sm">
                            <input type="{{ $key == 'presion_arterial' ? 'text' : 'number' }}" 
                                   id="{{ $data['id'] }}" step="0.1" name="{{ $key }}" 
                                   class="form-control form-control-pastel text-uppercase font-weight-bold" 
                                   value="{{ old($key, $constanteVital->$key) }}">
                            <div class="input-group-append">
                                <span class="input-group-text bg-light-soft font-weight-bold text-muted small">{{ $data['unit'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- SECCIÓN 2: ANTROPOMETRÍA --}}
                <div class="row">
                    <div class="col-12">
                        <h6 class="text-pastel-purple font-weight-bold mb-3 border-bottom pb-2 text-uppercase">
                            <i class="fas fa-weight mr-2"></i>Antropometría
                        </h6>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-uppercase">Peso (kg)</label>
                        <input type="number" step="0.1" name="peso" id="pesoInput" class="form-control form-control-pastel shadow-sm" value="{{ $constanteVital->peso }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-uppercase">Talla (cm)</label>
                        <input type="number" step="0.1" name="talla" id="tallaInput" class="form-control form-control-pastel shadow-sm" value="{{ $constanteVital->talla }}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-uppercase">IMC (Calculado)</label>
                        <input type="text" name="imc" id="imcInput" class="form-control bg-light border-0 font-weight-bold" readonly value="{{ $constanteVital->imc }}">
                    </div>
                    <div class="col-md-3 mb-3 text-center">
                        <label class="small font-weight-bold text-uppercase d-block">Estado Nutricional</label>
                        <span id="imcBadge" class="badge badge-pill badge-secondary mt-2 p-2 w-100 shadow-sm text-uppercase">-</span>
                    </div>
                    {{-- Campo oculto para la categoría si lo necesitas --}}
                    <input type="hidden" name="categoria_imc" id="categoriaImcInput" value="{{ $constanteVital->categoria_imc }}">
                </div>
            </div>

            <div class="card-footer bg-white text-right py-3">
                <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray mr-2">
                    <i class="fas fa-times mr-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-warning shadow-sm px-4 font-weight-bold" id="btnGuardar">
                    <i class="fas fa-sync-alt mr-1"></i> ACTUALIZAR REGISTRO
                </button>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
    .text-pastel-purple { color: #9B86BD !important; }
    .bg-pastel-purple { background-color: #9B86BD !important; color: white; }
    .bg-pastel-blue { background-color: #778DA9 !important; }
    .btn-pastel-gray { background-color: #E0E1DD; color: #415A77; border: none; }
    .btn-pastel-gray:hover { background-color: #d1d2cd; }
    
    .card-pastel { border-radius: 12px; border: none; }
    .form-control-pastel { border-radius: 8px; border: 1px solid #E0E1DD; padding: 0.6rem; }
    .form-control-pastel:focus { border-color: #9B86BD; box-shadow: 0 0 0 0.2rem rgba(155, 134, 189, 0.15); }
    .bg-light-soft { background-color: #F8F9FA; }
    .border-right { border-right: 1px solid #dee2e6 !important; }

    /* Mayúsculas forzadas visualmente */
    .text-uppercase { text-transform: uppercase; }

    @media (max-width: 768px) {
        .border-right { border-right: none !important; border-bottom: 1px solid #dee2e6; margin-bottom: 10px; padding-bottom: 10px; }
    }
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

        // 2. Restricción de caracteres para Presión Arterial
        $('#presionIn').on('keypress', function(e) {
            var charCode = (e.which) ? e.which : e.keyCode;
            if (charCode != 47 && (charCode < 48 || charCode > 57)) {
                e.preventDefault();
                return false;
            }
        });

        // 3. Cálculo de IMC
        function calcularIMC() {
            let peso = parseFloat($('#pesoInput').val());
            let talla = parseFloat($('#tallaInput').val()) / 100;
            let imcInput = $('#imcInput');
            let badge = $('#imcBadge');
            let catInput = $('#categoriaImcInput');

            if (peso > 0 && talla > 0) {
                let imc = (peso / (talla * talla)).toFixed(2);
                imcInput.val(imc);
                
                let label = 'NORMAL';
                let color = 'bg-success';

                if (imc < 18.5) { label = 'BAJO PESO'; color = 'bg-warning text-dark'; }
                else if (imc >= 25 && imc < 30) { label = 'SOBREPESO'; color = 'bg-warning text-dark'; }
                else if (imc >= 30) { label = 'OBESIDAD'; color = 'bg-danger text-white'; }

                badge.text(label).removeClass('badge-secondary bg-success bg-warning bg-danger text-dark text-white').addClass(color);
                catInput.val(label);
            } else {
                imcInput.val('');
                badge.text('-').removeClass('bg-success bg-warning bg-danger text-dark text-white').addClass('badge-secondary');
            }
        }

        $('#pesoInput, #tallaInput').on('input', calcularIMC);
        calcularIMC(); // Ejecutar al cargar para mostrar el IMC actual

        // 4. SweetAlert2: Confirmación de Actualización
        $('#constantesForm').on('submit', function(e) {
            e.preventDefault();
            
            // Validación de formato de Presión Arterial
            let presionVal = $('#presionIn').val();
            let regexPresion = /^[0-9\/]+$/;

            if (presionVal !== "" && !regexPresion.test(presionVal)) {
                Swal.fire({
                    icon: 'error',
                    title: 'FORMATO INCORRECTO',
                    text: 'LA PRESIÓN SOLO PERMITE NÚMEROS Y "/"',
                    confirmButtonColor: '#9B86BD'
                });
                return false;
            }

            Swal.fire({
                title: '¿CONFIRMAR ACTUALIZACIÓN?',
                text: "SE MODIFICARÁN LOS PARÁMETROS CLÍNICOS DEL PACIENTE.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#9B86BD',
                cancelButtonColor: '#778DA9',
                confirmButtonText: '<i class="fas fa-check"></i> SÍ, ACTUALIZAR',
                cancelButtonText: 'REVISAR'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@stop