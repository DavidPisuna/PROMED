@extends('adminlte::page')

@section('title', 'Registrar Consumo de Sustancias y Estilo de Vida')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-prescription-bottle-alt mr-2"></i>Consumo y Estilo de Vida
    </h1>
    <a href="{{ route('admin.registros.show', $registro->id) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE (Estilo Resumen Pastel) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Información General del Registro</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">{{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}</span>
                </div>
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo de Registro</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">{{ strtoupper($registro->tipo) }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Doctor Responsable</small>
                    <span class="text-dark font-weight-bold">DR. {{ strtoupper($registro->doctor->primer_nombre ?? '—') }} {{ strtoupper($registro->doctor->primer_apellido ?? '') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO PRINCIPAL --}}
    <form action="{{ route('admin.consumos.store', $registro->id) }}" method="POST" id="consumoForm">
        @csrf
        <div class="card card-pastel shadow-lg">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                    <i class="fas fa-edit mr-2"></i>Ingreso de Datos de Estilo de Vida
                </h5>
            </div>
            <div class="card-body">

                <div class="row">
                    {{-- SECCIÓN: TABACO --}}
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 bg-light-soft shadow-none border-left-pastel-blue" style="border-left: 5px solid var(--pastel-blue) !important;">
                            <div class="card-body">
                                <h6 class="font-weight-bold text-pastel-blue mb-3"><i class="fas fa-smoking mr-2"></i>Consumo de Tabaco</h6>
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label class="small font-weight-bold">Estado *</label>
                                        <select name="tabaco_estado" id="tabaco_estado" class="form-control form-control-pastel" required>
                                            <option value="no_consume">NO CONSUME</option>
                                            <option value="activo">ACTIVO</option>
                                            <option value="ex_consumidor">EX CONSUMIDOR</option>
                                        </select>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="small font-weight-bold">Tiempo (meses)</label>
                                        <input type="number" name="tabaco_tiempo_consumo" id="tabaco_tiempo_consumo" class="form-control form-control-pastel" min="0" step="0.5">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="small font-weight-bold">Abstinencia</label>
                                        <input type="number" name="tabaco_tiempo_abstinencia" id="tabaco_tiempo_abstinencia" class="form-control form-control-pastel" min="0" step="0.5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN: ALCOHOL --}}
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 bg-light-soft shadow-none border-left-pastel-purple" style="border-left: 5px solid var(--pastel-purple) !important;">
                            <div class="card-body">
                                <h6 class="font-weight-bold text-pastel-purple mb-3"><i class="fas fa-wine-bottle mr-2"></i>Consumo de Alcohol</h6>
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <label class="small font-weight-bold">Estado *</label>
                                        <select name="alcohol_estado" id="alcohol_estado" class="form-control form-control-pastel" required>
                                            <option value="no_consume">NO CONSUME</option>
                                            <option value="activo">ACTIVO</option>
                                            <option value="ex_consumidor">EX CONSUMIDOR</option>
                                        </select>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="small font-weight-bold">Tiempo (meses)</label>
                                        <input type="number" name="alcohol_tiempo_consumo" id="alcohol_tiempo_consumo" class="form-control form-control-pastel" min="0">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="small font-weight-bold">Abstinencia</label>
                                        <input type="number" name="alcohol_tiempo_abstinencia" id="alcohol_tiempo_abstinencia" class="form-control form-control-pastel" min="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- OTRAS SUSTANCIAS --}}
                <div class="card border-0 bg-light-soft mb-4">
                    <div class="card-body">
                        <h6 class="font-weight-bold text-danger mb-3"><i class="fas fa-pills mr-2"></i>Otras Sustancias</h6>
                        <div class="row">
                            <div class="col-md-3 form-group">
                                <label class="small font-weight-bold">Estado</label>
                                <select name="otras_sustancias_estado" id="otras_sustancias_estado" class="form-control form-control-pastel">
                                    <option value="no_consume">NO CONSUME</option>
                                    <option value="activo">ACTIVO</option>
                                    <option value="ex_consumidor">EX CONSUMIDOR</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="small font-weight-bold">¿Cuál?</label>
                                <input type="text" name="otras_sustancias_cual" id="otras_sustancias_cual" class="form-control form-control-pastel text-uppercase">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="small font-weight-bold">Tiempo (meses)</label>
                                <input type="number" name="otras_sustancias_tiempo_consumo" id="otras_sustancias_tiempo_consumo" class="form-control form-control-pastel">
                            </div>
                            <div class="col-md-3 form-group">
                                <label class="small font-weight-bold">Abstinencia</label>
                                <input type="number" name="otras_sustancias_tiempo_abstinencia" id="otras_sustancias_tiempo_abstinencia" class="form-control form-control-pastel">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- ACTIVIDAD FÍSICA --}}
                    <div class="col-lg-6">
                        <div class="card card-pastel shadow-none border">
                            <div class="card-header bg-pastel-green d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold"><i class="fas fa-running mr-1"></i> Actividad Física</span>
                                <button type="button" class="btn btn-sm btn-white shadow-sm" id="btn-add-actividad"><i class="fas fa-plus text-success"></i></button>
                            </div>
                            <div class="card-body p-0">
                                <table class="table mb-0" id="tabla_actividad_fisica">
                                    <thead class="bg-light small font-weight-bold">
                                        <tr>
                                            <th>Actividad</th>
                                            <th>Min</th>
                                            <th>Frecuencia</th>
                                            <th width="40"></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- MEDICACIÓN --}}
                    <div class="col-lg-6">
                        <div class="card card-pastel shadow-none border">
                            <div class="card-header bg-pastel-blue d-flex justify-content-between align-items-center">
                                <span class="font-weight-bold"><i class="fas fa-capsules mr-1"></i> Medicación Habitual</span>
                                <button type="button" class="btn btn-sm btn-white shadow-sm" id="btn-add-medicacion"><i class="fas fa-plus text-primary"></i></button>
                            </div>
                            <div class="card-body p-0">
                                <table class="table mb-0" id="tabla_medicacion">
                                    <thead class="bg-light small font-weight-bold">
                                        <tr>
                                            <th>Medicamento</th>
                                            <th>Dosis</th>
                                            <th width="40"></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4">
                    <label class="font-weight-bold text-muted">OBSERVACIONES GENERALES</label>
                    <textarea name="observaciones" rows="2" class="form-control form-control-pastel text-uppercase" placeholder="NOTAS ADICIONALES..."></textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2">CANCELAR</button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i>GUARDAR REGISTRO
                    </button>
                </div>
            </div>
        </div>
    </form>
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

    .card-pastel { border-radius: 12px; overflow: hidden; border: none; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white; }
    .bg-pastel-green { background-color: var(--pastel-green) !important; }
    .bg-light-soft { background-color: #f8fbfd; }
    .text-pastel-blue { color: #5fa4be !important; }
    .text-pastel-purple { color: #9d89d3 !important; }

    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #e0e6ed;
        transition: all 0.3s;
        height: auto;
        padding: 8px 12px;
    }

    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 0 0.2rem rgba(168, 216, 234, 0.25);
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-blue:hover { background: #91c9de; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .btn-white { background: white; border: none; }
    
    .table thead th { border-top: none; text-transform: uppercase; color: #777; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // 1. Lógica de habilitar campos (Adaptada)
    const grupos = [
        { id: 'tabaco', campos: ['tabaco_tiempo_consumo', 'tabaco_tiempo_abstinencia'] },
        { id: 'alcohol', campos: ['alcohol_tiempo_consumo', 'alcohol_tiempo_abstinencia'] },
        { id: 'otras_sustancias', campos: ['otras_sustancias_cual', 'otras_sustancias_tiempo_consumo', 'otras_sustancias_tiempo_abstinencia'] }
    ];

    grupos.forEach(grupo => {
        $(`#${grupo.id}_estado`).on('change', function() {
            const isDisabled = $(this).val() === 'no_consume';
            grupo.campos.forEach(c => {
                $(`#${c}`).prop('disabled', isDisabled).val(isDisabled ? '' : $(`#${c}`).val());
            });
        }).trigger('change');
    });

    // 2. Tablas Dinámicas Estilizadas
    $('#btn-add-actividad').click(function() {
        $('#tabla_actividad_fisica tbody').append(`
            <tr>
                <td><input type="text" name="actividad_fisica_cual[]" class="form-control form-control-pastel text-uppercase" placeholder="EJ: CAMINATA" required></td>
                <td><input type="number" name="actividad_fisica_tiempo[]" class="form-control form-control-pastel" placeholder="30"></td>
                <td><input type="text" name="actividad_fisica_frecuencia[]" class="form-control form-control-pastel text-uppercase" placeholder="DIARIO"></td>
                <td class="text-center"><button type="button" class="btn btn-link text-danger remove-row"><i class="fas fa-times"></i></button></td>
            </tr>`);
    });

    $('#btn-add-medicacion').click(function() {
        $('#tabla_medicacion tbody').append(`
            <tr>
                <td><input type="text" name="medicacion_habitual_cual[]" class="form-control form-control-pastel text-uppercase" placeholder="NOMBRE..." required></td>
                <td><input type="text" name="medicacion_habitual_cantidad[]" class="form-control form-control-pastel text-uppercase" placeholder="1 TAB / 8H"></td>
                <td class="text-center"><button type="button" class="btn btn-link text-danger remove-row"><i class="fas fa-times"></i></button></td>
            </tr>`);
    });

    $(document).on('click', '.remove-row', function() { $(this).closest('tr').remove(); });

    // 3. Mayúsculas y SweetAlert
    $('input[type="text"], textarea').on('input', function() { this.value = this.value.toUpperCase(); });

    $('#consumoForm').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Guardar cambios?',
            text: "Se actualizará la información de estilo de vida.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#A8D8EA',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Revisar'
        }).then((result) => {
            if (result.isConfirmed) this.submit();
        });
    });

    $('#btnCancelar').on('click', function() {
        window.location.href = "{{ route('admin.registros.show', $registro->id) }}";
    });

    // Iniciar con una fila
    $('#btn-add-actividad').click();
    $('#btn-add-medicacion').click();
});
</script>
@stop