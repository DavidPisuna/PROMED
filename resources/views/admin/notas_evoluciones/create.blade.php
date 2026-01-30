@extends('adminlte::page')

@section('title', 'Nueva Nota de Evolución')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-file-medical mr-2"></i>Nueva Nota de Evolución
    </h1>
    <a href="{{ route('admin.notas.byPaciente', $paciente) }}"
        class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver a la lista
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">

    {{-- 🧑 RESUMEN DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-circle mr-2"></i>Paciente Seleccionado</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-5 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark text-uppercase">
                        {{ $paciente->primer_apellido }} {{ $paciente->segundo_apellido }} 
                        {{ $paciente->primer_nombre }} {{ $paciente->segundo_nombre }}
                    </span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación (C.I.)</small>
                    <span class="h6 font-weight-bold">{{ $paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Edad Clínica</small>
                    <span class="h6 font-weight-bold">
                        {{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age . ' años' : 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.notas.store') }}" method="POST" id="notaEvolucionForm">
        @csrf
        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

        {{-- 📋 FORMULARIO DE NOTA --}}
        <div class="card card-pastel shadow-lg">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                    <i class="fas fa-notes-medical mr-2"></i>Registro de Evolución
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- EMPRESA --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Empresa Solicitante <span class="text-danger">*</span></label>
                            <select name="empresa_id" class="form-control form-control-pastel select2" required>
                                <option value="">-- SELECCIONE --</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                        {{ strtoupper($empresa->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- MÉDICO --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Médico Responsable <span class="text-danger">*</span></label>
                            <select name="doctor_id" class="form-control form-control-pastel" required>
                                <option value="">-- SELECCIONE --</option>
                                @foreach($doctores as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        DR(A). {{ strtoupper($doctor->primer_nombre) }} {{ strtoupper($doctor->primer_apellido) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- FECHA Y HORA --}}
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold">Fecha</label>
                            <input type="date" name="fecha" class="form-control form-control-pastel" 
                                   value="{{ old('fecha', now()->toDateString()) }}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold">Hora</label>
                            <input type="time" name="hora" class="form-control form-control-pastel" 
                                   value="{{ old('hora', now()->format('H:i')) }}" required>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- PROBLEMAS --}}
                <div class="form-group">
                    <label class="font-weight-bold">Problemas Detectados (Lista)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light border-right-0"><i class="fas fa-list-ol text-muted"></i></span>
                        </div>
                        <input type="text" name="problemas" id="inputProblemas" class="form-control form-control-pastel border-left-0" 
                               placeholder="EJ: 1. CEFALEA  2. DOLOR ABDOMINAL" value="{{ old('problemas') }}">
                    </div>
                    <small class="text-info font-italic">Se guardará automáticamente en MAYÚSCULAS.</small>
                </div>

                {{-- EVOLUCIÓN --}}
                <div class="form-group">
                    <label class="font-weight-bold">Comentarios y Evolución Clínica <span class="text-danger">*</span></label>
                    <textarea name="evolucion" id="textareaEvolucion" rows="8" class="form-control form-control-pastel" 
                              placeholder="ESCRIBA EL DETALLE DE LA EVOLUCIÓN DEL PACIENTE..." required>{{ old('evolucion') }}</textarea>
                </div>
            </div>

            <div class="card-footer bg-white d-flex justify-content-end py-3">
                <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2 px-4">
                    CANCELAR
                </button>
                <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm font-weight-bold text-dark">
                    <i class="fas fa-save mr-2"></i>GUARDAR NOTA DE EVOLUCIÓN
                </button>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
    :root { 
        --pastel-blue: #A8D8EA; 
        --pastel-purple: #CAB8FF; 
        --pastel-gray: #E3E3E3; 
    }
    
    /* Estilos de Tarjetas */
    .card-pastel { border: none; border-radius: 15px; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-light-soft { background-color: #fafafa; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .text-pastel-blue { color: #5fa8c3 !important; }
    
    /* Inputs Pastel */
    .form-control-pastel { 
        border-radius: 8px; 
        border: 1.5px solid #dce4ec; 
        transition: all 0.3s ease; 
        text-transform: uppercase; /* Forzado visual en CSS */
    }
    .form-control-pastel:focus { 
        border-color: var(--pastel-blue); 
        box-shadow: 0 0 10px rgba(168, 216, 234, 0.5); 
        outline: none;
    }

    /* Botones */
    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; transition: all 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .input-group-text { border-radius: 8px 0 0 8px; border: 1.5px solid #dce4ec; border-right: none; }
    
    /* Select2 personalizado si lo usas */
    .select2-container--default .select2-selection--single { border-radius: 8px; border: 1.5px solid #dce4ec; height: calc(2.25rem + 2px); }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        // 1. MAYÚSCULAS AUTOMÁTICAS (En tiempo real)
        // Aplicamos a todos los inputs de texto y textareas
        $(document).on('input', 'input[type="text"], textarea', function() {
            let start = this.selectionStart;
            let end = this.selectionEnd;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(start, end); // Mantiene la posición del cursor
        });

        // 2. CONFIRMACIÓN DE GUARDADO CON SWEETALERT2
        $('#notaEvolucionForm').on('submit', function(e) {
            e.preventDefault();
            
            // Asegurar mayúsculas finales antes de enviar
            $(this).find('input[type="text"], textarea').each(function() {
                $(this).val($(this).val().toUpperCase());
            });

            Swal.fire({
                title: '¿CONFIRMAR REGISTRO?',
                text: "La nota se agregará al expediente clínico del paciente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: '<span style="color: #2c3e50">SÍ, GUARDAR</span>',
                cancelButtonText: 'REVISAR',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar carga
                    Swal.fire({
                        title: 'Guardando...',
                        didOpen: () => { Swal.showLoading() },
                        allowOutsideClick: false
                    });
                    this.submit();
                }
            });
        });

        // 3. BOTÓN CANCELAR
        $('#btnCancelar').on('click', function () {
            Swal.fire({
                title: '¿DESCARTAR NOTA?',
                text: "Si sales ahora, perderás la información escrita.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffb3b3',
                confirmButtonText: 'SÍ, SALIR',
                cancelButtonText: 'VOLVER',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.notas.byPaciente', $paciente) }}";
                }
            });
        });

        // 4. MANEJO DE ERRORES DE LARAVEL (BACKEND)
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Atención',
                html: `<div class="text-left">
                        <p>Por favor corrige lo siguiente:</p>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                       </div>`,
                confirmButtonText: 'Entendido'
            });
        @endif
    });
</script>
@stop