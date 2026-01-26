@extends('adminlte::page')

@section('title', 'Editar Puesto de Trabajo')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-briefcase mr-2"></i>Editar Puesto de Trabajo
    </h1>
    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Registro
    </a>
</div>
@endsection

@section('content')
<div class="container-fluid pb-4">
    <form method="POST" action="{{ route('admin.puestos.update', [$registro, $puesto]) }}" id="puestoForm">
        @csrf
        @method('PUT')

        {{-- CARD: DATOS GENERALES --}}
        <div class="card card-pastel shadow-sm mb-4">
            <div class="card-header bg-pastel-blue">
                <h3 class="card-title font-weight-bold text-white"><i class="fas fa-id-card mr-2"></i>Datos del Puesto</h3>
            </div>
            <div class="card-body bg-light-soft">
                <div class="form-group">
                    <label class="form-label font-weight-bold">Nombre del Puesto <span class="text-danger">*</span></label>
                    <input type="text" name="nombre_puesto" class="form-control form-control-pastel text-uppercase"
                           value="{{ old('nombre_puesto', $puesto->nombre_puesto) }}" required>
                </div>
            </div>
        </div>

        {{-- CARD: ACTIVIDADES --}}
        <div class="card card-pastel shadow-lg">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                    <i class="fas fa-tasks mr-2"></i>Actividades y Factores de Riesgo
                </h5>
                <button type="button" class="btn btn-pastel-green btn-sm" onclick="agregarActividad()">
                    <i class="fas fa-plus mr-1"></i> Agregar Actividad
                </button>
            </div>

            <div class="card-body" id="contenedor-actividades">
                @foreach ($puesto->actividades as $index => $actividad)
                    <div class="card card-outline card-secondary mb-4 actividad shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="font-weight-bold text-secondary"><i class="fas fa-bolt mr-2"></i>Actividad #{{ $index + 1 }}</h6>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarActividad(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>

                            <div class="form-group">
                                <label class="small font-weight-bold">Nombre de la actividad</label>
                                <input type="text" name="actividades[{{ $index }}][nombre]" 
                                       class="form-control form-control-pastel text-uppercase"
                                       value="{{ $actividad->nombre_actividad }}" required>
                            </div>

                            <div class="row">
                                @foreach ($factoresRiesgo as $categoria => $factores)
                                    <div class="col-md-4 mb-3">
                                        <label class="text-capitalize text-info small font-weight-bold">{{ $categoria }}</label>
                                        <div class="factor-container p-2 border rounded bg-white">
                                            @foreach ($factores as $factor)
                                                @php
                                                    $checked = $actividad->factoresRiesgo
                                                        ->where('categoria', $categoria)
                                                        ->where('factor_riesgo', $factor)
                                                        ->count() > 0;
                                                @endphp
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" 
                                                           id="chk_{{ $index }}_{{ $loop->parent->index }}_{{ $loop->index }}"
                                                           name="actividades[{{ $index }}][factores][]"
                                                           value="{{ $categoria }}_{{ $factor }}" {{ $checked ? 'checked' : '' }}>
                                                    <label class="custom-control-label small" for="chk_{{ $index }}_{{ $loop->parent->index }}_{{ $loop->index }}">
                                                        {{ $factor }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- BOTONES DE ACCIÓN --}}
        <div class="text-right mt-4">
            <button type="button" id="btnCancelar" class="btn btn-pastel-gray px-4 mr-2">CANCELAR</button>
            <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                <i class="fas fa-save mr-2"></i>ACTUALIZAR PUESTO
            </button>
        </div>
    </form>
</div>
@endsection

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
    .text-pastel-purple { color: #8e7cc3 !important; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    
    .form-control-pastel {
        border-radius: 8px;
        border: 1.5px solid #eee;
        transition: all 0.3s ease;
    }
    
    .form-control-pastel:focus {
        border-color: var(--pastel-blue);
        box-shadow: 0 0 8px rgba(168, 216, 234, 0.4);
    }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-green { background: var(--pastel-green); border: none; border-radius: 8px; font-weight: bold; color: #444; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    .text-uppercase { text-transform: uppercase; }
    .factor-container { max-height: 150px; overflow-y: auto; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let indexActividad = {{ $puesto->actividades->count() }};

    // 1. Forzar Mayúsculas en inputs y textareas
    $(document).on('input', 'input[type="text"], textarea', function() {
        this.value = this.value.toUpperCase();
    });

    // 2. Función Dinámica para Agregar Actividad
    function agregarActividad() {
        let html = `
        <div class="card card-outline card-secondary mb-4 actividad shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="font-weight-bold text-secondary">Nueva Actividad</h6>
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="eliminarActividad(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="form-group">
                    <label class="small font-weight-bold">Nombre de la actividad</label>
                    <input type="text" name="actividades[${indexActividad}][nombre]" class="form-control form-control-pastel text-uppercase" required>
                </div>
                <div class="row">
                    @foreach ($factoresRiesgo as $categoria => $factores)
                        <div class="col-md-4 mb-3">
                            <label class="text-capitalize text-info small font-weight-bold">{{ $categoria }}</label>
                            <div class="factor-container p-2 border rounded bg-white">
                                @foreach ($factores as $factor)
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" 
                                               id="chk_${indexActividad}_{{ $loop->parent->index }}_{{ $loop->index }}"
                                               name="actividades[${indexActividad}][factores][]" 
                                               value="{{ $categoria }}_{{ $factor }}">
                                        <label class="custom-control-label small" for="chk_${indexActividad}_{{ $loop->parent->index }}_{{ $loop->index }}">
                                            {{ $factor }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>`;
        $('#contenedor-actividades').append(html);
        indexActividad++;
    }

    function eliminarActividad(btn) {
        $(btn).closest('.actividad').fadeOut(300, function() { $(this).remove(); });
    }

    // 3. Confirmación de Guardado
    $('#puestoForm').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Guardar cambios?',
            text: "Se actualizará la información del puesto de trabajo.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#A8D8EA',
            cancelButtonColor: '#E3E3E3',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    // 4. Botón Cancelar
    $('#btnCancelar').on('click', function() {
        Swal.fire({
            title: '¿Salir sin guardar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Salir',
            cancelButtonText: 'Volver',
            confirmButtonColor: '#CAB8FF',
        }).then((result) => {
            if (result.isConfirmed) window.location.href = "{{ route('admin.registros.show', $registro) }}";
        });
    });
</script>
@stop