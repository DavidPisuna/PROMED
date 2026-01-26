@extends('adminlte::page')

@section('title', 'Editar Aptitud Médica')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Aptitud Médica
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
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-file-alt mr-2"></i>Contexto del Registro</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                    <p class="mb-0 small text-muted">C.I: {{ $registro->paciente->cedula_identidad ?? '—' }}</p>
                </div>
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Evaluación</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">
                        {{ strtoupper($registro->tipo) }}
                    </span>
                    <p class="mb-0 small text-muted">Fecha: {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico Asignado</small>
                    <span class="text-dark font-weight-bold">DR. {{ strtoupper($registro->doctor->primer_apellido ?? '') }}</span>
                    <p class="mb-0 small text-muted text-uppercase">{{ $registro->doctor->especialidad ?? 'MEDICINA GENERAL' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-clipboard-check mr-2"></i>Actualizar Evaluación de Aptitud
            </h5>
            <span class="badge badge-light border text-muted">ID Aptitud: {{ $aptitudMedica->id }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.aptitudes_medicas.update', [$registro->id, $aptitudMedica->id]) }}" method="POST" id="aptitudesForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 border-right">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-stethoscope text-pastel-blue mr-2"></i>Resultado de Aptitud <span class="text-danger">*</span>
                            </label>
                            {{-- Select con forzado de mayúsculas --}}
                            <select name="aptitud" id="aptitud-select" class="form-control form-control-pastel font-weight-bold text-uppercase" required>
                                <option value="">-- SELECCIONE APTITUD --</option>
                                <option value="apto" {{ $aptitudMedica->aptitud == 'apto' ? 'selected' : '' }}>APTO</option>
                                <option value="apto_observacion" {{ $aptitudMedica->aptitud == 'apto_observacion' ? 'selected' : '' }}>APTO CON OBSERVACIÓN</option>
                                <option value="apto_limitaciones" {{ $aptitudMedica->aptitud == 'apto_limitaciones' ? 'selected' : '' }}>APTO CON LIMITACIONES</option>
                                <option value="no_apto" {{ $aptitudMedica->aptitud == 'no_apto' ? 'selected' : '' }}>NO APTO</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div id="aptitud-info" class="alert h-100 d-flex align-items-center mb-0 shadow-sm" style="border-radius: 12px; transition: all 0.4s ease;">
                            <div>
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>Seleccione una aptitud para ver la descripción.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-eye text-info mr-2"></i>Observaciones Médicas</label>
                            {{-- Agregada clase force-uppercase --}}
                            <textarea name="observaciones" rows="4" class="form-control form-control-pastel force-uppercase" 
                                      placeholder="DESCRIBA HALLAZGOS CLÍNICOS...">{{ old('observaciones', $aptitudMedica->observaciones) }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-prescription text-success mr-2"></i>Recomendaciones y Tratamiento</label>
                            {{-- Agregada clase force-uppercase --}}
                            <textarea name="recomendaciones_tratamiento" rows="4" class="form-control form-control-pastel force-uppercase" 
                                      placeholder="INDICACIONES PARA EL PACIENTE...">{{ old('recomendaciones_tratamiento', $aptitudMedica->recomendaciones_tratamiento) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 border-top pt-4">
                    <button type="button" class="btn btn-outline-danger btn-sm border-0" id="btnEliminar">
                        <i class="fas fa-trash-alt mr-1"></i> Eliminar Registro
                    </button>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray mr-2">CANCELAR</a>
                        <button type="submit" class="btn btn-pastel-purple px-5 shadow-sm" id="btnActualizar">
                            <i class="fas fa-save mr-2"></i>GUARDAR CAMBIOS
                        </button>
                    </div>
                </div>
            </form>

            <form id="deleteForm" action="{{ route('admin.aptitudes_medicas.destroy', [$registro->id, $aptitudMedica->id]) }}" method="POST" style="display: none;">
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
        --pastel-gray: #E3E3E3;
    }

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .text-pastel-blue { color: #6fb9d6 !important; }

    /* Forzado visual de mayúsculas */
    .force-uppercase, .text-uppercase { 
        text-transform: uppercase !important; 
    }

    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
        padding: 10px;
        transition: all 0.3s ease;
    }

    .form-control-pastel:focus {
        border-color: var(--pastel-purple);
        box-shadow: 0 0 8px rgba(202, 184, 255, 0.4);
        outline: none;
    }

    .btn-pastel-purple { background: var(--pastel-purple); border: none; border-radius: 8px; font-weight: bold; color: white; transition: 0.3s; }
    .btn-pastel-purple:hover { background: #b5a0f5; transform: scale(1.02); color: white; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }

    .apto-alert { background-color: #e2f3e5; border: 1px solid #c3e6cb; color: #155724; }
    .apto-obs-alert { background-color: #fff9e6; border: 1px solid #ffeaa7; color: #856404; }
    .no-apto-alert { background-color: #fdf2f2; border: 1px solid #f5c6cb; color: #721c24; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        // 1. CONVERSIÓN AUTOMÁTICA A MAYÚSCULAS (Lógica de negocio)
        // Esto captura cualquier input/textarea con la clase y cambia el valor real
        $(document).on('input', '.force-uppercase', function() {
            this.value = this.value.toUpperCase();
        });

        // 2. LÓGICA DINÁMICA DEL SELECT
        function updateAptitudUI(value) {
            const alertDiv = $('#aptitud-info');
            let config = {
                text: '<strong>Información:</strong> Seleccione una aptitud.',
                class: 'alert-info'
            };

            switch(value) {
                case 'apto':
                    config = { text: '<strong>APTO:</strong> Cumple con requisitos médicos.', class: 'apto-alert' };
                    break;
                case 'apto_observacion':
                    config = { text: '<strong>APTO CON OBSERVACIÓN:</strong> Requiere seguimiento.', class: 'apto-obs-alert' };
                    break;
                case 'apto_limitaciones':
                    config = { text: '<strong>APTO CON LIMITACIONES:</strong> Restricciones específicas.', class: 'apto-obs-alert' };
                    break;
                case 'no_apto':
                    config = { text: '<strong>NO APTO:</strong> No cumple con requisitos.', class: 'no-apto-alert' };
                    break;
            }

            alertDiv.removeClass('apto-alert apto-obs-alert no-apto-alert alert-info').addClass(config.class);
            alertDiv.find('span').html(config.text);
        }

        updateAptitudUI($('#aptitud-select').val());

        $('#aptitud-select').change(function() {
            updateAptitudUI($(this).val());
        });

        // 3. CONFIRMACIONES SWEETALERT
        $('#aptitudesForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Guardar cambios?',
                text: "Se actualizará la aptitud del paciente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#CAB8FF',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'SÍ, ACTUALIZAR',
                cancelButtonText: 'CANCELAR'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        $('#btnEliminar').click(function() {
            Swal.fire({
                title: '¿Eliminar aptitud?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'SÍ, ELIMINAR',
                cancelButtonText: 'CANCELAR'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteForm').submit();
                }
            });
        });
    });
</script>
@stop