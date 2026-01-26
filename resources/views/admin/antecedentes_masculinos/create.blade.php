@extends('adminlte::page')

@section('title', 'Crear Antecedente Reproductivo Masculino')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-primary"><i class="fas fa-male mr-2"></i> Crear Antecedente Reproductivo Masculino</h1>
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

    {{-- 🔹 FORMULARIO PRINCIPAL --}}
    <div class="card card-primary shadow-sm">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit mr-2"></i>
                <strong>Formulario de Antecedentes Reproductivos Masculinos</strong>
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.antecedentes_masculinos.store', $registro) }}" method="POST" id="antecedenteForm">
                @csrf

                {{-- SECCIÓN: MÉTODO DE PLANIFICACIÓN FAMILIAR --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-heartbeat mr-2"></i>
                                    Método de Planificación Familiar
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="planificacion_si" name="planificacion_si" value="1" {{ old('planificacion_si') ? 'checked' : '' }}>
                                                <label for="planificacion_si" class="custom-control-label font-weight-normal">
                                                    <i class="fas fa-check-circle text-success mr-1"></i> Sí
                                                </label>
                                            </div>
                                            <input type="text" name="planificacion_cual" class="form-control mt-2" placeholder="¿Cuál método utiliza?" value="{{ old('planificacion_cual') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="planificacion_no" name="planificacion_no" value="1" {{ old('planificacion_no') ? 'checked' : '' }}>
                                                <label for="planificacion_no" class="custom-control-label font-weight-normal">
                                                    <i class="fas fa-times-circle text-danger mr-1"></i> No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input class="custom-control-input" type="checkbox" id="planificacion_no_responde" name="planificacion_no_responde" value="1" {{ old('planificacion_no_responde') ? 'checked' : '' }}>
                                                <label for="planificacion_no_responde" class="custom-control-label font-weight-normal">
                                                    <i class="fas fa-question-circle text-warning mr-1"></i> No responde
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: EXÁMENES MASCULINOS --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card card-outline card-success">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h3 class="card-title">
                                    <i class="fas fa-vials mr-2"></i>
                                    Exámenes Realizados
                                </h3>
                                <button type="button" id="add-examen" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus mr-1"></i> Agregar Examen
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="examenes-container">
                                    <div class="examen-item card card-light mb-3">
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label"><i class="fas fa-stethoscope text-primary mr-1"></i> Nombre del examen</label>
                                                        <input type="text" name="examen_realizado[]" class="form-control" placeholder="Ej: Espermatograma" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label class="form-label"><i class="fas fa-clock text-info mr-1"></i> Tiempo (meses)</label>
                                                        <input type="number" name="tiempo_meses[]" class="form-control" placeholder="Ej: 3" min="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label class="form-label"><i class="fas fa-clipboard-check text-success mr-1"></i> Resultado</label>
                                                        <input type="text" name="resultado[]" class="form-control" placeholder="Ej: Normal">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label class="form-label text-white">-</label>
                                                        <button type="button" class="btn btn-danger btn-sm remove-examen" title="Eliminar examen">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Puede agregar múltiples exámenes haciendo clic en "Agregar Examen"
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BOTÓN GUARDAR --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card-footer bg-white text-right">
                            <button type="button" class="btn btn-default mr-2" onclick="history.back()">
                                <i class="fas fa-times mr-1"></i> Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary" id="btnGuardar">
                                <i class="fas fa-save mr-1"></i> Guardar Antecedente
                            </button>
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
    .examen-item {
        transition: all 0.3s ease;
    }
    
    .examen-item:hover {
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .info-box {
        border-radius: 8px;
        margin-bottom: 10px;
    }
    
    .card-outline {
        border-top: 3px solid;
    }
    
    .custom-control-input:checked ~ .custom-control-label::before {
        border-color: #007bff;
        background-color: #007bff;
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 5px;
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Agregar nuevo examen
        $('#add-examen').click(function() {
            let examenHtml = `
            <div class="examen-item card card-light mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-stethoscope text-primary mr-1"></i> Nombre del examen</label>
                                <input type="text" name="examen_realizado[]" class="form-control" placeholder="Ej: Espermatograma" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-clock text-info mr-1"></i> Tiempo (meses)</label>
                                <input type="number" name="tiempo_meses[]" class="form-control" placeholder="Ej: 3" min="0">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-clipboard-check text-success mr-1"></i> Resultado</label>
                                <input type="text" name="resultado[]" class="form-control" placeholder="Ej: Normal">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label class="form-label text-white">-</label>
                                <button type="button" class="btn btn-danger btn-sm remove-examen" title="Eliminar examen">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
            $('#examenes-container').append(examenHtml);
        });

        // Eliminar examen
        $(document).on('click', '.remove-examen', function() {
            Swal.fire({
                title: '¿Está seguro?',
                text: "El examen será eliminado del formulario",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest('.examen-item').fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            });
        });

        // Validación de checkboxes exclusivos
        $('input[name="planificacion_si"], input[name="planificacion_no"], input[name="planificacion_no_responde"]').change(function() {
            if ($(this).is(':checked')) {
                $('input[name="planificacion_si"], input[name="planificacion_no"], input[name="planificacion_no_responde"]').not(this).prop('checked', false);
            }
        });

        // SweetAlert mensajes
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                timer: 2500,
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
                timer: 3000,
                showConfirmButton: true
            });
        @endif

        // Validación del formulario antes de enviar
        $('#antecedenteForm').on('submit', function(e) {
            let tieneExamenes = $('input[name="examen_realizado[]"]').filter(function() {
                return $(this).val().trim() !== '';
            }).length > 0;

            if (!tieneExamenes) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Debe agregar al menos un examen realizado',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }

            $('#btnGuardar').html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...').prop('disabled', true);
        });
    });

    // Evita que el navegador use su Back-Forward Cache (bfcache)
    window.addEventListener("pageshow", function (event) {
        if (event.persisted) {
            // Si la página fue cargada desde el caché de navegación
            window.location.reload();
        }
    });

    // Limpia los campos del formulario al cargar (opcional)
    window.onload = function() {
        if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
            // Limpia todos los inputs del formulario si se accedió con "Atrás"
            document.querySelectorAll("form input, form textarea, form select").forEach(el => {
                el.value = "";
                if (el.type === "checkbox" || el.type === "radio") el.checked = false;
            });
        }
    };
</script>
@stop