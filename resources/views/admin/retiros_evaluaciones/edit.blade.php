@extends('adminlte::page')

@section('title', 'Editar Evaluación de Retiro')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Evaluación de Retiro
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE (Estilo Resumen) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Información del Registro Original</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo de Registro</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">
                        {{ strtoupper($registro->tipo) }}
                    </span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Doctor Asignado</small>
                    <span class="text-dark font-weight-bold">DR. {{ strtoupper($registro->doctor->primer_apellido ?? 'N/A') }}</span>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Fecha Registro</small>
                    <span class="text-dark">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-file-signature mr-2"></i>Detalles de la Evaluación
            </h5>
            <span class="badge badge-light border text-muted">ID EVALUACIÓN: {{ $retiroEvaluacion->id }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.retiros_evaluaciones.update', [$registro, $retiroEvaluacion]) }}" method="POST" id="evaluacionForm">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- SE REALIZA EVALUACIÓN --}}
                    <div class="col-md-6 border-right">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-check-circle text-info mr-2"></i>¿Se realiza la evaluación? <span class="text-danger">*</span>
                            </label>
                            <select name="se_realiza_evaluacion" class="form-control form-control-pastel select2-mayus" required>
                                <option value="1" {{ $retiroEvaluacion->se_realiza_evaluacion ? 'selected' : '' }}>SÍ, SE REALIZÓ</option>
                                <option value="0" {{ !$retiroEvaluacion->se_realiza_evaluacion ? 'selected' : '' }}>NO SE REALIZÓ</option>
                            </select>
                        </div>
                    </div>

                    {{-- CONDICIÓN DE SALUD RELACIONADA --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-heartbeat text-danger mr-2"></i>Condición de salud relacionada <span class="text-danger">*</span>
                            </label>
                            <select name="condicion_salud_relacionada" class="form-control form-control-pastel select2-mayus" required>
                                <option value="1" {{ $retiroEvaluacion->condicion_salud_relacionada ? 'selected' : '' }}>SÍ TIENE RELACIÓN LABORAL</option>
                                <option value="0" {{ !$retiroEvaluacion->condicion_salud_relacionada ? 'selected' : '' }}>NO TIENE RELACIÓN LABORAL</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- OBSERVACIONES --}}
                <div class="form-group mt-2">
                    <label class="form-label font-weight-bold"><i class="fas fa-comment-medical mr-2 text-pastel-purple"></i>Observaciones y Hallazgos</label>
                    <textarea name="observaciones" rows="4" class="form-control form-control-pastel text-uppercase" 
                              placeholder="DESCRIBA LOS HALLAZGOS RELEVANTES...">{{ old('observaciones', $retiroEvaluacion->observaciones) }}</textarea>
                </div>

                {{-- INDICADOR DE ESTADO DINÁMICO --}}
                <div id="estado-evaluacion" class="alert mt-4 shadow-sm border-0" style="border-radius: 12px;">
                    {{-- Se llena vía JS --}}
                </div>

                <hr class="my-4">

                {{-- INFORMACIÓN DE AUDITORÍA --}}
                <div class="row text-center mb-4">
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded border-dashed">
                            <small class="text-muted font-weight-bold">FECHA DE CREACIÓN</small>
                            <p class="mb-0">{{ $retiroEvaluacion->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-2 bg-light rounded border-dashed">
                            <small class="text-muted font-weight-bold">ÚLTIMA ACTUALIZACIÓN</small>
                            <p class="mb-0">{{ $retiroEvaluacion->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                {{-- BOTONES DE ACCIÓN --}}
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <button type="button" class="btn btn-outline-danger btn-sm px-4" id="btnEliminar" style="border-radius: 8px;">
                        <i class="fas fa-trash-alt mr-2"></i>ELIMINAR EVALUACIÓN
                    </button>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray mr-2">CANCELAR</a>
                        <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm" id="btnActualizar">
                            <i class="fas fa-sync-alt mr-2"></i>ACTUALIZAR DATOS
                        </button>
                    </div>
                </div>
            </form>

            {{-- Formulario oculto para eliminar --}}
            <form id="deleteForm" action="{{ route('admin.retiros_evaluaciones.destroy', [$registro, $retiroEvaluacion]) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
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
        --pastel-red: #FFB7B2;
        --pastel-yellow: #FFFFD1;
        --pastel-gray: #E3E3E3;
    }

    .card-pastel { border: none; border-radius: 15px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white; }
    .bg-light-soft { background-color: #fafafa; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .text-pastel-purple { color: #8e7cc3 !important; }

    .border-dashed { border: 1px dashed #ccc; }

    .form-control-pastel {
        border-radius: 10px;
        border: 1.5px solid #eee;
        padding: 10px;
        transition: all 0.3s ease;
        height: auto !important;
    }

    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 10px rgba(168, 216, 234, 0.4);
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 10px; font-weight: bold; color: #2c3e50; transition: 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: translateY(-2px); }
    
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 10px; font-weight: bold; color: #555; }

    /* Clases de estado dinámico */
    .status-positive { background-color: #d4f0f0 !important; color: #1e5656; }
    .status-negative { background-color: #ffdada !important; color: #721c24; }
    .status-warning { background-color: #fff4d1 !important; color: #856404; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        function actualizarEstadoVisual() {
            const evaluacion = $('select[name="se_realiza_evaluacion"]').val();
            const condicion = $('select[name="condicion_salud_relacionada"]').val();
            const alertDiv = $('#estado-evaluacion');
            
            let message = '';
            let cssClass = '';
            let icon = 'fa-info-circle';

            if (evaluacion === '1') {
                if (condicion === '1') {
                    message = '<strong>AVISO:</strong> Se realizó la evaluación y se detectaron factores de riesgo laborales.';
                    cssClass = 'status-warning';
                    icon = 'fa-exclamation-triangle';
                } else {
                    message = '<strong>OK:</strong> Evaluación realizada con éxito sin hallazgos ocupacionales críticos.';
                    cssClass = 'status-positive';
                    icon = 'fa-check-circle';
                }
            } else {
                message = '<strong>ATENCIÓN:</strong> El proceso de evaluación de retiro no se llevó a cabo.';
                cssClass = 'status-negative';
                icon = 'fa-times-circle';
            }
            
            alertDiv.fadeOut(200, function() {
                $(this).removeClass('status-positive status-negative status-warning')
                       .addClass(cssClass)
                       .html(`<i class="fas ${icon} mr-2"></i>${message}`)
                       .fadeIn(200);
            });
        }

        $('select').change(actualizarEstadoVisual);
        actualizarEstadoVisual();

        // SweetAlert Confirmación Actualizar
        $('#evaluacionForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Guardar cambios?',
                text: "Se actualizará el registro médico del paciente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#CAB8FF',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Revisar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // SweetAlert Confirmación Eliminar
        $('#btnEliminar').click(function() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará permanentemente esta evaluación.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FFB7B2',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm').submit();
                }
            });
        });
    });
</script>
@stop