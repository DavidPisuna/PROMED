@extends('adminlte::page')

@section('title', 'Crear Nuevo Paciente')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-user-plus mr-2"></i>Crear Nuevo Paciente
    </h1>
    <a href="{{ route('admin.pacientes.index') }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Listado
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-pastel-blue d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-dark">
                <i class="fas fa-user-injured mr-2"></i>Datos Generales del Registro
            </h5>
            <span class="badge badge-pastel border">Formulario de Ingreso</span>
        </div>

        <div class="card-body bg-light-soft">
            {{-- Errores de validación --}}
            @if($errors->any())
                <div class="alert alert-pastel-danger border-left-danger shadow-sm">
                    <h6 class="font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Por favor corrige los errores:</h6>
                    <ul class="mb-0 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.pacientes.store') }}" method="POST" id="pacienteForm">
                @csrf

                <div class="row">
                    {{-- Bloque Izquierdo: Identificación --}}
                    <div class="col-md-6 border-right-divider">
                        <h6 class="text-muted text-uppercase small font-weight-bold mb-4">Información Personal</h6>
                        
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">Primer Apellido <span class="text-danger">*</span></label>
                                <input type="text" name="primer_apellido" 
                                       class="form-control form-control-pastel @error('primer_apellido') is-invalid @enderror" 
                                       value="{{ old('primer_apellido') }}" required autofocus>
                                @error('primer_apellido') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">Segundo Apellido</label>
                                <input type="text" name="segundo_apellido" class="form-control form-control-pastel" value="{{ old('segundo_apellido') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">Primer Nombre <span class="text-danger">*</span></label>
                                <input type="text" name="primer_nombre" 
                                       class="form-control form-control-pastel @error('primer_nombre') is-invalid @enderror" 
                                       value="{{ old('primer_nombre') }}" required>
                                @error('primer_nombre') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">Segundo Nombre</label>
                                <input type="text" name="segundo_nombre" class="form-control form-control-pastel" value="{{ old('segundo_nombre') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label"><i class="fas fa-id-card mr-1 text-pastel-blue"></i> Cédula <span class="text-danger">*</span></label>
                                <input type="text" name="cedula_identidad" 
                                       class="form-control form-control-pastel @error('cedula_identidad') is-invalid @enderror" 
                                       value="{{ old('cedula_identidad') }}" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label"><i class="fas fa-venus-mars mr-1 text-pastel-blue"></i> Sexo</label>
                                <select name="sexo" class="form-control form-control-pastel">
                                    <option value="">Seleccionar...</option>
                                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Bloque Derecho: Datos Clínicos/Admin --}}
                    <div class="col-md-6">
                        <h6 class="text-muted text-uppercase small font-weight-bold mb-4">Datos Administrativos</h6>
                        
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label"><i class="fas fa-id-badge mr-1 text-pastel-blue"></i> Cód. Empleado <span class="text-danger">*</span></label>
                                <input type="text" name="codigo_empleado" 
                                       class="form-control form-control-pastel @error('codigo_empleado') is-invalid @enderror" 
                                       value="{{ old('codigo_empleado') }}" required>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label"><i class="fas fa-tint mr-1 text-pastel-blue"></i> G. Sanguíneo</label>
                                <select name="grupo_sanguineo" class="form-control form-control-pastel">
                                    <option value="">Seleccionar...</option>
                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $tipo)
                                        <option value="{{ $tipo }}" {{ old('grupo_sanguineo') == $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label"><i class="fas fa-birthday-cake mr-1 text-pastel-blue"></i> F. Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" 
                                       class="form-control form-control-pastel" value="{{ old('fecha_nacimiento') }}">
                                <small id="display_edad" class="text-info font-weight-bold"></small>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label"><i class="fas fa-hand-paper mr-1 text-pastel-blue"></i> Lateralidad</label>
                                <select name="lateralidad" class="form-control form-control-pastel">
                                    <option value="">Seleccionar...</option>
                                    <option value="Diestro" {{ old('lateralidad') == 'Diestro' ? 'selected' : '' }}>Diestro</option>
                                    <option value="Zurdo" {{ old('lateralidad') == 'Zurdo' ? 'selected' : '' }}>Zurdo</option>
                                    <option value="Ambidiestro" {{ old('lateralidad') == 'Ambidiestro' ? 'selected' : '' }}>Ambidiestro</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label"><i class="fas fa-store mr-1 text-pastel-blue"></i> Sucursal Asignada <span class="text-danger">*</span></label>
                            <select name="sucursal_id" class="form-control form-control-pastel" required>
                                <option value="">-- Seleccione una sucursal --</option>
                                @foreach($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}" {{ old('sucursal_id') == $sucursal->id ? 'selected' : '' }}>
                                        {{ $sucursal->nombre }} {{ $sucursal->codigo ? "({$sucursal->codigo})" : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- DISEÑO DE ESTADO (OPCIÓN A) --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label d-block mb-3">Estado del Registro</label>
                        <div class="status-toggle-container shadow-sm {{ old('activo', true) ? 'is-active' : 'is-inactive' }}" id="statusCard">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="activo" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }}>
                                <label class="custom-control-label w-100 cursor-pointer" for="activo">
                                    <div class="d-flex align-items-center">
                                        <i id="statusIcon" class="fas {{ old('activo', true) ? 'fa-check-circle' : 'fa-times-circle' }} fa-2x mr-3"></i>
                                        <div>
                                            <span id="statusTitle" class="d-block font-weight-bold">
                                                {{ old('activo', true) ? 'PACIENTE ACTIVO' : 'PACIENTE INACTIVO' }}
                                            </span>
                                            <small id="statusDesc" class="text-muted">
                                                {{ old('activo', true) ? 'El registro estará disponible para consultas.' : 'El registro quedará archivado.' }}
                                            </small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-right d-flex align-items-end justify-content-end">
                        <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2">
                            <i class="fas fa-times mr-1"></i> Cancelar
                        </button>
                        <button type="submit" class="btn btn-pastel-blue px-5">
                            <i class="fas fa-save mr-1"></i> Registrar Paciente
                        </button>
                    </div>
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
        --pastel-danger: #F8D7DA;
    }

    /* Estructura Card */
    .card-pastel { border: none; border-radius: 15px; overflow: hidden; }
    .card-header.bg-pastel-blue { background-color: var(--pastel-blue) !important; color: #2c3e50; }
    .bg-light-soft { background-color: #fdfdfd; }
    .text-pastel-purple { color: var(--pastel-purple) !important; }
    .text-pastel-blue { color: #82c4de !important; }

    /* Inputs */
    .form-control-pastel {
        border: 2px solid #eee;
        border-radius: 10px;
        transition: all 0.3s;
    }
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 0 0.2rem rgba(168, 216, 234, 0.25);
    }

    /* Botones */
    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 10px; font-weight: 600; color: #2c3e50; transition: transform 0.2s; }
    .btn-pastel-blue:hover { transform: translateY(-2px); background: #97c9db; color: #2c3e50; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 10px; font-weight: 600; color: #555; }

    /* Divisores */
    .border-right-divider { border-right: 1px solid #eee; }
    @media (max-width: 768px) { .border-right-divider { border-right: none; border-bottom: 1px solid #eee; margin-bottom: 20px; } }

    /* DISEÑO OPCIÓN A: Status Card */
    .status-toggle-container {
        padding: 15px 20px;
        border-radius: 12px;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        background: #fff;
    }
    .status-toggle-container.is-active { border-color: var(--pastel-green); background-color: #f0fff4; }
    .status-toggle-container.is-active i { color: #28a745; }
    .status-toggle-container.is-inactive { border-color: #f5c6cb; background-color: #fff5f5; }
    .status-toggle-container.is-inactive i { color: #dc3545; }

    .cursor-pointer { cursor: pointer; }

    /* Ajuste del switch dentro de la card */
    .custom-switch .custom-control-label::before { height: 1.5rem; width: 2.75rem; border-radius: 1rem; }
    .custom-switch .custom-control-label::after { width: calc(1.5rem - 4px); height: calc(1.5rem - 4px); border-radius: 1rem; }
    .custom-control-input:checked ~ .custom-control-label::before { background-color: #28a745; border-color: #28a745; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // 1. Mayúsculas automáticas
        $('.form-control-pastel').on('blur', function() {
            if(['primer_apellido', 'segundo_apellido', 'primer_nombre', 'segundo_nombre'].includes(this.name)) {
                this.value = this.value.toUpperCase().trim();
            }
        });

        // 2. Solo números en cédula
        $('input[name="cedula_identidad"]').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // 3. Edad en tiempo real
        $('#fecha_nacimiento').on('change', function() {
            if(this.value) {
                const fechaNac = new Date(this.value);
                const hoy = new Date();
                let edad = hoy.getFullYear() - fechaNac.getFullYear();
                const mes = hoy.getMonth() - fechaNac.getMonth();
                if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) edad--;
                $('#display_edad').text('('+edad + ' años)');
            }
        });

        // 4. LÓGICA DE ESTADO (OPCIÓN A)
        $('#activo').on('change', function() {
            const isChecked = $(this).is(':checked');
            const container = $('#statusCard');
            
            if(isChecked) {
                container.removeClass('is-inactive').addClass('is-active');
                $('#statusTitle').text('PACIENTE ACTIVO');
                $('#statusDesc').text('El registro estará disponible para consultas.');
                $('#statusIcon').removeClass('fa-times-circle').addClass('fa-check-circle');
            } else {
                container.removeClass('is-active').addClass('is-inactive');
                $('#statusTitle').text('PACIENTE INACTIVO');
                $('#statusDesc').text('El registro quedará archivado.');
                $('#statusIcon').removeClass('fa-check-circle').addClass('fa-times-circle');
            }
        });

        // 5. Confirmación al Salir
        let formChanged = false;
        $('#pacienteForm').on('change', 'input, select', () => formChanged = true);

        $('#btnCancelar').on('click', function() {
            if(formChanged) {
                Swal.fire({
                    title: '¿Deseas salir?',
                    text: "Se perderán los cambios realizados.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, salir',
                    cancelButtonText: 'Seguir editando',
                    confirmButtonColor: '#CAB8FF',
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = "{{ route('admin.pacientes.index') }}";
                });
            } else {
                window.location.href = "{{ route('admin.pacientes.index') }}";
            }
        });

        // 6. Alerta de éxito inicial
        @if(session('success'))
            Swal.fire({ icon: 'success', title: '¡Hecho!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false });
        @endif
    });
</script>
@stop