@extends('adminlte::page')

@section('title', 'Gestión de Registros')

@section('content_header')

@stop

@section('content')
<div class="container-fluid">
    {{-- Estadísticas con Colores Pasteles --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-box bg-pastel-blue shadow-sm card-hover">
                <span class="info-box-icon bg-soft-primary"><i class="fas fa-folder-open text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Total Registros</span>
                    <span class="info-box-number text-dark">{{ $registros->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-orange shadow-sm card-hover">
                <span class="info-box-icon bg-soft-warning"><i class="fas fa-star text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Atención Prioritaria</span>
                    <span class="info-box-number text-dark">{{ $registros->whereNotNull('atencion_prioritaria')->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-green shadow-sm card-hover">
                <span class="info-box-icon bg-soft-success"><i class="fas fa-user-injured text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Pacientes Únicos</span>
                    <span class="info-box-number text-dark">{{ $registros->pluck('paciente_id')->unique()->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-purple shadow-sm card-hover">
                <span class="info-box-icon bg-soft-info"><i class="fas fa-calendar-day text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Hoy</span>
                    <span class="info-box-number text-dark">{{ $registros->where('created_at', '>=', today())->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Búsqueda y Filtros --}}
    <div class="card shadow-sm border-0 mb-4 bg-pastel-light">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group mb-0">
                        <label class="form-label text-muted small">
                            <i class="fas fa-search mr-1"></i>Filtrar Registros
                        </label>
                        <div class="input-group input-group-pastel">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-soft-primary border-0">
                                    <i class="fas fa-search text-white"></i>
                                </span>
                            </div>
                            <input type="text" name="table_search" class="form-control border-0" 
                                   placeholder="Buscar por paciente, doctor, empresa o tipo de atención...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de Registros --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-pastel-blue text-dark d-flex justify-content-between align-items-center border-0">
            <h5 class="card-title mb-0">
                <i class="fas fa-list mr-2 text-soft-primary"></i>Listado de Atenciones
            </h5>
            <span class="badge badge-pastel-light text-dark py-2 px-3">
                {{ $registros->count() }} registros encontrados
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-pastel-light">
                        <tr>
                            <th class="text-center border-0">ID</th>
                            <th class="border-0">Paciente / Empresa</th>
                            <th class="border-0">Doctor Asignado</th>
                            <th class="border-0">Tipo / Prioridad</th>
                            <th class="border-0">Fecha</th>
                            <th class="text-center border-0">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registros as $registro)
                        <tr class="table-row-hover">
                            <td class="text-center align-middle">
                                <strong class="text-soft-primary">#{{ $registro->id }}</strong>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-user-circle fa-2x text-soft-muted mr-3"></i>
                                    <div>
                                        <strong class="text-dark">{{ $registro->paciente->primer_nombre }} {{ $registro->paciente->primer_apellido }}</strong>
                                        <br><small class="text-muted"><i class="fas fa-building mr-1"></i>{{ $registro->empresa->nombre }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <span class="text-dark"><i class="fas fa-user-md mr-1 text-soft-info"></i> {{ $registro->doctor->nombre_completo }}</span>
                            </td>
                            <td class="align-middle">
                                <span class="badge badge-pastel-purple text-dark py-2 px-2">
                                    {{ ucfirst($registro->tipo) }}
                                </span>
                                @if($registro->atencion_prioritaria)
                                    <br><small class="text-soft-danger font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>{{ $registro->atencion_prioritaria }}</small>
                                @endif
                            </td>
                            <td class="align-middle">
                                @php
                                    $fecha = $registro->fecha_ingreso ?? $registro->fecha_periodica ?? $registro->fecha_reintegro ?? $registro->fecha_retiro ?? $registro->created_at;
                                @endphp
                                <div class="text-muted small">
                                    <i class="fas fa-calendar-alt mr-1"></i> {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="btn-group btn-group-pastel" role="group">
                                    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-outline-pastel-info btn-sm" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.registros.edit', $registro) }}" class="btn btn-outline-pastel-warning btn-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-pastel-danger btn-sm" title="Eliminar" onclick="confirmDelete({{ $registro->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="delete-form-{{ $registro->id }}" action="{{ route('admin.registros.destroy', $registro) }}" method="POST" style="display:none;">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 bg-pastel-light">
                                <i class="fas fa-clipboard-list fa-3x text-soft-muted mb-3"></i>
                                <h4 class="text-muted">No hay registros disponibles</h4>
                                <a href="{{ route('admin.registros.create') }}" class="btn btn-soft-primary mt-2">Crear Registro</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    /* Inyectamos las mismas variables y estilos pastel del diseño de Empresas */
    :root {
        --pastel-blue: #e3f2fd; --pastel-green: #e8f5e8; --pastel-orange: #fff3e0;
        --pastel-purple: #f3e5f5; --pastel-red: #ffebee; --pastel-light: #fafafa;
        --soft-primary: #90caf9; --soft-success: #a5d6a7; --soft-warning: #ffcc80;
        --soft-info: #80deea; --soft-danger: #ef9a9a; --soft-muted: #cfd8dc;
    }

    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-green { background-color: var(--pastel-green) !important; }
    .bg-pastel-orange { background-color: var(--pastel-orange) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    .bg-pastel-light { background-color: var(--pastel-light) !important; }
    .text-soft-primary { color: var(--soft-primary) !important; }
    .text-soft-danger { color: #e57373 !important; }
    .bg-soft-primary { background-color: var(--soft-primary) !important; }
    .bg-soft-success { background-color: var(--soft-success) !important; }
    .bg-soft-warning { background-color: var(--soft-warning) !important; }
    .bg-soft-info { background-color: var(--soft-info) !important; }
    
    .btn-soft-primary { background-color: var(--soft-primary) !important; color: white !important; border: none; }
    .btn-soft-primary:hover { background-color: #64b5f6 !important; transform: translateY(-1px); }

    .btn-outline-pastel-info { border-color: var(--soft-info) !important; color: var(--soft-info) !important; }
    .btn-outline-pastel-warning { border-color: var(--soft-warning) !important; color: var(--soft-warning) !important; }
    .btn-outline-pastel-danger { border-color: var(--soft-danger) !important; color: var(--soft-danger) !important; }

    .badge-pastel-purple { background-color: var(--pastel-purple) !important; color: #7b1fa2 !important; }
    .badge-pastel-light { background-color: #f1f1f1 !important; }

    .card-hover { transition: all 0.3s ease; }
    .card-hover:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.08) !important; }
    .table-row-hover:hover { background-color: var(--pastel-blue) !important; }
    
    .info-box { border-radius: 12px; min-height: 80px; }
    .info-box-icon { border-radius: 12px 0 0 12px; font-size: 1.5rem; }
    .input-group-pastel .form-control { border-radius: 0 8px 8px 0 !important; }
    .input-group-pastel .input-group-text { border-radius: 8px 0 0 8px !important; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: '¿Eliminar Registro?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef9a9a',
            cancelButtonColor: '#cfd8dc',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            background: '#fafafa'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    $(document).ready(function(){
        $('input[name="table_search"]').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    @if(session('success'))
        Swal.fire({
            icon: 'success', title: '¡Éxito!', text: '{{ session('success') }}',
            timer: 2500, showConfirmButton: false, toast: true, position: 'top-end'
        });
    @endif
</script>
@stop