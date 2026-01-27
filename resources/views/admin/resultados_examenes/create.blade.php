@extends('adminlte::page')

@section('title', 'Añadir Resultados de Exámenes')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h4 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-vials mr-2"></i>J. RESULTADOS DE EXÁMENES GENERALES Y ESPECÍFICOS DE ACUERDO AL RIESGO Y PUESTO DE TRABAJO (IMAGEN, LABORATORIO Y OTROS)
    </h4>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Información General del Registro</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                    <p class="mb-0 small text-muted">CI: {{ $registro->paciente->cedula_identidad ?? '—' }}</p>
                </div>
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Evaluación</small>
                    <span class="badge badge-pill bg-pastel-purple px-3 text-uppercase">
                        {{ $registro->tipo }}
                    </span>
                    <p class="mb-0 small text-muted">Fecha: {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico Responsable</small>
                    <span class="text-dark font-weight-bold">DR. {{ strtoupper($registro->doctor->primer_nombre ?? '—') }} {{ strtoupper($registro->doctor->primer_apellido ?? '') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DINÁMICO DE EXÁMENES --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-flask mr-2"></i>Registrando Resultados
            </h5>
            <div class="card-tools">
                <span class="badge badge-pill bg-pastel-purple px-3" id="contador-examenes">1 Examen</span>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.resultados_examenes.store', $registro->id) }}" method="POST" id="resultadosForm">
                @csrf

                <div id="examenesContainer">
                    {{-- PRIMER EXAMEN (POR DEFECTO) --}}
                    <div class="examen-item card border shadow-none mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                            <span class="font-weight-bold text-muted small text-uppercase"><i class="fas fa-tag mr-1"></i> Examen #1</span>
                            <button type="button" class="btn btn-xs btn-outline-danger remove-examen" style="display:none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3 mb-md-0">
                                        <label class="small font-weight-bold text-uppercase">Nombre del Examen <span class="text-danger">*</span></label>
                                        <input type="text" name="nombre_examen[]" class="form-control form-control-pastel text-uppercase" 
                                               required placeholder="EJ: HEMOGRAMA COMPLETO">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3 mb-md-0">
                                        <label class="small font-weight-bold text-uppercase">Fecha Realizada <span class="text-danger">*</span></label>
                                        <input type="date" name="fecha_examen[]" class="form-control form-control-pastel fecha-input" 
                                               required max="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-0">
                                        <label class="small font-weight-bold text-uppercase">Resultados / Observaciones</label>
                                        <textarea name="resultados[]" class="form-control form-control-pastel text-uppercase" 
                                                  rows="2" placeholder="VALORES Y DETALLES DEL EXAMEN..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BOTÓN AGREGAR --}}
                <div class="text-center mt-2">
                    <button type="button" id="addExamen" class="btn btn-outline-info btn-round px-4 shadow-sm">
                        <i class="fas fa-plus-circle mr-1"></i> AGREGAR OTRO EXAMEN
                    </button>
                </div>

                <hr class="my-4">

                {{-- BOTONES ACCIÓN --}}
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2 px-4">CANCELAR</button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm" id="btnGuardar">
                        <i class="fas fa-save mr-2"></i>GUARDAR TODO
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
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .text-pastel-blue { color: #6fb9d6 !important; }

    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
        transition: all 0.3s ease;
    }

    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; transition: 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); color: #2c3e50; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .btn-round { border-radius: 20px; font-weight: bold; }
    .examen-item { border-radius: 10px; border: 1px solid #ebedf0 !important; }
    .text-uppercase { text-transform: uppercase; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    const hoy = new Date().toISOString().split('T')[0];

    function updateUI() {
        const total = $('.examen-item').length;
        $('#contador-examenes').text(`${total} ${total === 1 ? 'Examen' : 'Exámenes'}`);
        $('.remove-examen').toggle(total > 1);
        $('.fecha-input').attr('max', hoy);
    }

    // Agregar Examen
    $('#addExamen').click(function() {
        const index = $('.examen-item').length + 1;
        const nuevoExamen = `
            <div class="examen-item card border shadow-none mb-4" style="display:none;">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                    <span class="font-weight-bold text-muted small text-uppercase"><i class="fas fa-tag mr-1"></i> Examen #${index}</span>
                    <button type="button" class="btn btn-xs btn-outline-danger remove-examen">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-0">
                                <label class="small font-weight-bold text-uppercase">Nombre del Examen <span class="text-danger">*</span></label>
                                <input type="text" name="nombre_examen[]" class="form-control form-control-pastel text-uppercase" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group mb-0">
                                <label class="small font-weight-bold text-uppercase">Fecha Realizada <span class="text-danger">*</span></label>
                                <input type="date" name="fecha_examen[]" class="form-control form-control-pastel fecha-input" required max="${hoy}">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mb-0">
                                <label class="small font-weight-bold text-uppercase">Resultados / Observaciones</label>
                                <textarea name="resultados[]" class="form-control form-control-pastel text-uppercase" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
        
        const $el = $(nuevoExamen).appendTo('#examenesContainer');
        $el.slideDown(200);
        updateUI();
    });

    // Remover Examen
    $(document).on('click', '.remove-examen', function() {
        const $card = $(this).closest('.examen-item');
        Swal.fire({
            title: '¿Remover este examen?',
            text: "Los datos ingresados en esta fila se borrarán.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffb3b3',
            cancelButtonColor: '#E3E3E3',
            confirmButtonText: 'Sí, remover',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $card.slideUp(300, function() { 
                    $(this).remove(); 
                    reindexar();
                    updateUI();
                });
            }
        });
    });

    function reindexar() {
        $('.examen-item').each(function(i) {
            $(this).find('.card-header span').html(`<i class="fas fa-tag mr-1"></i> Examen #${i + 1}`);
        });
    }

    // Forzar Mayúsculas
    $(document).on('input', 'input[type="text"], textarea', function() {
        this.value = this.value.toUpperCase();
    });

    // Confirmación al Guardar
    $('#resultadosForm').on('submit', function(e) {
        e.preventDefault();

        // Validar si hay campos vacíos obligatorios
        let vacios = false;
        $('input[name="nombre_examen[]"]').each(function() {
            if ($(this).val().trim() === "") vacios = true;
        });

        if (vacios) {
            Swal.fire({ icon: 'error', title: 'Campos incompletos', text: 'Por favor, asigne un nombre a todos los exámenes.' });
            return;
        }

        Swal.fire({
            title: '¿Guardar resultados?',
            text: "Se registrarán los exámenes en la ficha del paciente.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#A8D8EA',
            cancelButtonColor: '#E3E3E3',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Revisar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#btnGuardar').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...');
                this.submit();
            }
        });
    });

    // Botón Cancelar
    $('#btnCancelar').on('click', function() {
        Swal.fire({
            title: '¿Descartar cambios?',
            text: "Se perderá la información no guardada.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Salir',
            confirmButtonColor: '#CAB8FF',
            cancelButtonColor: '#E3E3E3',
        }).then((result) => {
            if (result.isConfirmed) window.location.href = "{{ route('admin.registros.show', $registro) }}";
        });
    });

    updateUI();
});
</script>
@stop