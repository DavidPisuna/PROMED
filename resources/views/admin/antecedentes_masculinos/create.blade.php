@extends('adminlte::page')

@section('title', 'Crear Antecedente Reproductivo Masculino')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-male mr-2"></i> ANTECEDENTE REPRODUCTIVO MASCULINO
    </h1>
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
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Resumen del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                    <small class="d-block text-muted">CÉDULA: {{ $registro->paciente->cedula_identidad ?? 'N/A' }}</small>
                </div>
                <div class="col-md-3 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo de Registro</small>
                    <span class="badge badge-pill bg-pastel-purple px-3 text-uppercase">{{ $registro->tipo }}</span>
                </div>
                <div class="col-md-5">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Doctor Responsable</small>
                    <span class="text-dark font-weight-500">
                        DR. {{ strtoupper($registro->doctor->primer_nombre ?? 'N/A') }} {{ strtoupper($registro->doctor->primer_apellido ?? '') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO PRINCIPAL --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-edit mr-2"></i>Registro de Antecedentes Reproductivos
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.antecedentes_masculinos.store', $registro) }}" method="POST" id="antecedenteForm">
                @csrf

                {{-- SECCIÓN: MÉTODO DE PLANIFICACIÓN FAMILIAR --}}
                <div class="card card-outline card-info shadow-none border">
                    <div class="card-header py-2">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-heartbeat mr-2 text-info"></i>Método de Planificación Familiar</h3>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="plan_si" name="planificacion" value="SI" class="custom-control-input" {{ old('planificacion') == 'SI' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="plan_si">SÍ UTILIZA</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="plan_no" name="planificacion" value="NO" class="custom-control-input" {{ old('planificacion') == 'NO' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="plan_no">NO</label>
                                </div>
                            </div>
                            <div class="col-md-9 mt-2 mt-md-0" id="div_cual_plan" style="display: none;">
                                <input type="text" name="planificacion_cual" class="form-control form-control-pastel text-uppercase" 
                                       placeholder="¿CUÁL MÉTODO UTILIZA?" value="{{ old('planificacion_cual') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: EXÁMENES REALIZADOS --}}
                <div class="card card-outline card-success shadow-none border mt-4">
                    <div class="card-header py-2 d-flex justify-content-between align-items-center">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-vials mr-2 text-success"></i>Exámenes Realizados</h3>
                        <button type="button" id="add-examen" class="btn btn-success btn-sm rounded-pill">
                            <i class="fas fa-plus mr-1"></i> Agregar Examen
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="examenes-container">
                            <div class="examen-item bg-light p-3 rounded mb-3 border">
                                <div class="row align-items-end">
                                    <div class="col-md-4">
                                        <label class="small font-weight-bold">NOMBRE DEL EXAMEN</label>
                                        <input type="text" name="examen_realizado[]" class="form-control form-control-pastel text-uppercase" placeholder="EJ: ESPERMATOGRAMA">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="small font-weight-bold">TIEMPO (AÑOS)</label>
                                        <input type="number" name="tiempo_meses[]" class="form-control form-control-pastel" placeholder="0">
                                    </div>
                                    <div class="col-md-5">
                                        <label class="small font-weight-bold">RESULTADO</label>
                                        <input type="text" name="resultado[]" class="form-control form-control-pastel text-uppercase" placeholder="EJ: NORMAL / PATOLÓGICO">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-outline-danger btn-block remove-examen border-0"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BOTONES --}}
                <div class="d-flex justify-content-end mt-4 gap-2">
                    <button type="button" class="btn btn-pastel-gray mr-2" onclick="history.back()">CANCELAR</button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm" id="btnGuardar">
                        <i class="fas fa-save mr-2"></i>GUARDAR ANTECEDENTE
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    :root { --pastel-blue: #A8D8EA; --pastel-purple: #CAB8FF; --pastel-gray: #E3E3E3; }
    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white !important; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    .border-right { border-right: 1px solid #ebedf0 !important; }
    
    .form-control-pastel {
        border-radius: 8px; border: 1.5px solid #eee; padding: 10px;
        transition: all 0.3s ease; background-color: #ffffff !important;
    }
    .form-control-pastel:focus {
        border-color: var(--pastel-blue); box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
    }
    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; transition: 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    .text-uppercase { text-transform: uppercase; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // 1. Mayúsculas automáticas en tiempo real
        $(document).on('input', 'input[type="text"], textarea', function() {
            this.value = this.value.toUpperCase();
        });

        // 2. Mostrar/Ocultar campo "¿Cuál?" de planificación
        $('input[name="planificacion"]').change(function() {
            if ($(this).val() === 'SI') {
                $('#div_cual_plan').fadeIn();
            } else {
                $('#div_cual_plan').fadeOut();
                $('input[name="planificacion_cual"]').val('');
            }
        });

        // 3. Agregar/Eliminar Exámenes dinámicos
        $('#add-examen').click(function() {
            let examenHtml = `
            <div class="examen-item bg-light p-3 rounded mb-3 border" style="display:none">
                <div class="row align-items-end">
                    <div class="col-md-4">
                        <label class="small font-weight-bold">NOMBRE DEL EXAMEN</label>
                        <input type="text" name="examen_realizado[]" class="form-control form-control-pastel text-uppercase">
                    </div>
                    <div class="col-md-2">
                        <label class="small font-weight-bold">TIEMPO (MESES)</label>
                        <input type="number" name="tiempo_meses[]" class="form-control form-control-pastel">
                    </div>
                    <div class="col-md-5">
                        <label class="small font-weight-bold">RESULTADO</label>
                        <input type="text" name="resultado[]" class="form-control form-control-pastel text-uppercase">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-block remove-examen border-0"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>`;
            $(examenHtml).appendTo('#examenes-container').slideDown();
        });

        $(document).on('click', '.remove-examen', function() {
            $(this).closest('.examen-item').slideUp(function() { $(this).remove(); });
        });

        // 4. SweetAlert2: Confirmación antes de enviar
        $('#antecedenteForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Confirmar Registro?',
                text: "Se guardarán los antecedentes reproductivos masculinos.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'SÍ, GUARDAR',
                cancelButtonText: 'REVISAR',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btnGuardar').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>GUARDANDO...');
                    this.submit();
                }
            });
        });

        // 5. Alertas de Éxito/Error
        @if(session('success'))
            Swal.fire({ icon: 'success', title: '¡Éxito!', text: '{{ session('success') }}', timer: 3000, showConfirmButton: false, toast: true, position: 'top-end' });
        @endif
    });
</script>
@stop