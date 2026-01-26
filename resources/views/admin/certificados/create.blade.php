@extends('adminlte::page')

@section('title', 'Crear Certificado')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-file-medical-alt mr-2"></i>Nuevo Certificado Médico
    </h1>
    <a href="{{ route('admin.certificados.byPaciente', $paciente->id) }}"
        class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver a la lista
    </a>


</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 RESUMEN DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-circle mr-2"></i>Paciente Seleccionado</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-5 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($paciente->primer_nombre) }} {{ strtoupper($paciente->segundo_nombre) }} 
                        {{ strtoupper($paciente->primer_apellido) }} {{ strtoupper($paciente->segundo_apellido) }}
                    </span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Cédula</small>
                    <span class="h6 font-weight-bold">{{ $paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Empresa asignada</small>
                    <span class="text-dark font-weight-500">{{ strtoupper($paciente->sucursal->nombre ?? 'SIN SUCURSAL') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE CERTIFICADO --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-pen-nib mr-2"></i>Detalles del Certificado
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.certificados.store') }}" method="POST" id="certificadoForm">
                @csrf
                {{-- Campos ocultos necesarios --}}
                <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

                <div class="row">
                    {{-- Bloque: Información General --}}
                    <div class="col-md-6 border-right">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Empresa que solicita <span class="text-danger">*</span></label>
                            <select name="empresa_id" class="form-control form-control-pastel select2-mayus" required>
                                <option value="">SELECCIONE EMPRESA</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                        {{ strtoupper($empresa->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Médico Evaluador <span class="text-danger">*</span></label>
                            <select name="doctor_id" class="form-control form-control-pastel" required>
                                <option value="">SELECCIONE MÉDICO</option>
                                @foreach($doctores as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        DR(A). {{ strtoupper($doctor->primer_nombre) }} {{ strtoupper($doctor->primer_apellido) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-primary">Tipo Evaluación <span class="text-danger">*</span></label>
                                    <select name="tipo" class="form-control form-control-pastel border-primary" required>
                                        <option value="">-- SELECCIONE --</option>
                                        <option value="ingreso" {{ old('tipo') == 'ingreso' ? 'selected' : '' }}>INGRESO</option>
                                        <option value="periodica" {{ old('tipo') == 'periodica' ? 'selected' : '' }}>PERIÓDICA</option>
                                        <option value="retiro" {{ old('tipo') == 'retiro' ? 'selected' : '' }}>RETIRO</option>
                                        <option value="reintegro" {{ old('tipo') == 'reintegro' ? 'selected' : '' }}>REINTEGRO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Fecha Emisión <span class="text-danger">*</span></label>
                                    <input type="date" name="fecha_emision" class="form-control form-control-pastel" value="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bloque: Aptitud y Puesto --}}
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">Puesto de Trabajo</label>
                            <input type="text" name="puesto" class="form-control form-control-pastel text-uppercase" placeholder="EJ: OPERADOR DE MAQUINARIA" value="{{ old('puesto') }}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-danger">Aptitud Médica <span class="text-danger">*</span></label>
                            <select name="aptitud" id="aptitud" class="form-control form-control-pastel border-danger" required>
                                <option value="">-- SELECCIONE APTITUD --</option>
                                <option value="apto" {{ old('aptitud') == 'apto' ? 'selected' : '' }}>APTO</option>
                                <option value="apto en observacion" {{ old('aptitud') == 'apto en observacion' ? 'selected' : '' }}>APTO EN OBSERVACIÓN</option>
                                <option value="apto con limitacion" {{ old('aptitud') == 'apto con limitacion' ? 'selected' : '' }}>APTO CON LIMITACIÓN</option>
                                <option value="no apto" {{ old('aptitud') == 'no apto' ? 'selected' : '' }}>NO APTO</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Observación de Aptitud</label>
                            <textarea name="observa_aptitud" rows="2" class="form-control form-control-pastel text-uppercase" placeholder="DETALLES DE LA APTITUD...">{{ old('observa_aptitud') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Bloque: Recomendaciones --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-success"><i class="fas fa-clipboard-check mr-2"></i>Descripción de Recomendaciones</label>
                            <textarea name="descripcion_reco" rows="3" class="form-control form-control-pastel text-uppercase" placeholder="INDIQUE LAS RECOMENDACIONES...">{{ old('descripcion_reco') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="font-weight-bold text-info"><i class="fas fa-eye mr-2"></i>Observaciones de Recomendaciones</label>
                            <textarea name="observa_reco" rows="3" class="form-control form-control-pastel text-uppercase" placeholder="OBSERVACIONES ADICIONALES...">{{ old('observa_reco') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2 px-4">CANCELAR</button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i>GENERAR CERTIFICADO
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

    .card-pastel { border: none; border-radius: 12px; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-light-soft { background-color: #fafafa; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .text-pastel-blue { color: #5fa8c3 !important; }
    
    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #dce4ec;
        height: auto !important;
        padding: 10px 15px !important;
        transition: all 0.3s ease;
    }
    
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-blue:hover { background: #91c9de; color: #1a252f; transform: translateY(-1px); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .text-uppercase { text-transform: uppercase; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // 1. Mayúsculas automáticas mientras escribe
        $('input[type="text"], textarea').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // 2. Confirmación SweetAlert
        $('#certificadoForm').on('submit', function(e) {
            e.preventDefault();

            // Validar campos requeridos antes de la animación
            if (!this.checkValidity()) {
                this.reportValidity();
                return;
            }
            
            Swal.fire({
                title: '¿EMITIR CERTIFICADO?',
                text: "Verifique que los datos de aptitud sean los correctos.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'SÍ, GUARDAR',
                cancelButtonText: 'REVISAR',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Asegurar que todo se envíe en mayúsculas
                    $(this).find('input[type="text"], textarea').each(function() {
                        $(this).val($(this).val().toUpperCase());
                    });
                    this.submit();
                }
            });
        });

        // 3. Botón Cancelar
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