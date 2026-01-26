@extends('adminlte::page')

@section('title', 'Editar Actividad Extra')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Actividad Extra
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD RESUMEN DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-user-circle mr-2"></i>Información del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                </div>
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo de Registro</small>
                    <span class="badge badge-pill bg-pastel-purple px-3 text-uppercase">
                        {{ $registro->tipo }}
                    </span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Doctor</small>
                    <span class="text-dark font-weight-500">
                        DR. {{ strtoupper($registro->doctor->primer_nombre) }} {{ strtoupper($registro->doctor->primer_apellido) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-running mr-2"></i>Modificar Actividad Extra
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.actividades_extras.update', [$registro, $actividadExtra]) }}" method="POST" id="actividadForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-running mr-2 text-info"></i>Tipo de Actividad <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="tipo_actividad" 
                                   class="form-control form-control-pastel text-uppercase" 
                                   value="{{ old('tipo_actividad', $actividadExtra->tipo_actividad) }}" 
                                   required placeholder="EJ: DEPORTE, HOBBY, EJERCICIO...">
                            @error('tipo_actividad')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-calendar-alt mr-2 text-success"></i>Fecha de Actividad
                            </label>
                            <input type="date" name="fecha" 
                                   class="form-control form-control-pastel" 
                                   value="{{ old('fecha', $actividadExtra->fecha?->format('Y-m-d')) }}"
                                   max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2">CANCELAR</button>
                    <button type="button" id="btnLimpiar" class="btn btn-outline-secondary mr-2">
                        <i class="fas fa-broom mr-1"></i> RESTAURAR
                    </button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i>ACTUALIZAR ACTIVIDAD
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
        --pastel-gray: #E3E3E3;
    }

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .text-pastel-purple { color: #a389f5 !important; }
    
    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
        padding: 10px;
        height: calc(2.5rem + 2px) !important;
        transition: all 0.3s ease;
    }
    
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
        outline: none;
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .text-uppercase { text-transform: uppercase; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // 1. Forzar mayúsculas en tiempo real
        $('input[type="text"]').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // 2. Confirmación de Actualización
        $('#actividadForm').on('submit', function(e) {
            e.preventDefault();
            
            const tipo = $('input[name="tipo_actividad"]').val().trim();
            if(!tipo) {
                Swal.fire('Error', 'El tipo de actividad es obligatorio', 'error');
                return;
            }

            Swal.fire({
                title: '¿Guardar Cambios?',
                text: "Se actualizará la información de la actividad extra.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Revisar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // 3. Botón Restaurar (Limpiar)
        $('#btnLimpiar').on('click', function() {
            Swal.fire({
                title: '¿Restaurar valores?',
                text: "Se volverá a los datos originales de la actividad.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#CAB8FF',
                confirmButtonText: 'Sí, restaurar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Recarga la página para restaurar valores de base de datos
                    window.location.reload();
                }
            });
        });

        // 4. Botón Cancelar
        $('#btnCancelar').on('click', function() {
            Swal.fire({
                title: '¿Salir sin guardar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, salir',
                confirmButtonColor: '#E3E3E3',
                cancelButtonColor: '#CAB8FF',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.registros.show', $registro) }}";
                }
            });
        });
    });
</script>
@stop