@extends('adminlte::page')

@section('title', 'Editar Examen Físico')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap p-2">
    <div>
        <h1 class="text-pastel-purple font-weight-bold mb-0">
            <i class="fas fa-stethoscope mr-2"></i>Edición de Examen Físico
        </h1>
        <p class="text-muted mb-0">Registro de hallazgos y anomalías por región anatómica</p>
    </div>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm hover-lift">
        <i class="fas fa-chevron-left mr-1"></i> Volver al Expediente
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-5">

    {{-- 🔹 HEADER DE PACIENTE: ESTILO COMPACTO --}}
    <div class="card shadow-sm border-0 mb-4 overflow-hidden" style="border-radius: 15px;">
        <div class="row no-gutters">
            <div class="col-md-1 bg-pastel-purple d-flex align-items-center justify-content-center p-3 text-white">
                <i class="fas fa-user-circle fa-2x"></i>
            </div>
            <div class="col-md-11">
                <div class="card-body py-3">
                    <div class="row text-center text-md-left">
                        <div class="col-md-4 border-right-md">
                            <label class="small text-uppercase text-muted font-weight-bold mb-0">Paciente</label>
                            <div class="h6 font-weight-bold text-dark mb-0 text-uppercase">
                                {{ $registro->paciente->primer_nombre }} {{ $registro->paciente->primer_apellido }}
                            </div>
                        </div>
                        <div class="col-md-3 border-right-md">
                            <label class="small text-uppercase text-muted font-weight-bold mb-0">Identificación</label>
                            <div class="h6 font-weight-bold mb-0">{{ $registro->paciente->cedula_identidad }}</div>
                        </div>
                        <div class="col-md-2 border-right-md">
                            <label class="small text-uppercase text-muted font-weight-bold mb-0">Tipo Evaluación</label>
                            <div><span class="badge badge-pill bg-pastel-blue-light text-primary px-3">{{ $registro->tipo }}</span></div>
                        </div>
                        <div class="col-md-3">
                            <label class="small text-uppercase text-muted font-weight-bold mb-0">Doctor Responsable</label>
                            <div class="h6 font-weight-bold mb-0 text-uppercase">DR. {{ $registro->doctor->primer_apellido ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ALERTA INFORMATIVA --}}
    <div class="alert bg-pastel-blue-light border-0 shadow-sm mb-4" style="border-radius: 12px;">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle fa-lg text-primary mr-3"></i>
            <span class="text-dark"><strong>Modo Edición:</strong> Marque únicamente los ítems que presentan <strong>hallazgos o anomalías</strong>. Los ítems no seleccionados se considerarán normales.</span>
        </div>
    </div>

    {{-- 🩺 FORMULARIO PRINCIPAL --}}
    <form action="{{ route('admin.examenes_fisicos.update', $registro) }}" method="POST" id="examenFisicoForm">
        @csrf
        @method('PUT')

        <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h5 class="font-weight-bold text-pastel-purple mb-0">
                    <i class="fas fa-clipboard-check mr-2"></i>Exploración Física por Regiones
                </h5>
            </div>

            <div class="card-body px-4">
                {{-- NAVEGACIÓN DE PESTAÑAS --}}
                <ul class="nav nav-pills nav-justified mb-4" id="regionTabs" role="tablist">
                    @foreach(array_keys($regiones) as $index => $region)
                    <li class="nav-item">
                        <a class="nav-link border-0 text-uppercase font-weight-bold py-3 m-1 {{ $index === 0 ? 'active' : '' }}" 
                           id="tab-{{ $region }}" 
                           data-toggle="pill" 
                           href="#panel-{{ $region }}" 
                           role="tab" 
                           style="border-radius: 12px;">
                            {{ str_replace('_', ' ', $region) }}
                        </a>
                    </li>
                    @endforeach
                </ul>

                <div class="tab-content pt-2" id="regionTabsContent">
                    @foreach($regiones as $region => $items)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="panel-{{ $region }}" role="tabpanel">
                        <div class="row">
                            @foreach($items as $item)
                                @php
                                    $examenItem = $examenes[$region]->firstWhere('item', $item) ?? null;
                                    $valor = $examenItem ? $examenItem->valor : false;
                                    $observacion = $examenItem ? $examenItem->observacion : '';
                                @endphp
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100 examen-card transition-all border {{ $valor ? 'border-danger bg-light-red' : 'border-light bg-white' }}" 
                                         style="border-radius: 15px; cursor: pointer;">
                                        <div class="card-body p-3">
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" 
                                                       class="custom-control-input examen-checkbox" 
                                                       id="{{ $region }}_{{ $item }}"
                                                       name="examenes[{{ $region }}][{{ $item }}][valor]"
                                                       value="1" {{ $valor ? 'checked' : '' }}
                                                       data-target="{{ $region }}_{{ $item }}_observacion">
                                                <label class="custom-control-label font-weight-bold text-dark text-uppercase" for="{{ $region }}_{{ $item }}">
                                                    {{ str_replace('_', ' ', $item) }}
                                                </label>
                                            </div>
                                            
                                            <div id="{{ $region }}_{{ $item }}_observacion_group" class="mt-3 {{ $valor ? '' : 'd-none' }}">
                                                <label class="small font-weight-bold text-danger">DETALLE DEL HALLAZGO</label>
                                                <textarea name="examenes[{{ $region }}][{{ $item }}][observacion]" 
                                                          id="{{ $region }}_{{ $item }}_observacion"
                                                          class="form-control form-control-sm border-0 bg-white text-uppercase" 
                                                          rows="2" 
                                                          style="border-radius: 8px;"
                                                          placeholder="DESCRIBA LA ANOMALÍA...">{{ $observacion }}</textarea>
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

            {{-- BOTONES DE ACCIÓN --}}
            <div class="card-footer bg-light border-0 py-4 px-4 d-flex justify-content-end">
                <button type="button" id="btnCancelar" class="btn btn-pastel-gray px-4 mr-3">
                    <i class="fas fa-times mr-1"></i> CANCELAR
                </button>
                <button type="submit" class="btn btn-pastel-blue px-5 shadow font-weight-bold py-2" style="border-radius: 10px;">
                    <i class="fas fa-save mr-2"></i> GUARDAR CAMBIOS
                </button>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
    /* Paleta Pastel Unificada */
    :root {
        --pastel-purple: #CAB8FF;
        --pastel-blue: #A8D8EA;
        --pastel-gray: #E3E3E3;
    }

    .bg-pastel-purple { background: linear-gradient(135deg, #6a1b9a, #8e24aa); }
    .bg-pastel-blue-light { background-color: #e3f2fd; }
    .text-pastel-purple { color: #6a1b9a; }
    
    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; transition: 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }

    /* Estilos de Pestañas (Pills) */
    .nav-pills .nav-link { color: #6c757d; background: #f8f9fa; margin: 0 4px; }
    .nav-pills .nav-link.active { background-color: var(--pastel-purple) !important; color: white !important; box-shadow: 0 4px 10px rgba(202, 184, 255, 0.4); }

    /* Cards de Examen */
    .examen-card { transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .examen-card:hover { transform: translateY(-3px); box-shadow: 0 6px 12px rgba(0,0,0,0.08); }
    .bg-light-red { background-color: #fff5f5 !important; }
    
    .hover-lift:hover { transform: translateY(-2px); transition: 0.2s; }
    .border-right-md { border-right: 1px solid #eee; }
    
    /* Personalización Checkbox */
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #e74c3c !important;
        border-color: #e74c3c !important;
    }

    @media (max-width: 768px) { .border-right-md { border-right: none; border-bottom: 1px solid #eee; margin-bottom: 10px; } }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        // 1. Lógica de selección y visualización
        $('.examen-checkbox').on('change', function() {
            const isChecked = $(this).is(':checked');
            const targetGroup = $('#' + $(this).data('target') + '_group');
            const card = $(this).closest('.examen-card');

            if (isChecked) {
                targetGroup.removeClass('d-none').hide().fadeIn();
                card.addClass('border-danger bg-light-red');
            } else {
                targetGroup.fadeOut(300, function() { 
                    $(this).addClass('d-none'); 
                    $(this).find('textarea').val('');
                });
                card.removeClass('border-danger bg-light-red');
            }
        });

        // Click en el card activa el checkbox
        $('.examen-card').on('click', function(e) {
            if (!$(e.target).is('input, textarea, label')) {
                const cb = $(this).find('.examen-checkbox');
                cb.prop('checked', !cb.prop('checked')).trigger('change');
            }
        });

        // 2. Mayúsculas en tiempo real
        $(document).on('input', 'textarea', function() {
            this.value = this.value.toUpperCase();
        });

        // 3. SweetAlert2: Confirmación de Guardado
        $('#examenFisicoForm').on('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Guardar Examen Físico?',
                text: "Se actualizarán los hallazgos clínicos del paciente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, guardar',
                cancelButtonText: 'Revisar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // 4. SweetAlert2: Cancelar
        $('#btnCancelar').on('click', function() {
            Swal.fire({
                title: '¿Descartar cambios?',
                text: "Los cambios realizados no se guardarán.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#CAB8FF',
                confirmButtonText: 'Salir sin guardar',
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