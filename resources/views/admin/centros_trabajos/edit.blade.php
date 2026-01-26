@extends('adminlte::page')

@section('title', 'Editar Centro de Trabajo')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Centro de Trabajo
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">

    {{-- 🔹 RESUMEN DEL REGISTRO --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark">
                <i class="fas fa-user-circle mr-2"></i>Resumen del Registro
            </h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row text-center text-md-left">
                <div class="col-md-4 border-right">
                    <small class="text-muted text-uppercase font-weight-bold">Paciente</small>
                    <div class="font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </div>
                </div>
                <div class="col-md-4 border-right">
                    <small class="text-muted text-uppercase font-weight-bold">Tipo Registro</small>
                    <div>
                        <span class="badge badge-pill bg-pastel-purple px-3">
                            {{ strtoupper($registro->tipo) }}
                        </span>
                    </div>
                </div>
                <div class="col-md-4">
                    <small class="text-muted text-uppercase font-weight-bold">Doctor</small>
                    <div class="font-weight-bold text-dark">
                        {{ strtoupper($registro->doctor->primer_nombre ?? 'N/A') }} {{ strtoupper($registro->doctor->primer_apellido ?? '') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-building mr-2"></i>Datos del Centro de Trabajo
            </h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.centros_trabajos.update', [$registro, $centro]) }}" method="POST" id="centroTrabajoForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-building mr-2 text-info"></i>Nombre Centro
                            </label>
                            <input type="text" name="nombre_centro_trabajo"
                                   class="form-control form-control-pastel text-uppercase"
                                   value="{{ old('nombre_centro_trabajo', $centro->nombre_centro_trabajo) }}" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-briefcase mr-2 text-warning"></i>Tipo Trabajo
                            </label>
                            <select name="tipo_trabajo" class="form-control form-control-pastel" required>
                                <option value="">-- SELECCIONE --</option>
                                <option value="actual" {{ $centro->tipo_trabajo == 'actual' ? 'selected' : '' }}>ACTUAL</option>
                                <option value="anterior" {{ $centro->tipo_trabajo == 'anterior' ? 'selected' : '' }}>ANTERIOR</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-clock mr-2 text-info"></i>Tiempo de Trabajo (Años/Meses)
                            </label>
                            <input type="text" name="tiempo_trabajo"
                                   class="form-control form-control-pastel text-uppercase"
                                   value="{{ old('tiempo_trabajo', $centro->tiempo_trabajo) }}" placeholder="EJ: 2 AÑOS">
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label class="form-label font-weight-bold">
                        <i class="fas fa-tasks mr-2 text-success"></i>Actividades Desempeñadas
                    </label>
                    <textarea name="actividades_desempenadas" rows="3"
                              class="form-control form-control-pastel text-uppercase"
                              required>{{ old('actividades_desempenadas', $centro->actividades_desempenadas) }}</textarea>
                </div>

                {{-- SECCIÓN DE RIESGOS --}}
                <div class="row mb-4 bg-light p-3 rounded mx-1 border">
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="incidente" name="incidente" value="1" {{ $centro->incidente ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="incidente">INCIDENTE</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="accidente" name="accidente" value="1" {{ $centro->accidente ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="accidente">ACCIDENTE</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="enfermedad_profesional" name="enfermedad_profesional" value="1" {{ $centro->enfermedad_profesional ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="enfermedad_profesional">ENFERMEDAD PROF.</label>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="calificado_iess" name="calificado_iess" value="1" {{ $centro->calificado_iess ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold text-primary" for="calificado_iess">CALIFICADO IESS</label>
                        </div>
                    </div>
                </div>

                {{-- FECHA IESS (DINÁMICA) --}}
                <div class="form-group mb-4" id="fecha-calificacion-group" style="{{ $centro->calificado_iess ? '' : 'display:none' }}">
                    <label class="form-label font-weight-bold">
                        <i class="fas fa-calendar-alt mr-2 text-primary"></i>Fecha de Calificación IESS
                    </label>
                    <input type="date" name="fecha_calificacion" id="fecha_calificacion"
                           class="form-control form-control-pastel"
                           value="{{ old('fecha_calificacion', optional($centro->fecha_calificacion)->format('Y-m-d')) }}">
                </div>

                <div class="form-group mb-4">
                    <label class="form-label font-weight-bold">Observaciones</label>
                    <textarea name="observaciones" rows="2"
                              class="form-control form-control-pastel text-uppercase">{{ old('observaciones', $centro->observaciones) }}</textarea>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2">CANCELAR</button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i>ACTUALIZAR CAMBIOS
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
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white !important; }
    .text-pastel-purple { color: #8e74e6 !important; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    
    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
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
    .bg-light-soft { background-color: #fcfcfc; }

    /* Estilo para los checkboxes personalizados de AdminLTE/Bootstrap */
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: var(--pastel-blue);
        border-color: var(--pastel-blue);
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        // 1. Mayúsculas en tiempo real
        $(document).on('input', 'input[type="text"], textarea', function() {
            this.value = this.value.toUpperCase();
        });

        // 2. Lógica Dinámica Fecha IESS
        $('#calificado_iess').on('change', function() {
            if ($(this).is(':checked')) {
                $('#fecha-calificacion-group').fadeIn();
                $('#fecha_calificacion').attr('required', true);
            } else {
                $('#fecha-calificacion-group').fadeOut();
                $('#fecha_calificacion').attr('required', false).val('');
            }
        });

        // 3. Confirmación SweetAlert para actualizar
        $('#centroTrabajoForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Actualizar Centro de Trabajo?',
                text: "Los cambios se guardarán en el historial del registro.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Revisar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Convertir a mayúsculas antes de enviar
                    $(this).find('input[type="text"], textarea').each(function() {
                        $(this).val($(this).val().toUpperCase());
                    });
                    this.submit();
                }
            });
        });

        // 4. Botón Cancelar
        $('#btnCancelar').on('click', function() {
            Swal.fire({
                title: '¿Descartar cambios?',
                text: "No se guardarán las ediciones realizadas.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#CAB8FF',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Continuar editando'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.registros.show', $registro) }}";
                }
            });
        });
    });
</script>
@stop