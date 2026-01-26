@extends('adminlte::page')

@section('title', 'Editar Registro')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Registro Médico
    </h1>
    <a href="{{ route('admin.registros.index') }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver a la lista
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE (Estilo Resumen) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Resumen del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->segundo_nombre) }} 
                        {{ strtoupper($registro->paciente->primer_apellido) }} {{ strtoupper($registro->paciente->segundo_apellido) }}
                    </span>
                </div>
                <div class="col-md-2 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación</small>
                    <span class="h6 font-weight-bold text-dark">{{ $registro->paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-2 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Edad</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">
                        {{ \Carbon\Carbon::parse($registro->paciente->fecha_nacimiento)->age }} AÑOS
                    </span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Estado Civil / Sexo</small>
                    <span class="text-dark font-weight-500">{{ strtoupper($registro->paciente->estado_civil ?? 'N/A') }} / {{ strtoupper($registro->paciente->sexo ?? 'N/A') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-sync-alt mr-2"></i>Actualizar Información de Evaluación
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.registros.update', $registro) }}" method="POST" id="registroForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="paciente_id" value="{{ $registro->paciente_id }}">

                <div class="row">
                    {{-- Columna Izquierda --}}
                    <div class="col-md-6 border-right">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-building mr-2 text-info"></i>Empresa <span class="text-danger">*</span></label>
                            <select name="empresa_id" class="form-control form-control-pastel" required>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id', $registro->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                        {{ strtoupper($empresa->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-user-md mr-2 text-success"></i>Doctor <span class="text-danger">*</span></label>
                            <select name="doctor_id" class="form-control form-control-pastel" required>
                                @foreach($doctores as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $registro->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        DR. {{ strtoupper($doctor->primer_nombre) }} {{ strtoupper($doctor->primer_apellido) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Columna Derecha --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-briefcase mr-2 text-warning"></i>Puesto de Trabajo</label>
                            <input type="text" name="puesto" class="form-control form-control-pastel text-uppercase" 
                                   value="{{ old('puesto', $registro->puesto) }}" placeholder="EJ: ANALISTA DE SISTEMAS">
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-star mr-2 text-danger"></i>Atención Prioritaria</label>
                            <select name="atencion_prioritaria" class="form-control form-control-pastel">
                                <option value="">NO APLICA</option>
                                <option value="EMBARAZADA" {{ old('atencion_prioritaria', $registro->atencion_prioritaria) == 'EMBARAZADA' ? 'selected' : '' }}>EMBARAZADA</option>
                                <option value="DISCAPACIDAD" {{ old('atencion_prioritaria', $registro->atencion_prioritaria) == 'DISCAPACIDAD' ? 'selected' : '' }}>PERSONA CON DISCAPACIDAD</option>
                                <option value="CATASTROFICA" {{ old('atencion_prioritaria', $registro->atencion_prioritaria) == 'CATASTROFICA' ? 'selected' : '' }}>ENFERMEDAD CATASTRÓFICA</option>
                                <option value="ADULTO MAYOR" {{ old('atencion_prioritaria', $registro->atencion_prioritaria) == 'ADULTO MAYOR' ? 'selected' : '' }}>ADULTO MAYOR</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- SECCIÓN DINÁMICA DE FECHAS --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label font-weight-bold text-primary"><i class="fas fa-list mr-2"></i>Tipo de Evaluación <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-control form-control-pastel border-primary shadow-sm font-weight-bold" required>
                                <option value="INGRESO" {{ old('tipo', $registro->tipo) == 'INGRESO' ? 'selected' : '' }}>INGRESO</option>
                                <option value="PERIODICA" {{ old('tipo', $registro->tipo) == 'PERIODICA' ? 'selected' : '' }}>PERIÓDICA</option>
                                <option value="RETIRO" {{ old('tipo', $registro->tipo) == 'RETIRO' ? 'selected' : '' }}>RETIRO</option>
                                <option value="REINTEGRO" {{ old('tipo', $registro->tipo) == 'REINTEGRO' ? 'selected' : '' }}>REINTEGRO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="p-3 rounded bg-light border d-flex justify-content-between">
                            <div class="date-input-group">
                                <label class="small font-weight-bold mb-0">F. INGRESO</label>
                                <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control form-control-sm fecha-input" value="{{ old('fecha_ingreso', $registro->fecha_ingreso) }}" readonly>
                            </div>
                            <div class="date-input-group">
                                <label class="small font-weight-bold mb-0">F. PERIÓDICA</label>
                                <input type="date" name="fecha_periodica" id="fecha_periodica" class="form-control form-control-sm fecha-input" value="{{ old('fecha_periodica', $registro->fecha_periodica) }}" readonly>
                            </div>
                            <div class="date-input-group">
                                <label class="small font-weight-bold mb-0">F. RETIRO</label>
                                <input type="date" name="fecha_retiro" id="fecha_retiro" class="form-control form-control-sm fecha-input" value="{{ old('fecha_retiro', $registro->fecha_retiro) }}" readonly>
                            </div>
                            <div class="date-input-group">
                                <label class="small font-weight-bold mb-0">F. REINTEGRO</label>
                                <input type="date" name="fecha_reintegro" id="fecha_reintegro" class="form-control form-control-sm fecha-input" value="{{ old('fecha_reintegro', $registro->fecha_reintegro) }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label class="form-label font-weight-bold text-secondary">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="form-control form-control-pastel text-uppercase">{{ old('observaciones', $registro->observaciones) }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <a href="{{ route('admin.registros.index') }}" class="btn btn-pastel-gray mr-2">CANCELAR</a>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i>GUARDAR CAMBIOS
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
        --pastel-green: #B6E2D3;
        --pastel-gray: #E3E3E3;
    }

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    
    .form-control-pastel {
        height: calc(2.5rem + 2px) !important;
        border-radius: 8px;
        border: 1.5px solid #eee;
        padding: 0.375rem 0.75rem !important;
        transition: all 0.3s ease;
        color: #495057 !important;
        background-color: #ffffff !important;
    }
    
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
        outline: none;
    }

    /* Estilo para campos bloqueados pero visibles */
    .fecha-input[readonly] {
        background-color: #f1f3f5 !important;
        border-color: #e9ecef;
        color: #adb5bd !important;
        cursor: not-allowed;
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; transition: 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); color: #2c3e50; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .text-uppercase { text-transform: uppercase; }
    .date-input-group { flex: 1; margin: 0 5px; }
    
    .fecha-input:not([readonly]) { 
        border: 2px solid var(--pastel-blue) !important; 
        background-color: #fff !important; 
        color: #495057 !important;
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        const tipoSelect = $('#tipo');
        const inputsFecha = $('.fecha-input');

        function gestionarFechas() {
            const seleccion = tipoSelect.val();
            // Bloquear todos con readonly (para que pasen al request)
            inputsFecha.prop('readonly', true);
            
            const mapa = {
                'INGRESO': '#fecha_ingreso',
                'PERIODICA': '#fecha_periodica',
                'RETIRO': '#fecha_retiro',
                'REINTEGRO': '#fecha_reintegro'
            };

            if (mapa[seleccion]) {
                $(mapa[seleccion]).prop('readonly', false);
            }
        }

        // Ejecutar al inicio (Edición)
        gestionarFechas();

        // Escuchar cambios
        tipoSelect.on('change', function() {
            // Opcional: limpiar fechas si cambias de tipo, o dejar las que están
            gestionarFechas();
        });

        // Mayúsculas automáticas
        $('input[type="text"], textarea').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // Confirmación SweetAlert
        $('#registroForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Guardar Cambios?',
                text: "Se actualizará la información del registro médico.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@stop