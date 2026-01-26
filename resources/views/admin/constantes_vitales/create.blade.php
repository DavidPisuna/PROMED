@extends('adminlte::page')

@section('title', 'Registrar Constantes Vitales')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-heartbeat mr-2"></i>Registrar Constantes Vitales
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE (Estilo Resumen Pastel) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-circle mr-2"></i>Información del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre del Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                </div>
                <div class="col-md-2 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">ID Registro</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">#{{ $registro->id }}</span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo / Fecha</small>
                    <span class="text-dark font-weight-bold text-uppercase">{{ $registro->tipo }}</span>
                    <small class="d-block text-secondary">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</small>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico</small>
                    <span class="text-dark font-weight-500">DR. {{ strtoupper($registro->doctor->primer_apellido ?? 'N/A') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE CONSTANTES VITALES --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-clipboard-list mr-2"></i>Ingreso de Signos y Antropometría
            </h5>
        </div>
        
        <form action="{{ route('admin.constantes_vitales.store', $registro) }}" method="POST" id="constantesForm">
            @csrf
            <div class="card-body">
                {{-- SECCIÓN 1: SIGNOS VITALES --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-pastel-purple font-weight-bold mb-3 border-bottom pb-2">
                            <i class="fas fa-heart mr-2"></i>Signos Vitales
                        </h6>
                    </div>
                    @php
                        $signosVitales = [
                            'temperatura' => ['icon' => 'thermometer-half', 'unit' => '°C', 'color' => 'text-info', 'placeholder' => '36.5', 'id' => 'tempIn'],
                            'presion_arterial' => ['icon' => 'tachometer-alt', 'unit' => 'mmHg', 'color' => 'text-danger', 'placeholder' => '120/80', 'id' => 'presionIn'],
                            'frecuencia_cardiaca' => ['icon' => 'heartbeat', 'unit' => 'lpm', 'color' => 'text-success', 'placeholder' => '72', 'id' => 'fcIn'],
                            'frecuencia_respiratoria' => ['icon' => 'wind', 'unit' => 'rpm', 'color' => 'text-primary', 'placeholder' => '16', 'id' => 'frIn'],
                            'saturacion_oxigeno' => ['icon' => 'lungs', 'unit' => '%', 'color' => 'text-warning', 'placeholder' => '98', 'id' => 'satIn'],
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
                                   class="form-control form-control-pastel" 
                                   placeholder="{{ $data['placeholder'] }}" value="{{ old($key) }}">
                            <div class="input-group-append">
                                <span class="input-group-text bg-light-soft font-weight-bold text-muted small">{{ $data['unit'] }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- SECCIÓN 2: ANTROPOMETRÍA --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-pastel-purple font-weight-bold mb-3 border-bottom pb-2">
                            <i class="fas fa-weight mr-2"></i>Antropometría
                        </h6>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-uppercase">Peso (kg)</label>
                        <input type="number" step="0.1" name="peso" id="pesoInput" class="form-control form-control-pastel shadow-sm" placeholder="0.0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-uppercase">Talla (cm)</label>
                        <input type="number" step="0.1" name="talla" id="tallaInput" class="form-control form-control-pastel shadow-sm" placeholder="0">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="small font-weight-bold text-uppercase">IMC (Calculado)</label>
                        <input type="text" name="imc" id="imcInput" class="form-control bg-light border-0" readonly>
                    </div>
                    <div class="col-md-3 mb-3 text-center">
                        <label class="small font-weight-bold text-uppercase d-block">Estado Nutricional</label>
                        <span id="imcBadge" class="badge badge-pill badge-secondary mt-2 p-2 w-100 shadow-sm">-</span>
                    </div>
                </div>

                {{-- SECCIÓN 3: EVALUACIÓN --}}
                <div class="row">
                    <div class="col-12">
                        <label class="form-label font-weight-bold text-pastel-blue">
                            <i class="fas fa-stethoscope mr-1"></i> OBSERVACIONES O ENFERMEDAD ACTUAL
                        </label>
                        <textarea name="enfermedad_actual" class="form-control form-control-pastel shadow-sm" rows="3" placeholder="Ej: Paciente presenta cefalea leve y fatiga...">{{ old('enfermedad_actual') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="card-footer bg-white text-right py-3">
                <button type="button" id="btnLimpiar" class="btn btn-pastel-gray mr-2">
                    <i class="fas fa-eraser mr-1"></i> Limpiar
                </button>
                <button type="submit" class="btn btn-pastel-purple shadow-sm px-4" id="btnGuardar">
                    <i class="fas fa-save mr-1"></i> Guardar Registro
                </button>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
<style>
    /* Estilos Pastel Coincidentes con la otra vista */
    .text-pastel-purple { color: #9B86BD !important; }
    .bg-pastel-purple { background-color: #9B86BD !important; color: white; }
    .bg-pastel-blue { background-color: #778DA9 !important; }
    .btn-pastel-purple { background-color: #9B86BD; color: white; border: none; transition: 0.3s; }
    .btn-pastel-purple:hover { background-color: #836ba8; transform: translateY(-1px); color: white; }
    .btn-pastel-gray { background-color: #E0E1DD; color: #415A77; border: none; }
    .btn-pastel-gray:hover { background-color: #d1d2cd; }
    
    .card-pastel { border-radius: 12px; border: none; }
    .form-control-pastel { border-radius: 8px; border: 1px solid #E0E1DD; padding: 0.6rem; }
    .form-control-pastel:focus { border-color: #9B86BD; box-shadow: 0 0 0 0.2rem rgba(155, 134, 189, 0.15); }
    .bg-light-soft { background-color: #F8F9FA; }
    .border-right { border-right: 1px solid #dee2e6 !important; }

    /* Alertas de rango (opcional si quieres resaltar campos) */
    .border-warning-pastel { border: 2px solid #ffc107 !important; }

    @media (max-width: 768px) {
        .border-right { border-right: none !important; border-bottom: 1px solid #dee2e6; margin-bottom: 10px; padding-bottom: 10px; }
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // --- Cálculo de IMC ---
        function calcularIMC() {
            let peso = parseFloat($('#pesoInput').val());
            let talla = parseFloat($('#tallaInput').val()) / 100;
            let imcInput = $('#imcInput');
            let badge = $('#imcBadge');

            if (peso > 0 && talla > 0) {
                let imc = (peso / (talla * talla)).toFixed(2);
                imcInput.val(imc);
                
                let label = 'Normal';
                let color = 'bg-success';

                if (imc < 18.5) { label = 'Bajo Peso'; color = 'bg-warning text-dark'; }
                else if (imc >= 25 && imc < 30) { label = 'Sobrepeso'; color = 'bg-warning text-dark'; }
                else if (imc >= 30) { label = 'Obesidad'; color = 'bg-danger text-white'; }

                badge.text(label).removeClass('badge-secondary bg-success bg-warning bg-danger text-dark text-white').addClass(color);
            } else {
                imcInput.val('');
                badge.text('-').removeClass('bg-success bg-warning bg-danger text-dark text-white').addClass('badge-secondary');
            }
        }

        $('#pesoInput, #tallaInput').on('input', calcularIMC);

        // --- SweetAlert: Guardar con Validación de Rangos ---
        $('#constantesForm').on('submit', function(e) {
            e.preventDefault();
            
            let alertas = [];
            let temp = parseFloat($('#tempIn').val());
            let sat = parseFloat($('#satIn').val());
            let fc = parseFloat($('#fcIn').val());

            // Validaciones rápidas de rangos
            if (temp > 37.5) alertas.push("<li>Temperatura elevada (Fiebre)</li>");
            if (temp < 35.5 && temp > 0) alertas.push("<li>Temperatura baja (Hipotermia)</li>");
            if (sat < 95 && sat > 0) alertas.push("<li>Saturación de oxígeno baja</li>");
            if (fc > 100) alertas.push("<li>Frecuencia cardíaca alta (Taquicardia)</li>");

            let htmlMsg = alertas.length > 0 
                ? `<div class="text-left mt-2"><p>Se han detectado valores fuera del rango normal:</p><ul>${alertas.join('')}</ul><p>¿Desea continuar con el registro?</p></div>`
                : "¿Desea guardar los datos ingresados?";

            Swal.fire({
                title: alertas.length > 0 ? '¡Atención!' : '¿Confirmar registro?',
                html: htmlMsg,
                icon: alertas.length > 0 ? 'warning' : 'question',
                showCancelButton: true,
                confirmButtonColor: '#9B86BD',
                cancelButtonColor: '#778DA9',
                confirmButtonText: '<i class="fas fa-check"></i> Sí, guardar',
                cancelButtonText: 'Revisar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // --- SweetAlert: Limpiar ---
        $('#btnLimpiar').click(function() {
            Swal.fire({
                title: '¿Limpiar formulario?',
                text: "Se perderán los datos no guardados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, borrar todo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#constantesForm')[0].reset();
                    calcularIMC();
                }
            });
        });
    });
</script>
@stop