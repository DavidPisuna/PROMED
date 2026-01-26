@extends('adminlte::page')

@section('title', 'Editar Antecedente Reproductivo')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Antecedente Reproductivo Masculino
    </h1>
    <a href="{{ route('admin.registros.show', $registro->id) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE (Estilo Resumen Pastel) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Resumen del Paciente y Registro</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark text-uppercase">
                        {{ $registro->paciente->primer_nombre }} {{ $registro->paciente->primer_apellido }}
                    </span>
                </div>
                <div class="col-md-2 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Cédula</small>
                    <span class="h6 font-weight-bold">{{ $registro->paciente->cedula_identidad ?? 'N/A' }}</span>
                </div>
                <div class="col-md-3 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo de Evaluación</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">
                        {{ $registro->tipo }}
                    </span>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Doctor Asignado</small>
                    <span class="text-dark font-weight-bold text-uppercase">DR. {{ $registro->doctor->primer_apellido ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-pen-square mr-2"></i>Actualizar Información Médica
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.antecedentes_masculinos.update', $antecedenteMasculino) }}" method="POST" id="antecedenteForm">
                @csrf
                @method('PUT')

                {{-- SECCIÓN: PLANIFICACIÓN --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label font-weight-bold mb-3"><i class="fas fa-heartbeat mr-2 text-danger"></i>MÉTODO DE PLANIFICACIÓN FAMILIAR</label>
                        <div class="p-3 rounded bg-light border d-flex justify-content-around flex-wrap">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="plan_si" name="planificacion_familia" value="si" {{ $antecedenteMasculino->planificacion_si ? 'checked' : '' }}>
                                <label for="plan_si" class="custom-control-label font-weight-bold text-success">SÍ UTILIZA</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="plan_no" name="planificacion_familia" value="no" {{ $antecedenteMasculino->planificacion_no ? 'checked' : '' }}>
                                <label for="plan_no" class="custom-control-label font-weight-bold text-danger">NO UTILIZA</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input" type="radio" id="plan_nr" name="planificacion_familia" value="nr" {{ $antecedenteMasculino->planificacion_no_responde ? 'checked' : '' }}>
                                <label for="plan_nr" class="custom-control-label font-weight-bold text-warning">NO RESPONDE</label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <input type="text" name="planificacion_cual" id="planificacion_cual" 
                                   class="form-control form-control-pastel text-uppercase {{ !$antecedenteMasculino->planificacion_si ? 'd-none' : '' }}" 
                                   placeholder="DESCRIBA EL MÉTODO UTILIZADO..." 
                                   value="{{ $antecedenteMasculino->planificacion_cual }}">
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- SECCIÓN: EXÁMENES --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <label class="form-label font-weight-bold mb-0">
                        <i class="fas fa-vials mr-2 text-primary"></i>EXÁMENES REALIZADOS
                    </label>
                    <button type="button" id="add-examen" class="btn btn-sm btn-pastel-blue px-3">
                        <i class="fas fa-plus mr-1"></i> AÑADIR EXAMEN
                    </button>
                </div>

                <div id="examenes-container">
                    @foreach($antecedenteMasculino->examenes as $examen)
                    <div class="examen-item card border shadow-sm mb-3 bg-light-soft">
                        <div class="card-body p-3">
                            <div class="row align-items-end">
                                <div class="col-md-4">
                                    <label class="small font-weight-bold text-muted">NOMBRE DEL EXAMEN</label>
                                    <input type="text" name="examen_realizado[]" class="form-control form-control-pastel text-uppercase" value="{{ $examen->examen_realizado }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="small font-weight-bold text-muted">TIEMPO (MESES)</label>
                                    <input type="number" name="tiempo_meses[]" class="form-control form-control-pastel" value="{{ $examen->tiempo_meses }}">
                                </div>
                                <div class="col-md-5">
                                    <label class="small font-weight-bold text-muted">RESULTADO</label>
                                    <input type="text" name="resultado[]" class="form-control form-control-pastel text-uppercase" value="{{ $examen->resultado }}">
                                </div>
                                <div class="col-md-1 text-center">
                                    <button type="button" class="btn btn-danger btn-sm remove-examen shadow-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end mt-5">
                    <a href="{{ route('admin.registros.show', $registro->id) }}" class="btn btn-pastel-gray mr-2 px-4">CANCELAR</a>
                    <button type="submit" class="btn btn-pastel-purple px-5 shadow-sm" id="btnActualizar">
                        <i class="fas fa-save mr-2"></i>ACTUALIZAR ANTECEDENTE
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
        --pastel-green: #B6E2D3;
        --pastel-gray: #E3E3E3;
    }

    .card-pastel { border: none; border-radius: 15px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    
    .form-control-pastel {
        border-radius: 10px;
        border: 1.5px solid #e0e0e0;
        padding: 10px;
        transition: all 0.3s ease;
        text-transform: uppercase;
    }
    
    .form-control-pastel:focus {
        border-color: var(--pastel-purple);
        box-shadow: 0 0 8px rgba(202, 184, 255, 0.4);
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 10px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-purple { background: var(--pastel-purple); border: none; border-radius: 10px; font-weight: bold; color: white; }
    .btn-pastel-purple:hover { background: #b5a0f5; color: white; transform: translateY(-2px); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 10px; font-weight: bold; color: #555; }

    .examen-item { border-radius: 12px; border-left: 5px solid var(--pastel-blue) !important; }
    .text-uppercase { text-transform: uppercase; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Manejo de visibilidad del campo "Cual"
        $('input[name="planificacion_familia"]').change(function() {
            if ($('#plan_si').is(':checked')) {
                $('#planificacion_cual').removeClass('d-none').focus();
            } else {
                $('#planificacion_cual').addClass('d-none').val('');
            }
        });

        // Agregar nuevo examen con estilo pastel
        $('#add-examen').click(function() {
            let examenHtml = `
            <div class="examen-item card border shadow-sm mb-3 bg-light-soft" style="display:none;">
                <div class="card-body p-3">
                    <div class="row align-items-end">
                        <div class="col-md-4">
                            <label class="small font-weight-bold text-muted">NOMBRE DEL EXAMEN</label>
                            <input type="text" name="examen_realizado[]" class="form-control form-control-pastel text-uppercase" required>
                        </div>
                        <div class="col-md-2">
                            <label class="small font-weight-bold text-muted">TIEMPO (MESES)</label>
                            <input type="number" name="tiempo_meses[]" class="form-control form-control-pastel">
                        </div>
                        <div class="col-md-5">
                            <label class="small font-weight-bold text-muted">RESULTADO</label>
                            <input type="text" name="resultado[]" class="form-control form-control-pastel text-uppercase">
                        </div>
                        <div class="col-md-1 text-center">
                            <button type="button" class="btn btn-danger btn-sm remove-examen shadow-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
            $(examenHtml).appendTo('#examenes-container').fadeIn(400);
        });

        // Eliminar examen
        $(document).on('click', '.remove-examen', function() {
            $(this).closest('.examen-item').fadeOut(300, function() { $(this).remove(); });
        });

        // Submit con loading
        $('#antecedenteForm').on('submit', function() {
            $('#btnActualizar').html('<i class="fas fa-spinner fa-spin mr-2"></i>PROCESANDO...').prop('disabled', true);
        });
    });
</script>
@stop