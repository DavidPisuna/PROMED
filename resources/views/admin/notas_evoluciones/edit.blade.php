@extends('adminlte::page')

@section('title', 'Editar Nota de Evolución')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-warning font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Nota de Evolución
    </h1>
    <a href="{{ route('admin.notas.byPaciente', $nota->paciente) }}"
        class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver a la lista
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">

    {{-- 🧑 DATOS DEL PACIENTE (LECTURA) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-warning py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Paciente en Edición</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-5 border-right border-warning-light">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark text-uppercase">
                        {{ $nota->paciente->primer_apellido }} {{ $nota->paciente->segundo_apellido }} 
                        {{ $nota->paciente->primer_nombre }} {{ $nota->paciente->segundo_nombre }}
                    </span>
                </div>
                <div class="col-md-3 border-right border-warning-light">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Cédula</small>
                    <span class="h6 font-weight-bold">{{ $nota->paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Edad Clínica</small>
                    <span class="h6 font-weight-bold">
                        {{ $nota->paciente->fecha_nacimiento ? \Carbon\Carbon::parse($nota->paciente->fecha_nacimiento)->age . ' años' : 'N/A' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.notas.update', $nota) }}" method="POST" id="editNotaForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="paciente_id" value="{{ $nota->paciente_id }}">

        {{-- 📋 FORMULARIO DE EDICIÓN --}}
        <div class="card card-pastel shadow-lg border-warning-soft">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0 font-weight-bold text-pastel-orange">
                    <i class="fas fa-clipboard-check mr-2"></i>Actualizar Registro Clínico
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- EMPRESA --}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Empresa Solicitante <span class="text-danger">*</span></label>
                            <select name="empresa_id" class="form-control form-control-pastel" required>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ $nota->empresa_id == $empresa->id ? 'selected' : '' }}>
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
                                @foreach($doctores as $doctor)
                                    <option value="{{ $doctor->id }}" {{ $nota->doctor_id == $doctor->id ? 'selected' : '' }}>
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
                                   value="{{ $nota->fecha }}" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="font-weight-bold">Hora</label>
                            <input type="time" name="hora" class="form-control form-control-pastel" 
                                   value="{{ \Carbon\Carbon::parse($nota->hora)->format('H:i') }}" required>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- PROBLEMAS --}}
                <div class="form-group">
                    <label class="font-weight-bold">Identificación de Problemas</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light border-right-0"><i class="fas fa-list-ul"></i></span>
                        </div>
                        <input type="text" name="problemas" class="form-control form-control-pastel border-left-0" 
                               value="{{ $nota->problemas }}" placeholder="EJ: 1. HIPERTENSIÓN ARTERIAL">
                    </div>
                </div>

                {{-- EVOLUCIÓN --}}
                <div class="form-group">
                    <label class="font-weight-bold">Evolución Clínica <span class="text-danger">*</span></label>
                    <textarea name="evolucion" rows="8" class="form-control form-control-pastel" 
                              placeholder="DETALLE LA EVOLUCIÓN..." required>{{ $nota->evolucion }}</textarea>
                </div>
            </div>

            <div class="card-footer bg-white d-flex justify-content-end py-3">
                <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2 px-4">CANCELAR</button>
                <button type="submit" class="btn btn-pastel-orange px-5 shadow-sm font-weight-bold text-white">
                    <i class="fas fa-sync-alt mr-2"></i>ACTUALIZAR NOTA
                </button>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
    :root { 
        --pastel-warning: #FFECB3; /* Amarillo pastel */
        --pastel-orange: #FFCC80;  /* Naranja pastel para botones */
        --pastel-gray: #E3E3E3; 
    }
    
    .card-pastel { border: none; border-radius: 15px; overflow: hidden; }
    .bg-pastel-warning { background-color: var(--pastel-warning) !important; }
    .border-warning-light { border-color: #ffe082 !important; }
    .border-warning-soft { border: 1px solid #fff9c4; }
    .text-pastel-warning { color: #fbc02d !important; }
    .text-pastel-orange { color: #ef6c00 !important; }
    .bg-light-soft { background-color: #fcfcfc; }

    .form-control-pastel { 
        border-radius: 8px; 
        border: 1.5px solid #ffecb3; 
        transition: all 0.3s ease; 
        text-transform: uppercase;
    }
    .form-control-pastel:focus { 
        border-color: var(--pastel-orange); 
        box-shadow: 0 0 10px rgba(255, 204, 128, 0.4); 
    }

    .btn-pastel-orange { background: var(--pastel-orange); border: none; border-radius: 8px; }
    .btn-pastel-orange:hover { background: #ffb74d; transform: translateY(-1px); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .input-group-text { border-radius: 8px 0 0 8px; border: 1.5px solid #ffecb3; border-right: none; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        // 1. CONVERSIÓN A MAYÚSCULAS (Mantiene posición del cursor)
        $(document).on('input', 'input[type="text"], textarea', function() {
            let start = this.selectionStart;
            let end = this.selectionEnd;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(start, end);
        });

        // 2. SWEETALERT PARA ACTUALIZACIÓN
        $('#editNotaForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿ACTUALIZAR INFORMACIÓN?',
                text: "Se guardarán los cambios realizados en esta nota de evolución.",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#FFCC80',
                confirmButtonText: '<span style="color: #5d4037">SÍ, ACTUALIZAR</span>',
                cancelButtonText: 'CANCELAR',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // 3. BOTÓN CANCELAR
        $('#btnCancelar').on('click', function () {
            Swal.fire({
                title: '¿SALIR SIN GUARDAR?',
                text: "Los cambios realizados se perderán permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3e3e3',
                confirmButtonText: '<span style="color: #333">SÍ, SALIR</span>',
                cancelButtonText: 'VOLVER',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.notas.byPaciente', $nota->paciente) }}";
                }
            });
        });

        // 4. ERRORES DE BACKEND
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'No se pudo actualizar',
                html: '<ul class="text-left">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>',
                confirmButtonText: 'Corregir'
            });
        @endif
    });
</script>
@stop