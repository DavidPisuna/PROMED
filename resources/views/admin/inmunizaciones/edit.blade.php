@extends('adminlte::page')

@section('title', 'Editar Inmunización')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-syringe mr-2"></i> Editar Inmunización #{{ $inmunizacion->id }}
    </h1>
    <a href="{{ route('admin.inmunizaciones.show', $inmunizacion) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">

    {{-- ERRORES DE VALIDACIÓN --}}
    @if($errors->any())
    <div class="alert alert-danger shadow-sm border-0" style="border-radius: 12px;">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- 🔹 INFO DEL PACIENTE (DIRECTO, SIN @INCLUDE) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Información del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark text-uppercase">
                        {{ $inmunizacion->paciente->primer_nombre }} {{ $inmunizacion->paciente->primer_apellido }}
                    </span>
                </div>
                <div class="col-md-6 text-md-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación</small>
                    <span class="h6 font-weight-bold text-dark">{{ $inmunizacion->paciente->cedula_identidad }}</span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.inmunizaciones.update', $inmunizacion) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card card-pastel shadow-sm">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="font-weight-bold text-pastel-purple mb-0">Datos Generales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- EMPRESA --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-muted text-uppercase">Empresa Solicitante</label>
                            <select name="empresa_id" class="form-control" required>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id', $inmunizacion->empresa_id) == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- DOCTOR --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small font-weight-bold text-muted text-uppercase">Médico Responsable</label>
                            <select name="doctor_id" class="form-control" required>
                                @foreach($doctores as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $inmunizacion->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                        DR(A). {{ $doctor->primer_nombre }} {{ $doctor->primer_apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="small font-weight-bold text-muted text-uppercase">Observaciones Generales</label>
                    <textarea name="observaciones_generales" class="form-control text-uppercase" rows="2">{{ old('observaciones_generales', $inmunizacion->observaciones_generales) }}</textarea>
                </div>
            </div>
        </div>

        {{-- TABLA DINÁMICA DE VACUNAS --}}
        <div class="card card-pastel shadow-lg mt-4">
            <div class="card-header bg-light">
                <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-syringes mr-2"></i>Detalle de Vacunas</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0" id="tabla-vacunas">
                    <thead class="bg-light small text-muted text-uppercase">
                        <tr>
                            <th style="width: 30%">Vacuna</th>
                            <th>Dosis</th>
                            <th>Fecha</th>
                            <th>Lote</th>
                            <th class="text-center">Esquema</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inmunizacion->detalles as $index => $detalle)
                        <tr>
                            <td>
                                <input type="text" name="vacunas[{{ $index }}][vacuna]" class="form-control form-control-sm text-uppercase" value="{{ $detalle->vacuna }}" required>
                            </td>
                            <td>
                                <input type="text" name="vacunas[{{ $index }}][dosis]" class="form-control form-control-sm text-uppercase" value="{{ $detalle->dosis }}" required>
                            </td>
                            <td>
                                <input type="date" name="vacunas[{{ $index }}][fecha]" class="form-control form-control-sm" value="{{ $detalle->fecha }}">
                            </td>
                            <td>
                                <input type="text" name="vacunas[{{ $index }}][lote]" class="form-control form-control-sm text-uppercase" value="{{ $detalle->lote }}">
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="vacunas[{{ $index }}][esquema_completo]" value="1" {{ $detalle->esquema_completo ? 'checked' : '' }}>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger eliminar-fila"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white border-top-0">
                <button type="submit" class="btn btn-primary shadow-sm float-right px-4">
                    <i class="fas fa-save mr-2"></i> Actualizar Registro
                </button>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
    :root { --pastel-blue: #A8D8EA; --pastel-purple: #CAB8FF; --pastel-gray: #E3E3E3; }
    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-purple { color: #9b86d6 !important; }
    .btn-pastel-gray { background-color: var(--pastel-gray); border: none; border-radius: 8px; font-weight: 600; color: #666; }
    .form-control { border-radius: 8px; }
</style>
@stop

@section('js')
<script>
    $(document).on('click', '.eliminar-fila', function() {
        if ($('#tabla-vacunas tbody tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            alert('Debe haber al menos una vacuna registrada.');
        }
    });
</script>
@stop