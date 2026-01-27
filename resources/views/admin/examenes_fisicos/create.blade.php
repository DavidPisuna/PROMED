@extends('adminlte::page')

@section('title', 'Crear Examen Físico')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-stethoscope mr-2"></i>F. EXAMEN FÍSICO REGIONAL
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">

    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE (Estilo Resumen Pastel) --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2 text-white">
            <h6 class="mb-0 font-weight-bold"><i class="fas fa-user-circle mr-2"></i>Información General del Registro</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                    <small class="d-block text-secondary">ID: {{ $registro->paciente->cedula_identidad ?? '—' }}</small>
                </div>
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo de Evaluación</small>
                    <span class="badge badge-pill bg-pastel-purple px-3 text-uppercase">{{ $registro->tipo }}</span>
                    <small class="d-block text-secondary mt-1">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</small>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico a Cargo</small>
                    <span class="text-dark font-weight-bold">DR. {{ strtoupper($registro->doctor->primer_apellido ?? '—') }}</span>
                    <small class="d-block text-secondary">{{ $registro->doctor->especialidad ?? 'MEDICINA GENERAL' }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO PRINCIPAL --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-clipboard-check mr-2"></i>Evaluación por Sistemas y Regiones
            </h5>
            <span class="badge bg-pastel-green text-dark px-3 py-2">NUEVO EXAMEN</span>
        </div>

        <form action="{{ route('admin.examenes_fisicos.store', $registro) }}" method="POST" id="examenFisicoForm">
            @csrf

            <div class="card-body">
                {{-- 🔸 NAVEGACIÓN DE REGIONES (TABS) --}}
                <ul class="nav nav-pills mb-4 bg-light p-2 rounded" id="regionTabs" role="tablist" style="gap: 5px;">
                    @foreach(array_keys($regiones) as $index => $region)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $index === 0 ? 'active' : '' }} btn-tab-pastel" 
                                id="tab-{{ $region }}"
                                data-bs-toggle="tab" 
                                data-bs-target="#panel-{{ $region }}" 
                                type="button" role="tab">
                            {{ strtoupper(str_replace('_', ' ', $region)) }}
                        </button>
                    </li>
                    @endforeach
                </ul>

                {{-- 🔸 CONTENIDO DE PESTAÑAS --}}
                <div class="tab-content pt-2" id="regionTabsContent">
                    @foreach($regiones as $region => $items)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                         id="panel-{{ $region }}" role="tabpanel">
                        
                        <div class="row">
                            @foreach($items as $item)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100 border-light shadow-sm item-card">
                                    <div class="card-body">
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="custom-control-input examen-checkbox" 
                                                   id="{{ $region }}_{{ $item }}"
                                                   name="examenes[{{ $region }}][{{ $item }}][valor]"
                                                   value="1"
                                                   data-target="{{ $region }}_{{ $item }}_observacion">
                                            <label class="custom-control-label font-weight-bold text-dark" for="{{ $region }}_{{ $item }}">
                                                {{ strtoupper(str_replace('_', ' ', $item)) }}
                                            </label>
                                        </div>
                                        
                                        <div id="{{ $region }}_{{ $item }}_observacion_group" class="observacion-group d-none mt-2">
                                            <textarea name="examenes[{{ $region }}][{{ $item }}][observacion]"
                                                      id="{{ $region }}_{{ $item }}_observacion"
                                                      rows="2" class="form-control form-control-sm form-control-pastel text-uppercase"
                                                      placeholder="HALLAZGOS..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- 🔹 ACCIONES --}}
            <div class="card-footer bg-white text-right py-3 border-top">
                <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2">
                    <i class="fas fa-times mr-1"></i> CANCELAR
                </button>
                <button type="submit" class="btn btn-pastel-blue shadow-sm px-5" id="btnGuardar">
                    <i class="fas fa-save mr-1"></i> GUARDAR EXAMEN
                </button>
            </div>
        </form>
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

    /* Estilo General */
    .text-pastel-purple { color: #9B86BD !important; }
    .bg-pastel-purple { background-color: #9B86BD !important; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-green { background-color: var(--pastel-green) !important; }
    .card-pastel { border-radius: 12px; border: none; }
    .bg-light-soft { background-color: #F8F9FA; }
    .border-right { border-right: 1px solid #dee2e6 !important; }

    /* Tabs Estilo Pastel */
    .btn-tab-pastel {
        border-radius: 8px !important;
        color: #555 !important;
        font-weight: bold;
        transition: 0.3s;
        border: none !important;
    }
    .btn-tab-pastel.active {
        background-color: var(--pastel-purple) !important;
        color: white !important;
        box-shadow: 0 4px 10px rgba(202, 184, 255, 0.4);
    }

    /* Inputs y Checkboxes */
    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
        transition: all 0.3s ease;
    }
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
    }
    .item-card { transition: 0.3s; border-radius: 10px; }
    .item-card:hover { transform: translateY(-3px); border-color: var(--pastel-blue); }

    /* Botones */
    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-blue:hover { background: #91c9de; color: #1a252f; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }

    @media (max-width: 768px) {
        .border-right { border-right: none !important; border-bottom: 1px solid #dee2e6; margin-bottom: 10px; }
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // 1. Mostrar/ocultar observaciones al marcar checkbox
    $('.examen-checkbox').on('change', function() {
        const targetGroup = $('#' + $(this).data('target') + '_group');
        if (this.checked) {
            targetGroup.removeClass('d-none').hide().fadeIn(300);
        } else {
            targetGroup.fadeOut(200, function() {
                $(this).addClass('d-none');
                $(this).find('textarea').val('');
            });
        }
    });

    // 2. Mayúsculas automáticas
    $('textarea').on('input', function() {
        this.value = this.value.toUpperCase();
    });

    // 3. Confirmación de Guardado SweetAlert2
    $('#examenFisicoForm').on('submit', function(e) {
        e.preventDefault();
        
        const anyChecked = $('.examen-checkbox:checked').length > 0;

        if (!anyChecked) {
            Swal.fire({
                icon: 'warning',
                title: 'Examen Vacío',
                text: 'Debe seleccionar al menos un sistema o región para guardar.',
                confirmButtonColor: '#9B86BD'
            });
            return;
        }

        Swal.fire({
            title: '¿Guardar Examen Físico?',
            text: "Se registrarán los hallazgos en la historia clínica del paciente.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#A8D8EA',
            cancelButtonColor: '#E3E3E3',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Revisar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let btn = $('#btnGuardar');
                btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...').prop('disabled', true);
                this.submit();
            }
        });
    });

    // 4. Botón Cancelar
    $('#btnCancelar').on('click', function() {
        Swal.fire({
            title: '¿Descartar cambios?',
            text: "Se perderá la información ingresada en este examen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#CAB8FF',
            confirmButtonText: 'Sí, salir',
            cancelButtonText: 'Continuar editando'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('admin.registros.show', $registro) }}";
            }
        });
    });
});
</script>
@stop