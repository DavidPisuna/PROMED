@extends('adminlte::page')

@section('title', 'Registrar Centros de Trabajo')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-building mr-2"></i>Registrar Centros de Trabajo
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA (Estilo Resumen Pastel) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-info-circle mr-2"></i>Información General del Registro</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                    <small class="d-block text-muted">ID: {{ $registro->paciente->cedula_identidad }}</small>
                </div>
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Evaluación</small>
                    <span class="badge badge-pill bg-pastel-purple px-3 text-uppercase">{{ $registro->tipo }}</span>
                    <small class="d-block mt-1 font-weight-bold">Fecha: {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</small>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Doctor Asignado</small>
                    <span class="text-dark font-weight-bold">DR. {{ strtoupper($registro->doctor->primer_nombre) }} {{ strtoupper($registro->doctor->primer_apellido) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE REGISTRO MÚLTIPLE --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-edit mr-2"></i>Detalle de Centros Laborales
            </h5>
            <span class="badge badge-secondary shadow-sm" id="contador-centros">1 Centro(s)</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.centros_trabajos.store', $registro) }}" method="POST" id="centrosTrabajoForm">
                @csrf

                <div id="centros-container">
                    {{-- PLANTILLA DE CENTRO --}}
                    <div class="centro-item card border shadow-none mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                            <span class="font-weight-bold text-muted"><i class="fas fa-layer-group mr-1"></i> Centro de Trabajo #1</span>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-centro" style="display:none;">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Nombre del Centro <span class="text-danger">*</span></label>
                                        <input type="text" name="nombre_centro_trabajo[]" class="form-control form-control-pastel text-uppercase" required placeholder="EJ: EMPRESA XYZ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tipo de Trabajo <span class="text-danger">*</span></label>
                                        <select name="tipo_trabajo[]" class="form-control form-control-pastel" required>
                                            <option value="">-- SELECCIONE --</option>
                                            <option value="actual">ACTUAL</option>
                                            <option value="anterior">ANTERIOR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Actividades Desempeñadas <span class="text-danger">*</span></label>
                                        <textarea name="actividades_desempenadas[]" rows="2" class="form-control form-control-pastel text-uppercase" required placeholder="DESCRIPCIÓN DE TAREAS..."></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Tiempo de Permanencia</label>
                                        <input type="text" name="tiempo_trabajo[]" class="form-control form-control-pastel text-uppercase" placeholder="EJ: 2 AÑOS">
                                    </div>
                                </div>
                                <div class="col-md-8 mt-2">
                                    <label class="font-weight-bold d-block">Eventos Laborales</label>
                                    <div class="d-flex flex-wrap gap-3 p-2 bg-light rounded border">
                                        <div class="custom-control custom-checkbox mr-3">
                                            <input type="checkbox" name="incidente[0]" value="1" class="custom-control-input" id="incidente_0">
                                            <label class="custom-control-label" for="incidente_0">Incidente</label>
                                        </div>
                                        <div class="custom-control custom-checkbox mr-3">
                                            <input type="checkbox" name="accidente[0]" value="1" class="custom-control-input" id="accidente_0">
                                            <label class="custom-control-label" for="accidente_0">Accidente</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="enfermedad_profesional[0]" value="1" class="custom-control-input" id="enfermedad_profesional_0">
                                            <label class="custom-control-label" for="enfermedad_profesional_0">Enf. Profesional</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3 border-top pt-3">
                                <div class="col-md-4">
                                    <div class="custom-control custom-switch mt-2">
                                        <input type="checkbox" name="calificado_iess[0]" value="1" class="custom-control-input switch-iess" id="calificado_iess_0">
                                        <label class="custom-control-label" for="calificado_iess_0">Calificado IESS</label>
                                    </div>
                                </div>
                                <div class="col-md-4 fecha-calif-wrapper" style="display:none;">
                                    <input type="date" name="fecha_calificacion[]" class="form-control form-control-pastel">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="especificar[]" class="form-control form-control-pastel text-uppercase" placeholder="ESPECIFICAR...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BOTONES ACCIÓN --}}
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <button type="button" id="btnAddCentro" class="btn btn-outline-success font-weight-bold">
                        <i class="fas fa-plus mr-1"></i> AGREGAR OTRO CENTRO
                    </button>
                    
                    <div class="d-flex gap-2">
                        <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2">CANCELAR</button>
                        <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                            <i class="fas fa-save mr-2"></i>GUARDAR TODO
                        </button>
                    </div>
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
        transition: all 0.3s ease;
    }

    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
        outline: none;
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 1rem; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    let centroCount = 1;

    // 1. Agregar Centro Dinámicamente
    $('#btnAddCentro').on('click', function() {
        centroCount++;
        let nuevoCentro = $('.centro-item:first').clone();
        
        // Limpiar valores y actualizar IDs de checkboxes/labels
        nuevoCentro.find('input, textarea').val('');
        nuevoCentro.find('input[type="checkbox"]').prop('checked', false);
        nuevoCentro.find('.fecha-calif-wrapper').hide();
        
        // Actualizar nombres e IDs para que no colisionen (especialmente los checkboxes)
        actualizarAtributos(nuevoCentro, centroCount);
        
        nuevoCentro.find('.remove-centro').show();
        nuevoCentro.find('.font-weight-bold.text-muted').html(`<i class="fas fa-layer-group mr-1"></i> Centro de Trabajo #${centroCount}`);
        
        $('#centros-container').append(nuevoCentro);
        $('#contador-centros').text(`${centroCount} Centro(s)`);
    });

    // 2. Eliminar Centro
    $(document).on('click', '.remove-centro', function() {
        $(this).closest('.centro-item').remove();
        centroCount--;
        $('#contador-centros').text(`${centroCount} Centro(s)`);
    });

    // 3. Switch IESS (Mostrar/Ocultar Fecha)
    $(document).on('change', '.switch-iess', function() {
        const wrapper = $(this).closest('.row').find('.fecha-calif-wrapper');
        $(this).is(':checked') ? wrapper.fadeIn() : wrapper.fadeOut();
    });

    // 4. Mayúsculas en tiempo real
    $(document).on('input', 'input[type="text"], textarea', function() {
        this.value = this.value.toUpperCase();
    });

    // 5. SweetAlert: Confirmación Guardar
    $('#centrosTrabajoForm').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Guardar Centros?',
            text: "Se registrarán los datos laborales del paciente.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#A8D8EA',
            cancelButtonColor: '#E3E3E3',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Revisar'
        }).then((result) => {
            if (result.isConfirmed) this.submit();
        });
    });

    // 6. SweetAlert: Cancelar
    $('#btnCancelar').on('click', function() {
        Swal.fire({
            title: '¿Salir sin guardar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Salir',
            confirmButtonColor: '#CAB8FF',
            cancelButtonText: 'Continuar aquí'
        }).then((result) => {
            if (result.isConfirmed) window.location.href = "{{ route('admin.registros.show', $registro) }}";
        });
    });

    function actualizarAtributos(elemento, index) {
        const suffix = index - 1;
        elemento.find('#incidente_0').attr('id', 'incidente_'+suffix).attr('name', 'incidente['+suffix+']');
        elemento.find('label[for="incidente_0"]').attr('for', 'incidente_'+suffix);
        
        elemento.find('#accidente_0').attr('id', 'accidente_'+suffix).attr('name', 'accidente['+suffix+']');
        elemento.find('label[for="accidente_0"]').attr('for', 'accidente_'+suffix);
        
        elemento.find('#enfermedad_profesional_0').attr('id', 'enfermedad_profesional_'+suffix).attr('name', 'enfermedad_profesional['+suffix+']');
        elemento.find('label[for="enfermedad_profesional_0"]').attr('for', 'enfermedad_profesional_'+suffix);
        
        elemento.find('#calificado_iess_0').attr('id', 'calificado_iess_'+suffix).attr('name', 'calificado_iess['+suffix+']');
        elemento.find('label[for="calificado_iess_0"]').attr('for', 'calificado_iess_'+suffix);
    }
});
</script>
@stop