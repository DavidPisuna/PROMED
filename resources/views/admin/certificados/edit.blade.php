@extends('adminlte::page')

@section('title', 'Editar Certificado')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Certificado Médico
    </h1>
        <a href="{{ route('admin.certificados.byPaciente', $paciente) }}"
            class="btn btn-pastel-gray shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i> Volver a certificados del paciente
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
                        {{ strtoupper($paciente->primer_nombre) }} {{ strtoupper($paciente->segundo_nombre) }} 
                        {{ strtoupper($paciente->primer_apellido) }} {{ strtoupper($paciente->segundo_apellido) }}
                    </span>
                </div>
                <div class="col-md-2 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación</small>
                    <span class="h6 font-weight-bold">{{ $paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-6">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Empresa/Sucursal Original</small>
                    <span class="text-dark font-weight-500">{{ strtoupper($paciente->sucursal->nombre ?? 'N/A') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-sync-alt mr-2"></i>Actualizar Evaluación Médica
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.certificados.update', $certificado) }}" method="POST" id="registroForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

                <div class="row">
                    {{-- Columna Izquierda --}}
                    <div class="col-md-6 border-right">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-building mr-2 text-info"></i>Empresa del Certificado <span class="text-danger">*</span></label>
                            <select name="empresa_id" id="empresa_id" class="form-control form-control-pastel" required>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id', $certificado->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                        {{ strtoupper($empresa->nombre ?? $empresa->razon_social) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-user-md mr-2 text-success"></i>Doctor <span class="text-danger">*</span></label>
                            <select name="doctor_id" id="doctor_id" class="form-control form-control-pastel" required>
                                @foreach($doctores as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $certificado->doctor_id) == $doctor->id ? 'selected' : '' }}>
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
                                   value="{{ old('puesto', $certificado->puesto) }}" placeholder="EJ: ANALISTA DE SISTEMAS">
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-calendar-alt mr-2 text-danger"></i>Fecha de Emisión <span class="text-danger">*</span></label>
                            <input type="date" name="fecha_emision" class="form-control form-control-pastel" 
                                   value="{{ old('fecha_emision', \Carbon\Carbon::parse($certificado->fecha_emision)->format('Y-m-d')) }}" required>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label font-weight-bold text-primary"><i class="fas fa-list mr-2"></i>Tipo de Evaluación <span class="text-danger">*</span></label>
                            <select name="tipo" id="tipo" class="form-control form-control-pastel border-primary font-weight-bold" required>
                                @foreach(['ingreso' => 'INGRESO', 'periodica' => 'PERIÓDICA', 'retiro' => 'RETIRO', 'reintegro' => 'REINTEGRO'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('tipo', $certificado->tipo) == $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label font-weight-bold text-success"><i class="fas fa-check-circle mr-2"></i>Aptitud Médica <span class="text-danger">*</span></label>
                            <select name="aptitud" class="form-control form-control-pastel border-success font-weight-bold" required>
                                @foreach(['apto', 'apto en observacion', 'apto con limitacion', 'no apto'] as $apt)
                                    <option value="{{ $apt }}" {{ old('aptitud', $certificado->aptitud) == $apt ? 'selected' : '' }}>{{ strtoupper($apt) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label class="form-label font-weight-bold">Observaciones de Aptitud</label>
                    <textarea name="observa_aptitud" rows="2" class="form-control form-control-pastel text-uppercase">{{ old('observa_aptitud', $certificado->observa_aptitud) }}</textarea>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Descripción Recomendaciones</label>
                        <textarea name="descripcion_reco" rows="3" class="form-control form-control-pastel text-uppercase">{{ old('descripcion_reco', $certificado->descripcion_reco) }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-weight-bold">Observaciones Generales</label>
                        <textarea name="observa_reco" rows="3" class="form-control form-control-pastel text-uppercase">{{ old('observa_reco', $certificado->observa_reco) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2">CANCELAR</button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i>ACTUALIZAR CERTIFICADO
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
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-purple { color: #8e74d1 !important; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    
    .form-control-pastel {
        height: calc(2.5rem + 2px) !important;
        border-radius: 8px;
        border: 1px solid #ced4da;
        background-color: #ffffff !important;
        color: #495057 !important;
    }
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 0 0.2rem rgba(168, 216, 234, 0.25);
    }
    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; transition: 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); color: #2c3e50; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    .text-uppercase { text-transform: uppercase; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // 1. Mayúsculas en tiempo real
        $('input[type="text"], textarea').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // 2. Confirmación con SweetAlert2
        $('#registroForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Guardar cambios?',
                text: "Se actualizará la información del certificado médico.",
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

        // 3. Botón Cancelar con advertencia
        $('#btnCancelar').on('click', function () {
            Swal.fire({
                title: '¿DESCARTAR?',
                text: "Se perderán los datos ingresados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#CAB8FF',
                confirmButtonText: 'SÍ, SALIR',
                cancelButtonText: 'CONTINUAR AQUÍ'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.certificados.byPaciente', $paciente) }}";
                }
            });
        });


    });
</script>
@stop