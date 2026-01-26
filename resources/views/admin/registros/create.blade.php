@extends('adminlte::page')

@section('title', 'Crear Registro')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-file-medical mr-2"></i>Crear Registro Médico
    </h1>
    <a href="{{ url('/admin/pacientes/'.$paciente->id.'/registros') }}"
        class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver a la lista
    </a>

</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE (Estilo Resumen) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-user-circle mr-2"></i>Resumen del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($paciente->primer_nombre) }} {{ strtoupper($paciente->segundo_nombre) }} 
                        {{ strtoupper($paciente->primer_apellido) }} {{ strtoupper($paciente->segundo_apellido) }}
                    </span>
                </div>
                <div class="col-md-2 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación</small>
                    <span class="h6 font-weight-bold">{{ $paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-2 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Edad</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">
                        {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años
                    </span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Empresa/Sucursal</small>
                    <span class="text-dark font-weight-500">{{ strtoupper($paciente->sucursal->nombre ?? 'N/A') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE REGISTRO --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-plus-circle mr-2"></i>Nuevo Ingreso de Evaluación
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.registros.store') }}" method="POST" id="registroForm">
                @csrf
                <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

                <div class="row">
                    {{-- Columna Izquierda --}}
                    <div class="col-md-6 border-right">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-building mr-2 text-info"></i>Empresa <span class="text-danger">*</span></label>
                            <select name="empresa_id" id="empresa_id" class="form-control form-control-pastel select2-mayus" required>
                                <option value="">SELECCIONE UNA EMPRESA</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                        {{ strtoupper($empresa->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-user-md mr-2 text-success"></i>Doctor <span class="text-danger">*</span></label>
                            <select name="doctor_id" id="doctor_id" class="form-control form-control-pastel select2-mayus" required>
                                <option value="">SELECCIONE UN DOCTOR</option>
                                @foreach($doctores as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
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
                            <input type="text" name="puesto" id="puesto" 
                                   class="form-control form-control-pastel text-uppercase" 
                                   value="{{ old('puesto') }}" placeholder="EJ: ANALISTA DE SISTEMAS">
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-star mr-2 text-danger"></i>Atención Prioritaria</label>
                            <select name="atencion_prioritaria" class="form-control form-control-pastel">
                                <option value="">NO APLICA</option>
                                <option value="EMBARAZADA">EMBARAZADA</option>
                                <option value="DISCAPACIDAD">PERSONA CON DISCAPACIDAD</option>
                                <option value="CATASTROFICA">ENFERMEDAD CATASTRÓFICA</option>
                                <option value="ADULTO MAYOR">ADULTO MAYOR</option>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- SECCIÓN DINÁMICA DE FECHAS SEGÚN TIPO --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label font-weight-bold text-primary"><i class="fas fa-list mr-2"></i>Tipo de Evaluación <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-control form-control-pastel border-primary shadow-sm font-weight-bold" required>
                                <option value="">-- SELECCIONE --</option>
                                <option value="INGRESO">INGRESO</option>
                                <option value="PERIODICA">PERIÓDICA</option>
                                <option value="RETIRO">RETIRO</option>
                                <option value="REINTEGRO">REINTEGRO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="p-3 rounded bg-light border d-flex justify-content-between">
                            <div class="date-input-group">
                                <label class="small font-weight-bold mb-0">F. INGRESO</label>
                                <input type="date" name="fecha_ingreso" id="fecha_ingreso" class="form-control form-control-sm fecha-input" disabled>
                            </div>
                            <div class="date-input-group">
                                <label class="small font-weight-bold mb-0">F. PERIÓDICA</label>
                                <input type="date" name="fecha_periodica" id="fecha_periodica" class="form-control form-control-sm fecha-input" disabled>
                            </div>
                            <div class="date-input-group">
                                <label class="small font-weight-bold mb-0">F. RETIRO</label>
                                <input type="date" name="fecha_retiro" id="fecha_retiro" class="form-control form-control-sm fecha-input" disabled>
                            </div>
                            <div class="date-input-group">
                                <label class="small font-weight-bold mb-0">F. REINTEGRO</label>
                                <input type="date" name="fecha_reintegro" id="fecha_reintegro" class="form-control form-control-sm fecha-input" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label class="form-label font-weight-bold">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="form-control form-control-pastel text-uppercase" placeholder="DESCRIPCIÓN ADICIONAL..."></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2">CANCELAR</button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i>GUARDAR REGISTRO
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
        border-radius: 8px;
        border: 1.5px solid #eee;
        padding: 10px;
        transition: all 0.3s ease;
    }
    
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
    }

    .form-control-pastel:disabled { background-color: #f8f9fa; border-color: #eee; }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; transition: 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .text-uppercase { text-transform: uppercase; }
    .date-input-group { flex: 1; margin: 0 5px; }
    .fecha-input:not(:disabled) { border: 2px solid var(--pastel-blue); background-color: #fff; }
    /* Asegura que el select tenga altura y el texto no se corte */
.form-control-pastel {
    height: calc(2.5rem + 2px) !important; /* Altura suficiente */
    padding: 0.375rem 0.75rem !important;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057 !important; /* Texto oscuro para que se vea */
    background-color: #ffffff !important; /* Fondo blanco para contraste */
    border: 1px solid #ced4da;
    border-radius: 8px; /* Bordes suaves */
    display: block;
    width: 100%;
}

/* Evita que el texto de las opciones sea invisible */
.form-control-pastel option {
    padding: 10px;
    color: #333 !important;
    background-color: #fff !important;
}

/* Efecto al seleccionar/enfocar */
.form-control-pastel:focus {
    border-color: #a1c4fd;
    box-shadow: 0 0 0 0.2rem rgba(161, 196, 253, 0.25);
    outline: none;
}
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // 1. Lógica de habilitar/deshabilitar fechas según tipo
        $('#tipo').on('change', function() {
            const seleccion = $(this).val();
            // Resetear y deshabilitar todos
            $('.fecha-input').prop('disabled', true).val('');
            
            if(seleccion === 'INGRESO') $('#fecha_ingreso').prop('disabled', false).focus();
            if(seleccion === 'PERIODICA') $('#fecha_periodica').prop('disabled', false).focus();
            if(seleccion === 'RETIRO') $('#fecha_retiro').prop('disabled', false).focus();
            if(seleccion === 'REINTEGRO') $('#fecha_reintegro').prop('disabled', false).focus();
        });

        // 2. Forzar mayúsculas en tiempo real y al enviar
        $('input[type="text"], textarea').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // 3. Confirmación de Guardado con SweetAlert
        $('#registroForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Confirmar Registro?',
                text: "Se creará una nueva evaluación para este paciente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Revisar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Convertir todo a mayúsculas antes del envío final
                    $(this).find('input[type="text"], textarea').each(function() {
                        $(this).val($(this).val().toUpperCase());
                    });
                    this.submit();
                }
            });
        });

        // 4. Botón Cancelar
        $('#btnCancelar').on('click', function () {
            Swal.fire({
                title: '¿Descartar cambios?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Salir',
                confirmButtonColor: '#CAB8FF',
                cancelButtonText: 'Continuar editando'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ url('/admin/pacientes/'.$paciente->id.'/registros') }}";
                }
            });
        });
    });
</script>
@stop