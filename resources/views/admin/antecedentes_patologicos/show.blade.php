@extends('adminlte::page')

@section('title', 'Antecedentes Patológicos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-primary"><i class="fas fa-notes-medical mr-2"></i>Antecedentes Patológicos</h1>
    <a href="{{ route('admin.registros.show', $registro->id) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    {{-- 🔹 CARD con información del paciente y registro --}}
    <div class="card card-info shadow-sm mb-4">
        <div class="card-header bg-info text-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-user mr-2"></i>Información General del Registro
            </h5>
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

    {{-- 🔹 FORMULARIO --}}
    <div class="card card-primary shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-notes-medical mr-2"></i>Registrar Antecedentes Patológicos
            </h5>
            <span class="badge badge-light">Paso 1 de 3</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.antecedentes_patologicos.store') }}" method="POST" id="antecedentesForm">
                @csrf
                <input type="hidden" name="registro_id" value="{{ $registro->id }}">

                <div class="row">
                    {{-- Antecedentes Clínicos y Quirúrgicos --}}
                    <div class="col-12">
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-stethoscope text-primary mr-1"></i>
                                Antecedentes Clínicos y Quirúrgicos
                            </label>
                            <textarea name="antecedente_app" class="form-control @error('antecedente_app') is-invalid @enderror" 
                                      rows="4" placeholder="Describa los antecedentes clínicos y quirúrgicos relevantes del paciente...">{{ old('antecedente_app') }}</textarea>
                            <small class="form-text text-muted">
                                Enfermedades previas, cirugías, hospitalizaciones, tratamientos médicos importantes
                            </small>
                            @error('antecedente_app')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Antecedentes Familiares --}}
                    <div class="col-12">
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-users text-primary mr-1"></i>
                                Antecedentes Familiares
                            </label>
                            <textarea name="antecedente_apqx" class="form-control @error('antecedente_apqx') is-invalid @enderror" 
                                      rows="4" placeholder="Describa los antecedentes médicos familiares relevantes...">{{ old('antecedente_apqx') }}</textarea>
                            <small class="form-text text-muted">
                                Enfermedades hereditarias, condiciones médicas en familiares directos
                            </small>
                            @error('antecedente_apqx')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Autorización de Transfusiones --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-tint text-danger mr-1"></i>
                                ¿Autoriza Transfusiones?
                            </label>
                            <select name="autoriza_transfusiones" class="form-control @error('autoriza_transfusiones') is-invalid @enderror">
                                <option value="">-- Seleccione una opción --</option>
                                <option value="1" {{ old('autoriza_transfusiones') == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ old('autoriza_transfusiones') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            <small class="form-text text-muted">
                                Consentimiento para transfusiones sanguíneas en caso de emergencia
                            </small>
                            @error('autoriza_transfusiones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Tratamiento Hormonal --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-pills text-warning mr-1"></i>
                                ¿Está bajo Tratamiento Hormonal?
                            </label>
                            <select id="tratamiento_hormonal_si_no" name="tratamiento_hormonal_si_no" 
                                    class="form-control @error('tratamiento_hormonal_si_no') is-invalid @enderror">
                                <option value="">-- Seleccione una opción --</option>
                                <option value="1" {{ old('tratamiento_hormonal_si_no') == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ old('tratamiento_hormonal_si_no') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                            <small class="form-text text-muted">
                                Uso actual de terapia hormonal o anticonceptivos
                            </small>
                            @error('tratamiento_hormonal_si_no')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Descripción del Tratamiento Hormonal (condicional) --}}
                <div id="descripcion_tratamiento" class="row" style="display: none;">
                    <div class="col-12">
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-file-medical-alt text-info mr-1"></i>
                                Descripción del Tratamiento Hormonal
                            </label>
                            <textarea name="tratamiento_hormonal_descripcion" class="form-control @error('tratamiento_hormonal_descripcion') is-invalid @enderror" 
                                      rows="3" placeholder="Especifique el tipo de tratamiento hormonal, dosis, frecuencia...">{{ old('tratamiento_hormonal_descripcion') }}</textarea>
                            <small class="form-text text-muted">
                                Detalle del tratamiento hormonal actual
                            </small>
                            @error('tratamiento_hormonal_descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Indicador de Estado --}}
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-info" id="estado-formulario">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Información:</strong> Complete los antecedentes patológicos del paciente. Los campos marcados con (*) son obligatorios.
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.registros.show', $registro->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary" id="btnGuardar">
                                <i class="fas fa-save mr-1"></i> Guardar y Continuar
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
    
    .form-control:focus {
        border-color: #52B1CB;
        box-shadow: 0 0 0 0.2rem rgba(82, 177, 203, 0.25);
    }
    
    .btn-primary {
        background-color: #52B1CB !important;
        border-color: #52B1CB !important;
    }
    
    .btn-primary:hover {
        background-color: #4294ac !important;
        border-color: #4294ac !important;
    }
    
    .is-invalid {
        border-color: #dc3545;
    }
    
    .invalid-feedback {
        display: block;
        font-size: 0.875em;
    }
    
    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Mostrar u ocultar el campo de descripción según la selección
        $('#tratamiento_hormonal_si_no').change(function() {
            const descripcionDiv = $('#descripcion_tratamiento');
            if (this.value == '1') {
                descripcionDiv.slideDown(300);
            } else {
                descripcionDiv.slideUp(300);
            }
        });

        // Inicializar estado del campo de descripción
        if ($('#tratamiento_hormonal_si_no').val() == '1') {
            $('#descripcion_tratamiento').show();
        }

        // Validación del formulario
        $('#antecedentesForm').on('submit', function(e) {
            e.preventDefault();
            
            const tratamientoHormonal = $('#tratamiento_hormonal_si_no').val();
            const descripcionTratamiento = $('textarea[name="tratamiento_hormonal_descripcion"]').val();

            // Validar que si seleccionó "Sí" en tratamiento hormonal, complete la descripción
            if (tratamientoHormonal == '1' && !descripcionTratamiento.trim()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Descripción requerida',
                    text: 'Debe describir el tratamiento hormonal cuando selecciona "Sí"',
                    confirmButtonText: 'Entendido'
                });
                return false;
            }

            Swal.fire({
                title: '¿Guardar antecedentes patológicos?',
                html: `Se registrarán los antecedentes patológicos para:<br>
                      <strong>{{ $registro->paciente->primer_nombre }} {{ $registro->paciente->primer_apellido }}</strong><br>
                      <small class="text-muted">Registro #{{ $registro->id }}</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#52B1CB',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, guardar',
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
                    $('#btnGuardar').html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...').prop('disabled', true);
                    $('#antecedentesForm').off('submit').submit();
                }
            });
        });

        // Cambios en los campos
        $('textarea, select').on('input change', function() {
            actualizarEstadoFormulario();
        });

        // Función para actualizar el estado visual
        function actualizarEstadoFormulario() {
            const antecedentesApp = $('textarea[name="antecedente_app"]').val();
            const antecedentesApqx = $('textarea[name="antecedente_apqx"]').val();
            const alertDiv = $('#estado-formulario');
            
            let message = '';
            let alertClass = 'alert-info';

            if (antecedentesApp || antecedentesApqx) {
                message = `<strong>Registrando Antecedentes:</strong> Se guardarán los antecedentes patológicos del paciente.`;
                alertClass = 'alert-success';
            } else {
                message = '<strong>Información:</strong> Complete los antecedentes patológicos del paciente. Los campos marcados con (*) son obligatorios.';
                alertClass = 'alert-info';
            }
            
            alertDiv.removeClass().addClass(`alert ${alertClass}`);
            alertDiv.html(`<i class="fas fa-info-circle mr-2"></i>${message}`);
        }

        // SweetAlert para errores
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Errores en el formulario',
                html: `@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach`,
                confirmButtonColor: '#52B1CB',
                confirmButtonText: 'Entendido'
            });
        @endif

        // SweetAlert para éxito
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

        // Inicializar estado del formulario
        actualizarEstadoFormulario();
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