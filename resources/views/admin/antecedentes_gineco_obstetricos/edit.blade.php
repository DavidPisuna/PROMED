@extends('adminlte::page')

@section('title', 'Editar Antecedente Gineco-Obstétrico')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Antecedente Gineco-Obstétrico
    </h1>
    <a href="{{ route('admin.registros.show', $registro->id) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Información del Registro</h6>
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
                <div class="col-md-4 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Evaluación / Fecha</small>
                    <span class="badge badge-pill bg-pastel-purple px-3 text-uppercase mb-1">{{ $registro->tipo }}</span>
                    <small class="d-block text-dark font-weight-bold">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</small>
                </div>
                <div class="col-md-4 text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico Responsable</small>
                    <span class="text-dark font-weight-bold">DR. {{ strtoupper($registro->doctor->primer_nombre ?? 'N/A') }}</span>
                    <small class="d-block text-muted text-uppercase">{{ $registro->doctor->especialidad ?? 'MEDICINA GENERAL' }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-clipboard-check mr-2"></i>Actualizar Registro Gineco-Obstétrico
            </h5>
            <span class="badge badge-light border text-muted">ANTECEDENTE ID: {{ $antecedenteGineco->id }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.antecedentes_gineco_obstetricos.update', $antecedenteGineco->id) }}" method="POST" id="ginecoForm">
                @csrf
                @method('PUT')

                {{-- SECCIÓN: INFORMACIÓN BÁSICA --}}
                <div class="card card-outline card-pastel-blue mb-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0 font-weight-bold"><i class="fas fa-calendar-alt mr-2 text-info"></i>Información Básica Actualizada</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">Fecha Última Menstruación (FUM)</label>
                                    <input type="date" name="fecha_ultima_menstruacion" class="form-control form-control-pastel @error('fecha_ultima_menstruacion') is-invalid @enderror" 
                                           value="{{ old('fecha_ultima_menstruacion', $antecedenteGineco->fecha_ultima_menstruacion ? \Carbon\Carbon::parse($antecedenteGineco->fecha_ultima_menstruacion)->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">Gestas</label>
                                    <input type="number" name="gestas" class="form-control form-control-pastel" value="{{ old('gestas', $antecedenteGineco->gestas) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">Partos</label>
                                    <input type="number" name="partos" class="form-control form-control-pastel" value="{{ old('partos', $antecedenteGineco->partos) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">Cesáreas</label>
                                    <input type="number" name="cesareas" class="form-control form-control-pastel" value="{{ old('cesareas', $antecedenteGineco->cesareas) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="form-label font-weight-bold">Abortos</label>
                                    <input type="number" name="abortos" class="form-control form-control-pastel" value="{{ old('abortos', $antecedenteGineco->abortos) }}" min="0">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: PLANIFICACIÓN --}}
                <div class="card card-outline card-pastel-purple mb-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0 font-weight-bold"><i class="fas fa-user-shield mr-2 text-purple"></i>Planificación Familiar</h6>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label class="form-label d-block font-weight-bold mb-3">¿Utiliza algún método de planificación?</label>
                                <div class="d-flex gap-4">
                                    <div class="custom-control custom-radio mr-4">
                                        <input class="custom-control-input" type="radio" name="planificacion_opcion" id="planificacion_si" value="si" 
                                            {{ old('planificacion_opcion', $antecedenteGineco->planificacion_si ? 'si' : ($antecedenteGineco->planificacion_no ? 'no' : ($antecedenteGineco->planificacion_no_responde ? 'no_responde' : ''))) == 'si' ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-normal" for="planificacion_si">SÍ, UTILIZA</label>
                                    </div>
                                    <div class="custom-control custom-radio mr-4">
                                        <input class="custom-control-input" type="radio" name="planificacion_opcion" id="planificacion_no" value="no" 
                                            {{ old('planificacion_opcion', $antecedenteGineco->planificacion_si ? 'si' : ($antecedenteGineco->planificacion_no ? 'no' : ($antecedenteGineco->planificacion_no_responde ? 'no_responde' : ''))) == 'no' ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-normal" for="planificacion_no">NO UTILIZA</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input class="custom-control-input" type="radio" name="planificacion_opcion" id="planificacion_no_responde" value="no_responde" 
                                            {{ old('planificacion_opcion', $antecedenteGineco->planificacion_si ? 'si' : ($antecedenteGineco->planificacion_no ? 'no' : ($antecedenteGineco->planificacion_no_responde ? 'no_responde' : ''))) == 'no_responde' ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-normal" for="planificacion_no_responde">NO RESPONDE</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" id="planificacion_cual_container" style="display:none;">
                                <div class="form-group mb-0">
                                    <label class="form-label font-weight-bold">Especifique el método</label>
                                    <input type="text" name="planificacion_cual" class="form-control form-control-pastel text-uppercase" 
                                           value="{{ old('planificacion_cual', $antecedenteGineco->planificacion_cual) }}" placeholder="EJ: DIU, T DE COBRE, ORALES...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN: EXÁMENES --}}
                <div class="card card-outline card-pastel-green mb-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0 font-weight-bold"><i class="fas fa-vials mr-2 text-success"></i>Exámenes Realizados</h6>
                        <button type="button" class="btn btn-sm btn-pastel-blue btn-add-examen"><i class="fas fa-plus mr-1"></i>Añadir Examen</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless" id="tabla_examenes">
                                <thead class="text-muted small text-uppercase">
                                    <tr>
                                        <th width="45%">Examen</th>
                                        <th width="15%">Tiempo (Meses)</th>
                                        <th width="30%">Resultado</th>
                                        <th width="10%" class="text-center"></th>
                                    </tr>
                                </thead>
                                <tbody id="examenes-container">
                                    @forelse($antecedenteGineco->examenes as $examen)
                                    <tr class="examen-item">
                                        <td><input type="text" name="examen_realizado[]" class="form-control form-control-pastel text-uppercase" value="{{ $examen->examen_realizado }}" required></td>
                                        <td><input type="number" name="tiempo_meses[]" class="form-control form-control-pastel" value="{{ $examen->tiempo_meses }}"></td>
                                        <td><input type="text" name="resultado[]" class="form-control form-control-pastel text-uppercase" value="{{ $examen->resultado }}"></td>
                                        <td class="text-center"><button type="button" class="btn btn-sm text-danger btn-remove-examen"><i class="fas fa-trash-alt"></i></button></td>
                                    </tr>
                                    @empty
                                    <tr class="examen-item">
                                        <td><input type="text" name="examen_realizado[]" class="form-control form-control-pastel text-uppercase" placeholder="Papanicolaou..." required></td>
                                        <td><input type="number" name="tiempo_meses[]" class="form-control form-control-pastel" placeholder="0"></td>
                                        <td><input type="text" name="resultado[]" class="form-control form-control-pastel text-uppercase" placeholder="Normal..."></td>
                                        <td class="text-center"><button type="button" class="btn btn-sm text-danger btn-remove-examen"><i class="fas fa-trash-alt"></i></button></td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.registros.show', $registro->id) }}" class="btn btn-pastel-gray mr-2">CANCELAR</a>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm" id="btnGuardar">
                        <i class="fas fa-sync mr-2"></i>ACTUALIZAR ANTECEDENTE
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

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .card-pastel-blue { border-top-color: var(--pastel-blue) !important; }
    .card-pastel-purple { border-top-color: var(--pastel-purple) !important; }
    .card-pastel-green { border-top-color: var(--pastel-green) !important; }
    
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    
    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
        background-color: #fff !important;
        transition: 0.3s;
    }
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-blue:hover { background: #91c9de; color: #2c3e50; transform: translateY(-1px); }
    
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .border-right { border-right: 1px solid #ebedf0 !important; }
    .text-uppercase { text-transform: uppercase; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        // --- 1. Lógica Planificación Familiar ---
        function togglePlanificacion() {
            if ($('#planificacion_si').is(':checked')) {
                $('#planificacion_cual_container').show();
            } else {
                $('#planificacion_cual_container').hide();
            }
        }
        $('input[name="planificacion_opcion"]').change(togglePlanificacion);
        togglePlanificacion(); // Ejecutar al inicio para estados guardados

        // --- 2. Tabla Dinámica de Exámenes ---
        $('.btn-add-examen').click(function() {
            let nuevaFila = `
                <tr class="examen-item">
                    <td><input type="text" name="examen_realizado[]" class="form-control form-control-pastel text-uppercase" required></td>
                    <td><input type="number" name="tiempo_meses[]" class="form-control form-control-pastel"></td>
                    <td><input type="text" name="resultado[]" class="form-control form-control-pastel text-uppercase"></td>
                    <td class="text-center"><button type="button" class="btn btn-sm text-danger btn-remove-examen"><i class="fas fa-trash-alt"></i></button></td>
                </tr>`;
            $(nuevaFila).appendTo('#examenes-container');
        });

        $(document).on('click', '.btn-remove-examen', function() {
            $(this).closest('tr').remove();
        });

        // --- 3. Forzar Mayúsculas ---
        $(document).on('input', 'input[type="text"]', function() {
            this.value = this.value.toUpperCase();
        });

        // --- 4. SWEETALERT2: Confirmación Actualización ---
        $('#ginecoForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Actualizar Antecedente?',
                text: "Se modificarán los datos gineco-obstétricos guardados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Revisar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btnGuardar').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>ACTUALIZANDO...');
                    this.submit();
                }
            });
        });

        // --- 5. SWEETALERT2: Mensajes de Sistema ---
        @if(session('success'))
            Swal.fire({ icon: 'success', title: '¡Actualizado!', text: '{{ session('success') }}', timer: 3000, toast: true, position: 'top-end', showConfirmButton: false });
        @endif
    });
</script>
@stop