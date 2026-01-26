@extends('adminlte::page')

@section('title', 'Detalle de Diagnóstico')

@section('content_header')
    <h1>Diagnóstico del Registro: {{ $registro->id }}</h1>
@endsection

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-notes-medical"></i> Detalle del Diagnóstico</h5>
        <div>
            <a href="{{ route('admin.diagnosticos.edit', [$registro->id, $diagnostico->id]) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>

            <form action="{{ route('admin.diagnosticos.destroy', [$registro->id, $diagnostico->id]) }}" method="POST" class="d-inline eliminar-diagnostico">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <p><strong>CIE10:</strong> {{ $diagnostico->cie10 }}</p>
        <p><strong>Descripción:</strong> {{ $diagnostico->descripcion }}</p>
        <p><strong>Tipo de Diagnóstico:</strong> {{ ucfirst($diagnostico->tipo_diagnostico) }}</p>
        <p><strong>Fecha de Creación:</strong> {{ $diagnostico->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Última Actualización:</strong> {{ $diagnostico->updated_at->format('d/m/Y H:i') }}</p>
    </div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Confirmación SweetAlert para eliminar
    document.querySelectorAll('.eliminar-diagnostico').forEach(form => {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });
</script>
@endpush