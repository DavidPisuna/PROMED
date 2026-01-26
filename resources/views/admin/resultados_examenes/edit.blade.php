@extends('adminlte::page')

@section('title', 'Editar Resultado de Examen')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Resultado de Examen
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">

    {{-- 🔹 RESUMEN DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold">
                <i class="fas fa-user-circle mr-2"></i>Resumen del Paciente
            </h6>
        </div>
        <div class="card-body bg-light-soft">
            <div class="row">
                <div class="col-md-4 border-right">
                    <small class="text-muted font-weight-bold text-uppercase d-block">Paciente</small>
                    <div class="h6 font-weight-bold mb-0">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </div>
                </div>
                <div class="col-md-4 border-right">
                    <small class="text-muted font-weight-bold text-uppercase d-block">Tipo de Evaluación</small>
                    <span class="badge bg-pastel-purple px-3">
                        {{ strtoupper($registro->tipo) }}
                    </span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted font-weight-bold text-uppercase d-block">Fecha Registro</small>
                    <div class="font-weight-bold text-dark">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-microscope mr-2"></i>Información del Examen
            </h5>
        </div>

        <div class="card-body">
            <form method="POST" 
                  action="{{ route('admin.resultados_examenes.update', [$registro->id, $resultadoExamen->id]) }}" 
                  id="examenForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-flask text-info mr-1"></i>Nombre del Examen <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre_examen" 
                                   class="form-control form-control-pastel text-uppercase" 
                                   value="{{ old('nombre_examen', $resultadoExamen->nombre_examen) }}" 
                                   required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-calendar-alt text-success mr-1"></i>Fecha del Examen <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   name="fecha_examen" 
                                   class="form-control form-control-pastel" 
                                   value="{{ old('fecha_examen', $resultadoExamen->fecha_examen->format('Y-m-d')) }}" 
                                   max="{{ date('Y-m-d') }}" 
                                   required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label font-weight-bold">
                        <i class="fas fa-clipboard-check text-warning mr-1"></i>Resultados / Hallazgos
                    </label>
                    <textarea name="resultados" 
                              rows="5" 
                              class="form-control form-control-pastel text-uppercase"
                              placeholder="INGRESE LOS RESULTADOS DETALLADOS...">{{ old('resultados', $resultadoExamen->resultados) }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="button" id="btnRestaurar" class="btn btn-pastel-gray mr-2">
                        <i class="fas fa-undo-alt mr-1"></i> RESTAURAR ORIGINAL
                    </button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                        <i class="fas fa-save mr-1"></i> ACTUALIZAR RESULTADO
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

    .card-pastel { border-radius: 12px; border: none; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: #fff; }
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
        outline: none;
    }

    .btn-pastel-blue { 
        background: var(--pastel-blue); 
        border-radius: 8px; 
        font-weight: bold; 
        color: #2c3e50;
        transition: 0.3s;
        border: none;
    }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); }

    .btn-pastel-gray { 
        background: var(--pastel-gray); 
        border-radius: 8px; 
        font-weight: bold; 
        color: #555;
        border: none;
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {

    // 1. Forzar MAYÚSCULAS en tiempo real
    $('input[type="text"], textarea').on('input', function () {
        this.value = this.value.toUpperCase();
    });

    // 2. Restaurar valores originales con SweetAlert
    $('#btnRestaurar').click(function () {
        Swal.fire({
            title: '¿Restaurar valores?',
            text: "Se perderán los cambios que no hayas guardado.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#CAB8FF',
            cancelButtonColor: '#E3E3E3',
            confirmButtonText: 'Sí, restaurar',
            cancelButtonText: 'Cancelar'
        }).then(res => {
            if(res.isConfirmed){
                $('input[name="nombre_examen"]').val('{{ $resultadoExamen->nombre_examen }}');
                $('input[name="fecha_examen"]').val('{{ $resultadoExamen->fecha_examen->format('Y-m-d') }}');
                $('textarea[name="resultados"]').val(`{{ $resultadoExamen->resultados }}`);
                
                Swal.fire({
                    title: 'Restaurado',
                    icon: 'success',
                    timer: 1000,
                    showConfirmButton: false
                });
            }
        });
    });

    // 3. Confirmar Actualización con SweetAlert
    $('#examenForm').on('submit', function (e) {
        e.preventDefault();

        Swal.fire({
            title: '¿Actualizar resultado?',
            text: "Los cambios se aplicarán permanentemente.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#A8D8EA',
            cancelButtonColor: '#E3E3E3',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Revisar'
        }).then(res => {
            if(res.isConfirmed){
                // Limpieza final de mayúsculas antes de enviar
                $(this).find('input[type="text"], textarea').each(function() {
                    $(this).val($(this).val().toUpperCase());
                });
                this.submit();
            }
        });
    });

});
</script>
@stop