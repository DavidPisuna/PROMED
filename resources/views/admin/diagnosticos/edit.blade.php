@extends('adminlte::page')

@section('title', 'Editar Diagnóstico')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-stethoscope mr-2"></i>K. DIAGNÓSTICO                                         PRE:PRESUNTIVO DEF: DEFINITIVO
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">

    {{-- 🔹 RESUMEN DEL PACIENTE (Estilo Unificado) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark">
                <i class="fas fa-user-circle mr-2"></i>Resumen de la Atención
            </h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                </div>
                <div class="col-md-3 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo Registro</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">
                        {{ strtoupper($registro->tipo) }}
                    </span>
                </div>
                <div class="col-md-5">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico Responsable</small>
                    <span class="text-dark font-weight-bold">
                        DR. {{ strtoupper($registro->doctor->primer_nombre ?? 'N/A') }} {{ strtoupper($registro->doctor->primer_apellido ?? '') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-edit mr-2"></i>Actualizar Información Médica
            </h5>
        </div>

        <div class="card-body">
            <form action="{{ route('admin.diagnosticos.update', [$registro->id, $diagnostico->id]) }}"
                  method="POST"
                  id="diagnosticoForm">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Código CIE-10 --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-barcode text-info mr-2"></i>Código CIE-10 <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="cie10"
                                   class="form-control form-control-pastel text-uppercase"
                                   value="{{ old('cie10', $diagnostico->cie10) }}"
                                   required
                                   maxlength="10"
                                   placeholder="EJ: J06.9">
                        </div>
                    </div>

                    {{-- Tipo de Diagnóstico --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-filter text-success mr-2"></i>Tipo Diagnóstico <span class="text-danger">*</span>
                            </label>
                            <select name="tipo_diagnostico" class="form-control form-control-pastel" required>
                                <option value="">-- SELECCIONE --</option>
                                <option value="presuntivo" {{ $diagnostico->tipo_diagnostico == 'presuntivo' ? 'selected' : '' }}>PRESUNTIVO</option>
                                <option value="definitivo" {{ $diagnostico->tipo_diagnostico == 'definitivo' ? 'selected' : '' }}>DEFINITIVO</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Descripción --}}
                <div class="form-group mb-4">
                    <label class="form-label font-weight-bold">
                        <i class="fas fa-clipboard-list text-warning mr-2"></i>Descripción Detallada
                    </label>
                    <textarea name="descripcion"
                              rows="4"
                              class="form-control form-control-pastel text-uppercase"
                              required
                              placeholder="INGRESE EL DETALLE DEL DIAGNÓSTICO...">{{ old('descripcion', $diagnostico->descripcion) }}</textarea>
                </div>

                <div class="alert alert-info bg-light border-info shadow-sm">
                    <i class="fas fa-info-circle mr-2 text-info"></i>
                    Recuerde que los diagnósticos <strong>definitivos</strong> cierran el ciclo de sospecha clínica.
                </div>

                {{-- BOTONES DE ACCIÓN --}}
                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="button" id="btnRestaurar" class="btn btn-pastel-gray mr-2">
                        <i class="fas fa-undo-alt mr-1"></i> RESTAURAR
                    </button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i>ACTUALIZAR DIAGNÓSTICO
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
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .text-pastel-purple { color: #8e7cc3 !important; }

    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
        padding: 10px;
        height: auto !important;
        transition: all 0.3s ease;
    }

    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
        outline: none;
    }

    .btn-pastel-blue { 
        background: var(--pastel-blue); 
        border: none; 
        border-radius: 8px; 
        font-weight: bold; 
        color: #2c3e50; 
        transition: 0.3s; 
    }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); color: #2c3e50; }
    
    .btn-pastel-gray { 
        background: var(--pastel-gray); 
        border: none; 
        border-radius: 8px; 
        font-weight: bold; 
        color: #555; 
        transition: 0.3s;
    }
    .btn-pastel-gray:hover { background: #d4d4d4; }

    .border-right { border-right: 1px solid #dee2e6 !important; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function(){
    // Forzar Mayúsculas
    $('input[type="text"], textarea').on('input', function(){
        this.value = this.value.toUpperCase();
    });

    // Restaurar Valores Originales
    $('#btnRestaurar').click(function(){
        Swal.fire({
            title: '¿Restaurar valores?',
            text: "Se perderán los cambios no guardados",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#CAB8FF',
            confirmButtonText: 'Sí, restaurar',
            cancelButtonText: 'Cancelar'
        }).then(r=>{
            if(r.isConfirmed){
                $('input[name="cie10"]').val('{{ $diagnostico->cie10 }}');
                $('select[name="tipo_diagnostico"]').val('{{ $diagnostico->tipo_diagnostico }}');
                $('textarea[name="descripcion"]').val(`{{ $diagnostico->descripcion }}`);
                Swal.fire('Restaurado', 'Los campos han vuelto a su estado original', 'success');
            }
        });
    });

    // Validación y Confirmación de Envío
    $('#diagnosticoForm').on('submit', function(e){
        e.preventDefault();

        const cie10 = $('input[name="cie10"]').val().trim();
        const pattern = /^[A-Z][0-9]{2}(\.[0-9]{1,2})?$/;

        if(!pattern.test(cie10)){
            Swal.fire('Formato CIE-10 Inválido','Debe ser como J06 o J06.9','warning');
            return;
        }

        Swal.fire({
            title: '¿Actualizar diagnóstico?',
            text: "Los cambios se reflejarán en el historial clínico",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#A8D8EA',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Revisar'
        }).then(r=>{
            if(r.isConfirmed){
                this.submit();
            }
        });
    });
});
</script>
@stop