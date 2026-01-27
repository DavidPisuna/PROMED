@extends('adminlte::page')

@section('title', 'Agregar Aptitud Médica')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-clipboard-check mr-2"></i>L. APTITUD MÉDICA PARA EL TRABAJO
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD RESUMEN DEL PACIENTE (Estilo consistente) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-circle mr-2"></i>Información del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                </div>
                <div class="col-md-3 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Evaluación</small>
                    <span class="badge badge-pill bg-pastel-purple px-3 text-uppercase">
                        {{ $registro->tipo }}
                    </span>
                </div>
                <div class="col-md-5">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico Evaluador</small>
                    <span class="text-dark font-weight-500">DR. {{ strtoupper($registro->doctor->primer_nombre) }} {{ strtoupper($registro->doctor->primer_apellido) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE APTITUD --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-stethoscope mr-2"></i>Registro de Evaluación Médica
            </h5>
            <span class="badge badge-info" id="contador-aptitudes">NUEVO INGRESO</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.aptitudes_medicas.store', $registro->id) }}" method="POST" id="aptitudesForm">
                @csrf

                <div class="row">
                    {{-- Selección de Aptitud --}}
                    <div class="col-md-6 border-right">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-star mr-2 text-warning"></i>Resultado de Aptitud <span class="text-danger">*</span>
                            </label>
                            <select name="aptitud" id="aptitud_select" class="form-control form-control-pastel font-weight-bold" required>
                                <option value="">-- SELECCIONE LA APTITUD --</option>
                                <option value="apto">APTO</option>
                                <option value="apto_observacion">APTO CON OBSERVACIÓN</option>
                                <option value="apto_limitaciones">APTO CON LIMITACIONES</option>
                                <option value="no_apto">NO APTO</option>
                            </select>
                        </div>
                    </div>

                    {{-- Indicador Visual Dinámico --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label font-weight-bold text-muted small text-uppercase">Estado de Evaluación</label>
                            <div class="alert alert-info shadow-sm h-100 mb-0 d-flex align-items-center" id="aptitud-alert">
                                <div class="w-100 text-center">
                                    <i class="fas fa-info-circle mr-2"></i>Seleccione un resultado para ver detalles.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Observaciones y Recomendaciones --}}
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-comment-medical mr-2 text-info"></i>Observaciones Médicas</label>
                            <textarea name="observaciones" rows="4" class="form-control form-control-pastel text-uppercase" placeholder="DESCRIBA LOS HALLAZGOS CLÍNICOS..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <h4 class="text-pastel-purple font-weight-bold">
                        <i class="fas fa-clipboard-check mr-2"></i>M. RECOMENDACIONES Y/O TRATAMIENTO
                    </h4>
                </div>
                <br>
                  <div class="row">
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-prescription-bottle-alt mr-2 text-success"></i>Recomendaciones y Tratamiento</label>
                            <textarea name="recomendaciones_tratamiento" rows="4" class="form-control form-control-pastel text-uppercase" placeholder="INDIQUE PLAN DE SEGUIMIENTO O MEDICACIÓN..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2">CANCELAR</button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm" id="btnGuardar">
                        <i class="fas fa-save mr-2"></i>GUARDAR APTITUD
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
    }

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .text-pastel-purple { color: #9b86d9 !important; }
    
    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
        transition: all 0.3s ease;
        height: auto !important;
        padding: 12px;
    }
    
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; transition: 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    /* Colores para las Alertas de Aptitud */
    .apto-alert { background-color: #d4edda !important; color: #155724 !important; border: 1px solid #c3e6cb !important; }
    .apto-obs-alert { background-color: #fff3cd !important; color: #856404 !important; border: 1px solid #ffeaa7 !important; }
    .no-apto-alert { background-color: #f8d7da !important; color: #721c24 !important; border: 1px solid #f5c6cb !important; }

    .text-uppercase { text-transform: uppercase; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        // 1. Lógica dinámica del cuadro de información (Alert)
        $('#aptitud_select').on('change', function() {
            const val = $(this).val();
            const alertBox = $('#aptitud-alert');
            let text = '';
            let cssClass = 'alert-info';

            switch(val) {
                case 'apto':
                    text = '<strong>APTO:</strong> El paciente cumple con todos los requisitos para sus actividades.';
                    cssClass = 'apto-alert';
                    break;
                case 'apto_observacion':
                    text = '<strong>APTO CON OBSERVACIÓN:</strong> Requiere seguimiento médico monitoreado.';
                    cssClass = 'apto-obs-alert';
                    break;
                case 'apto_limitaciones':
                    text = '<strong>APTO CON LIMITACIONES:</strong> Restricciones específicas en actividades laborales.';
                    cssClass = 'apto-obs-alert';
                    break;
                case 'no_apto':
                    text = '<strong>NO APTO:</strong> No cumple con los requisitos médicos necesarios.';
                    cssClass = 'no-apto-alert';
                    break;
                default:
                    text = '<i class="fas fa-info-circle mr-2"></i>Seleccione un resultado para ver detalles.';
                    cssClass = 'alert-info';
            }

            alertBox.fadeOut(200, function() {
                $(this).removeClass('alert-info apto-alert apto-obs-alert no-apto-alert')
                         .addClass(cssClass)
                         .html(`<div class="w-100 text-center">${text}</div>`)
                         .fadeIn(200);
            });
        });

        // 2. Mayúsculas en tiempo real
        $('input[type="text"], textarea').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // 3. Confirmación de Guardado (SweetAlert2)
        $('#aptitudesForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Confirmar Aptitud Médica?',
                text: "Se registrará la evaluación final del paciente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Revisar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btnGuardar').html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...').prop('disabled', true);
                    this.submit();
                }
            });
        });

        // 4. Botón Cancelar (SweetAlert2)
        $('#btnCancelar').on('click', function() {
            Swal.fire({
                title: '¿Descartar cambios?',
                text: "No se guardará la aptitud médica.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Salir',
                confirmButtonColor: '#CAB8FF',
                cancelButtonColor: '#E3E3E3',
                cancelButtonText: 'Seguir editando'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.registros.show', $registro) }}";
                }
            });
        });
    });
</script>
@stop