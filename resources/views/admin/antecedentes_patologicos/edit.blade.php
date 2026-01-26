@extends('adminlte::page')

@section('title', 'Editar Antecedentes Patológicos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-notes-medical mr-2"></i>
        Editar Antecedentes Patológicos
    </h1>

    <a href="{{ route('admin.registros.show', $antecedente->registro_id) }}"
       class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Registro
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid pb-4">
    
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-user-circle mr-2"></i>Paciente en Evaluación</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-6 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($antecedente->registro->paciente->primer_nombre) }} {{ strtoupper($antecedente->registro->paciente->primer_apellido) }}
                    </span>
                </div>
                <div class="col-md-3 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación</small>
                    <span class="h6 font-weight-bold">{{ $antecedente->registro->paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-3 text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">ID Registro</small>
                    <span class="badge badge-pill bg-pastel-purple px-3"># {{ $antecedente->registro_id }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DE EDICIÓN --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-edit mr-2"></i>Actualizar Información Clínica
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.antecedentes_patologicos.update', $antecedente) }}" 
                  method="POST" id="editAntecedenteForm">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- APP --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-user-injured mr-2 text-info"></i>Personales (APP)
                            </label>
                            <textarea name="antecedente_app" 
                                      class="form-control form-control-pastel text-uppercase" 
                                      rows="3" placeholder="DESCRIBA LOS ANTECEDENTES PERSONALES...">{{ old('antecedente_app', $antecedente->antecedente_app) }}</textarea>
                        </div>
                    </div>

                    {{-- APQX --}}
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label font-weight-bold">
                                <i class="fas fa-procedures mr-2 text-success"></i>Quirúrgicos (APQX)
                            </label>
                            <textarea name="antecedente_apqx" 
                                      class="form-control form-control-pastel text-uppercase" 
                                      rows="3" placeholder="DESCRIBA LOS ANTECEDENTES QUIRÚRGICOS...">{{ old('antecedente_apqx', $antecedente->antecedente_apqx) }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row align-items-center">
                    {{-- CHECKBOXES --}}
                    <div class="col-md-5">
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success mb-3">
                            <input type="checkbox" class="custom-control-input" id="autoriza_transfusiones" name="autoriza_transfusiones" value="1" {{ old('autoriza_transfusiones', $antecedente->autoriza_transfusiones) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="autoriza_transfusiones">Autoriza transfusiones sanguíneas</label>
                        </div>

                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input" id="tratamiento_hormonal_si_no" name="tratamiento_hormonal_si_no" value="1" {{ old('tratamiento_hormonal_si_no', $antecedente->tratamiento_hormonal_si_no) ? 'checked' : '' }}>
                            <label class="custom-control-label font-weight-bold" for="tratamiento_hormonal_si_no">Tratamiento hormonal</label>
                        </div>
                    </div>

                    {{-- DESCRIPCIÓN TRATAMIENTO --}}
                    <div class="col-md-7">
                        <div class="form-group mb-0">
                            <label class="form-label font-weight-bold">Descripción del tratamiento hormonal</label>
                            <textarea name="tratamiento_hormonal_descripcion" id="tratamiento_hormonal_descripcion"
                                      class="form-control form-control-pastel text-uppercase" 
                                      rows="2" {{ old('tratamiento_hormonal_si_no', $antecedente->tratamiento_hormonal_si_no) ? '' : 'disabled' }}>{{ old('tratamiento_hormonal_descripcion', $antecedente->tratamiento_hormonal_descripcion) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-5 gap-2">
                    <a href="{{ route('admin.registros.show', $antecedente->registro_id) }}" class="btn btn-pastel-gray mr-2">CANCELAR</a>
                    <button type="submit" class="btn btn-pastel-purple px-5 shadow-sm text-white">
                        <i class="fas fa-save mr-2"></i>ACTUALIZAR ANTECEDENTES
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

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
    .text-pastel-purple { color: #9b86d9 !important; }
    .bg-light-soft { background-color: #fcfcfc; }
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

    .btn-pastel-purple { background: var(--pastel-purple); border: none; border-radius: 8px; font-weight: bold; transition: 0.3s; }
    .btn-pastel-purple:hover { background: #b4a0f5; transform: scale(1.02); color: white; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }

    .text-uppercase { text-transform: uppercase; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // 1. Forzar mayúsculas en tiempo real
        $('input[type="text"], textarea').on('input', function() {
            this.value = this.value.toUpperCase();
        });

        // 2. Lógica para habilitar/deshabilitar textarea de hormonas
        $('#tratamiento_hormonal_si_no').on('change', function() {
            if($(this).is(':checked')) {
                $('#tratamiento_hormonal_descripcion').prop('disabled', false).focus();
            } else {
                $('#tratamiento_hormonal_descripcion').prop('disabled', true).val('');
            }
        });

        // 3. Confirmación con SweetAlert2
        $('#editAntecedenteForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Guardar cambios?',
                text: "Se actualizará la información clínica del paciente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#CAB8FF',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Revisar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Asegurar mayúsculas antes de enviar
                    $(this).find('textarea').each(function() {
                        $(this).val($(this).val().toUpperCase());
                    });
                    this.submit();
                }
            });
        });
    });
</script>
@stop