@extends('adminlte::page')

@section('title', 'Detalles de Empresa')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="text-primary"><i class="fas fa-building"></i> Detalles de Empresa</h1>
        <div>
            <a href="{{ route('admin.empresas.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Listado
            </a>
            <a href="{{ route('admin.empresas.edit', $empresa) }}" class="btn btn-warning" style="background-color: #52B1CB; border-color: #52B1CB;">
                <i class="fas fa-edit"></i> Editar
            </a>
            <button class="btn btn-danger" onclick="confirmDelete({{ $empresa->id }})">
                <i class="fas fa-trash"></i> Eliminar
            </button>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-sm border-0">
            <div class="card-header" style="background-color: #52B1CB; color: #fff;">
                <h3 class="card-title"><i class="fas fa-info-circle"></i> Información General</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong><i class="fas fa-building"></i> Nombre:</strong>
                    <p>{{ $empresa->nombre }}</p>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-id-card"></i> RUC:</strong>
                    <p>{{ $empresa->ruc }}</p>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-briefcase"></i> Actividad Económica:</strong>
                    <p>{{ $empresa->actividad_economica }}</p>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-code"></i> Código CIIU:</strong>
                    <p>{{ $empresa->ciiu ?? '-' }}</p>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-map-marker-alt"></i> Dirección:</strong>
                    <p>{{ $empresa->direccion }}</p>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-user-tie"></i> Representante Legal:</strong>
                    <p>{{ $empresa->representante_legal }}</p>
                </div>

                <div class="mb-3">
                    <strong><i class="fas fa-toggle-on"></i> Estado:</strong>
                    <span class="badge badge-{{ $empresa->activo ? 'success' : 'danger' }}">
                        {{ $empresa->activo ? 'Activa' : 'Inactiva' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Formulario oculto para eliminar -->
<form id="delete-form-{{ $empresa->id }}" action="{{ route('admin.empresas.destroy', $empresa) }}" method="POST" style="display:none;">
    @csrf
    @method('DELETE')
</form>
@stop

@section('css')
    <style>
        .card-header { font-weight: bold; }
        p { margin-bottom: 0.5rem; }
    </style>
@stop

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(empresaId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + empresaId).submit();
                }
            });
        }

        @if(session('success'))
            Swal.fire({ icon: 'success', title: '¡Éxito!', text: '{{ session('success') }}', timer: 2000, showConfirmButton: false });
        @endif

        @if(session('error'))
            Swal.fire({ icon: 'error', title: '¡Error!', text: '{{ session('error') }}', timer: 2500, showConfirmButton: true });
        @endif
    </script>
@stop