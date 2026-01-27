@extends('adminlte::page')

@section('title', 'Registrar Puesto de Trabajo')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-briefcase mr-2"></i>G. FACTORES DE RIESGO DEL TRABAJO ACTUAL    
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">

    {{-- 🔹 RESUMEN DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4 border-0">
        <div class="card-body bg-light-soft py-3" style="border-left: 5px solid #A8D8EA;">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block font-weight-bold text-uppercase">Paciente</small>
                    <span class="h6 font-weight-bold">{{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}</span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block font-weight-bold text-uppercase">Cédula</small>
                    <span class="h6 font-weight-bold text-pastel-blue">{{ $registro->paciente->cedula_identidad ?? '—' }}</span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block font-weight-bold text-uppercase">Tipo Registro</small>
                    <span class="badge bg-pastel-purple text-white px-3">{{ $registro->tipo }}</span>
                </div>
                <div class="col-md-2">
                    <small class="text-muted d-block font-weight-bold text-uppercase">Fecha</small>
                    <span class="h6">{{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO PRINCIPAL --}}
    <form action="{{ route('admin.puestos.store', $registro) }}" method="POST" id="puestoForm">
        @csrf

        <div class="card card-pastel shadow-lg border-0 mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                    <i class="fas fa-id-card mr-2"></i>Información del Cargo
                </h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-0 text-uppercase">
                    <label class="font-weight-bold text-muted small"><i class="fas fa-briefcase text-primary mr-1"></i> Nombre del Puesto de Trabajo</label>
                    <input type="text" name="nombre_puesto" class="form-control form-control-pastel text-uppercase font-weight-bold" 
                           required placeholder="EJ: OPERARIO DE MÁQUINA, SUPERVISOR..." value="{{ old('nombre_puesto') }}">
                </div>
            </div>
        </div>

        {{-- 🔹 SECCIÓN DE ACTIVIDADES Y RIESGOS --}}
        <div class="card card-pastel shadow-lg border-0">
            <div class="card-header bg-pastel-blue py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-white font-weight-bold">
                    <i class="fas fa-exclamation-triangle mr-2"></i>Factores de Riesgo por Actividad
                    <span class="badge badge-pill bg-white text-info ml-2" id="contador-actividades">1</span>
                </h5>
                <button type="button" id="add-actividad" class="btn btn-light btn-sm shadow-sm font-weight-bold">
                    <i class="fas fa-plus-circle text-success mr-1"></i> AGREGAR ACTIVIDAD
                </button>
            </div>
            
            <div class="card-body bg-light-soft p-4">
                <div id="actividades-container">
                    {{-- Actividad Inicial --}}
                    <div class="actividad-item card shadow-sm mb-4 border-0 animate__animated animate__fadeIn">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold text-pastel-purple"><i class="fas fa-tasks mr-2"></i> ACTIVIDAD #1</span>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="small font-weight-bold text-muted text-uppercase">Descripción detallada</label>
                                <input type="text" name="actividades[0][nombre]" class="form-control form-control-pastel text-uppercase" required>
                            </div>
                            
                            <div class="row mt-3">
                                @php $colorIndex = 0; @endphp
                                @foreach ($factoresRiesgo as $categoria => $factores)
                                    <div class="col-md-4 mb-3">
                                        <div class="card h-100 border-light-pastel shadow-none">
                                            <div class="card-header py-1 bg-light text-center border-0">
                                                <small class="font-weight-bold text-pastel-blue text-uppercase">{{ $categoria }}</small>
                                            </div>
                                            <div class="card-body p-2" style="max-height: 150px; overflow-y: auto; font-size: 0.85rem;">
                                                @foreach ($factores as $factor)
                                                    <div class="custom-control custom-checkbox mb-1">
                                                        <input class="custom-control-input" type="checkbox" 
                                                               name="factores_riesgo[0][]" 
                                                               value="{{ $categoria }}_{{ $factor }}" 
                                                               id="{{ $categoria }}_{{ Str::slug($factor) }}_0">
                                                        <label class="custom-control-label font-weight-normal pointer text-uppercase" for="{{ $categoria }}_{{ Str::slug($factor) }}_0">
                                                            {{ $factor }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Empty State --}}
                <div class="text-center py-5 d-none" id="sin-actividades">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-50">
                    <p class="text-muted mt-3">No hay actividades registradas. Haga clic en el botón superior para agregar.</p>
                </div>
            </div>

            <div class="card-footer bg-white text-right py-3 border-top">
                <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray mr-2 px-4">CANCELAR</a>
                <button type="submit" class="btn btn-pastel-purple shadow px-5" id="btnGuardar">
                    <i class="fas fa-save mr-2"></i>GUARDAR PUESTO
                </button>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
    /* Estilos Pastel Coherentes */
    .text-pastel-purple { color: #9B86BD !important; }
    .bg-pastel-purple { background-color: #9B86BD !important; }
    .text-pastel-blue { color: #778DA9 !important; }
    .bg-pastel-blue { background-color: #A8D8EA !important; }
    .btn-pastel-gray { background-color: #E0E1DD; color: #415A77; border-radius: 8px; font-weight: bold; }
    .btn-pastel-purple { background-color: #9B86BD; color: white; border-radius: 8px; font-weight: bold; transition: 0.3s; }
    .btn-pastel-purple:hover { background-color: #836ba8; color: white; transform: translateY(-2px); }
    
    .card-pastel { border-radius: 15px; overflow: hidden; }
    .bg-light-soft { background-color: #f8fafc; }
    .border-light-pastel { border: 1px solid #e2e8f0; border-radius: 10px; }
    
    .form-control-pastel { border-radius: 10px; border: 1.5px solid #E0E1DD; }
    .form-control-pastel:focus { border-color: #9B86BD; box-shadow: 0 0 0 0.2rem rgba(155, 134, 189, 0.1); }
    
    .pointer { cursor: pointer; }
    .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #9B86BD;
        border-color: #9B86BD;
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    let actividadCount = 1;

    // 🔹 Agregar Actividad (Refactorizado para consistencia)
    $('#add-actividad').click(function() {
        actividadCount++;
        const index = actividadCount - 1;
        
        const html = `
            <div class="actividad-item card shadow-sm mb-4 border-0 animate__animated animate__fadeInUp">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-weight-bold text-pastel-purple"><i class="fas fa-tasks mr-2"></i> ACTIVIDAD #${actividadCount}</span>
                    <button type="button" class="btn btn-sm btn-outline-danger border-0 remove-actividad">
                        <i class="fas fa-trash-alt"></i> ELIMINAR
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label class="small font-weight-bold text-muted text-uppercase">Descripción detallada</label>
                        <input type="text" name="actividades[${index}][nombre]" class="form-control form-control-pastel text-uppercase" required>
                    </div>
                    <div class="row mt-3">
                        ${generarFactoresHtml(index)}
                    </div>
                </div>
            </div>`;
        
        $('#actividades-container').append(html);
        actualizarContador();
        $('#sin-actividades').addClass('d-none');
    });

    function generarFactoresHtml(index) {
        const categorias = @json($factoresRiesgo);
        let html = '';
        for (const [categoria, factores] of Object.entries(categorias)) {
            html += `
                <div class="col-md-4 mb-3">
                    <div class="card h-100 border-light-pastel shadow-none">
                        <div class="card-header py-1 bg-light text-center border-0">
                            <small class="font-weight-bold text-pastel-blue text-uppercase">${categoria}</small>
                        </div>
                        <div class="card-body p-2" style="max-height: 150px; overflow-y: auto; font-size: 0.85rem;">
                            ${factores.map(f => `
                                <div class="custom-control custom-checkbox mb-1">
                                    <input class="custom-control-input" type="checkbox" name="factores_riesgo[${index}][]" value="${categoria}_${f}" id="${categoria}_${index}_${f.replace(/\s+/g, '')}">
                                    <label class="custom-control-label font-weight-normal pointer text-uppercase" for="${categoria}_${index}_${f.replace(/\s+/g, '')}">${f}</label>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>`;
        }
        return html;
    }

    // 🔹 Eliminar Actividad con SweetAlert
    $(document).on('click', '.remove-actividad', function() {
        const item = $(this).closest('.actividad-item');
        Swal.fire({
            title: '¿Eliminar actividad?',
            text: "Se perderán los factores de riesgo seleccionados para esta actividad.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffb3b3',
            cancelButtonColor: '#E0E1DD',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                item.remove();
                actualizarContador();
                if ($('.actividad-item').length === 0) $('#sin-actividades').removeClass('d-none');
            }
        });
    });

    function actualizarContador() {
        $('#contador-actividades').text($('.actividad-item').length);
    }

    // 🔹 Submit con validación SweetAlert
    $('#puestoForm').on('submit', function(e) {
        e.preventDefault();
        
        if ($('.actividad-item').length === 0) {
            Swal.fire('Atención', 'Debe registrar al menos una actividad.', 'warning');
            return;
        }

        Swal.fire({
            title: '¿Confirmar Registro?',
            text: "Se guardará el análisis de puesto de trabajo para este paciente.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#9B86BD',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Revisar'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#btnGuardar').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Guardando...');
                this.submit();
            }
        });
    });

    // Forzar Mayúsculas
    $(document).on('input', 'input[type="text"]', function() {
        this.value = this.value.toUpperCase();
    });
});
</script>
@stop