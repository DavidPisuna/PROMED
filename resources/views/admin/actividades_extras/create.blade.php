@extends('adminlte::page')

@section('title', 'Registrar Actividades Extras')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-running mr-2"></i>Registrar Actividades Extras
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
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Resumen del Registro Médico</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                    <p class="mb-0 small text-muted">Cédula: {{ $registro->paciente->cedula_identidad ?? 'N/A' }}</p>
                </div>
                <div class="col-md-4 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo de Evaluación</small>
                    <span class="badge badge-pill bg-pastel-purple px-3 text-uppercase">
                        {{ $registro->tipo }}
                    </span>
                    <p class="mb-0 small text-muted">Fecha: {{ \Carbon\Carbon::parse($registro->fecha)->format('d/m/Y') }}</p>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Médico Responsable</small>
                    <span class="text-dark font-weight-bold">DR. {{ strtoupper($registro->doctor->primer_nombre ?? '—') }} {{ strtoupper($registro->doctor->primer_apellido ?? '') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DINÁMICO --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-list-ul mr-2"></i>Nuevas Actividades Extras
            </h5>
            <div class="card-tools">
                <span class="badge badge-pill bg-pastel-purple px-3" id="contador-actividades">1 Actividad</span>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.actividades_extras.store', $registro) }}" method="POST" id="actividadesForm">
                @csrf

                <div id="contenedor-actividades">
                    {{-- PRIMERA FILA (POR DEFECTO) --}}
                    <div class="actividad-item card border shadow-none mb-4">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                            <span class="font-weight-bold text-muted small"><i class="fas fa-tag mr-1"></i> ACTIVIDAD #1</span>
                            <button type="button" class="btn btn-xs btn-outline-danger remove-actividad" style="display:none;">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group mb-0">
                                        <label class="small font-weight-bold text-uppercase">Descripción de la Actividad <span class="text-danger">*</span></label>
                                        <input type="text" name="actividades[0][tipo_actividad]" class="form-control form-control-pastel text-uppercase" 
                                               required placeholder="EJ: NATACIÓN, GIMNASIO, CURSO DE PINTURA..."
                                               value="{{ old('actividades.0.tipo_actividad') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="small font-weight-bold text-uppercase">Fecha Realizada</label>
                                        <input type="date" name="actividades[0][fecha]" class="form-control form-control-pastel fecha-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BOTÓN AGREGAR --}}
                <div class="text-center mt-2">
                    <button type="button" id="agregar-actividad" class="btn btn-outline-info btn-round px-4 shadow-sm">
                        <i class="fas fa-plus-circle mr-1"></i> AGREGAR OTRA ACTIVIDAD
                    </button>
                </div>

                <hr class="my-4">

                {{-- BOTONES ACCIÓN --}}
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2 px-4">CANCELAR</button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                        <i class="fas fa-save mr-2"></i>GUARDAR ACTIVIDADES
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
        --pastel-gray: #E3E3E3;
    }

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .text-pastel-blue { color: #6fb9d6 !important; }

    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
        height: calc(2.5rem + 2px);
        transition: all 0.3s ease;
    }

    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
        outline: none;
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; transition: 0.3s; }
    .btn-pastel-blue:hover { background: #91c9de; transform: scale(1.02); color: #2c3e50; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .btn-round { border-radius: 20px; font-weight: bold; }
    .actividad-item { border-radius: 10px; border: 1px solid #ebedf0 !important; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        const hoy = new Date().toISOString().split('T')[0];

        // Función para aplicar validación de fecha máxima y UI
        function updateUI() {
            const total = $('.actividad-item').length;
            $('#contador-actividades').text(`${total} ${total === 1 ? 'Actividad' : 'Actividades'}`);
            
            // Mostrar/Ocultar botón eliminar
            $('.remove-actividad').toggle(total > 1);
            
            // Aplicar fecha máxima a todos los inputs de fecha
            $('.fecha-input').attr('max', hoy);
        }

        // Agregar Nueva Actividad
        $('#agregar-actividad').click(function() {
            const index = $('.actividad-item').length;
            const nuevaActividad = `
                <div class="actividad-item card border shadow-none mb-4" style="display:none;">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                        <span class="font-weight-bold text-muted small"><i class="fas fa-tag mr-1"></i> ACTIVIDAD #${index + 1}</span>
                        <button type="button" class="btn btn-xs btn-outline-danger remove-actividad">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold text-uppercase">Descripción de la Actividad <span class="text-danger">*</span></label>
                                    <input type="text" name="actividades[${index}][tipo_actividad]" class="form-control form-control-pastel text-uppercase" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold text-uppercase">Fecha Realizada</label>
                                    <input type="date" name="actividades[${index}][fecha]" class="form-control form-control-pastel fecha-input" max="${hoy}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`;
            
            const $el = $(nuevaActividad).appendTo('#contenedor-actividades');
            $el.slideDown(200);
            updateUI();
        });

        // Eliminar Fila con confirmación
        $(document).on('click', '.remove-actividad', function() {
            const $card = $(this).closest('.actividad-item');
            Swal.fire({
                title: '¿Remover esta actividad?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffb3b3',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, remover',
                cancelButtonText: 'No, mantener'
            }).then((result) => {
                if (result.isConfirmed) {
                    $card.slideUp(300, function() { 
                        $(this).remove(); 
                        reindexar();
                        updateUI();
                    });
                }
            });
        });

        function reindexar() {
            $('.actividad-item').each(function(i) {
                $(this).find('.card-header span').html(`<i class="fas fa-tag mr-1"></i> ACTIVIDAD #${i + 1}`);
                $(this).find('input[name*="tipo_actividad"]').attr('name', `actividades[${i}][tipo_actividad]`);
                $(this).find('input[name*="fecha"]').attr('name', `actividades[${i}][fecha]`);
            });
        }

        // Forzar Mayúsculas en inputs de texto
        $(document).on('input', 'input[type="text"]', function() {
            this.value = this.value.toUpperCase();
        });

        // Confirmación Final de Guardado
        $('#actividadesForm').on('submit', function(e) {
            e.preventDefault();

            // Validar que no haya fechas futuras manualmente (doble seguridad)
            let fechaInvalida = false;
            $('.fecha-input').each(function() {
                if ($(this).val() > hoy) fechaInvalida = true;
            });

            if (fechaInvalida) {
                Swal.fire({
                    icon: 'error',
                    title: 'Fecha incorrecta',
                    text: 'No es posible registrar actividades con fecha posterior a hoy.',
                    confirmButtonColor: '#A8D8EA'
                });
                return;
            }
            
            Swal.fire({
                title: '¿Confirmar Registro?',
                text: "Se guardarán las actividades en el historial del paciente.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, guardar todo',
                cancelButtonText: 'Revisar'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Botón Cancelar
        $('#btnCancelar').on('click', function() {
            Swal.fire({
                title: '¿Salir sin guardar?',
                text: "Los cambios realizados se perderán.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, salir',
                confirmButtonColor: '#CAB8FF',
                cancelButtonColor: '#E3E3E3',
            }).then((result) => {
                if (result.isConfirmed) window.location.href = "{{ route('admin.registros.show', $registro) }}";
            });
        });

        // Inicializar UI
        updateUI();
    });
</script>
@stop