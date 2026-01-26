@extends('adminlte::page')

@section('title', 'Gestión de Doctores')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-soft-primary"><i class="fas fa-user-md mr-2"></i>Gestión de Doctores</h1>
    <a href="{{ route('admin.doctores.create') }}" class="btn btn-soft-primary shadow-sm">
        <i class="fas fa-plus mr-1"></i> Nuevo Doctor
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    {{-- Estadísticas con Colores Pasteles --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-box bg-pastel-blue shadow-sm card-hover">
                <span class="info-box-icon bg-soft-primary"><i class="fas fa-user-md text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Total Doctores</span>
                    <span class="info-box-number text-dark">{{ $doctores->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-green shadow-sm card-hover">
                <span class="info-box-icon bg-soft-success"><i class="fas fa-check-circle text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Activos</span>
                    <span class="info-box-number text-dark">{{ $doctores->where('activo', true)->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-orange shadow-sm card-hover">
                <span class="info-box-icon bg-soft-warning"><i class="fas fa-pause-circle text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Inactivos</span>
                    <span class="info-box-number text-dark">{{ $doctores->where('activo', false)->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-purple shadow-sm card-hover">
                <span class="info-box-icon bg-soft-info"><i class="fas fa-stethoscope text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Especialidades</span>
                    <span class="info-box-number text-dark">{{ $doctores->pluck('especialidad')->unique()->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Búsqueda y Filtros con Estilo Pastel --}}
    <div class="card shadow-sm border-0 mb-4 bg-pastel-light">
        <div class="card-header bg-pastel-blue border-0">
            <h5 class="card-title mb-0 text-dark">
                <i class="fas fa-search mr-2 text-soft-primary"></i>Búsqueda y Filtros
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="form-label text-muted small">
                            <i class="fas fa-search mr-1"></i>Buscar Doctor
                        </label>
                        <div class="input-group input-group-pastel">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-soft-primary border-0">
                                    <i class="fas fa-search text-white"></i>
                                </span>
                            </div>
                            <input type="text" name="table_search" class="form-control border-0" 
                                   placeholder="Buscar por nombre, especialidad, licencia o email...">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label text-muted small">
                            <i class="fas fa-filter mr-1"></i>Filtrar por Estado
                        </label>
                        <select name="estado_filter" class="form-control border-0">
                            <option value="">Todos los estados</option>
                            <option value="activo">Activos</option>
                            <option value="inactivo">Inactivos</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de Doctores con Colores Suaves --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-pastel-blue text-dark d-flex justify-content-between align-items-center border-0">
            <h5 class="card-title mb-0">
                <i class="fas fa-list mr-2 text-soft-primary"></i>Listado de Doctores
            </h5>
            <span class="badge badge-pastel-light text-dark py-2 px-3">
                <i class="fas fa-user-md mr-1 text-soft-primary"></i> {{ $doctores->count() }} registros
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-pastel-light">
                        <tr>
                            <th class="text-center border-0" style="width: 8%">ID</th>
                            <th class="border-0" style="width: 25%">Información del Doctor</th>
                            <th class="border-0" style="width: 15%">Especialidad</th>
                            <th class="border-0" style="width: 15%">Licencia</th>
                            <th class="border-0" style="width: 17%">Contacto</th>
                            <th class="text-center border-0" style="width: 15%">Estado</th>
                            <th class="text-center border-0" style="width: 15%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($doctores as $doctor)
                        <tr class="{{ $doctor->activo ? '' : 'bg-pastel-light' }} table-row-hover" style="{{ !$doctor->activo ? 'opacity: 0.8;' : '' }}">
                            <td class="text-center">
                                <strong class="text-soft-primary">#{{ $doctor->id }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <i class="fas fa-user-md fa-2x text-soft-primary"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark">Dr. {{ $doctor->nombre_completo }}</strong>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-alt mr-1"></i>
                                            Registrado: {{ $doctor->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-pastel-purple text-dark py-2 px-3">
                                    <i class="fas fa-stethoscope mr-1"></i>
                                    {{ $doctor->especialidad }}
                                </span>
                            </td>
                            <td>
                                <code class="bg-pastel-light p-2 rounded text-dark">{{ $doctor->numero_licencia }}</code>
                            </td>
                            <td>
                                <div>
                                    @if($doctor->telefono)
                                        <div class="mb-1">
                                            <i class="fas fa-phone text-soft-success mr-1"></i>
                                            <small class="text-dark">{{ $doctor->telefono }}</small>
                                        </div>
                                    @endif
                                    @if($doctor->email)
                                        <div>
                                            <i class="fas fa-envelope text-soft-primary mr-1"></i>
                                            <small class="text-dark">{{ $doctor->email }}</small>
                                        </div>
                                    @endif
                                    @if(!$doctor->telefono && !$doctor->email)
                                        <span class="text-muted small">Sin contacto</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="badge {{ $doctor->activo ? 'badge-pastel-green' : 'badge-pastel-red' }} mb-1 py-2 px-3 text-dark">
                                        <i class="fas {{ $doctor->activo ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                        {{ $doctor->activo ? 'ACTIVO' : 'INACTIVO' }}
                                    </span>
                                    <form action="{{ route('admin.doctores.toggleActivo', $doctor) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm {{ $doctor->activo ? 'btn-outline-pastel-orange' : 'btn-outline-pastel-green' }}">
                                            <i class="fas {{ $doctor->activo ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                                            {{ $doctor->activo ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-pastel" role="group">
                                    <a href="{{ route('admin.doctores.show', $doctor) }}" 
                                       class="btn btn-outline-pastel-info btn-sm" 
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.doctores.edit', $doctor) }}" 
                                       class="btn btn-outline-pastel-warning btn-sm" 
                                       title="Editar doctor">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-pastel-danger btn-sm" 
                                            title="Eliminar doctor" 
                                            onclick="confirmDelete({{ $doctor->id }}, 'Dr. {{ $doctor->nombre_completo }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                {{-- Formulario para eliminar --}}
                                <form id="delete-form-{{ $doctor->id }}" 
                                      action="{{ route('admin.doctores.destroy', $doctor) }}" 
                                      method="POST" 
                                      style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 bg-pastel-light">
                                <div class="py-4">
                                    <i class="fas fa-user-md fa-4x text-soft-muted mb-3"></i>
                                    <h4 class="text-muted">No hay doctores registrados</h4>
                                    <p class="text-muted mb-4">Comience agregando el primer doctor al sistema</p>
                                    <a href="{{ route('admin.doctores.create') }}" class="btn btn-soft-primary">
                                        <i class="fas fa-plus mr-1"></i> Crear Primer Doctor
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($doctores->count())
        <div class="card-footer bg-pastel-light border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1 text-soft-info"></i>
                        Mostrando <strong>{{ $doctores->count() }}</strong> doctores registrados
                    </small>
                </div>
                <div>
                    @if(method_exists($doctores, 'links'))
                        {{ $doctores->links() }}
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@stop

@section('css')
<style>
    /* Paleta de Colores Pasteles */
    :root {
        --pastel-blue: #e3f2fd;
        --pastel-green: #e8f5e8;
        --pastel-orange: #fff3e0;
        --pastel-purple: #f3e5f5;
        --pastel-red: #ffebee;
        --pastel-pink: #fce4ec;
        --pastel-light: #fafafa;
        --pastel-muted: #b0bec5;
        --soft-primary: #90caf9;
        --soft-success: #a5d6a7;
        --soft-warning: #ffcc80;
        --soft-info: #80deea;
        --soft-danger: #ef9a9a;
        --soft-muted: #cfd8dc;
    }

    /* Fondo general suave */
    .content-wrapper {
        background-color: #f8f9fa !important;
    }
    
    /* Colores de fondo pastel */
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-green { background-color: var(--pastel-green) !important; }
    .bg-pastel-orange { background-color: var(--pastel-orange) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    .bg-pastel-red { background-color: var(--pastel-red) !important; }
    .bg-pastel-pink { background-color: var(--pastel-pink) !important; }
    .bg-pastel-light { background-color: var(--pastel-light) !important; }

    /* Colores de texto suaves */
    .text-soft-primary { color: var(--soft-primary) !important; }
    .text-soft-success { color: var(--soft-success) !important; }
    .text-soft-warning { color: var(--soft-warning) !important; }
    .text-soft-info { color: var(--soft-info) !important; }
    .text-soft-danger { color: var(--soft-danger) !important; }
    .text-soft-muted { color: var(--soft-muted) !important; }

    /* Background colors suaves */
    .bg-soft-primary { background-color: var(--soft-primary) !important; }
    .bg-soft-success { background-color: var(--soft-success) !important; }
    .bg-soft-warning { background-color: var(--soft-warning) !important; }
    .bg-soft-info { background-color: var(--soft-info) !important; }
    .bg-soft-danger { background-color: var(--soft-danger) !important; }

    /* Botones pastel */
    .btn-soft-primary { 
        background-color: var(--soft-primary) !important; 
        border-color: var(--soft-primary) !important;
        color: white !important;
    }
    
    .btn-soft-primary:hover {
        background-color: #64b5f6 !important;
        border-color: #64b5f6 !important;
    }

    /* Botones outline pastel */
    .btn-outline-pastel-primary {
        border-color: var(--soft-primary) !important;
        color: var(--soft-primary) !important;
        background-color: transparent;
    }
    
    .btn-outline-pastel-success {
        border-color: var(--soft-success) !important;
        color: var(--soft-success) !important;
        background-color: transparent;
    }
    
    .btn-outline-pastel-info {
        border-color: var(--soft-info) !important;
        color: var(--soft-info) !important;
        background-color: transparent;
    }
    
    .btn-outline-pastel-warning {
        border-color: var(--soft-warning) !important;
        color: var(--soft-warning) !important;
        background-color: transparent;
    }
    
    .btn-outline-pastel-danger {
        border-color: var(--soft-danger) !important;
        color: var(--soft-danger) !important;
        background-color: transparent;
    }
    
    .btn-outline-pastel-orange {
        border-color: var(--soft-warning) !important;
        color: var(--soft-warning) !important;
        background-color: transparent;
    }

    /* Badges pastel */
    .badge-pastel-blue { background-color: var(--pastel-blue) !important; color: #1565c0 !important; }
    .badge-pastel-green { background-color: var(--pastel-green) !important; color: #2e7d32 !important; }
    .badge-pastel-orange { background-color: var(--pastel-orange) !important; color: #ef6c00 !important; }
    .badge-pastel-purple { background-color: var(--pastel-purple) !important; color: #7b1fa2 !important; }
    .badge-pastel-red { background-color: var(--pastel-red) !important; color: #c62828 !important; }
    .badge-pastel-pink { background-color: var(--pastel-pink) !important; color: #ad1457 !important; }
    .badge-pastel-light { background-color: var(--pastel-light) !important; color: #546e7a !important; }

    /* Efectos hover suaves */
    .card-hover {
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }
    
    .card-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        border-color: rgba(0,0,0,0.05);
    }

    .table-row-hover:hover {
        background-color: var(--pastel-blue) !important;
    }

    /* Input group pastel */
    .input-group-pastel .input-group-text {
        border-radius: 0.375rem 0 0 0.375rem !important;
    }
    
    .input-group-pastel .form-control {
        border-radius: 0 0.375rem 0.375rem 0 !important;
        background-color: white;
    }

    /* Info boxes mejoradas */
    .info-box {
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.05);
        margin-bottom: 15px;
    }
    
    .info-box-icon {
        border-radius: 12px 0 0 12px;
        background-color: rgba(255,255,255,0.2) !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Botones de acción compactos */
    .btn-group-pastel .btn {
        margin: 0 1px;
        padding: 5px 8px;
        border-radius: 6px;
        border: 1px solid;
        background-color: white;
    }

    /* Mejoras en la tabla */
    .table {
        border-radius: 8px;
        overflow: hidden;
        font-size: 0.9rem;
    }
    
    .table thead th {
        border-bottom: 1px solid #e0e0e0;
        font-weight: 600;
        color: #546e7a;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table td {
        vertical-align: middle;
        padding: 12px 8px;
        border-color: #f0f0f0;
    }

    /* Cards mejoradas */
    .card {
        border-radius: 12px;
        border: none;
    }
    
    .card-header {
        border-radius: 12px 12px 0 0 !important;
        border: none;
        font-weight: 600;
        padding: 15px 20px;
    }
    
    .card-body {
        padding: 20px;
    }

    /* Progress bars para info-box si se agregan después */
    .progress {
        border-radius: 10px;
        background-color: rgba(255,255,255,0.3);
        height: 6px;
    }
    
    .progress-bar {
        border-radius: 10px;
    }

    /* Form controls mejorados */
    .form-control {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
    }
    
    .form-control:focus {
        border-color: var(--soft-primary);
        box-shadow: 0 0 0 0.2rem rgba(144, 202, 249, 0.25);
    }

    /* Paginación suave */
    .pagination .page-link {
        border-color: #e0e0e0;
        color: #546e7a;
        border-radius: 6px;
        margin: 0 2px;
    }
    
    .pagination .page-item.active .page-link {
        background-color: var(--soft-primary);
        border-color: var(--soft-primary);
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(doctorId, doctorName) {
        Swal.fire({
            title: '¿Eliminar Doctor?',
            html: `Esta acción no se puede deshacer<br>
                  <strong>${doctorName}</strong><br>
                  <small class="text-muted">ID: ${doctorId}</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef5350',
            cancelButtonColor: '#90a4ae',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true,
            background: '#fafafa',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        resolve();
                    }, 1000);
                });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + doctorId).submit();
            }
        });
    }

    $(document).ready(function(){
        // Búsqueda en tiempo real
        $('input[name="table_search"]').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Filtro por estado
        $('select[name="estado_filter"]').on('change', function() {
            var estado = $(this).val().toLowerCase();
            
            if (estado === '') {
                $('tbody tr').show();
            } else if (estado === 'activo') {
                $('tbody tr').hide();
                $('tbody tr:has(.badge-pastel-green)').show();
            } else if (estado === 'inactivo') {
                $('tbody tr').hide();
                $('tbody tr:has(.badge-pastel-red)').show();
            }
        });

        // Efecto hover en botones
        $('.btn').hover(
            function() {
                $(this).css('transform', 'translateY(-1px)');
            },
            function() {
                $(this).css('transform', 'translateY(0)');
            }
        );

        // Tooltips
        $('[title]').tooltip();
    });

    // SweetAlert para mensajes de sesión con estilo pastel
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            html: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            position: 'top-end',
            toast: true,
            background: '#e8f5e8',
            iconColor: '#4caf50'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: '{{ session('error') }}',
            timer: 4000,
            showConfirmButton: true,
            background: '#ffebee',
            iconColor: '#f44336'
        });
    @endif
</script>
@stop