@extends('adminlte::page')

@section('title', 'Agregar Diagnóstico')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-stethoscope mr-2"></i>K. DIAGNÓSTICO                                         PRE:PRESUNTIVO DEF: DEFINITIVO
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al registro
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD RESUMEN DEL REGISTRO --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-info-circle mr-2"></i>Información del Registro Activo</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Paciente</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($registro->paciente->primer_nombre) }} {{ strtoupper($registro->paciente->primer_apellido) }}
                    </span>
                </div>
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Tipo de Evaluación</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">
                        {{ $registro->tipo }}
                    </span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Doctor Responsable</small>
                    <span class="text-dark font-weight-bold">DR. {{ strtoupper($registro->doctor->primer_apellido) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 FORMULARIO DINÁMICO --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-notes-medical mr-2"></i>Detalle de Diagnósticos
            </h5>
            <span class="badge badge-info shadow-sm" id="contador-diagnosticos">1 Diagnóstico</span>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.diagnosticos.store', $registro->id) }}" method="POST" id="diagnosticosForm">
                @csrf
                <div id="diagnosticos-wrapper">
                    {{-- ITEM DE DIAGNÓSTICO --}}
                    <div class="diagnostico-item p-3 mb-4 rounded border border-light shadow-sm">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="font-weight-bold text-primary mb-0"># <span class="item-number">1</span></h6>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-diagnostico" style="display:none;">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="small font-weight-bold">CÓDIGO CIE-10</label>
                                    <input type="text" name="cie10[]" class="form-control form-control-pastel text-uppercase" 
                                           placeholder="EJ: J06.9" required>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="small font-weight-bold">TIPO DE DIAGNÓSTICO</label>
                                    <select name="tipo_diagnostico[]" class="form-control form-control-pastel" required>
                                        <option value="presuntivo">PRESUNTIVO</option>
                                        <option value="definitivo">DEFINITIVO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold">DESCRIPCIÓN CLÍNICA</label>
                                    <textarea name="descripcion[]" class="form-control form-control-pastel text-uppercase" 
                                              rows="2" placeholder="DESCRIPCIÓN DETALLADA..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="button" id="agregar-diagnostico" class="btn btn-link text-pastel-blue font-weight-bold">
                        <i class="fas fa-plus-circle mr-1"></i> AGREGAR OTRO DIAGNÓSTICO
                    </button>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2">CANCELAR</button>
                    <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm font-weight-bold">
                        <i class="fas fa-save mr-2"></i>GUARDAR DIAGNÓSTICOS
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
    .text-pastel-purple { color: #9b86d9 !important; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .bg-light-soft { background-color: #f8fafd; }

    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #e9ecef;
        transition: all 0.3s ease;
    }
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
    }
    .btn-pastel-blue { background-color: var(--pastel-blue); color: white; border-radius: 8px; }
    .btn-pastel-blue:hover { background-color: #92cada; color: white; }
    .btn-pastel-gray { background-color: var(--pastel-gray); color: #666; border-radius: 8px; }
    
    .diagnostico-item { background: #ffffff; border-left: 4px solid var(--pastel-purple) !important; }
</style>
@stop



@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        
        // 1. Forzar Mayúsculas en CIE-10 y Descripción
        $(document).on('input', 'input[name="cie10[]"], textarea[name="descripcion[]"]', function() {
            let start = this.selectionStart;
            let end = this.selectionEnd;
            this.value = this.value.toUpperCase();
            this.setSelectionRange(start, end);
        });

        // 2. Función para actualizar la interfaz (Números y Botones)
        function refreshUI() {
            const items = $('.diagnostico-item');
            const total = items.length;
            
            $('#contador-diagnosticos').text(`${total} ${total === 1 ? 'Diagnóstico' : 'Diagnósticos'}`);
            
            items.each(function(index) {
                $(this).find('.item-number').text(index + 1);
                // Solo mostrar botón eliminar si hay más de uno
                if (total > 1) {
                    $(this).find('.remove-diagnostico').fadeIn();
                } else {
                    $(this).find('.remove-diagnostico').hide();
                }
            });
        }

        // 3. Agregar nuevo bloque de diagnóstico
        $('#agregar-diagnostico').click(function() {
            const wrapper = $('#diagnosticos-wrapper');
            const newIndex = $('.diagnostico-item').length + 1;
            
            // Clonamos el primero, limpiamos valores y clases de error
            const clone = $('.diagnostico-item').first().clone();
            clone.find('input, textarea').val('').removeClass('is-invalid');
            clone.find('select').prop('selectedIndex', 0);
            
            clone.hide().appendTo(wrapper).fadeIn(300);
            refreshUI();
        });

        // 4. Eliminar bloque con SweetAlert2
        $(document).on('click', '.remove-diagnostico', function() {
            const item = $(this).closest('.diagnostico-item');
            
            Swal.fire({
                title: '¿Eliminar línea?',
                text: "Se borrará la información de este diagnóstico",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#CAB8FF', // Morado pastel
                cancelButtonColor: '#E3E3E3',  // Gris pastel
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'No, mantener',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    item.fadeOut(300, function() {
                        $(this).remove();
                        refreshUI();
                    });
                }
            });
        });

        // 5. Confirmación de Envío (Guardar)
        $('#diagnosticosForm').on('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: '¿Confirmar registro?',
                html: `Se guardarán <b>${$('.diagnostico-item').length}</b> diagnósticos para el paciente.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA', // Azul pastel
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: '<i class="fas fa-check"></i> Sí, guardar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mostrar carga en el botón
                    const btn = $(this).find('button[type="submit"]');
                    btn.html('<i class="fas fa-spinner fa-spin"></i> Guardando...').prop('disabled', true);
                    this.submit();
                }
            });
        });

        // 6. Botón Cancelar con advertencia si hay datos
        $('#btnCancelar').click(function() {
            const hasData = $('input[name="cie10[]"]').filter(function() { return $(this).val() !== ""; }).length > 0;
            
            if (hasData) {
                Swal.fire({
                    title: '¿Salir sin guardar?',
                    text: "Los cambios realizados se perderán.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#E3E3E3',
                    confirmButtonText: 'Salir',
                    cancelButtonColor: '#A8D8EA',
                    cancelButtonText: 'Seguir editando'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('admin.registros.show', $registro) }}";
                    }
                });
            } else {
                window.location.href = "{{ route('admin.registros.show', $registro) }}";
            }
        });

        // Inicializar interfaz
        refreshUI();
    });
</script>
@stop
