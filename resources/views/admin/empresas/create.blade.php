@extends('adminlte::page')

@section('title', 'Crear Nueva Empresa')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-pastel-purple"><i class="fas fa-building mr-2"></i>Crear Nueva Empresa</h1>
    <a href="{{ route('admin.empresas.index') }}" class="btn btn-pastel-gray">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Listado
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-pastel shadow-sm">
        <div class="card-header bg-pastel-blue text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-building mr-2"></i>Nueva Empresa
            </h5>
            <span class="badge badge-pastel">Formulario de Registro</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.empresas.store') }}" method="POST" id="empresaForm">
                @csrf

                <div class="row">
                    {{-- Columna Izquierda --}}
                    <div class="col-md-6">
                        {{-- Nombre de la Empresa --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-building text-pastel-blue mr-1"></i>
                                Nombre de la Empresa <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nombre" id="nombre" class="form-control form-control-pastel uppercase-input @error('nombre') is-invalid @enderror" 
                                   value="{{ old('nombre') }}" placeholder="Ingrese el nombre completo de la empresa" required>
                            <small class="form-text text-muted">
                                Nombre legal completo de la empresa
                            </small>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- RUC --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-id-card text-pastel-blue mr-1"></i>
                                RUC <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="ruc" id="ruc" class="form-control form-control-pastel @error('ruc') is-invalid @enderror" 
                                   value="{{ old('ruc') }}" placeholder="Ingrese el RUC (10 a 13 dígitos)" minlength="10" maxlength="13" required>
                            <small class="form-text text-muted">
                                Registro Único de Contribuyentes (10-13 dígitos)
                            </small>
                            @error('ruc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Actividad Económica --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-briefcase text-pastel-blue mr-1"></i>
                                Actividad Económica <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="actividad_economica" id="actividad_economica" class="form-control form-control-pastel uppercase-input @error('actividad_economica') is-invalid @enderror" 
                                   value="{{ old('actividad_economica') }}" placeholder="Describa la actividad económica principal" required>
                            <small class="form-text text-muted">
                                Actividad económica principal de la empresa
                            </small>
                            @error('actividad_economica')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Código CIIU --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-code text-pastel-blue mr-1"></i>
                                Código CIIU
                            </label>
                            <input type="text" name="ciiu" id="ciiu" class="form-control form-control-pastel uppercase-input @error('ciiu') is-invalid @enderror" 
                                   value="{{ old('ciiu') }}" placeholder="Ingrese el código CIIU (opcional)">
                            <small class="form-text text-muted">
                                Clasificación Industrial Internacional Uniforme
                            </small>
                            @error('ciiu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Columna Derecha --}}
                    <div class="col-md-6">
                        {{-- Dirección --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt text-pastel-blue mr-1"></i>
                                Dirección <span class="text-danger">*</span>
                            </label>
                            <textarea name="direccion" id="direccion" rows="4" 
                                      class="form-control form-control-pastel uppercase-input @error('direccion') is-invalid @enderror" 
                                      placeholder="Ingrese la dirección completa" required>{{ old('direccion') }}</textarea>
                            <small class="form-text text-muted">
                                Dirección fiscal completa de la empresa
                            </small>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Representante Legal --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-user-tie text-pastel-blue mr-1"></i>
                                Representante Legal <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="representante_legal" id="representante_legal" class="form-control form-control-pastel uppercase-input @error('representante_legal') is-invalid @enderror" 
                                   value="{{ old('representante_legal') }}" placeholder="Nombre completo del representante legal" required>
                            <small class="form-text text-muted">
                                Nombre completo del representante legal autorizado
                            </small>
                            @error('representante_legal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado Activo --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-check-circle text-pastel-green mr-1"></i>
                                Estado de la Empresa <span class="text-danger">*</span>
                            </label>
                            
                            <div class="estado-selector d-flex">
                                {{-- Activa --}}
                                <div class="estado-option estado-activo me-3">
                                    <input type="radio" name="activo" id="activo_si" value="1" 
                                        class="estado-radio @error('activo') is-invalid @enderror"
                                        {{ old('activo', '1') == '1' ? 'checked' : '' }}>
                                    <label for="activo_si" class="estado-label">
                                        <div class="estado-circle">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div class="estado-info">
                                            <div class="estado-title">Activa</div>
                                            <div class="estado-desc">Operando</div>
                                        </div>
                                    </label>
                                </div>
                                
                                {{-- Inactiva --}}
                                <div class="estado-option estado-inactivo">
                                    <input type="radio" name="activo" id="activo_no" value="0" 
                                        class="estado-radio @error('activo') is-invalid @enderror"
                                        {{ old('activo') == '0' ? 'checked' : '' }}>
                                    <label for="activo_no" class="estado-label">
                                        <div class="estado-circle">
                                            <i class="fas fa-times"></i>
                                        </div>
                                        <div class="estado-info">
                                            <div class="estado-title">Inactiva</div>
                                            <div class="estado-desc">No operando</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Estado actual de la empresa en el sistema
                            </small>
                            
                            @error('activo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                       
                    </div>
                </div>

                {{-- Indicador de Estado --}}
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-pastel-info" id="estado-formulario">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Información:</strong> Complete los campos obligatorios (*) para registrar la nueva empresa.
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <button type="button" id="btnLimpiar" class="btn btn-pastel-gray">
                                <i class="fas fa-undo mr-1"></i> Limpiar Formulario
                            </button>
                            <div>
                                <a href="{{ route('admin.empresas.index') }}" class="btn btn-pastel-gray mr-2">
                                    <i class="fas fa-times mr-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-pastel-blue" id="btnGuardar">
                                    <i class="fas fa-save mr-1"></i> Guardar Empresa
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

    /* Estilos para selector de estado minimalista */
.estado-selector {
    display: flex;
    gap: 20px;
}

.estado-radio {
    display: none;
}

.estado-option {
    flex: 1;
}

.estado-label {
    display: flex;
    align-items: center;
    padding: 15px;
    border-radius: 12px;
    border: 2px solid #e0e0e0;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
}

.estado-label:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.estado-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-right: 15px;
    transition: all 0.3s ease;
}

.estado-activo .estado-circle {
    background-color: var(--pastel-green);
    color: #2e7d32;
}

.estado-inactivo .estado-circle {
    background-color: var(--pastel-danger);
    color: #c62828;
}

.estado-info {
    flex: 1;
}

.estado-title {
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 3px;
}

.estado-desc {
    font-size: 0.85rem;
    color: #7f8c8d;
}

/* Cuando está seleccionado */
.estado-radio:checked + .estado-label {
    border-color: var(--pastel-blue);
    background-color: rgba(168, 216, 234, 0.1);
    box-shadow: 0 5px 20px rgba(168, 216, 234, 0.2);
}

.estado-radio:checked + .estado-label .estado-circle {
    transform: scale(1.1);
    box-shadow: 0 3px 8px rgba(0,0,0,0.2);
}

/* Para mostrar error */
.is-invalid ~ .estado-label {
    border-color: #ff9aa2 !important;
}
    /* Paleta de colores pastel */
    :root {
        --pastel-blue: #A8D8EA;
        --pastel-purple: #CAB8FF;
        --pastel-green: #B6E2D3;
        --pastel-pink: #F8C8DC;
        --pastel-yellow: #FCE38A;
        --pastel-orange: #FFD3B6;
        --pastel-gray: #E3E3E3;
        --pastel-light: #F9F7F7;
        --pastel-info: #D3E4FD;
        --pastel-success: #D1F0D1;
        --pastel-warning: #FFF3CD;
        --pastel-danger: #F8D7DA;
    }
    
    .text-pastel-purple {
        color: var(--pastel-purple) !important;
    }
    
    .bg-pastel-blue {
        background-color: var(--pastel-blue) !important;
    }
    
    .bg-pastel-light {
        background-color: var(--pastel-light) !important;
    }
    
    .card-pastel {
        border: none;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }
    
    .card-header.bg-pastel-blue {
        border-radius: 15px 15px 0 0 !important;
        padding: 1.25rem 1.5rem;
    }
    
    .btn-pastel-blue {
        background: linear-gradient(135deg, var(--pastel-blue), #97c9db) !important;
        border: none !important;
        color: #2c3e50;
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(168, 216, 234, 0.3);
    }
    
    .btn-pastel-blue:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(168, 216, 234, 0.4);
        background: linear-gradient(135deg, #97c9db, var(--pastel-blue)) !important;
    }
    
    .btn-pastel-gray {
        background: linear-gradient(135deg, var(--pastel-gray), #d4d4d4) !important;
        border: none !important;
        color: #2c3e50;
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(227, 227, 227, 0.3);
    }
    
    .btn-pastel-gray:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(227, 227, 227, 0.4);
        background: linear-gradient(135deg, #d4d4d4, var(--pastel-gray)) !important;
    }
    
    .badge-pastel {
        background: var(--pastel-yellow);
        color: #2c3e50;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        box-shadow: 0 2px 4px rgba(252, 227, 138, 0.3);
    }
    
    .form-control-pastel {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
        background-color: white;
        padding: 12px 15px;
        font-size: 0.95rem;
    }
    
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 0 0.3rem rgba(168, 216, 234, 0.2);
        background-color: #f8fdff;
    }
    
    .form-label {
        font-weight: 600;
        color: #34495e;
        margin-bottom: 8px;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
    }
    
    .text-pastel-blue {
        color: var(--pastel-blue) !important;
    }
    
    .text-pastel-green {
        color: var(--pastel-green) !important;
    }
    
    .alert-pastel-info {
        background-color: var(--pastel-info);
        border: 2px solid #b8d4fa;
        color: #1a4a8f;
        border-radius: 10px;
        padding: 15px 20px;
        font-size: 0.95rem;
    }
    
    .alert-pastel-success {
        background-color: var(--pastel-success);
        border: 2px solid #a8e0a8;
        color: #1a5c1a;
        border-radius: 10px;
        padding: 15px 20px;
        font-size: 0.95rem;
    }
    
    .alert-pastel-warning {
        background-color: var(--pastel-warning);
        border: 2px solid #ffeeba;
        color: #856404;
        border-radius: 10px;
        padding: 15px 20px;
    }
    
    .is-invalid {
        border-color: #ff9aa2 !important;
        background-color: #fff9fa;
    }
    
    .is-invalid:focus {
        box-shadow: 0 0 0 0.3rem rgba(255, 154, 162, 0.2) !important;
    }
    
    .invalid-feedback {
        display: block;
        font-size: 0.85rem;
        color: #e74c3c;
        margin-top: 5px;
        font-weight: 500;
    }
    
    .card-body {
        background-color: #fdfdfd;
        padding: 2rem;
    }
    
    .text-muted {
        color: #7f8c8d !important;
        font-size: 0.85rem;
    }
    
    .uppercase-input {
        text-transform: uppercase;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    /* SweetAlert personalización */
    .swal2-popup {
        border-radius: 15px !important;
        background-color: #fdfdfd !important;
    }
    
    /* Estilo para los iconos en labels */
    .form-label i {
        width: 20px;
        text-align: center;
        margin-right: 8px;
        font-size: 1rem;
    }
    
    /* Animación suave para los campos */
    .form-group {
        transition: transform 0.3s ease;
    }
    
    .form-group:focus-within {
        transform: translateX(5px);
    }
    
    /* Estilo para textarea */
    textarea.form-control-pastel {
        min-height: 120px;
        resize: vertical;
    }
    
    /* Estilo para select */
    select.form-control-pastel {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23A8D8EA' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 15px center;
        background-size: 16px;
        padding-right: 40px;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem;
        }
        
        .btn-pastel-blue,
        .btn-pastel-gray {
            padding: 8px 20px;
            font-size: 0.9rem;
        }
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Solo números para RUC
        $('#ruc').on('input', function() { 
            this.value = this.value.replace(/[^0-9]/g,''); 
        });

        // Función para convertir a mayúsculas manteniendo la posición del cursor
        function convertirAMayusculas(event) {
            var start = this.selectionStart;
            var end = this.selectionEnd;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(start, end);
        }

        // Lista de campos que deben ser en mayúsculas
        var camposMayusculas = [
            '#nombre', 
            '#actividad_economica', 
            '#representante_legal', 
            '#direccion',
            '#ciiu'
        ];

        // Aplicar conversión a mayúsculas
        camposMayusculas.forEach(function(selector) {
            $(selector).on('input', convertirAMayusculas);
            
            // También aplicar al perder el foco
            $(selector).on('blur', function() {
                this.value = this.value.toUpperCase();
            });
            
            // Aplicar a valores existentes (en caso de error de validación)
            $(selector).val($(selector).val().toUpperCase());
        });

        // Limpiar formulario con SweetAlert
        $('#btnLimpiar').click(function() {
            Swal.fire({
                title: '¿Limpiar formulario?',
                html: `<div class="text-center">
                      <i class="fas fa-broom fa-3x text-pastel-blue mb-3"></i>
                      <p>Todos los datos ingresados serán eliminados</p>
                      </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'var(--pastel-blue)',
                cancelButtonColor: 'var(--pastel-gray)',
                confirmButtonText: 'Sí, limpiar',
                cancelButtonText: 'Cancelar',
                background: 'var(--pastel-light)',
                customClass: {
                    confirmButton: 'btn-pastel-blue',
                    cancelButton: 'btn-pastel-gray'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#empresaForm')[0].reset();
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    actualizarEstadoFormulario();
                    
                    Swal.fire({
                        icon: 'success', 
                        title: '¡Formulario limpiado!', 
                        text: 'Todos los campos han sido restablecidos',
                        timer: 1500, 
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        background: 'var(--pastel-success)',
                        iconColor: 'var(--pastel-green)'
                    });
                }
            });
        });

        // Validación del formulario
        $('#empresaForm').on('submit', function(e) {
            e.preventDefault();
            
            const nombre = $('#nombre').val();
            const ruc = $('#ruc').val();
            const actividad = $('#actividad_economica').val();
            const direccion = $('#direccion').val();
            const representante = $('#representante_legal').val();

            // Validar campos obligatorios
            if (!nombre || !ruc || !actividad || !direccion || !representante) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos requeridos',
                    html: `<div class="text-start">
                          <p>Debe completar todos los campos obligatorios:</p>
                          <ul class="mb-0">
                          ${!nombre ? '<li><i class="fas fa-building text-danger mr-1"></i> Nombre de la Empresa</li>' : ''}
                          ${!ruc ? '<li><i class="fas fa-id-card text-danger mr-1"></i> RUC</li>' : ''}
                          ${!actividad ? '<li><i class="fas fa-briefcase text-danger mr-1"></i> Actividad Económica</li>' : ''}
                          ${!direccion ? '<li><i class="fas fa-map-marker-alt text-danger mr-1"></i> Dirección</li>' : ''}
                          ${!representante ? '<li><i class="fas fa-user-tie text-danger mr-1"></i> Representante Legal</li>' : ''}
                          </ul>
                          </div>`,
                    confirmButtonText: 'Entendido',
                    background: 'var(--pastel-warning)',
                    confirmButtonColor: 'var(--pastel-blue)',
                    customClass: {
                        confirmButton: 'btn-pastel-blue'
                    }
                });
                return false;
            }

            // Validar longitud del RUC
            if (ruc.length < 10 || ruc.length > 13) {
                Swal.fire({
                    icon: 'error',
                    title: 'RUC inválido',
                    text: 'El RUC debe contener entre 10 y 13 dígitos',
                    confirmButtonText: 'Corregir',
                    background: 'var(--pastel-light)',
                    confirmButtonColor: 'var(--pastel-blue)'
                });
                $('#ruc').focus();
                return false;
            }

            // Confirmar creación
            Swal.fire({
                title: '¿Crear nueva empresa?',
                html: `<div class="text-center">
                      <i class="fas fa-building fa-3x text-pastel-blue mb-3"></i>
                      <p><strong>${nombre}</strong></p>
                      <div class="text-muted small">
                      <p><i class="fas fa-id-card mr-1"></i> RUC: ${ruc}</p>
                      <p><i class="fas fa-user-tie mr-1"></i> Representante: ${representante}</p>
                      </div>
                      </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'var(--pastel-blue)',
                cancelButtonColor: 'var(--pastel-gray)',
                confirmButtonText: '<i class="fas fa-save mr-1"></i> Sí, crear empresa',
                cancelButtonText: '<i class="fas fa-times mr-1"></i> Cancelar',
                background: 'var(--pastel-light)',
                customClass: {
                    confirmButton: 'btn-pastel-blue',
                    cancelButton: 'btn-pastel-gray'
                },
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
                    // Asegurar que todo esté en mayúsculas antes de enviar
                    camposMayusculas.forEach(function(selector) {
                        var campo = $(selector);
                        campo.val(campo.val().toUpperCase());
                    });
                    
                    $('#btnGuardar').html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...').prop('disabled', true);
                    $('#empresaForm').off('submit').submit();
                }
            });
        });

        // Cambios en los campos principales
        $('#nombre, #ruc').on('input', function() {
            actualizarEstadoFormulario();
        });

        // Función para actualizar el estado visual
        function actualizarEstadoFormulario() {
            const nombre = $('#nombre').val();
            const ruc = $('#ruc').val();
            const alertDiv = $('#estado-formulario');
            
            let message = '';
            let alertClass = 'alert-pastel-info';

            if (nombre && ruc) {
                message = `<strong>Registrando:</strong> Se creará la empresa <strong>${nombre}</strong> con RUC: <strong>${ruc}</strong>.`;
                alertClass = 'alert-pastel-success';
            } else {
                message = '<strong>Información:</strong> Complete los campos obligatorios (*) para registrar la nueva empresa.';
                alertClass = 'alert-pastel-info';
            }
            
            alertDiv.removeClass().addClass(`alert ${alertClass}`);
            alertDiv.html(`<i class="fas fa-info-circle mr-2"></i>${message}`);
        }

        // SweetAlert para errores de validación
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Errores en el formulario',
                html: `@foreach($errors->all() as $error)
                      <div class="text-start mb-2">
                      <i class="fas fa-exclamation-circle text-danger mr-2"></i>
                      {{ $error }}
                      </div>
                      @endforeach`,
                confirmButtonColor: 'var(--pastel-blue)',
                confirmButtonText: 'Entendido',
                background: 'var(--pastel-light)',
                customClass: {
                    confirmButton: 'btn-pastel-blue'
                }
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
                toast: true,
                background: 'var(--pastel-success)',
                iconColor: 'var(--pastel-green)'
            });
        @endif

        // SweetAlert para error
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: '{{ session('error') }}',
                confirmButtonColor: 'var(--pastel-blue)',
                confirmButtonText: 'Entendido',
                background: 'var(--pastel-light)',
                customClass: {
                    confirmButton: 'btn-pastel-blue'
                }
            });
        @endif

        // Inicializar estado del formulario
        actualizarEstadoFormulario();
        
        // Efecto hover en botones
        $('.btn').hover(
            function() {
                if (!$(this).prop('disabled')) {
                    $(this).css('transform', 'translateY(-2px)');
                }
            },
            function() {
                $(this).css('transform', 'translateY(0)');
            }
        );
        
        // Tooltips para los iconos
        $('[title]').tooltip({
            trigger: 'hover',
            placement: 'top',
            animation: true
        });
    });
</script>
@stop