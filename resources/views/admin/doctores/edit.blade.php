@extends('adminlte::page')

@section('title', 'Editar Doctor')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-pastel-purple"><i class="fas fa-user-edit mr-2"></i>Editar Doctor</h1>
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
                <i class="fas fa-user-md mr-2"></i>Editar Doctor: <span class="text-white">Dr. {{ $doctor->primer_nombre }} {{ $doctor->primer_apellido }}</span>
            </h5>
            <span class="badge badge-pastel">
                <i class="fas fa-id-badge mr-1"></i> Licencia: {{ $doctor->numero_licencia }}
            </span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.doctores.update', $doctor) }}" method="POST" id="doctorForm">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Información Personal --}}
                    <div class="col-md-6">
                        <div class="card mb-4 bg-pastel-light border-0">
                            <div class="card-header bg-pastel-purple text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-user-circle mr-2"></i>Información Personal</h6>
                            </div>
                            <div class="card-body">
                                {{-- Primer Nombre --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-user text-pastel-purple mr-1"></i>
                                        Primer Nombre <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="primer_nombre" id="primer_nombre" 
                                           class="form-control form-control-pastel uppercase-input @error('primer_nombre') is-invalid @enderror" 
                                           value="{{ old('primer_nombre', $doctor->primer_nombre) }}" 
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
                                        <i class="fas fa-user text-pastel-purple mr-1"></i>
                                        Segundo Nombre
                                    </label>
                                    <input type="text" name="segundo_nombre" id="segundo_nombre" 
                                           class="form-control form-control-pastel uppercase-input @error('segundo_nombre') is-invalid @enderror" 
                                           value="{{ old('segundo_nombre', $doctor->segundo_nombre) }}" 
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
                                        <i class="fas fa-id-card text-pastel-purple mr-1"></i>
                                        Primer Apellido <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="primer_apellido" id="primer_apellido" 
                                           class="form-control form-control-pastel uppercase-input @error('primer_apellido') is-invalid @enderror" 
                                           value="{{ old('primer_apellido', $doctor->primer_apellido) }}" 
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
                                        <i class="fas fa-id-card text-pastel-purple mr-1"></i>
                                        Segundo Apellido
                                    </label>
                                    <input type="text" name="segundo_apellido" id="segundo_apellido" 
                                           class="form-control form-control-pastel uppercase-input @error('segundo_apellido') is-invalid @enderror" 
                                           value="{{ old('segundo_apellido', $doctor->segundo_apellido) }}" 
                                           placeholder="Ingrese el segundo apellido (opcional)">
                                    <small class="form-text text-muted">
                                        Apellido materno del doctor (opcional)
                                    </small>
                                    @error('segundo_apellido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Información Profesional --}}
                        <div class="card mb-4 bg-pastel-light border-0">
                            <div class="card-header bg-pastel-green text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-stethoscope mr-2"></i>Información Profesional</h6>
                            </div>
                            <div class="card-body">
                                {{-- Especialidad --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-stethoscope text-pastel-green mr-1"></i>
                                        Especialidad <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="especialidad" id="especialidad" 
                                           class="form-control form-control-pastel uppercase-input @error('especialidad') is-invalid @enderror" 
                                           value="{{ old('especialidad', $doctor->especialidad) }}" 
                                           placeholder="Ingrese la especialidad médica" required>
                                    <small class="form-text text-muted">
                                        Especialidad médica del doctor
                                    </small>
                                    @error('especialidad')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Número de Licencia --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-id-badge text-pastel-green mr-1"></i>
                                        Número de Licencia <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="numero_licencia" id="numero_licencia" 
                                           class="form-control form-control-pastel @error('numero_licencia') is-invalid @enderror" 
                                           value="{{ old('numero_licencia', $doctor->numero_licencia) }}" 
                                           placeholder="Número de licencia médica" required>
                                    <small class="form-text text-muted">
                                        Número único de licencia médica
                                    </small>
                                    @error('numero_licencia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Información de Contacto y Estado --}}
                    <div class="col-md-6">
                        <div class="card mb-4 bg-pastel-light border-0">
                            <div class="card-header bg-pastel-pink text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-address-card mr-2"></i>Información de Contacto</h6>
                            </div>
                            <div class="card-body">
                                {{-- Teléfono --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-phone text-pastel-pink mr-1"></i>
                                        Teléfono
                                    </label>
                                    <input type="text" name="telefono" id="telefono" 
                                           class="form-control form-control-pastel @error('telefono') is-invalid @enderror" 
                                           value="{{ old('telefono', $doctor->telefono) }}" 
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
                                        <i class="fas fa-envelope text-pastel-pink mr-1"></i>
                                        Email
                                    </label>
                                    <input type="email" name="email" id="email" 
                                           class="form-control form-control-pastel @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $doctor->email) }}" 
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
                                        <i class="fas fa-map-marker-alt text-pastel-pink mr-1"></i>
                                        Dirección
                                    </label>
                                    <textarea name="direccion" id="direccion" rows="3" 
                                              class="form-control form-control-pastel uppercase-input @error('direccion') is-invalid @enderror" 
                                              placeholder="Ingrese la dirección completa">{{ old('direccion', $doctor->direccion) }}</textarea>
                                    <small class="form-text text-muted">
                                        Dirección de consultorio o residencia
                                    </small>
                                    @error('direccion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Fecha de Registro --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-alt text-pastel-pink mr-1"></i>
                                        Fecha de Registro
                                    </label>
                                    <input type="text" class="form-control form-control-pastel bg-pastel-light" 
                                           value="{{ $doctor->created_at->format('d/m/Y H:i') }}" readonly>
                                    <small class="form-text text-muted">
                                        Fecha de creación en el sistema
                                    </small>
                                </div>

                                {{-- Última Actualización --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-history text-pastel-pink mr-1"></i>
                                        Última Actualización
                                    </label>
                                    <input type="text" class="form-control form-control-pastel bg-pastel-light" 
                                           value="{{ $doctor->updated_at->format('d/m/Y H:i') }}" readonly>
                                    <small class="form-text text-muted">
                                        Fecha de la última modificación
                                    </small>
                                </div>
                            </div>
                        </div>

                        {{-- Estado del Doctor --}}
                        <div class="card mb-4 bg-pastel-light border-0">
                            <div class="card-header bg-pastel-orange text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-toggle-on mr-2"></i>Estado del Doctor</h6>
                            </div>
                            <div class="card-body">
                                {{-- Estado Activo (Radio Buttons) --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-check-circle text-pastel-orange mr-1"></i>
                                        Estado <span class="text-danger">*</span>
                                    </label>
                                    
                                    <div class="d-flex align-items-center mt-2">
                                        {{-- Opción Activo --}}
                                        <div class="form-check form-check-inline mr-4">
                                            <input type="radio" name="activo" id="activo_si" value="1" 
                                                   class="form-check-input estado-radio @error('activo') is-invalid @enderror"
                                                   {{ old('activo', $doctor->activo) == '1' ? 'checked' : '' }}>
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
                                                   {{ old('activo', $doctor->activo) == '0' ? 'checked' : '' }}>
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

                                {{-- Información Actual --}}
                                <div class="alert alert-pastel-info mt-3">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Información actual:</strong>
                                    <div class="small mt-2">
                                        <div><strong>Doctor:</strong> Dr. {{ $doctor->primer_nombre }} {{ $doctor->primer_apellido }}</div>
                                        <div><strong>Especialidad:</strong> {{ $doctor->especialidad }}</div>
                                        <div><strong>Estado:</strong> 
                                            <span class="badge {{ $doctor->activo ? 'badge-pastel-green' : 'badge-pastel-red' }}">
                                                {{ $doctor->activo ? 'ACTIVO' : 'INACTIVO' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Resumen de Cambios --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-pastel-light border-0">
                            <div class="card-header bg-pastel-yellow text-dark py-2">
                                <h6 class="mb-0"><i class="fas fa-clipboard-list mr-2"></i>Resumen de Cambios</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="alert alert-pastel-warning mb-3">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            <strong>Cambios detectados:</strong>
                                            <ul class="mb-0 mt-2" id="lista-cambios">
                                                <li>Modificación de datos del doctor</li>
                                                <li>Actualización de fecha de modificación</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-pastel-success">
                                            <i class="fas fa-user-md mr-2"></i>
                                            <strong>Doctor a actualizar:</strong>
                                            <div class="small mt-2">
                                                <div><strong>ID:</strong> {{ $doctor->id }}</div>
                                                <div><strong>Nombre completo:</strong> {{ $doctor->primer_nombre }} {{ $doctor->primer_apellido }}</div>
                                                <div><strong>Licencia:</strong> {{ $doctor->numero_licencia }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Indicador de Estado --}}
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="alert alert-pastel-info" id="estado-formulario">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Información:</strong> Modifique los campos que desea actualizar. Los cambios se guardarán al enviar el formulario.
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="button" id="btnRestaurar" class="btn btn-pastel-orange mr-2">
                                    <i class="fas fa-undo mr-1"></i> Restaurar Valores
                                </button>
                                <a href="{{ route('admin.doctores.show', $doctor) }}" class="btn btn-pastel-info">
                                    <i class="fas fa-eye mr-1"></i> Ver Detalles
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('admin.doctores.index') }}" class="btn btn-pastel-gray mr-2">
                                    <i class="fas fa-times mr-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-pastel-blue" id="btnGuardar">
                                    <i class="fas fa-save mr-1"></i> Actualizar Doctor
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
    /* Extender la paleta de colores pastel */
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
    
    .bg-pastel-green {
        background-color: var(--pastel-green) !important;
    }
    
    .bg-pastel-purple {
        background-color: var(--pastel-purple) !important;
    }
    
    .bg-pastel-pink {
        background-color: var(--pastel-pink) !important;
    }
    
    .bg-pastel-yellow {
        background-color: var(--pastel-yellow) !important;
    }
    
    .bg-pastel-orange {
        background-color: var(--pastel-orange) !important;
    }
    
    .bg-pastel-info {
        background-color: var(--pastel-info) !important;
    }
    
    .bg-pastel-light {
        background-color: var(--pastel-light) !important;
    }
    
    /* Botones adicionales */
    .btn-pastel-orange {
        background: linear-gradient(135deg, var(--pastel-orange), #ffc8a3) !important;
        border: none !important;
        color: #2c3e50;
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(255, 211, 182, 0.3);
    }
    
    .btn-pastel-orange:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(255, 211, 182, 0.4);
        background: linear-gradient(135deg, #ffc8a3, var(--pastel-orange)) !important;
    }
    
    .btn-pastel-info {
        background: linear-gradient(135deg, var(--pastel-info), #b8d4fa) !important;
        border: none !important;
        color: #2c3e50;
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(211, 228, 253, 0.3);
    }
    
    .btn-pastel-info:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(211, 228, 253, 0.4);
        background: linear-gradient(135deg, #b8d4fa, var(--pastel-info)) !important;
    }
    
    /* Badges */
    .badge-pastel-green {
        background-color: var(--pastel-green) !important;
        color: #2e7d32 !important;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .badge-pastel-red {
        background-color: var(--pastel-danger) !important;
        color: #c62828 !important;
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
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
    
    /* Alertas mejoradas */
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
    
    /* Cards internas */
    .card .card-header {
        border-radius: 8px 8px 0 0 !important;
        font-weight: 600;
        font-size: 0.95rem;
    }
    
    .card .card-body {
        background-color: white;
    }
    
    /* Campos de solo lectura */
    .form-control[readonly] {
        background-color: var(--pastel-light) !important;
        border-color: #e9ecef;
        cursor: not-allowed;
    }
    
    /* Lista de cambios */
    #lista-cambios {
        padding-left: 20px;
        margin-top: 10px;
    }
    
    #lista-cambios li {
        margin-bottom: 5px;
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Valores originales para restaurar
        const valoresOriginales = {
            primer_nombre: $('#primer_nombre').val(),
            segundo_nombre: $('#segundo_nombre').val(),
            primer_apellido: $('#primer_apellido').val(),
            segundo_apellido: $('#segundo_apellido').val(),
            especialidad: $('#especialidad').val(),
            numero_licencia: $('#numero_licencia').val(),
            telefono: $('#telefono').val(),
            email: $('#email').val(),
            direccion: $('#direccion').val(),
            activo: $('input[name="activo"]:checked').val()
        };

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
            
            // Aplicar a valores existentes
            $(selector).val($(selector).val().toUpperCase());
        });

        // Restaurar valores originales
        $('#btnRestaurar').click(function() {
            Swal.fire({
                title: '¿Restaurar valores originales?',
                html: `<div class="text-center">
                      <i class="fas fa-undo fa-3x text-pastel-orange mb-3"></i>
                      <p>Todos los cambios no guardados se perderán</p>
                      </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'var(--pastel-orange)',
                cancelButtonColor: 'var(--pastel-gray)',
                confirmButtonText: 'Sí, restaurar',
                cancelButtonText: 'Cancelar',
                background: 'var(--pastel-light)'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#primer_nombre').val(valoresOriginales.primer_nombre);
                    $('#segundo_nombre').val(valoresOriginales.segundo_nombre);
                    $('#primer_apellido').val(valoresOriginales.primer_apellido);
                    $('#segundo_apellido').val(valoresOriginales.segundo_apellido);
                    $('#especialidad').val(valoresOriginales.especialidad);
                    $('#numero_licencia').val(valoresOriginales.numero_licencia);
                    $('#telefono').val(valoresOriginales.telefono);
                    $('#email').val(valoresOriginales.email);
                    $('#direccion').val(valoresOriginales.direccion);
                    
                    // Restaurar estado
                    $(`input[name="activo"][value="${valoresOriginales.activo}"]`).prop('checked', true);
                    
                    // Aplicar mayúsculas
                    camposMayusculas.forEach(function(selector) {
                        $(selector).val($(selector).val().toUpperCase());
                    });
                    
                    // Limpiar errores
                    $('.is-invalid').removeClass('is-invalid');
                    $('.invalid-feedback').remove();
                    
                    Swal.fire({
                        icon: 'success', 
                        title: '¡Valores restaurados!', 
                        text: 'Se han restaurado los valores originales',
                        timer: 1500, 
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                        background: 'var(--pastel-success)',
                        iconColor: 'var(--pastel-green)'
                    });
                    
                    actualizarEstadoFormulario();
                    actualizarListaCambios();
                }
            });
        });

        // Detectar cambios en los campos
        $('input, textarea').on('change keyup', function() {
            actualizarEstadoFormulario();
            actualizarListaCambios();
        });

        // Función para actualizar el estado visual
        function actualizarEstadoFormulario() {
            const alertDiv = $('#estado-formulario');
            
            let cambios = false;
            
            // Verificar si hay cambios
            if ($('#primer_nombre').val() !== valoresOriginales.primer_nombre) cambios = true;
            else if ($('#segundo_nombre').val() !== valoresOriginales.segundo_nombre) cambios = true;
            else if ($('#primer_apellido').val() !== valoresOriginales.primer_apellido) cambios = true;
            else if ($('#segundo_apellido').val() !== valoresOriginales.segundo_apellido) cambios = true;
            else if ($('#especialidad').val() !== valoresOriginales.especialidad) cambios = true;
            else if ($('#numero_licencia').val() !== valoresOriginales.numero_licencia) cambios = true;
            else if ($('#telefono').val() !== valoresOriginales.telefono) cambios = true;
            else if ($('#email').val() !== valoresOriginales.email) cambios = true;
            else if ($('#direccion').val() !== valoresOriginales.direccion) cambios = true;
            else if ($('input[name="activo"]:checked').val() !== valoresOriginales.activo) cambios = true;
            
            if (cambios) {
                alertDiv.removeClass().addClass('alert alert-pastel-warning');
                alertDiv.html('<i class="fas fa-exclamation-triangle mr-2"></i>' +
                    '<strong>¡Hay cambios pendientes!</strong> Los campos modificados están listos para guardar.');
            } else {
                alertDiv.removeClass().addClass('alert alert-pastel-info');
                alertDiv.html('<i class="fas fa-info-circle mr-2"></i>' +
                    '<strong>Información:</strong> Modifique los campos que desea actualizar. Los cambios se guardarán al enviar el formulario.');
            }
        }

        // Función para actualizar la lista de cambios
        function actualizarListaCambios() {
            const lista = $('#lista-cambios');
            lista.empty();
            
            if ($('#primer_nombre').val() !== valoresOriginales.primer_nombre) {
                lista.append('<li><i class="fas fa-user text-primary mr-1"></i> Cambio en primer nombre</li>');
            }
            if ($('#segundo_nombre').val() !== valoresOriginales.segundo_nombre) {
                lista.append('<li><i class="fas fa-user text-primary mr-1"></i> Cambio en segundo nombre</li>');
            }
            if ($('#primer_apellido').val() !== valoresOriginales.primer_apellido) {
                lista.append('<li><i class="fas fa-id-card text-primary mr-1"></i> Cambio en primer apellido</li>');
            }
            if ($('#segundo_apellido').val() !== valoresOriginales.segundo_apellido) {
                lista.append('<li><i class="fas fa-id-card text-primary mr-1"></i> Cambio en segundo apellido</li>');
            }
            if ($('#especialidad').val() !== valoresOriginales.especialidad) {
                lista.append('<li><i class="fas fa-stethoscope text-primary mr-1"></i> Cambio en especialidad</li>');
            }
            if ($('#numero_licencia').val() !== valoresOriginales.numero_licencia) {
                lista.append('<li><i class="fas fa-id-badge text-primary mr-1"></i> Cambio en número de licencia</li>');
            }
            if ($('#telefono').val() !== valoresOriginales.telefono) {
                lista.append('<li><i class="fas fa-phone text-primary mr-1"></i> Cambio en teléfono</li>');
            }
            if ($('#email').val() !== valoresOriginales.email) {
                lista.append('<li><i class="fas fa-envelope text-primary mr-1"></i> Cambio en email</li>');
            }
            if ($('#direccion').val() !== valoresOriginales.direccion) {
                lista.append('<li><i class="fas fa-map-marker-alt text-primary mr-1"></i> Cambio en dirección</li>');
            }
            if ($('input[name="activo"]:checked').val() !== valoresOriginales.activo) {
                const nuevoEstado = $('input[name="activo"]:checked').val() == '1' ? 'Activo' : 'Inactivo';
                lista.append(`<li><i class="fas fa-toggle-on text-primary mr-1"></i> Cambio de estado a: ${nuevoEstado}</li>`);
            }
            
            if (lista.children().length === 0) {
                lista.append('<li>Sin cambios detectados</li>');
                lista.append('<li>Actualización de fecha de modificación</li>');
            }
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

            // Confirmar actualización
            Swal.fire({
                title: '¿Actualizar doctor?',
                html: `<div class="text-center">
                      <i class="fas fa-user-edit fa-3x text-pastel-blue mb-3"></i>
                      <p><strong>Dr. ${primerNombre} ${primerApellido}</strong></p>
                      <div class="text-muted small">
                      <p><i class="fas fa-stethoscope mr-1"></i> ${especialidad}</p>
                      <p><i class="fas fa-id-badge mr-1"></i> Licencia: ${numeroLicencia}</p>
                      <p><i class="fas fa-id-card mr-1"></i> ID: {{ $doctor->id }}</p>
                      </div>
                      </div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'var(--pastel-blue)',
                cancelButtonColor: 'var(--pastel-gray)',
                confirmButtonText: '<i class="fas fa-save mr-1"></i> Sí, actualizar',
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
                    
                    $('#btnGuardar').html('<i class="fas fa-spinner fa-spin mr-1"></i> Actualizando...').prop('disabled', true);
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

        // Inicializar estado del formulario y lista de cambios
        actualizarEstadoFormulario();
        actualizarListaCambios();
    });
</script>
@stop