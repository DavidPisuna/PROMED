@extends('adminlte::page')

@section('title', 'Agregar Evaluación de Retiro')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-clipboard-check mr-2"></i>Agregar Evaluación de Retiro
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA (Estilo Resumen Pastel) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-info-circle mr-2"></i>Información General del Registro</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                    <small class="d-block text-secondary">C.I: {{ $registro->paciente->cedula_identidad ?? '—' }}</small>
                </div>
                <div class="col-md-4 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo de Registro</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">
                        {{ strtoupper($registro->tipo) }}
                    </span>
                    <small class="d-block mt-1 text-secondary">Fecha: {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</small>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico Asignado</small>
                    <span class="text-dark font-weight-bold">DR. {{ strtoupper($registro->doctor->primer_nombre ?? '—') }} {{ strtoupper($registro->doctor->primer_apellido ?? '') }}</span>
                    <small class="d-block text-secondary">{{ strtoupper($registro->doctor->especialidad ?? 'MEDICINA GENERAL') }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EVALUACIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-edit mr-2"></i>Registrando Evaluación de Retiro
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.retiros_evaluaciones.store', $registro->id) }}" method="POST" id="evaluacionForm">
                @csrf

                <div class="row">
                    {{-- SE REALIZA EVALUACIÓN --}}
                    <div class="col-md-6 border-right">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-check-circle text-info mr-1"></i>¿Se realiza la evaluación? <span class="text-danger">*</span>
                            </label>
                            <select name="se_realiza_evaluacion" class="form-control form-control-pastel" required>
                                <option value="">-- SELECCIONE --</option>
                                <option value="1">SÍ, SE REALIZA</option>
                                <option value="0">NO SE REALIZA</option>
                            </select>
                            <small class="text-muted">Indique si se llevó a cabo el procedimiento médico.</small>
                        </div>
                    </div>

                    {{-- CONDICIÓN DE SALUD --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-heartbeat text-danger mr-1"></i>Condición de salud relacionada <span class="text-danger">*</span>
                            </label>
                            <select name="condicion_salud_relacionada" class="form-control form-control-pastel" required>
                                <option value="">-- SELECCIONE --</option>
                                <option value="1">SÍ, EXISTE RELACIÓN LABORAL</option>
                                <option value="0">NO EXISTE RELACIÓN LABORAL</option>
                            </select>
                            <small class="text-muted">¿Existe nexo causal con sus actividades laborales?</small>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-2">
                    <label class="form-label font-weight-bold"><i class="fas fa-eye text-warning mr-1"></i>Observaciones y Hallazgos</label>
                    <textarea name="observaciones" rows="4" class="form-control form-control-pastel text-uppercase" 
                              placeholder="DESCRIBA LOS HALLAZGOS RELEVANTES..."></textarea>
                </div>

                {{-- INDICADOR DE ESTADO DINÁMICO --}}
                <div class="alert shadow-sm mt-4 mb-0" id="estado-evaluacion" style="border-radius: 10px; background-color: #f8f9fa; border: 1px solid #eee;">
                    <i class="fas fa-info-circle mr-2 text-primary"></i>
                    <span id="estado-texto">Complete los campos requeridos para continuar.</span>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray mr-2">CANCELAR</a>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm" id="btnGuardar">
                        <i class="fas fa-save mr-2"></i>GUARDAR EVALUACIÓN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    :root {
        --pastel-blue: #A8D8EA;
        --pastel-purple: #CAB8FF;
        --pastel-green: #B6E2D3;
        --pastel-gray: #E3E3E3;
        --pastel-red: #FFB7B2;
        --pastel-yellow: #FFFFD1;
    }

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .text-pastel-purple { color: #8e7cc3 !important; }

    .form-control-pastel {
        height: calc(2.8rem + 2px) !important;
        border-radius: 10px;
        border: 1.5px solid #e9ecef;
        padding: 10px 15px;
        transition: all 0.3s ease;
        text-transform: uppercase;
    }

    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
        outline: none;
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 10px; font-weight: bold; color: #2c3e50; transition: 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: translateY(-1px); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 10px; font-weight: bold; color: #555; }
    
    /* Estados Dinámicos del Alert */
    .alert-success-pastel { background-color: #d4f1f4 !important; color: #0e4b50; border: 1px solid #b2ebf2; }
    .alert-danger-pastel { background-color: #ffe5e5 !important; color: #842029; border: 1px solid #f5c2c7; }
    .alert-warning-pastel { background-color: #fff4e0 !important; color: #664d03; border: 1px solid #ffecb5; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        function actualizarEstadoEvaluacion() {
            const evaluacion = $('select[name="se_realiza_evaluacion"]').val();
            const condicion = $('select[name="condicion_salud_relacionada"]').val();
            const alertDiv = $('#estado-evaluacion');
            const texto = $('#estado-texto');
            
            alertDiv.removeClass('alert-success-pastel alert-danger-pastel alert-warning-pastel');

            if (evaluacion === '1') {
                if (condicion === '1') {
                    alertDiv.addClass('alert-warning-pastel');
                    texto.html('<strong>Evaluación Realizada:</strong> Se identificó una condición de salud relacionada al trabajo.');
                } else if (condicion === '0') {
                    alertDiv.addClass('alert-success-pastel');
                    texto.html('<strong>Evaluación Realizada:</strong> No se identificaron hallazgos relacionados al trabajo.');
                }
            } else if (evaluacion === '0') {
                alertDiv.addClass('alert-danger-pastel');
                texto.html('<strong>Evaluación No Realizada:</strong> No se llevó a cabo el examen médico de retiro.');
            } else {
                texto.text('Complete los campos requeridos para continuar.');
            }
        }

        $('select').change(actualizarEstadoEvaluacion);

        $('#evaluacionForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Guardar Evaluación?',
                text: "Verifique que la información sea correcta.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Revisar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btnGuardar').html('<i class="fas fa-spinner fa-spin mr-1"></i> GUARDANDO...').prop('disabled', true);
                    this.submit();
                }
            });
        });
    });
</script>
@stop