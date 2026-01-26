@extends('adminlte::page')

@section('title', 'Nueva Sucursal')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-pastel-purple"><i class="fas fa-plus-circle mr-2"></i>Nueva Sucursal</h1>
    <a href="{{ route('admin.sucursales.index') }}" class="btn btn-outline-pastel-primary shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver al listado
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- El ID 'formSucursal' es clave para el control con JS --}}
            <form action="{{ route('admin.sucursales.store') }}" method="POST" id="formSucursal">
                @csrf

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-pastel-blue border-0">
                        <h5 class="card-title mb-0 text-dark">
                            <i class="fas fa-edit mr-2 text-soft-primary"></i>Información General
                        </h5>
                    </div>
                    
                    <div class="card-body bg-pastel-light">
                        <div class="row">
                            {{-- Nombre --}}
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="text-muted small">Nombre de la Sucursal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-store text-soft-primary"></i></span>
                                        </div>
                                        <input type="text" name="nombre" class="form-control border-left-0" 
                                               placeholder="Ej: Sucursal Central" value="{{ old('nombre') }}" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Código --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-muted small">Código Único</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-hashtag text-soft-primary"></i></span>
                                        </div>
                                        <input type="text" name="codigo" class="form-control border-left-0" 
                                               placeholder="SUC-001" value="{{ old('codigo') }}" required>
                                    </div>
                                </div>
                            </div>

                            {{-- Dirección --}}
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="text-muted small">Dirección Física</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-map-marker-alt text-soft-primary"></i></span>
                                        </div>
                                        <input type="text" name="direccion" class="form-control border-left-0" 
                                               placeholder="Calle, Número, Ciudad..." value="{{ old('direccion') }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Teléfono --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="text-muted small">Teléfono de Contacto</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-white border-right-0"><i class="fas fa-phone text-soft-primary"></i></span>
                                        </div>
                                        <input type="text" name="telefono" class="form-control border-left-0" 
                                               placeholder="+54 11 ..." value="{{ old('telefono') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-white border-0 text-right">
                        <a href="{{ route('admin.sucursales.index') }}" class="btn btn-light mr-2 btn-cancelar">
                            Cancelar
                        </a>
                        {{-- Botón tipo button para disparar SWAL --}}
                        <button type="button" id="btnGuardar" class="btn btn-pastel-blue shadow-sm px-4">
                            <i class="fas fa-save mr-1"></i> Guardar Sucursal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    :root {
        --pastel-blue: #e3f2fd;
        --pastel-purple: #f3e5f5;
        --pastel-light: #fafafa;
        --soft-primary: #90caf9;
    }

    .content-wrapper { background-color: #f8f9fa !important; }
    .text-pastel-purple { color: #7b1fa2 !important; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-light { background-color: var(--pastel-light) !important; }
    .text-soft-primary { color: var(--soft-primary) !important; }

    .btn-pastel-blue { 
        background-color: var(--soft-primary) !important; 
        color: white !important;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-pastel-blue:hover { background-color: #64b5f6 !important; transform: translateY(-1px); }

    .btn-outline-pastel-primary {
        border-color: var(--soft-primary) !important;
        color: var(--soft-primary) !important;
        background: white;
    }

    .card { border-radius: 12px; }
    .form-control { border-radius: 8px; border: 1px solid #e0e0e0; }
    .form-control:focus {
        border-color: var(--soft-primary);
        box-shadow: 0 0 0 0.2rem rgba(144, 202, 249, 0.25);
    }
    .input-group-text {
        border-radius: 8px 0 0 8px !important;
        background-color: #fdfdfd;
        border: 1px solid #e0e0e0;
    }
    .form-control.border-left-0 { border-radius: 0 8px 8px 0 !important; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        const form = $('#formSucursal');
        const btnGuardar = $('#btnGuardar');

        // 1. Confirmación de Guardado
        btnGuardar.on('click', function() {
            // Validar HTML5 nativo antes de abrir SWAL
            if (form[0].checkValidity()) {
                Swal.fire({
                    title: '¿Registrar sucursal?',
                    text: "Se creará una nueva sucursal en el sistema.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#90caf9',
                    cancelButtonColor: '#cfd8dc',
                    confirmButtonText: 'Sí, guardar',
                    cancelButtonText: 'Revisar',
                    background: '#fafafa',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar loader
                        Swal.fire({
                            title: 'Procesando...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });
                        form.submit();
                    }
                });
            } else {
                form[0].reportValidity();
            }
        });

        // 2. Confirmación al Cancelar (si hay datos escritos)
        $('.btn-cancelar').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            let hasData = false;
            
            form.find('input[type="text"]').each(function() {
                if ($(this).val() !== "") hasData = true;
            });

            if (hasData) {
                Swal.fire({
                    title: '¿Abandonar formulario?',
                    text: "Tienes cambios sin guardar que se perderán.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef9a9a',
                    confirmButtonText: 'Sí, salir',
                    cancelButtonText: 'Continuar aquí'
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = url;
                });
            } else {
                window.location.href = url;
            }
        });

        // 3. Manejo de errores desde Laravel (Validation Errors)
        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Error de validación',
                html: `<ul style="text-align: left;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                       </ul>`,
                confirmButtonColor: '#90caf9',
                background: '#ffebee'
            });
        @endif
    });
</script>
@stop