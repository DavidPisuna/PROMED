@extends('adminlte::page')

@section('title', 'Editar Antecedentes Patológicos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>EDITAR ANTECEDENTES PERSONALES
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
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Resumen del Paciente y Registro</h6>
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
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo de Evaluación</small>
                    <span class="badge badge-pill bg-pastel-purple px-3 text-uppercase">
                        {{ $registro->tipo }}
                    </span>
                </div>
                <div class="col-md-5">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico Responsable</small>
                    <span class="text-dark font-weight-500">
                        DR. {{ strtoupper($registro->doctor->primer_nombre ?? 'N/A') }} {{ strtoupper($registro->doctor->primer_apellido ?? '') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-clipboard-list mr-2"></i>Actualizar Antecedentes Clínicos
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.antecedentes_patologicos.update', $antecedente->id) }}" method="POST" id="antecedentesForm">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Antecedentes Clínicos y Quirúrgicos --}}
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-stethoscope mr-2 text-info"></i>Antecedentes Clínicos y Quirúrgicos <span class="text-danger">*</span>
                            </label>
                            <textarea name="antecedente_app" 
                                      class="form-control form-control-pastel text-uppercase @error('antecedente_app') is-invalid @enderror" 
                                      rows="3" placeholder="DESCRIPCIÓN...">{{ old('antecedente_app', $antecedente->antecedente_app) }}</textarea>
                            @error('antecedente_app')
                                <div class="invalid-feedback font-weight-bold">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Antecedentes Familiares --}}
                    <div class="col-md-12">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-users mr-2 text-warning"></i>Antecedentes Familiares
                            </label>
                            <textarea name="antecedente_apqx" 
                                      class="form-control form-control-pastel text-uppercase @error('antecedente_apqx') is-invalid @enderror" 
                                      rows="3" placeholder="DESCRIPCIÓN...">{{ old('antecedente_apqx', $antecedente->antecedente_apqx) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row border-top pt-4">
                    {{-- Autorización de Transfusiones --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-tint mr-2 text-danger"></i>¿Autoriza Transfusiones?</label>
                            <select name="autoriza_transfusiones" class="form-control form-control-pastel" required>
                                <option value="1" {{ old('autoriza_transfusiones', $antecedente->autoriza_transfusiones) == '1' ? 'selected' : '' }}>SÍ, AUTORIZA</option>
                                <option value="0" {{ old('autoriza_transfusiones', $antecedente->autoriza_transfusiones) == '0' ? 'selected' : '' }}>NO AUTORIZA</option>
                            </select>
                        </div>
                    </div>

                    {{-- Tratamiento Hormonal --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold"><i class="fas fa-pills mr-2 text-pastel-purple-icon"></i>¿Está bajo Tratamiento Hormonal?</label>
                            <select id="tratamiento_hormonal_si_no" name="tratamiento_hormonal_si_no" class="form-control form-control-pastel" required>
                                <option value="1" {{ old('tratamiento_hormonal_si_no', $antecedente->tratamiento_hormonal_si_no) == '1' ? 'selected' : '' }}>SÍ, SE ENCUENTRA EN TRATAMIENTO</option>
                                <option value="0" {{ old('tratamiento_hormonal_si_no', $antecedente->tratamiento_hormonal_si_no) == '0' ? 'selected' : '' }}>NO RECIBE TRATAMIENTO</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Descripción Hormonal --}}
                <div id="descripcion_tratamiento" class="row" style="display: none;">
                    <div class="col-12">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold text-info">Detalle del Tratamiento Hormonal</label>
                            <textarea name="tratamiento_hormonal_descripcion" 
                                      class="form-control form-control-pastel text-uppercase" 
                                      placeholder="ESPECIFIQUE...">{{ old('tratamiento_hormonal_descripcion', $antecedente->tratamiento_hormonal_descripcion) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="d-flex justify-content-end mt-4 gap-2">
                    <a href="{{ route('admin.registros.show', $registro->id) }}" class="btn btn-pastel-gray mr-2">
                        CANCELAR
                    </a>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm" id="btnGuardar">
                        <i class="fas fa-sync-alt mr-2"></i>ACTUALIZAR ANTECEDENTES
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
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .text-pastel-purple-icon { color: #CAB8FF !important; }
    .form-control-pastel {
        border-radius: 8px; border: 1.5px solid #eee; padding: 10px; transition: all 0.3s ease;
        height: auto !important; background-color: #ffffff !important; color: #495057 !important;
    }
    .form-control-pastel:focus { border-color: var(--pastel-blue); box-shadow: 0 0 8px rgba(168, 216, 234, 0.4); }
    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    .border-right { border-right: 1px solid #ebedf0 !important; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        function toggleHormonal() {
            if ($('#tratamiento_hormonal_si_no').val() == '1') {
                $('#descripcion_tratamiento').slideDown(300);
            } else {
                $('#descripcion_tratamiento').slideUp(300);
            }
        }
        $('#tratamiento_hormonal_si_no').change(toggleHormonal);
        toggleHormonal(); 

        $('textarea, input[type="text"]').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        $('#antecedentesForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Actualizar Antecedentes?',
                text: "Se modificarán los datos clínicos guardados.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#btnGuardar').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i>ACTUALIZANDO...');
                    this.submit();
                }
            });
        });
    });
</script>
@stop