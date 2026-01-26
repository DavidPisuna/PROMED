@extends('adminlte::page')

@section('title', 'Editar Paciente')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-pastel-purple"><i class="fas fa-user-edit mr-2"></i>Editar Paciente</h1>
    <a href="{{ route('admin.pacientes.index') }}" class="btn btn-pastel-gray">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Listado
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-pastel shadow-sm">
        <div class="card-header bg-pastel-blue text-white d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">
                <i class="fas fa-user-injured mr-2"></i>Editar Paciente: <span class="text-white">{{ $paciente->nombre_completo }}</span>
            </h5>
            <span class="badge badge-pastel">
                <i class="fas fa-id-card mr-1"></i> Cédula: {{ $paciente->cedula_identidad }}
            </span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pacientes.update', $paciente) }}" method="POST" id="pacienteForm">
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
                                {{-- Primer Apellido --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-id-card text-pastel-purple mr-1"></i>
                                        Primer Apellido <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="primer_apellido" 
                                           class="form-control form-control-pastel uppercase-input @error('primer_apellido') is-invalid @enderror" 
                                           value="{{ old('primer_apellido', $paciente->primer_apellido) }}" 
                                           placeholder="Ingrese el primer apellido" required>
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
                                    <input type="text" name="segundo_apellido" 
                                           class="form-control form-control-pastel uppercase-input @error('segundo_apellido') is-invalid @enderror" 
                                           value="{{ old('segundo_apellido', $paciente->segundo_apellido) }}" 
                                           placeholder="Ingrese el segundo apellido (opcional)">
                                    @error('segundo_apellido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Primer Nombre --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-user text-pastel-purple mr-1"></i>
                                        Primer Nombre <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="primer_nombre" 
                                           class="form-control form-control-pastel uppercase-input @error('primer_nombre') is-invalid @enderror" 
                                           value="{{ old('primer_nombre', $paciente->primer_nombre) }}" 
                                           placeholder="Ingrese el primer nombre" required>
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
                                    <input type="text" name="segundo_nombre" 
                                           class="form-control form-control-pastel uppercase-input @error('segundo_nombre') is-invalid @enderror" 
                                           value="{{ old('segundo_nombre', $paciente->segundo_nombre) }}" 
                                           placeholder="Ingrese el segundo nombre (opcional)">
                                    @error('segundo_nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Sexo --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-venus-mars text-pastel-purple mr-1"></i>
                                        Sexo
                                    </label>
                                    <select name="sexo" class="form-control form-control-pastel @error('sexo') is-invalid @enderror">
                                        <option value="">-- Seleccione el sexo --</option>
                                        <option value="M" {{ old('sexo', $paciente->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                                        <option value="F" {{ old('sexo', $paciente->sexo) == 'F' ? 'selected' : '' }}>Femenino</option>
                                    </select>
                                    @error('sexo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Información de Identificación --}}
                    <div class="col-md-6">
                        <div class="card mb-4 bg-pastel-light border-0">
                            <div class="card-header bg-pastel-green text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-id-badge mr-2"></i>Información de Identificación</h6>
                            </div>
                            <div class="card-body">
                                {{-- Cédula --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-address-card text-pastel-green mr-1"></i>
                                        Cédula de Identidad <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="cedula_identidad" 
                                           class="form-control form-control-pastel @error('cedula_identidad') is-invalid @enderror" 
                                           value="{{ old('cedula_identidad', $paciente->cedula_identidad) }}" 
                                           placeholder="Número de cédula" required>
                                    @error('cedula_identidad')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Código Empleado --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-id-badge text-pastel-green mr-1"></i>
                                        Código Empleado <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="codigo_empleado" 
                                           class="form-control form-control-pastel @error('codigo_empleado') is-invalid @enderror" 
                                           value="{{ old('codigo_empleado', $paciente->codigo_empleado) }}" 
                                           placeholder="Código interno del empleado" required>
                                    @error('codigo_empleado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Fecha de Nacimiento --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-birthday-cake text-pastel-green mr-1"></i>
                                        Fecha de Nacimiento
                                    </label>
                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                                           class="form-control form-control-pastel @error('fecha_nacimiento') is-invalid @enderror" 
                                           value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento ? $paciente->fecha_nacimiento->format('Y-m-d') : '') }}">
                                    @error('fecha_nacimiento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Edad Calculada --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-calculator text-pastel-green mr-1"></i>
                                        Edad Calculada
                                    </label>
                                    <input type="text" id="edad_calculada" class="form-control bg-pastel-light" readonly 
                                           value="{{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age . ' años' : '' }}">
                                </div>

                                {{-- Fecha de Registro --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-calendar-alt text-pastel-green mr-1"></i>
                                        Fecha de Registro
                                    </label>
                                    <input type="text" class="form-control form-control-pastel bg-pastel-light" 
                                           value="{{ $paciente->created_at->format('d/m/Y H:i') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Información Médica --}}
                    <div class="col-md-6">
                        <div class="card mb-4 bg-pastel-light border-0">
                            <div class="card-header bg-pastel-pink text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-heartbeat mr-2"></i>Información Médica</h6>
                            </div>
                            <div class="card-body">
                                {{-- Grupo Sanguíneo --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-tint text-pastel-pink mr-1"></i>
                                        Grupo Sanguíneo
                                    </label>
                                    <select name="grupo_sanguineo" class="form-control form-control-pastel @error('grupo_sanguineo') is-invalid @enderror">
                                        <option value="">-- Seleccione grupo --</option>
                                        <option value="A+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'A+' ? 'selected' : '' }}>A+</option>
                                        <option value="A-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'A-' ? 'selected' : '' }}>A-</option>
                                        <option value="B+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'B+' ? 'selected' : '' }}>B+</option>
                                        <option value="B-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'B-' ? 'selected' : '' }}>B-</option>
                                        <option value="AB+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                        <option value="AB-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                        <option value="O+" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'O+' ? 'selected' : '' }}>O+</option>
                                        <option value="O-" {{ old('grupo_sanguineo', $paciente->grupo_sanguineo) == 'O-' ? 'selected' : '' }}>O-</option>
                                    </select>
                                    @error('grupo_sanguineo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Lateralidad --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-hand-paper text-pastel-pink mr-1"></i>
                                        Lateralidad
                                    </label>
                                    <select name="lateralidad" class="form-control form-control-pastel @error('lateralidad') is-invalid @enderror">
                                        <option value="">-- Seleccione lateralidad --</option>
                                        <option value="Diestro" {{ old('lateralidad', $paciente->lateralidad) == 'Diestro' ? 'selected' : '' }}>Diestro</option>
                                        <option value="Zurdo" {{ old('lateralidad', $paciente->lateralidad) == 'Zurdo' ? 'selected' : '' }}>Zurdo</option>
                                        <option value="Ambidiestro" {{ old('lateralidad', $paciente->lateralidad) == 'Ambidiestro' ? 'selected' : '' }}>Ambidiestro</option>
                                    </select>
                                    @error('lateralidad')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Información de Asignación --}}
                    <div class="col-md-6">
                        <div class="card mb-4 bg-pastel-light border-0">
                            <div class="card-header bg-pastel-orange text-white py-2">
                                <h6 class="mb-0"><i class="fas fa-store mr-2"></i>Asignación y Estado</h6>
                            </div>
                            <div class="card-body">
                                {{-- Sucursal --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-store text-pastel-orange mr-1"></i>
                                        Sucursal <span class="text-danger">*</span>
                                    </label>
                                    <select name="sucursal_id" class="form-control form-control-pastel @error('sucursal_id') is-invalid @enderror" required>
                                        <option value="">-- Seleccione una sucursal --</option>
                                        @foreach($sucursales as $sucursal)
                                            <option value="{{ $sucursal->id }}" 
                                                {{ old('sucursal_id', $paciente->sucursal_id) == $sucursal->id ? 'selected' : '' }}>
                                                {{ $sucursal->nombre }}
                                                @if($sucursal->codigo)
                                                    ({{ $sucursal->codigo }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sucursal_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Última Actualización --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-history text-pastel-orange mr-1"></i>
                                        Última Actualización
                                    </label>
                                    <input type="text" class="form-control form-control-pastel bg-pastel-light" 
                                           value="{{ $paciente->updated_at->format('d/m/Y H:i') }}" readonly>
                                </div>

                                {{-- Estado Activo (Radio Buttons) --}}
                                <div class="form-group mb-4">
                                    <label class="form-label">
                                        <i class="fas fa-toggle-on text-pastel-orange mr-1"></i>
                                        Estado del Paciente <span class="text-danger">*</span>
                                    </label>
                                    
                                    <div class="d-flex align-items-center mt-2">
                                        {{-- Opción Activo --}}
                                        <div class="form-check form-check-inline mr-4">
                                            <input type="radio" name="activo" id="activo_si" value="1" 
                                                   class="form-check-input estado-radio @error('activo') is-invalid @enderror"
                                                   {{ old('activo', $paciente->activo) == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label d-flex align-items-center" for="activo_si">
                                                <span class="estado-badge estado-activo mr-2">
                                                    <i class="fas fa-check-circle"></i>
                                                </span>
                                                <div>
                                                    <strong class="text-success d-block">Activo</strong>
                                                    <small class="text-muted">Paciente activo en el sistema</small>
                                                </div>
                                            </label>
                                        </div>
                                        
                                        {{-- Opción Inactivo --}}
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="activo" id="activo_no" value="0" 
                                                   class="form-check-input estado-radio @error('activo') is-invalid @enderror"
                                                   {{ old('activo', $paciente->activo) == '0' ? 'checked' : '' }}>
                                            <label class="form-check-label d-flex align-items-center" for="activo_no">
                                                <span class="estado-badge estado-inactivo mr-2">
                                                    <i class="fas fa-times-circle"></i>
                                                </span>
                                                <div>
                                                    <strong class="text-danger d-block">Inactivo</strong>
                                                    <small class="text-muted">Paciente inactivo en el sistema</small>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <small class="form-text text-muted mt-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Estado actual del paciente en el sistema
                                    </small>
                                    
                                    @error('activo')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
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
                                                <li>Modificación de datos del paciente</li>
                                                <li>Actualización de fecha de modificación</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="alert alert-pastel-success">
                                            <i class="fas fa-user-injured mr-2"></i>
                                            <strong>Paciente a actualizar:</strong>
                                            <div class="small mt-2">
                                                <div><strong>ID:</strong> {{ $paciente->id }}</div>
                                                <div><strong>Nombre completo:</strong> {{ $paciente->nombre_completo }}</div>
                                                <div><strong>Cédula:</strong> {{ $paciente->cedula_identidad }}</div>
                                                <div><strong>Estado:</strong> 
                                                    <span class="badge {{ $paciente->activo ? 'badge-pastel-green' : 'badge-pastel-red' }}">
                                                        {{ $paciente->activo ? 'ACTIVO' : 'INACTIVO' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                <a href="{{ route('admin.pacientes.show', $paciente) }}" class="btn btn-pastel-info">
                                    <i class="fas fa-eye mr-1"></i> Ver Detalles
                                </a>
                            </div>
                            <div>
                                <a href="{{ route('admin.pacientes.index') }}" class="btn btn-pastel-gray mr-2">
                                    <i class="fas fa-times mr-1"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-pastel-blue" id="btnGuardar">
                                    <i class="fas fa-save mr-1"></i> Actualizar Paciente
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
{{-- Mismo CSS que en create --}}
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
    
    /* ... resto del CSS igual que en create ... */
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Valores originales para restaurar
        const valoresOriginales = {
            primer_apellido: $('input[name="primer_apellido"]').val(),
            segundo_apellido: $('input[name="segundo_apellido"]').val(),
            primer_nombre: $('input[name="primer_nombre"]').val(),
            segundo_nombre: $('input[name="segundo_nombre"]').val(),
            sexo: $('select[name="sexo"]').val(),
            cedula_identidad: $('input[name="cedula_identidad"]').val(),
            codigo_empleado: $('input[name="codigo_empleado"]').val(),
            fecha_nacimiento: $('input[name="fecha_nacimiento"]').val(),
            grupo_sanguineo: $('select[name="grupo_sanguineo"]').val(),
            lateralidad: $('select[name="lateralidad"]').val(),
            sucursal_id: $('select[name="sucursal_id"]').val(),
            activo: $('input[name="activo"]:checked').val()
        };

        // Solo números para cédula
        $('input[name="cedula_identidad"]').on('input', function() { 
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
            'input[name="primer_apellido"]',
            'input[name="segundo_apellido"]',
            'input[name="primer_nombre"]',
            'input[name="segundo_nombre"]'
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

        // Calcular edad automáticamente
        function calcularEdad(fecha) {
            if(!fecha) return '';
            const hoy = new Date();
            const nacimiento = new Date(fecha);
            let edad = hoy.getFullYear() - nacimiento.getFullYear();
            const m = hoy.getMonth() - nacimiento.getMonth();
            if(m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())){
                edad--;
            }
            return edad + ' años';
        }

        $('#fecha_nacimiento').on('change', function(){
            const edad = calcularEdad(this.value);
            $('#edad_calculada').val(edad);
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
                    $('input[name="primer_apellido"]').val(valoresOriginales.primer_apellido);
                    $('input[name="segundo_apellido"]').val(valoresOriginales.segundo_apellido);
                    $('input[name="primer_nombre"]').val(valoresOriginales.primer_nombre);
                    $('input[name="segundo_nombre"]').val(valoresOriginales.segundo_nombre);
                    $('select[name="sexo"]').val(valoresOriginales.sexo);
                    $('input[name="cedula_identidad"]').val(valoresOriginales.cedula_identidad);
                    $('input[name="codigo_empleado"]').val(valoresOriginales.codigo_empleado);
                    $('input[name="fecha_nacimiento"]').val(valoresOriginales.fecha_nacimiento);
                    $('select[name="grupo_sanguineo"]').val(valoresOriginales.grupo_sanguineo);
                    $('select[name="lateralidad"]').val(valoresOriginales.lateralidad);
                    $('select[name="sucursal_id"]').val(valoresOriginales.sucursal_id);
                    
                    // Restaurar estado
                    $(`input[name="activo"][value="${valoresOriginales.activo}"]`).prop('checked', true);
                    
                    // Actualizar edad
                    $('#edad_calculada').val(valoresOriginales.fecha_nacimiento ? calcularEdad(valoresOriginales.fecha_nacimiento) : '');
                    
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
                    
                    actualizarListaCambios();
                }
            });
        });

        // Detectar cambios en los campos
        $('input, select').on('change keyup', function() {
            actualizarListaCambios();
        });

        // Función para actualizar la lista de cambios
        function actualizarListaCambios() {
            const lista = $('#lista-cambios');
            lista.empty();
            
            if ($('input[name="primer_apellido"]').val() !== valoresOriginales.primer_apellido) {
                lista.append('<li><i class="fas fa-id-card text-primary mr-1"></i> Cambio en primer apellido</li>');
            }
            if ($('input[name="segundo_apellido"]').val() !== valoresOriginales.segundo_apellido) {
                lista.append('<li><i class="fas fa-id-card text-primary mr-1"></i> Cambio en segundo apellido</li>');
            }
            if ($('input[name="primer_nombre"]').val() !== valoresOriginales.primer_nombre) {
                lista.append('<li><i class="fas fa-user text-primary mr-1"></i> Cambio en primer nombre</li>');
            }
            if ($('input[name="segundo_nombre"]').val() !== valoresOriginales.segundo_nombre) {
                lista.append('<li><i class="fas fa-user text-primary mr-1"></i> Cambio en segundo nombre</li>');
            }
            if ($('select[name="sexo"]').val() !== valoresOriginales.sexo) {
                lista.append('<li><i class="fas fa-venus-mars text-primary mr-1"></i> Cambio en sexo</li>');
            }
            if ($('input[name="cedula_identidad"]').val() !== valoresOriginales.cedula_identidad) {
                lista.append('<li><i class="fas fa-address-card text-primary mr-1"></i> Cambio en cédula</li>');
            }
            if ($('input[name="codigo_empleado"]').val() !== valoresOriginales.codigo_empleado) {
                lista.append('<li><i class="fas fa-id-badge text-primary mr-1"></i> Cambio en código empleado</li>');
            }
            if ($('input[name="fecha_nacimiento"]').val() !== valoresOriginales.fecha_nacimiento) {
                lista.append('<li><i class="fas fa-birthday-cake text-primary mr-1"></i> Cambio en fecha de nacimiento</li>');
            }
            if ($('select[name="grupo_sanguineo"]').val() !== valoresOriginales.grupo_sanguineo) {
                lista.append('<li><i class="fas fa-tint text-primary mr-1"></i> Cambio en grupo sanguíneo</li>');
            }
            if ($('select[name="lateralidad"]').val() !== valoresOriginales.lateralidad) {
                lista.append('<li><i class="fas fa-hand-paper text-primary mr-1"></i> Cambio en lateralidad</li>');
            }
            if ($('select[name="sucursal_id"]').val() !== valoresOriginales.sucursal_id) {
                lista.append('<li><i class="fas fa-store text-primary mr-1"></i> Cambio en sucursal</li>');
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
        $('#pacienteForm').on('submit', function(e) {
            e.preventDefault();
            
            const primerApellido = $('input[name="primer_apellido"]').val();
            const primerNombre = $('input[name="primer_nombre"]').val();
            const cedula = $('input[name="cedula_identidad"]').val();
            const codigoEmpleado = $('input[name="codigo_empleado"]').val();
            const sucursal = $('select[name="sucursal_id"]').val();

            if (!primerApellido || !primerNombre || !cedula || !codigoEmpleado || !sucursal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campos requeridos',
                    text: 'Debe completar todos los campos obligatorios marcados con (*)',
                    confirmButtonText: 'Entendido',
                    background: 'var(--pastel-light)',
                    confirmButtonColor: 'var(--pastel-blue)'
                });
                return false;
            }

            Swal.fire({
                title: '¿Actualizar paciente?',
                html: `Se actualizarán los datos del paciente:<br>
                      <strong>${primerNombre} ${primerApellido}</strong><br>
                      <small class="text-muted">Cédula: ${cedula} | Código: ${codigoEmpleado}</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'var(--pastel-blue)',
                cancelButtonColor: 'var(--pastel-gray)',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar',
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
                    $('#pacienteForm').off('submit').submit();
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

        // Inicializar lista de cambios
        actualizarListaCambios();
    });
</script>
@stop