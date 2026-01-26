@extends('adminlte::page')

@section('title', 'Editar Antecedente Gineco Obstétrico')

@section('content_header')

<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Antecedente Gineco Obstétrico
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
{{-- 🔹 CARD INFORMATIVA DEL PACIENTE --}}
<div class="card card-pastel shadow-sm mb-4">
    <div class="card-header bg-pastel-blue py-2">
        <h6 class="mb-0 font-weight-bold text-white">
            <i class="fas fa-user-circle mr-2"></i>Resumen del Paciente
        </h6>
    </div>
    <div class="card-body bg-light-soft py-3">
        <div class="row align-items-center">
            <div class="col-md-4 border-right">
                <small class="text-muted d-block text-uppercase font-weight-bold small">Nombre Completo</small>
                <span class="h6 font-weight-bold text-dark">
                    {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->segundo_nombre) }} 
                    {{ strtoupper($registro->paciente->primer_apellido) }} {{ strtoupper($registro->paciente->segundo_apellido) }}
                </span>
            </div>
            <div class="col-md-2 border-right">
                <small class="text-muted d-block text-uppercase font-weight-bold small">Identificación</small>
                <span class="h6 font-weight-bold text-dark">{{ $registro->paciente->cedula_identidad }}</span>
            </div>
            <div class="col-md-2 border-right text-center">
                <small class="text-muted d-block text-uppercase font-weight-bold small">Edad</small>
                <span class="badge badge-pill bg-pastel-purple px-3">
                    {{ \Carbon\Carbon::parse($registro->paciente->fecha_nacimiento)->age }} años
                </span>
            </div>
            <div class="col-md-4 pl-4">
                <small class="text-muted d-block text-uppercase font-weight-bold small">Empresa / Sucursal</small>
                <span class="text-dark font-weight-bold">
                    <i class="fas fa-building mr-1 text-muted"></i>
                    {{ strtoupper($registro->paciente->sucursal->nombre ?? 'SIN SUCURSAL') }}
                </span>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid pb-4">
    <form method="POST" action="{{ route('admin.antecedentes_gineco_obstetricos.update', $antecedenteGineco) }}" id="ginecoForm">
        @csrf
        @method('PUT')

        <input type="hidden" name="registro_id" value="{{ $registro->id }}">

        {{-- ================= INFORMACIÓN GINECO OBSTÉTRICA ================= --}}
        <div class="card card-pastel shadow-sm mb-4">
            <div class="card-header bg-pastel-blue py-2">
                <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-female mr-2"></i>Información Gineco Obstétrica</h6>
            </div>
            <div class="card-body bg-light-soft">
                <div class="row">
                    @foreach(['gestas','partos','cesareas','abortos'] as $campo)
                    <div class="col-md-3 mb-3">
                        <label class="form-label font-weight-bold">{{ ucfirst($campo) }}</label>
                        <input type="number" class="form-control form-control-pastel" name="{{ $campo }}" min="0" 
                               value="{{ old($campo, $antecedenteGineco->$campo) }}">
                    </div>
                    @endforeach

                    <div class="col-md-4 mt-2">
                        <label class="form-label font-weight-bold">Fecha Última Menstruación</label>
                        <input type="date" name="fecha_ultima_menstruacion" class="form-control form-control-pastel"
                               value="{{ old('fecha_ultima_menstruacion', $antecedenteGineco->fecha_ultima_menstruacion) }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- ================= PLANIFICACIÓN FAMILIAR ================= --}}
        <div class="card card-pastel shadow-sm mb-4">
            <div class="card-header bg-pastel-purple py-2">
                <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-pills mr-2"></i>Planificación Familiar</h6>
            </div>
            <div class="card-body">
                @php
                    $plan = $antecedenteGineco->planificacion_si ? 'si' : ($antecedenteGineco->planificacion_no ? 'no' : 'nr');
                @endphp

                <div class="d-flex gap-4 mb-3">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="plan_si" name="planificacion" value="si" class="custom-control-input plan-radio" {{ $plan=='si'?'checked':'' }}>
                        <label class="custom-control-label" for="plan_si">SÍ</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="plan_no" name="planificacion" value="no" class="custom-control-input plan-radio" {{ $plan=='no'?'checked':'' }}>
                        <label class="custom-control-label" for="plan_no">NO</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="plan_nr" name="planificacion" value="nr" class="custom-control-input plan-radio" {{ $plan=='nr'?'checked':'' }}>
                        <label class="custom-control-label" for="plan_nr">NO RESPONDE</label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="font-weight-bold">Método seleccionado:</label>
                    <input type="text" name="planificacion_cual" id="planificacion_cual" 
                           class="form-control form-control-pastel bg-light" 
                           readonly value="{{ strtoupper($antecedenteGineco->planificacion_cual) }}">
                    <small class="text-muted">Si selecciona "SÍ", se le pedirá especificar mediante una ventana emergente.</small>
                </div>
            </div>
        </div>

        {{-- ================= EXÁMENES ================= --}}
        <div class="card card-pastel shadow-sm mb-4">
            <div class="card-header bg-pastel-green py-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-microscope mr-2"></i>Exámenes Realizados</h6>
                <button type="button" class="btn btn-sm btn-white shadow-sm" id="add-examen">
                    <i class="fas fa-plus text-success"></i> Agregar Examen
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Examen</th>
                            <th width="150">Meses</th>
                            <th>Resultado</th>
                            <th width="50"></th>
                        </tr>
                    </thead>
                    <tbody id="examenes-body">
                        @foreach($antecedenteGineco->examenes as $examen)
                        <tr>
                            <input type="hidden" name="examen_id[]" value="{{ $examen->id }}">
                            <td><input type="text" name="examen_realizado[]" class="form-control form-control-sm text-uppercase" value="{{ $examen->examen_realizado }}"></td>
                            <td><input type="number" name="tiempo_meses[]" class="form-control form-control-sm" value="{{ $examen->tiempo_meses }}"></td>
                            <td><input type="text" name="resultado[]" class="form-control form-control-sm text-uppercase" value="{{ $examen->resultado }}"></td>
                            <td><button type="button" class="btn btn-link text-danger remove-examen"><i class="fas fa-trash"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                <i class="fas fa-save mr-2"></i>ACTUALIZAR ANTECEDENTES
            </button>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
    :root { --pastel-blue: #A8D8EA; --pastel-purple: #CAB8FF; --pastel-green: #B6E2D3; --pastel-gray: #E3E3E3; }
    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    .bg-pastel-green { background-color: var(--pastel-green) !important; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .form-control-pastel { border-radius: 8px; border: 1.5px solid #eee; transition: 0.3s; }
    .form-control-pastel:focus { border-color: var(--pastel-blue); box-shadow: 0 0 8px rgba(168,216,234,0.4); }
    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    .gap-4 { gap: 1.5rem; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // 1. Forzar mayúsculas en inputs de texto
    $(document).on('input', 'input[type="text"]', function() {
        this.value = this.value.toUpperCase();
    });

    // 2. Lógica de Planificación con SweetAlert2
    $('.plan-radio').on('change', function() {
        let valor = $(this).val();
        let inputCual = $('#planificacion_cual');

        if (valor === 'si') {
            Swal.fire({
                title: '¿Qué método utiliza?',
                input: 'text',
                inputLabel: 'Especifique el método de planificación',
                inputPlaceholder: 'EJ: PRESERVATIVOS, T DE COBRE...',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                inputAttributes: { 'style': 'text-transform: uppercase;' },
                preConfirm: (value) => {
                    if (!value) {
                        Swal.showValidationMessage('Debe ingresar un método si selecciona SÍ');
                    }
                    return value.toUpperCase();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    inputCual.val(result.value);
                } else {
                    // Si cancela, regresamos el radio a "No responde" o "No"
                    $('#plan_nr').prop('checked', true);
                    inputCual.val('');
                }
            });
        } else {
            inputCual.val('');
        }
    });

    // 3. Agregar / Eliminar Exámenes
    $('#add-examen').click(function() {
        $('#examenes-body').append(`
            <tr>
                <input type="hidden" name="examen_id[]" value="">
                <td><input type="text" name="examen_realizado[]" class="form-control form-control-sm text-uppercase"></td>
                <td><input type="number" name="tiempo_meses[]" class="form-control form-control-sm"></td>
                <td><input type="text" name="resultado[]" class="form-control form-control-sm text-uppercase"></td>
                <td><button type="button" class="btn btn-link text-danger remove-examen"><i class="fas fa-trash"></i></button></td>
            </tr>
        `);
    });

    $(document).on('click', '.remove-examen', function() {
        $(this).closest('tr').remove();
    });

    // 4. Confirmación al actualizar
    $('#ginecoForm').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Guardar cambios?',
            text: "Se actualizarán los antecedentes de la paciente.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#A8D8EA',
            confirmButtonText: 'Sí, actualizar'
        }).then((result) => {
            if (result.isConfirmed) this.submit();
        });
    });
});
</script>
@stop