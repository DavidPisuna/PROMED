@extends('adminlte::page')

@section('title', 'Editar Consumo y Estilo de Vida')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-edit mr-2"></i>Editar Consumo y Estilo de Vida
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
        <h6 class="mb-0 font-weight-bold text-dark">
            <i class="fas fa-user-circle mr-2 text-soft-primary"></i>Resumen del Paciente y Registro
        </h6>
    </div>
    <div class="card-body bg-light-soft py-3">
        <div class="row align-items-center">
            {{-- Nombre del Paciente --}}
            <div class="col-md-4 border-right">
                <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Nombre Completo</small>
                <span class="h6 font-weight-bold text-dark">
                    @if($registro->paciente)
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->segundo_nombre) }} 
                        {{ strtoupper($registro->paciente->primer_apellido) }} {{ strtoupper($registro->paciente->segundo_apellido) }}
                    @else
                        N/A
                    @endif
                </span>
            </div>

            {{-- Identificación --}}
            <div class="col-md-2 border-right">
                <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Identificación</small>
                <span class="h6 font-weight-bold text-dark">{{ $registro->paciente->cedula ?? $registro->paciente->cedula_identidad ?? 'N/A' }}</span>
            </div>

            {{-- Edad (Calculada) --}}
            <div class="col-md-2 border-right text-center">
                <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Edad</small>
                @if(isset($registro->paciente->fecha_nacimiento))
                    <span class="badge badge-pill bg-pastel-purple px-3 text-dark">
                        {{ \Carbon\Carbon::parse($registro->paciente->fecha_nacimiento)->age }} años
                    </span>
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </div>

            {{-- Empresa / ID Registro --}}
            <div class="col-md-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">Empresa</small>
                        <span class="text-dark font-weight-bold">
                            {{ strtoupper($registro->empresa->nombre ?? 'N/A') }}
                        </span>
                    </div>
                    <div class="text-right">
                        <small class="text-muted d-block text-uppercase font-weight-bold" style="font-size: 0.7rem;">ID Registro</small>
                        <span class="badge badge-pastel-light border text-soft-primary">#{{ $registro->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <form action="{{ route('admin.consumos.update', $consumo->id) }}" method="POST" id="consumoForm">
        @csrf
        @method('PUT')

        {{-- 1. SECCIÓN: TABACO Y ALCOHOL --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card card-pastel shadow-sm h-100">
                    <div class="card-header bg-pastel-blue">
                        <h3 class="card-title font-weight-bold"><i class="fas fa-smoking mr-2"></i>Consumo de Tabaco</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Estado</label>
                            <select name="tabaco_estado" id="tabaco_estado" class="form-control form-control-pastel" required>
                                <option value="no_consume" {{ $consumo->tabaco_estado == 'no_consume' ? 'selected' : '' }}>NO CONSUME</option>
                                <option value="activo" {{ $consumo->tabaco_estado == 'activo' ? 'selected' : '' }}>ACTIVO</option>
                                <option value="ex_consumidor" {{ $consumo->tabaco_estado == 'ex_consumidor' ? 'selected' : '' }}>EX CONSUMIDOR</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tiempo consumo (años)</label>
                                    <input type="number" name="tabaco_tiempo_consumo" id="tabaco_tiempo_consumo" value="{{ $consumo->tabaco_tiempo_consumo }}" class="form-control form-control-pastel">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Abstinencia (años)</label>
                                    <input type="number" name="tabaco_tiempo_abstinencia" id="tabaco_tiempo_abstinencia" value="{{ $consumo->tabaco_tiempo_abstinencia }}" class="form-control form-control-pastel">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-pastel shadow-sm h-100">
                    <div class="card-header bg-pastel-green">
                        <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-wine-bottle mr-2"></i>Consumo de Alcohol</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">Estado</label>
                            <select name="alcohol_estado" id="alcohol_estado" class="form-control form-control-pastel" required>
                                <option value="no_consume" {{ $consumo->alcohol_estado == 'no_consume' ? 'selected' : '' }}>NO CONSUME</option>
                                <option value="activo" {{ $consumo->alcohol_estado == 'activo' ? 'selected' : '' }}>ACTIVO</option>
                                <option value="ex_consumidor" {{ $consumo->alcohol_estado == 'ex_consumidor' ? 'selected' : '' }}>EX CONSUMIDOR</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tiempo consumo (años)</label>
                                    <input type="number" name="alcohol_tiempo_consumo" id="alcohol_tiempo_consumo" value="{{ $consumo->alcohol_tiempo_consumo }}" class="form-control form-control-pastel">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Abstinencia (años)</label>
                                    <input type="number" name="alcohol_tiempo_abstinencia" id="alcohol_tiempo_abstinencia" value="{{ $consumo->alcohol_tiempo_abstinencia }}" class="form-control form-control-pastel">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. SECCIÓN: OTRAS SUSTANCIAS --}}
        <div class="card card-pastel shadow-sm mt-4">
            <div class="card-header bg-pastel-purple">
                <h3 class="card-title font-weight-bold text-white"><i class="fas fa-pills mr-2"></i>Otras Sustancias Psicoactivas</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Estado</label>
                            <select name="otras_sustancias_estado" id="otras_sustancias_estado" class="form-control form-control-pastel">
                                <option value="no_consume" {{ $consumo->otras_sustancias_estado == 'no_consume' ? 'selected' : '' }}>NO CONSUME</option>
                                <option value="activo" {{ $consumo->otras_sustancias_estado == 'activo' ? 'selected' : '' }}>ACTIVO</option>
                                <option value="ex_consumidor" {{ $consumo->otras_sustancias_estado == 'ex_consumidor' ? 'selected' : '' }}>EX CONSUMIDOR</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>¿Cuál sustancia?</label>
                            <input type="text" name="otras_sustancias_cual" id="otras_sustancias_cual" value="{{ $consumo->otras_sustancias_cual }}" class="form-control form-control-pastel text-uppercase" placeholder="ESPECIFIQUE">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tiempo (años)</label>
                            <input type="number" name="otras_sustancias_tiempo_consumo" id="otras_sustancias_tiempo_consumo" value="{{ $consumo->otras_sustancias_tiempo_consumo }}" class="form-control form-control-pastel">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Abstinencia (años)</label>
                            <input type="number" name="otras_sustancias_tiempo_abstinencia" id="otras_sustancias_tiempo_abstinencia" value="{{ $consumo->otras_sustancias_tiempo_abstinencia }}" class="form-control form-control-pastel">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. ACTIVIDAD FÍSICA DINÁMICA --}}
        <div class="card card-pastel shadow-sm mt-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
                <h3 class="card-title font-weight-bold text-pastel-blue"><i class="fas fa-running mr-2"></i>Actividad Física</h3>
                <button type="button" id="add-actividad" class="btn btn-pastel-blue btn-sm ml-auto">
                    <i class="fas fa-plus mr-1"></i> AGREGAR ACTIVIDAD
                </button>
            </div>
            <div class="card-body pb-0">
                <div id="actividades-container">
                    @forelse ($consumo->actividadesFisicas as $actividad)
                        <div class="actividad-item bg-light border rounded p-3 mb-3 shadow-sm">
                            <div class="row align-items-end">
                                <div class="col-md-5">
                                    <label>Actividad</label>
                                    <input type="text" name="actividad_fisica_cual[]" class="form-control form-control-pastel text-uppercase" value="{{ $actividad->actividad_fisica_cual }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Tiempo (min)</label>
                                    <input type="text" name="actividad_fisica_tiempo[]" class="form-control form-control-pastel text-uppercase" value="{{ $actividad->actividad_fisica_tiempo }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Frecuencia</label>
                                    <input type="text" name="actividad_fisica_frecuencia[]" class="form-control form-control-pastel text-uppercase" value="{{ $actividad->actividad_fisica_frecuencia }}" required>
                                </div>
                                <div class="col-md-1 text-right">
                                    <button type="button" class="btn btn-outline-danger remove-actividad"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-light text-center border py-4 no-data-alert">
                            <i class="fas fa-info-circle mr-2 text-info"></i> No se han registrado actividades físicas.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- 4. MEDICACIÓN HABITUAL DINÁMICA --}}
        <div class="card card-pastel shadow-sm mt-4">
            <div class="card-header d-flex justify-content-between align-items-center bg-white border-bottom">
                <h3 class="card-title font-weight-bold text-warning"><i class="fas fa-capsules mr-2"></i>Medicación Habitual</h3>
                <button type="button" id="add-medicacion" class="btn btn-pastel-warning btn-sm ml-auto">
                    <i class="fas fa-plus mr-1"></i> AGREGAR MEDICACIÓN
                </button>
            </div>
            <div class="card-body pb-0">
                <div id="medicaciones-container">
                    @forelse ($consumo->medicacionesHabituales as $medicacion)
                        <div class="medicacion-item bg-light border rounded p-3 mb-3 shadow-sm">
                            <div class="row align-items-end">
                                <div class="col-md-6">
                                    <label>Medicamento</label>
                                    <input type="text" name="medicacion_habitual_cual[]" class="form-control form-control-pastel text-uppercase" value="{{ $medicacion->medicacion_habitual_cual }}" required>
                                </div>
                                <div class="col-md-5">
                                    <label>Dosis / Frecuencia</label>
                                    <input type="text" name="medicacion_habitual_cantidad[]" class="form-control form-control-pastel text-uppercase" value="{{ $medicacion->medicacion_habitual_cantidad }}" required>
                                </div>
                                <div class="col-md-1 text-right">
                                    <button type="button" class="btn btn-outline-danger remove-medicacion"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-light text-center border py-4 no-data-alert-med">
                            <i class="fas fa-info-circle mr-2 text-warning"></i> No hay medicación habitual registrada.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- OBSERVACIONES --}}
        <div class="card card-pastel shadow-sm mt-4">
            <div class="card-header bg-pastel-gray">
                <h3 class="card-title font-weight-bold"><i class="fas fa-comment-medical mr-2"></i>Observaciones Adicionales</h3>
            </div>
            <div class="card-body">
                <textarea name="observaciones" class="form-control form-control-pastel text-uppercase" rows="3" placeholder="DETALLES RELEVANTES...">{{ $consumo->observaciones }}</textarea>
            </div>
        </div>

        {{-- BOTONES DE ACCIÓN --}}
        <div class="d-flex justify-content-end mt-4 gap-2">
            <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray mr-2">CANCELAR</a>
            <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm" id="btnActualizar">
                <i class="fas fa-save mr-2"></i>GUARDAR CAMBIOS
            </button>
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
        --pastel-yellow: #FFF5BA;
    }
    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    .bg-pastel-green { background-color: var(--pastel-green) !important; }
    .bg-pastel-gray { background-color: var(--pastel-gray) !important; }
    
    .text-pastel-purple { color: #8e74e6 !important; }
    .text-pastel-blue { color: #6fb9d6 !important; }

    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
        padding: 10px;
        transition: all 0.3s ease;
    }
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
        outline: none;
    }
    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); }
    
    .btn-pastel-warning { background: #FFE082; border: none; border-radius: 8px; font-weight: bold; color: #856404; }
    .btn-pastel-warning:hover { background: #FFD54F; transform: scale(1.02); }

    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    .text-uppercase { text-transform: uppercase; }
    .bg-light-soft { background-color: #fcfcfc; }

    /* Asegura que el texto sea visible en el select pastel */
.form-control-pastel {
    color: #495057 !important; /* Color gris oscuro profesional */
    background-color: #f8f9ff; /* Un fondo sutilmente azulado/pastel */
    border: 1px solid #dee2e6;
}

/* Esto arregla la visibilidad de las opciones dentro del desplegable */
.form-control-pastel option {
    color: #000000; 
    background-color: #ffffff;
}

/* Cambia el color cuando el campo tiene el foco */
.form-control-pastel:focus {
    color: #212529;
    background-color: #fff;
    border-color: #bac8ff; /* Color pastel al hacer click */
    box-shadow: 0 0 0 0.2rem rgba(186, 200, 255, 0.25);
}
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        // 1. Forzar Mayúsculas en tiempo real
        $(document).on('input', 'input[type="text"], textarea', function() {
            this.value = this.value.toUpperCase();
        });

        // 2. Lógica Dinámica: Actividad Física
        $('#add-actividad').click(function() {
            $('.no-data-alert').hide();
            let html = `
                <div class="actividad-item bg-light border rounded p-3 mb-3 shadow-sm" style="display:none">
                    <div class="row align-items-end">
                        <div class="col-md-5">
                            <label>Actividad</label>
                            <input type="text" name="actividad_fisica_cual[]" class="form-control form-control-pastel text-uppercase" placeholder="EJ: NATACIÓN" required>
                        </div>
                        <div class="col-md-3">
                            <label>Tiempo (min)</label>
                            <input type="text" name="actividad_fisica_tiempo[]" class="form-control form-control-pastel text-uppercase" placeholder="EJ: 45" required>
                        </div>
                        <div class="col-md-3">
                            <label>Frecuencia</label>
                            <input type="text" name="actividad_fisica_frecuencia[]" class="form-control form-control-pastel text-uppercase" placeholder="EJ: DIARIO" required>
                        </div>
                        <div class="col-md-1 text-right">
                            <button type="button" class="btn btn-outline-danger remove-actividad"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>`;
            $(html).appendTo('#actividades-container').fadeIn(300);
        });

        // 3. Lógica Dinámica: Medicación
        $('#add-medicacion').click(function() {
            $('.no-data-alert-med').hide();
            let html = `
                <div class="medicacion-item bg-light border rounded p-3 mb-3 shadow-sm" style="display:none">
                    <div class="row align-items-end">
                        <div class="col-md-6">
                            <label>Medicamento</label>
                            <input type="text" name="medicacion_habitual_cual[]" class="form-control form-control-pastel text-uppercase" placeholder="NOMBRE DEL MEDICAMENTO" required>
                        </div>
                        <div class="col-md-5">
                            <label>Dosis / Frecuencia</label>
                            <input type="text" name="medicacion_habitual_cantidad[]" class="form-control form-control-pastel text-uppercase" placeholder="EJ: 500MG CADA 8 HORAS" required>
                        </div>
                        <div class="col-md-1 text-right">
                            <button type="button" class="btn btn-outline-danger remove-medicacion"><i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </div>`;
            $(html).appendTo('#medicaciones-container').fadeIn(300);
        });

        // 4. Eliminar Items
        $(document).on('click', '.remove-actividad, .remove-medicacion', function() {
            let container = $(this).closest('.actividad-item, .medicacion-item').parent();
            $(this).closest('.actividad-item, .medicacion-item').fadeOut(300, function() { 
                $(this).remove(); 
                if (container.children().length === 0) {
                    container.find('.no-data-alert, .no-data-alert-med').fadeIn();
                }
            });
        });

        // 5. Control de Estados (Habilitar/Deshabilitar)
        function setupToggle(selectId, targetIds) {
            $(`#${selectId}`).change(function() {
                let isDisabled = $(this).val() === 'no_consume';
                targetIds.forEach(id => {
                    $(`#${id}`).prop('disabled', isDisabled);
                    if (isDisabled) $(`#${id}`).val('');
                });
            }).trigger('change');
        }

        setupToggle('tabaco_estado', ['tabaco_tiempo_consumo', 'tabaco_tiempo_abstinencia']);
        setupToggle('alcohol_estado', ['alcohol_tiempo_consumo', 'alcohol_tiempo_abstinencia']);
        setupToggle('otras_sustancias_estado', ['otras_sustancias_cual', 'otras_sustancias_tiempo_consumo', 'otras_sustancias_tiempo_abstinencia']);

        // 6. Confirmación con SweetAlert2
        $('#consumoForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Confirmar Actualización?',
                text: "Se guardarán los cambios en el historial del paciente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'SÍ, GUARDAR',
                cancelButtonText: 'REVISAR'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mayúsculas finales antes de enviar
                    $(this).find('input[type="text"], textarea').each(function() {
                        $(this).val($(this).val().toUpperCase());
                    });
                    
                    $('#btnActualizar').html('<i class="fas fa-spinner fa-spin mr-2"></i> PROCESANDO...').prop('disabled', true);
                    this.submit();
                }
            });
        });
    });
</script>
@stop