@extends('adminlte::page')

@section('title', 'Gestión de Pacientes')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-pastel-purple"><i class="fas fa-user-injured mr-2"></i>Gestión de Pacientes</h1>

</div>
@stop

@section('content')
<div class="container-fluid">
    {{-- Estadísticas con Colores Pasteles --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-box bg-pastel-blue shadow-sm card-hover">
                <span class="info-box-icon bg-soft-primary"><i class="fas fa-user-injured text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Total Pacientes</span>
                    <span class="info-box-number text-dark">{{ $pacientes->total() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-green shadow-sm card-hover">
                <span class="info-box-icon bg-soft-success"><i class="fas fa-check-circle text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Activos</span>
                    <span class="info-box-number text-dark">{{ $pacientes->where('activo', true)->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-orange shadow-sm card-hover">
                <span class="info-box-icon bg-soft-warning"><i class="fas fa-pause-circle text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Inactivos</span>
                    <span class="info-box-number text-dark">{{ $pacientes->where('activo', false)->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-purple shadow-sm card-hover">
                <span class="info-box-icon bg-soft-info"><i class="fas fa-store text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Sucursales</span>
                    <span class="info-box-number text-dark">{{ $pacientes->pluck('sucursal_id')->unique()->count() }}</span>
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
        <div class="card-body bg-light-soft">
            <div class="row align-items-end">
                {{-- BUSCADOR PRINCIPAL --}}
                <div class="col-md-5">
                    <div class="form-group mb-md-0">
                        <label class="form-label text-muted font-weight-bold small ml-1">
                            <i class="fas fa-search mr-1 text-primary"></i> BUSCAR PACIENTE
                        </label>
                        <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white border-0 pl-3">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                            </div>
                            <input type="text" name="table_search" id="table_search" 
                                class="form-control border-0 bg-white" 
                                placeholder="Nombre, cédula o código...">
                        </div>
                    </div>
                </div>

                {{-- FILTRO DE ESTADO --}}
                <div class="col-md-3">
                    <div class="form-group mb-md-0">
                        <label class="form-label text-muted font-weight-bold small ml-1">
                            <i class="fas fa-filter mr-1 text-primary"></i> ESTADO
                        </label>
                        <select name="estado_filter" id="estado_filter" class="form-control border-0 shadow-sm rounded-pill custom-select-pastel">
                            <option value="">Todos los registros</option>
                            <option value="activo">🟢 Activos</option>
                            <option value="inactivo">🔴 Inactivos</option>
                        </select>
                    </div>
                </div>

                {{-- ACCIONES --}}
                <div class="col-md-4">
                    <div class="d-flex justify-content-md-end align-items-center">
                        <button type="button" id="btnLimpiarFiltros" class="btn btn-link text-muted btn-sm mr-3 text-decoration-none">
                            <i class="fas fa-eraser mr-1"></i> Limpiar
                        </button>
                        <a href="{{ route('admin.pacientes.create') }}" class="btn btn-pastel-blue btn-rounded shadow-sm px-4">
                            <i class="fas fa-plus-circle mr-1"></i> Nuevo Paciente
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de Pacientes con Colores Suaves --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-pastel-blue text-dark d-flex justify-content-between align-items-center border-0">
            <h5 class="card-title mb-0">
                <i class="fas fa-list mr-2 text-soft-primary"></i>Listado de Pacientes
            </h5>
            <span class="badge badge-pastel-light text-dark py-2 px-3">
                <i class="fas fa-user-injured mr-1 text-soft-primary"></i> 
                Mostrando {{ $pacientes->count() }} de {{ $pacientes->total() }} pacientes
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-pastel-light">
                        <tr>
                            <th class="text-center border-0" style="width: 8%">ID</th>
                            <th class="border-0" style="width: 25%">Información del Paciente</th>
                            <th class="border-0" style="width: 20%">Sucursal</th>
                            <th class="text-center border-0" style="width: 12%">Estado</th>
                            <th class="text-center border-0" style="width: 20%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pacientes as $paciente)
                        <tr class="{{ $paciente->activo ? '' : 'bg-pastel-light' }} table-row-hover" 
                            data-search="{{ strtolower($paciente->nombre_completo . ' ' . $paciente->cedula_identidad . ' ' . $paciente->codigo_empleado) }}"
                            data-estado="{{ $paciente->activo ? 'activo' : 'inactivo' }}"
                            data-sucursal="{{ $paciente->sucursal_id ?? '' }}"
                            style="{{ !$paciente->activo ? 'opacity: 0.8;' : '' }}">
                            <td class="text-center">
                                <strong class="text-soft-primary">#{{ $paciente->id }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <div class="avatar-paciente">
                                            @if($paciente->sexo == 'F')
                                                <i class="fas fa-female fa-2x text-pastel-pink"></i>
                                            @elseif($paciente->sexo == 'M')
                                                <i class="fas fa-male fa-2x text-pastel-blue"></i>
                                            @else
                                                <i class="fas fa-user fa-2x text-soft-primary"></i>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <strong class="d-block text-dark">{{ $paciente->nombre_completo }}</strong>
                                        <div class="text-muted small">
                                            <i class="fas fa-user-tag mr-1"></i>
                                            Código: {{ $paciente->codigo_empleado ?? 'Sin código' }}
                                            @if($paciente->fecha_nacimiento)
                                                <br><i class="fas fa-birthday-cake mr-1"></i>
                                                {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años
                                            @endif
                                            @if($paciente->grupo_sanguineo)
                                                <br><i class="fas fa-tint mr-1"></i>
                                                {{ $paciente->grupo_sanguineo }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($paciente->sucursal)
                                        <i class="fas fa-store text-soft-warning mr-2"></i>
                                        <div>
                                            <strong class="text-dark">{{ $paciente->sucursal->nombre }}</strong>
                                            @if($paciente->sucursal->codigo)
                                                <br><small class="text-muted">
                                                    <i class="fas fa-hashtag mr-1"></i>
                                                    {{ $paciente->sucursal->codigo }}
                                                </small>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-center w-100">
                                            <span class="text-muted">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Sin sucursal
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="badge {{ $paciente->activo ? 'badge-pastel-green' : 'badge-pastel-red' }} mb-1 py-2 px-3 text-dark">
                                        <i class="fas {{ $paciente->activo ? 'fa-check-circle' : 'fa-times-circle' }} mr-1"></i>
                                        {{ $paciente->activo ? 'ACTIVO' : 'INACTIVO' }}
                                    </span>
                                    <form action="{{ route('admin.pacientes.toggleActivo', $paciente) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn btn-sm {{ $paciente->activo ? 'btn-outline-pastel-orange' : 'btn-outline-pastel-green' }} toggle-estado"
                                                data-paciente-id="{{ $paciente->id }}"
                                                data-paciente-nombre="{{ $paciente->nombre_completo }}"
                                                data-activo="{{ $paciente->activo }}">
                                            <i class="fas {{ $paciente->activo ? 'fa-toggle-on' : 'fa-toggle-off' }} mr-1"></i>
                                            {{ $paciente->activo ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                            <td class="text-center">
                                
        
                                    <a href="{{ route('admin.certificados.byPaciente', $paciente) }}" class="btn btn-white border-pastel shadow-xs" title="Certificados">
                                        <i class="fas fa-file-medical text-success"></i>
                                    </a>
                                    <a href="{{  route('admin.inmunizaciones.byPaciente', $paciente) }}" class="btn btn-white border-pastel shadow-xs" title="Inmunizaciones">
                                        <i class="fas fa-syringe text-red"></i>
                                    </a>
                                    <a href="{{ route('admin.notas.byPaciente', $paciente) }}" class="btn btn-white border-pastel shadow-xs" title="Notas">
                                        <i class="fas fa-pen-fancy text-warning"></i>
                                    </a>
                                    <a href="{{ route('admin.pacientes.vistaIndividual', $paciente) }}" class="btn btn-white border-pastel shadow-xs" title="Registros">
                                        <i class="fas fa-folder-open text-info"></i>
                                    </a>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-pastel" role="group">
                                    <a href="{{ route('admin.pacientes.show', $paciente) }}" 
                                       class="btn btn-outline-pastel-info btn-sm" 
                                       title="Ver detalles del paciente">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.pacientes.edit', $paciente) }}" 
                                       class="btn btn-outline-pastel-warning btn-sm" 
                                       title="Editar paciente">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                </div>
                                
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 bg-pastel-light">
                                <div class="py-4">
                                    <i class="fas fa-user-injured fa-4x text-soft-muted mb-3"></i>
                                    <h4 class="text-muted">No hay pacientes registrados</h4>
                                    <p class="text-muted mb-4">Comience agregando el primer paciente al sistema</p>
                                    <a href="{{ route('admin.pacientes.create') }}" class="btn btn-pastel-blue">
                                        <i class="fas fa-user-plus mr-1"></i> Crear Primer Paciente
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($pacientes->count())
        <div class="card-footer bg-pastel-light border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted">
                        <i class="fas fa-info-circle mr-1 text-soft-info"></i>
                        Mostrando <strong>{{ $pacientes->count() }}</strong> de <strong>{{ $pacientes->total() }}</strong> pacientes
                    </small>
                </div>
                <div>
                    @if(method_exists($pacientes, 'links'))
                        {{ $pacientes->links() }}
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
    .btn-pastel-blue { 
        background-color: var(--soft-primary) !important; 
        border-color: var(--soft-primary) !important;
        color: white !important;
    }
    
    .btn-pastel-blue:hover {
        background-color: #64b5f6 !important;
        border-color: #64b5f6 !important;
        color: white !important;
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
        background-color: var(--soft-primary);
        border: none;
        color: white;
    }
    
    .input-group-pastel .form-control {
        border-radius: 0 0.375rem 0.375rem 0 !important;
        background-color: white;
        border: 1px solid #e0e0e0;
        border-left: none;
    }

    .input-group-pastel .form-control:focus {
        border-color: var(--soft-primary);
        box-shadow: 0 0 0 0.2rem rgba(144, 202, 249, 0.25);
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
        transition: all 0.3s ease;
    }

    .btn-group-pastel .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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

    /* Avatar para pacientes */
    .avatar-paciente {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: var(--pastel-light);
        display: flex;
        align-items: center;
        justify-content: center;
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
    function confirmDelete(pacienteId, pacienteNombre, pacienteCedula) {
        Swal.fire({
            title: '¿Eliminar Paciente?',
            html: `Esta acción no se puede deshacer<br>
                  <strong>${pacienteNombre}</strong><br>
                  <small class="text-muted">Cédula: ${pacienteCedula} | ID: ${pacienteId}</small>`,
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
                document.getElementById('delete-form-' + pacienteId).submit();
            }
        });
    }

    $(document).ready(function(){
        // Búsqueda en tiempo real
        $('#table_search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).data('search').indexOf(value) > -1)
            });
            
            actualizarContador();
        });

        // Filtro por estado
        $('#estado_filter').on('change', function() {
            aplicarFiltros();
        });

        // Filtro por sucursal
        $('#sucursal_filter').on('change', function() {
            aplicarFiltros();
        });

        // Limpiar filtros
        $('#btnLimpiarFiltros').click(function() {
            $('#table_search').val('');
            $('#estado_filter').val('');
            $('#sucursal_filter').val('');
            aplicarFiltros();
        });

        // Función para aplicar todos los filtros
        function aplicarFiltros() {
            var estado = $('#estado_filter').val();
            var sucursal = $('#sucursal_filter').val();
            var search = $('#table_search').val().toLowerCase();
            
            $('tbody tr').each(function() {
                var show = true;
                var rowSearch = $(this).data('search');
                
                // Aplicar búsqueda
                if (search && rowSearch.indexOf(search) === -1) {
                    show = false;
                }
                
                // Aplicar filtro de estado
                if (estado && $(this).data('estado') !== estado) {
                    show = false;
                }
                
                // Aplicar filtro de sucursal
                if (sucursal && $(this).data('sucursal') != sucursal) {
                    show = false;
                }
                
                $(this).toggle(show);
            });
            
            actualizarContador();
        }

        // Actualizar contador de resultados
        function actualizarContador() {
            var visible = $('tbody tr:visible').length;
            var total = $('tbody tr').length;
            var contador = $('.badge-pastel-light');
            
            if (contador.length) {
                contador.html(`<i class="fas fa-user-injured mr-1 text-soft-primary"></i> Mostrando ${visible} de ${total} pacientes`);
            }
        }

        // Confirmación para cambiar estado
        $('.toggle-estado').on('click', function(e) {
            e.preventDefault();
            const pacienteId = $(this).data('paciente-id');
            const pacienteNombre = $(this).data('paciente-nombre');
            const esActivo = $(this).data('activo');
            const nuevoEstado = esActivo ? 'inactivo' : 'activo';
            const form = $(this).closest('form');
            
            Swal.fire({
                title: `¿Cambiar estado del paciente?`,
                html: `El paciente <strong>${pacienteNombre}</strong> será ${esActivo ? 'desactivado' : 'activado'}<br>
                      <small class="text-muted">Esta acción cambiará su estado a ${nuevoEstado}</small>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: esActivo ? '#ff9800' : '#4caf50',
                cancelButtonColor: '#9e9e9e',
                confirmButtonText: esActivo ? 'Sí, desactivar' : 'Sí, activar',
                cancelButtonText: 'Cancelar',
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
                    // Deshabilitar botón y mostrar loader
                    $(this).html('<i class="fas fa-spinner fa-spin mr-1"></i> Procesando...').prop('disabled', true);
                    form.submit();
                }
            });
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

        // Inicializar contador
        actualizarContador();
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