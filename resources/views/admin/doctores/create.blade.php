@extends('adminlte::page')

@section('title', 'Crear Nuevo Doctor')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-pastel-purple"><i class="fas fa-user-md mr-2"></i>Crear Nuevo Doctor</h1>
    <a href="{{ route('admin.doctores.index') }}" class="btn btn-pastel-gray">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Listado
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-pastel shadow-sm">
        <div class="card-header bg-pastel-blue text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-user-md mr-2"></i>Nuevo Doctor
            </h5>
            <span class="badge badge-pastel">Formulario de Registro</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.doctores.store') }}" method="POST" id="doctorForm">
                @csrf

                <div class="row">
                    {{-- Columna Izquierda --}}
                    <div class="col-md-6">
                        {{-- Primer Nombre --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-user text-pastel-blue mr-1"></i>
                                Primer Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="primer_nombre" id="primer_nombre" 
                                   class="form-control form-control-pastel uppercase-input @error('primer_nombre') is-invalid @enderror" 
                                   value="{{ old('primer_nombre') }}" 
                                   placeholder="Ingrese el primer nombre" required>
                            <small class="form-text text-muted">
                                Nombre principal del doctor
                            </small>
                            @error('primer_nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Segundo Nombre --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-user text-pastel-blue mr-1"></i>
                                Segundo Nombre
                            </label>
                            <input type="text" name="segundo_nombre" id="segundo_nombre" 
                                   class="form-control form-control-pastel uppercase-input @error('segundo_nombre') is-invalid @enderror" 
                                   value="{{ old('segundo_nombre') }}" 
                                   placeholder="Ingrese el segundo nombre (opcional)">
                            <small class="form-text text-muted">
                                Segundo nombre del doctor (opcional)
                            </small>
                            @error('segundo_nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Primer Apellido --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-id-card text-pastel-blue mr-1"></i>
                                Primer Apellido <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="primer_apellido" id="primer_apellido" 
                                   class="form-control form-control-pastel uppercase-input @error('primer_apellido') is-invalid @enderror" 
                                   value="{{ old('primer_apellido') }}" 
                                   placeholder="Ingrese el primer apellido" required>
                            <small class="form-text text-muted">
                                Apellido paterno del doctor
                            </small>
                            @error('primer_apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Segundo Apellido --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-id-card text-pastel-blue mr-1"></i>
                                Segundo Apellido
                            </label>
                            <input type="text" name="segundo_apellido" id="segundo_apellido" 
                                   class="form-control form-control-pastel uppercase-input @error('segundo_apellido') is-invalid @enderror" 
                                   value="{{ old('segundo_apellido') }}" 
                                   placeholder="Ingrese el segundo apellido (opcional)">
                            <small class="form-text text-muted">
                                Apellido materno del doctor (opcional)
                            </small>
                            @error('segundo_apellido')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Especialidad --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-stethoscope text-pastel-blue mr-1"></i>
                                Especialidad <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="especialidad" id="especialidad" 
                                   class="form-control form-control-pastel uppercase-input @error('especialidad') is-invalid @enderror" 
                                   value="{{ old('especialidad') }}" 
                                   placeholder="Ingrese la especialidad médica" required>
                            <small class="form-text text-muted">
                                Especialidad médica del doctor
                            </small>
                            @error('especialidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Columna Derecha --}}
                    <div class="col-md-6">
                        {{-- Número de Licencia --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-id-badge text-pastel-blue mr-1"></i>
                                Número de Licencia <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="numero_licencia" id="numero_licencia" 
                                   class="form-control form-control-pastel @error('numero_licencia') is-invalid @enderror" 
                                   value="{{ old('numero_licencia') }}" 
                                   placeholder="Número de licencia médica" required>
                            <small class="form-text text-muted">
                                Número único de licencia médica
                            </small>
                            @error('numero_licencia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-phone text-pastel-blue mr-1"></i>
                                Teléfono
                            </label>
                            <input type="text" name="telefono" id="telefono" 
                                   class="form-control form-control-pastel @error('telefono') is-invalid @enderror" 
                                   value="{{ old('telefono') }}" 
                                   placeholder="Número de teléfono">
                            <small class="form-text text-muted">
                                Número de contacto del doctor
                            </small>
                            @error('telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-envelope text-pastel-blue mr-1"></i>
                                Email
                            </label>
                            <input type="email" name="email" id="email" 
                                   class="form-control form-control-pastel @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" 
                                   placeholder="Correo electrónico">
                            <small class="form-text text-muted">
                                Correo electrónico del doctor
                            </small>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-map-marker-alt text-pastel-blue mr-1"></i>
                                Dirección
                            </label>
                            <textarea name="direccion" id="direccion" rows="3" 
                                      class="form-control form-control-pastel uppercase-input @error('direccion') is-invalid @enderror" 
                                      placeholder="Ingrese la dirección completa">{{ old('direccion') }}</textarea>
                            <small class="form-text text-muted">
                                Dirección de consultorio o residencia
                            </small>
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado Activo (Radio Buttons) --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-check-circle text-pastel-green mr-1"></i>
                                Estado del Doctor <span class="text-danger">*</span>
                            </label>
                            
                            <div class="d-flex align-items-center mt-2">
                                {{-- Opción Activo --}}
                                <div class="form-check form-check-inline mr-4">
                                    <input type="radio" name="activo" id="activo_si" value="1" 
                                           class="form-check-input estado-radio @error('activo') is-invalid @enderror"
                                           {{ old('activo', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center" for="activo_si">
                                        <span class="estado-badge estado-activo mr-2">
                                            <i class="fas fa-check-circle"></i>
                                        </span>
                                        <div>
                                            <strong class="text-success d-block">Activo</strong>
                                            <small class="text-muted">Disponible para consultas</small>
                                        </div>
                                    </label>
                                </div>
                                
                                {{-- Opción Inactivo --}}
                                <div class="form-check form-check-inline">
                                    <input type="radio" name="activo" id="activo_no" value="0" 
                                           class="form-check-input estado-radio @error('activo') is-invalid @enderror"
                                           {{ old('activo') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex align-items-center" for="activo_no">
                                        <span class="estado-badge estado-inactivo mr-2">
                                            <i class="fas fa-times-circle"></i>
                                        </span>
                                        <div>
                                            <strong class="text-danger d-block">Inactivo</strong>
                                            <small class="text-muted">No disponible</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <small class="form-text text-muted mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Estado actual del doctor en el sistema
                            </small>
                            
                            @error('activo')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de Registro --}}
                        <div class="form-group mb-4">
                            <label class="form-label">
                                <i class="fas fa-calendar-alt text-pastel-blue mr-1"></i>
                                Fecha de Registro
                            </label>
                            <input type="text" class="form-control form-control-pastel bg-pastel-light" 
                                   value="{{ date('d/m/Y') }}" readonly>
                            <small class="form-text text-muted">
                                Fecha actual del sistema
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Indicador de Estado --}}
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-pastel-info" id="estado-formulario">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Información:</strong> Complete los campos obligatorios (*) para registrar el nuevo doctor.
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
                                <a href="{{ route('admin.doctores.index') }}" class="btn btn-pastel-gray mr-2">
                                    <i class="fas fa-times mr-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-pastel-blue" id="btnGuardar">
                                    <i class="fas fa-save mr-1"></i> Guardar Doctor
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
    
    .uppercase-input {
        text-transform: uppercase;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    
    /* Estilos para los radio buttons de estado */
    .estado-radio {
        display: none;
    }
    
    .estado-badge {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        box-shadow: 0 3px 6px rgba(0,0,0,0.1);
    }
    
    .estado-activo {
        background-color: var(--pastel-green);
        color: #2e7d32;
        border: 3px solid #a5d6a7;
    }
    
    .estado-inactivo {
        background-color: var(--pastel-danger);
        color: #c62828;
        border: 3px solid #ef9a9a;
    }
    
    .form-check-label {
        cursor: pointer;
        padding: 10px 15px;
        border-radius: 10px;
        transition: all 0.3s ease;
        border: 2px solid transparent;
        margin: 5px;
    }
    
    .form-check-label:hover {
        background-color: rgba(168, 216, 234, 0.1);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    /* Cuando el radio está seleccionado */
    .estado-radio:checked + .form-check-label {
        border-color: var(--pastel-blue);
        background-color: rgba(168, 216, 234, 0.15);
        box-shadow: 0 5px 15px rgba(168, 216, 234, 0.2);
    }
    
    .estado-radio:checked + .form-check-label .estado-activo {
        border-color: #4caf50;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
        transform: scale(1.1);
    }
    
    .estado-radio:checked + .form-check-label .estado-inactivo {
        border-color: #f44336;
        box-shadow: 0 0 0 3px rgba(244, 67, 54, 0.2);
        transform: scale(1.1);
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Formatear teléfono mientras se escribe
        $('#telefono').on('input', function() { 
            this.value = this.value.replace(/[^0-9+\-() ]/g,''); 
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
            '#primer_nombre', 
            '#segundo_nombre',
            '#primer_apellido',
            '#segundo_apellido',
            '#especialidad',
            '#direccion'
        ];

        // Aplicar conversión a mayúsculas
        camposMayusculas.forEach(function(selector) {
            $(selector).on('input', convertirAMayusculas);
            
            // También aplicar al perder el foco
            $(selector).on('blur', function() {
                this.value = this.value.toUpperCase();
            });
        });

        // Limpiar formulario
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
                background: 'var(--pastel-light)'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#doctorForm')[0].reset();
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

        // Cambios en los campos principales
        $('#primer_nombre, #primer_apellido').on('input', function() {
            actualizarEstadoFormulario();
        });

        // Función para actualizar el estado visual
        function actualizarEstadoFormulario() {
            const primerNombre = $('#primer_nombre').val();
            const primerApellido = $('#primer_apellido').val();
            const especialidad = $('#especialidad').val();
            const licencia = $('#numero_licencia').val();
            const alertDiv = $('#estado-formulario');
            
            let message = '';
            let alertClass = 'alert-pastel-info';

            if (primerNombre && primerApellido && especialidad && licencia) {
                message = `<strong>Registrando:</strong> Dr. <strong>${primerNombre} ${primerApellido}</strong><br>
                          <small>Especialidad: ${especialidad} | Licencia: ${licencia}</small>`;
                alertClass = 'alert-pastel-success';
            } else {
                message = '<strong>Información:</strong> Complete los campos obligatorios (*) para registrar el nuevo doctor.';
                alertClass = 'alert-pastel-info';
            }
            
            alertDiv.removeClass().addClass(`alert ${alertClass}`);
            alertDiv.html(`<i class="fas fa-info-circle mr-2"></i>${message}`);
        }

        // Validación del formulario
        $('#doctorForm').on('submit', function(e) {
            e.preventDefault();
            
            const primerNombre = $('#primer_nombre').val();
            const primerApellido = $('#primer_apellido').val();
            const especialidad = $('#especialidad').val();
            const numeroLicencia = $('#numero_licencia').val();
            const email = $('#email').val();

            // Validar campos obligatorios
            if (!primerNombre || !primerApellido || !especialidad || !numeroLicencia) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos requeridos',
                    html: `<div class="text-start">
                          <p>Debe completar todos los campos obligatorios:</p>
                          <ul class="mb-0">
                          ${!primerNombre ? '<li><i class="fas fa-user text-danger mr-1"></i> Primer Nombre</li>' : ''}
                          ${!primerApellido ? '<li><i class="fas fa-id-card text-danger mr-1"></i> Primer Apellido</li>' : ''}
                          ${!especialidad ? '<li><i class="fas fa-stethoscope text-danger mr-1"></i> Especialidad</li>' : ''}
                          ${!numeroLicencia ? '<li><i class="fas fa-id-badge text-danger mr-1"></i> Número de Licencia</li>' : ''}
                          </ul>
                          </div>`,
                    confirmButtonText: 'Entendido',
                    background: 'var(--pastel-warning)',
                    confirmButtonColor: 'var(--pastel-blue)'
                });
                return false;
            }

            // Validar email si se ingresó
            if (email && !validateEmail(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Email inválido',
                    text: 'Por favor ingrese un email válido',
                    confirmButtonText: 'Corregir',
                    background: 'var(--pastel-light)',
                    confirmButtonColor: 'var(--pastel-blue)'
                });
                $('#email').focus();
                return false;
            }

            // Función para validar email
            function validateEmail(email) {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            }

            // Confirmar creación
            Swal.fire({
                title: '¿Crear nuevo doctor?',
                html: `<div class="text-center">
                      <i class="fas fa-user-md fa-3x text-pastel-blue mb-3"></i>
                      <p><strong>Dr. ${primerNombre} ${primerApellido}</strong></p>
                      <div class="text-muted small">
                      <p><i class="fas fa-stethoscope mr-1"></i> ${especialidad}</p>
                      <p><i class="fas fa-id-badge mr-1"></i> Licencia: ${numeroLicencia}</p>
                      </div>
                      </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'var(--pastel-blue)',
                cancelButtonColor: 'var(--pastel-gray)',
                confirmButtonText: '<i class="fas fa-save mr-1"></i> Sí, crear doctor',
                cancelButtonText: '<i class="fas fa-times mr-1"></i> Cancelar',
                background: 'var(--pastel-light)',
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
                    $('#doctorForm').off('submit').submit();
                }
            });
        });

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
                background: 'var(--pastel-light)'
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
                background: 'var(--pastel-light)'
            });
        @endif

        // Inicializar estado del formulario
        actualizarEstadoFormulario();
    });
</script>
@stop