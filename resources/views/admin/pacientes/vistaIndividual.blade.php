@extends('adminlte::page')

@section('title', 'Registros de Paciente')

@section('content_header')
<div class="row">
    {{-- Card del Paciente - Mejorada --}}
    <div class="col-md-12">
        <div class="card card-pastel-success shadow-soft">
            <div class="card-header bg-gradient-pastel-green d-flex align-items-center">
                <div class="header-icon bg-pastel-green">
                    <i class="fas fa-user-injured text-white"></i>
                </div>
                <div class="header-content ml-3">
                    <h6 class="card-title mb-0 text-white font-weight-bold">
                        Datos del Paciente
                    </h6>
                    <br>
                    <small class="text-white opacity-75">Información personal y médica</small>
                </div>
               
            </div>
            
            <div class="card-body">
                <div class="row">
                    @php
                        $infoPaciente = [
                            [
                                'icon' => 'id-badge',
                                'label' => 'PRIMER APELLIDO', 
                                'value' => $paciente->primer_apellido,
                                'color' => 'pastel-blue',
                                'gradient' => 'bg-gradient-pastel-blue'
                            ],
                            [
                                'icon' => 'id-badge',
                                'label' => 'SEGUNDO APELLIDO', 
                                'value' => $paciente->segundo_apellido ?? '-',
                                'color' => 'pastel-blue',
                                'gradient' => 'bg-gradient-pastel-blue'
                            ],
                            [
                                'icon' => 'user',
                                'label' => 'PRIMER NOMBRE', 
                                'value' => $paciente->primer_nombre,
                                'color' => 'pastel-purple',
                                'gradient' => 'bg-gradient-pastel-purple'
                            ],
                            [
                                'icon' => 'user',
                                'label' => 'SEGUNDO NOMBRE', 
                                'value' => $paciente->segundo_nombre ?? '-',
                                'color' => 'pastel-purple',
                                'gradient' => 'bg-gradient-pastel-purple'
                            ],
                            [
                                'icon' => 'id-card',
                                'label' => 'CÉDULA', 
                                'value' => $paciente->cedula_identidad,
                                'color' => 'pastel-blue',
                                'gradient' => 'bg-gradient-pastel-blue'
                            ],
                            [
                                'icon' => 'id-badge',
                                'label' => 'CÓDIGO EMPLEADO', 
                                'value' => $paciente->codigo_empleado,
                                'color' => 'pastel-orange',
                                'gradient' => 'bg-gradient-pastel-orange'
                            ],
                            [
                                'icon' => 'id-badge',
                                'label' => 'SUCURSAL', 
                                'value' => $paciente->Sucursal ?? '-',
                                'color' => 'pastel-green',
                                'gradient' => 'bg-gradient-pastel-green'
                            ],
                            [
                                'icon' => 'check-circle',
                                'label' => 'ESTADO', 
                                'value' => $paciente->activo ? 'Activo' : 'Inactivo',
                                'color' => $paciente->activo ? 'pastel-green' : 'pastel-red',
                                'gradient' => $paciente->activo ? 'bg-gradient-pastel-green' : 'bg-gradient-pastel-red'
                            ],
                        ];
                    @endphp

                    @foreach($infoPaciente as $item)
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="info-card {{ $item['gradient'] }} text-white rounded-lg p-3 h-100 d-flex flex-column justify-content-center">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="info-icon mr-2">
                                        <i class="fas fa-{{ $item['icon'] }} fa-lg"></i>
                                    </div>
                                    <small class="opacity-90">{{ $item['label'] }}</small>
                                </div>
                                <strong class="text-white">{{ $item['value'] }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')
{{-- Barra de Herramientas - Mejorada --}}
<div class="toolbar-pastel mb-4">
    <div class="row">
        <div class="col-md-8">
            <div class="search-card bg-white rounded-lg shadow-soft p-3">
                <div class="form-group mb-0">
                    <label class="form-label text-dark font-weight-bold mb-2">
                        <i class="fas fa-search text-pastel-blue mr-1"></i>Buscar Registros
                    </label>
                    <div class="input-group input-group-pastel">
                        <input type="text" name="table_search" class="form-control form-control-pastel" 
                               placeholder="Buscar por doctor, empresa, tipo de registro...">
                        <div class="input-group-append">
                            <button class="btn btn-pastel-primary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="stats-card bg-white rounded-lg shadow-soft p-3 h-100">
                <div class="d-flex justify-content-between align-items-center h-100">
                    <div class="stats-info">
                        <div class="stats-number text-dark font-weight-bold h4 mb-0">
                            {{ $registros->total() }}
                        </div>
                        <small class="text-muted">Registros Totales</small>
                    </div>
                    <div class="stats-info">
                         <div class="stats-icon">
                         <a href="{{ route('admin.registros.createFromPaciente', $paciente) }}"> 
                            <i class="fas fa-file-medical fa-2x text-pastel-blue"></i>
                        </a>
                        
                    </div>
                     <small class="text-muted">Nuevo Registro</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tabla de Registros - Mejorada --}}
<div class="card shadow-soft border-0">
    <div class="card-header bg-gradient-pastel-blue d-flex justify-content-between align-items-center py-3">
        <div class="d-flex align-items-center">
            <div class="header-icon-sm bg-pastel-blue mr-3">
                <i class="fas fa-list-alt text-white"></i>
            </div>
            <div>
                <h5 class="card-title mb-0 text-white">Registros Médicos</h5> <br>
                <small class="text-white opacity-75">Historial completo del paciente</small>
            </div>
        </div>
        
    </div>
    
    <div class="card-body p-0">
        @if($registros->count() > 0)
        <div class="table-responsive">
            <table class="table table-pastel mb-0">
                <thead class="bg-pastel-light">
                    <tr>
                        <th class="border-0 py-3" style="width: 22%">
                            <span class="text-dark font-weight-bold">Médico</span>
                        </th>
                        <th class="border-0 py-3" style="width: 20%">
                            <span class="text-dark font-weight-bold">Empresa</span>
                        </th>
                        <th class="border-0 py-3 text-center" style="width: 15%">
                            <span class="text-dark font-weight-bold">Tipo</span>
                        </th>
                        <th class="border-0 py-3 text-center" style="width: 15%">
                            <span class="text-dark font-weight-bold">Prioridad</span>
                        </th>
                        <th class="border-0 py-3 text-center" style="width: 15%">
                            <span class="text-dark font-weight-bold">Fecha</span>
                        </th>
                        <th class="border-0 py-3 text-center" style="width: 15%">
                            <span class="text-dark font-weight-bold">Acciones</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registros as $registro)
                    <tr class="table-row-pastel">
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-pastel-blue rounded-circle mr-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user-md text-white fa-sm"></i>
                                </div>
                                <div>
                                    <div class="text-dark font-weight-bold">{{ $registro->doctor->nombre_completo }}</div>
                                    <small class="text-muted">{{ $registro->doctor->especialidad }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-pastel-light rounded-circle mr-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-building text-muted fa-sm"></i>
                                </div>
                                <div>
                                    <div class="text-dark font-weight-bold">{{ $registro->empresa->nombre }}</div>
                                    <small class="text-muted">{{ $registro->empresa->sector ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            @php
                                $tipoConfig = [
                                    'ingreso' => ['color' => 'pastel-blue', 'icon' => 'fa-sign-in-alt', 'label' => 'Ingreso'],
                                    'periodica' => ['color' => 'pastel-green', 'icon' => 'fa-calendar-check', 'label' => 'Periódica'],
                                    'retiro' => ['color' => 'pastel-orange', 'icon' => 'fa-sign-out-alt', 'label' => 'Retiro'],
                                    'reintegro' => ['color' => 'pastel-purple', 'icon' => 'fa-undo', 'label' => 'Reintegro']
                                ];
                                $config = $tipoConfig[$registro->tipo] ?? ['color' => 'pastel-secondary', 'icon' => 'fa-file', 'label' => $registro->tipo];
                            @endphp
                            <span class="badge badge-{{ $config['color'] }} text-dark px-3 py-2">
                                <i class="fas {{ $config['icon'] }} mr-1"></i>
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            @if($registro->atencion_prioritaria)
                                <span class="badge badge-pastel-red text-dark px-3 py-2">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>Prioritaria
                                </span>
                            @else
                                <span class="badge badge-pastel-light text-muted px-3 py-2">
                                    <i class="fas fa-check-circle mr-1"></i>Normal
                                </span>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @php
                                $fecha = null;
                                $icono = 'fa-calendar';
                                if($registro->tipo === 'ingreso' && $registro->fecha_ingreso) {
                                    $fecha = $registro->fecha_ingreso->format('d/m/Y');
                                    $icono = 'fa-sign-in-alt';
                                } elseif($registro->tipo === 'periodica' && $registro->fecha_periodica) {
                                    $fecha = $registro->fecha_periodica->format('d/m/Y');
                                    $icono = 'fa-calendar-check';
                                } elseif($registro->tipo === 'retiro' && $registro->fecha_retiro) {
                                    $fecha = $registro->fecha_retiro->format('d/m/Y');
                                    $icono = 'fa-sign-out-alt';
                                } elseif($registro->tipo === 'reintegro' && $registro->fecha_reintegro) {
                                    $fecha = $registro->fecha_reintegro->format('d/m/Y');
                                    $icono = 'fa-undo';
                                }
                            @endphp
                            <div class="fecha-registro d-flex align-items-center justify-content-center">
                                <i class="fas {{ $icono }} text-pastel-blue mr-2"></i>
                                <span class="text-dark font-weight-bold">{{ $fecha ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <div class="btn-group-vertical btn-group-sm" role="group">
                                <a href="{{ route('admin.registros.show', $registro) }}" 
                                   class="btn btn-pastel-info mb-1" 
                                   title="Ver Detalles">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.registros.edit', $registro) }}" 
                                       class="btn btn-pastel-warning" 
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.registros.pdf', $registro->id) }}" 
                                       class="btn btn-pastel-danger" 
                                       target="_blank"
                                       title="PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-pastel-red" 
                                            title="Eliminar" 
                                            onclick="confirmDelete({{ $registro->id }}, '{{ $registro->tipo }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <form id="delete-form-{{ $registro->id }}" 
                                  action="{{ route('admin.registros.destroy', $registro) }}" 
                                  method="POST" 
                                  style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state text-center py-5">
            <div class="empty-state-icon mb-3">
                <i class="fas fa-clipboard-list fa-4x text-pastel-muted"></i>
            </div>
            <h4 class="text-muted mb-3">No hay registros médicos</h4>
            <p class="text-muted mb-4">Este paciente no tiene registros médicos aún</p>
            <a href="{{ route('admin.registros.createFromPaciente', $paciente) }}" class="btn btn-pastel-primary btn-lg">
                <i class="fas fa-plus mr-1"></i> Crear Primer Registro
            </a>
        </div>
        @endif
    </div>
    
    @if($registros->count() > 0)
    <div class="card-footer bg-pastel-light border-top">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <small class="text-muted mb-2 mb-md-0">
                <i class="fas fa-database mr-1 text-pastel-blue"></i>
                Mostrando <strong>{{ $registros->firstItem() }} - {{ $registros->lastItem() }}</strong> 
                de <strong>{{ $registros->total() }}</strong> registros
            </small>
            
            <!-- Paginación -->
            @if($registros->hasPages())
            <div class="pagination-pastel mb-2 mb-md-0">
                {{ $registros->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
            @endif
            
            <small class="text-muted mt-2 mt-md-0">
                <i class="fas fa-sync-alt mr-1 text-pastel-muted"></i>
                Página {{ $registros->currentPage() }} de {{ $registros->lastPage() }}
            </small>
        </div>
    </div>
    @endif
</div>

<a href="{{ route('admin.pacientes.index') }}" 
   class="btn btn-pastel-gray mb-3 mt-3">
   <i class="fas fa-chevron-left mr-2"></i> Regresar
</a>
@stop

@section('css')
<style>
    /* Paleta de Colores Pasteles Mejorada */
    :root {
        --pastel-blue: #A8D8EA;
        --pastel-blue-dark: #97c9db;
        --pastel-green: #B6E2D3;
        --pastel-green-dark: #a5d1c2;
        --pastel-orange: #FFD3B6;
        --pastel-orange-dark: #e6bea4;
        --pastel-purple: #CAB8FF;
        --pastel-purple-dark: #b9a6e6;
        --pastel-pink: #F8C8DC;
        --pastel-red: #FFB7B7;
        --pastel-red-dark: #e6a5a5;
        --pastel-yellow: #FCE38A;
        --pastel-light: #F9F7F7;
        --pastel-muted: #D6D6D6;
        --pastel-secondary: #E3E3E3;
    }

    /* Opción 2: Botón Pastel Gris */
    .btn-pastel-gray {
        background: linear-gradient(135deg, #E3E3E3, #D6D6D6);
        border: none;
        color: #666 !important;
        border-radius: 8px;
        font-weight: 600;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-pastel-gray:hover {
        background: linear-gradient(135deg, #D6D6D6, #C9C9C9);
        transform: translateY(-2px);
        color: #666 !important;
        text-decoration: none;
    }

    /* Gradientes Pasteles */
    .bg-gradient-pastel-blue {
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-blue-dark)) !important;
    }
    
    .bg-gradient-pastel-green {
        background: linear-gradient(135deg, var(--pastel-green), var(--pastel-green-dark)) !important;
    }
    
    .bg-gradient-pastel-orange {
        background: linear-gradient(135deg, var(--pastel-orange), var(--pastel-orange-dark)) !important;
    }
    
    .bg-gradient-pastel-purple {
        background: linear-gradient(135deg, var(--pastel-purple), var(--pastel-purple-dark)) !important;
    }

    /* Colores de texto */
    .text-pastel-blue { color: var(--pastel-blue) !important; }
    .text-pastel-green { color: var(--pastel-green) !important; }
    .text-pastel-orange { color: var(--pastel-orange) !important; }
    .text-pastel-purple { color: var(--pastel-purple) !important; }
    .text-pastel-pink { color: var(--pastel-pink) !important; }
    .text-pastel-red { color: var(--pastel-red) !important; }
    .text-pastel-yellow { color: var(--pastel-yellow) !important; }
    .text-pastel-muted { color: var(--pastel-muted) !important; }

    /* Fondos */
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-green { background-color: var(--pastel-green) !important; }
    .bg-pastel-orange { background-color: var(--pastel-orange) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    .bg-pastel-pink { background-color: var(--pastel-pink) !important; }
    .bg-pastel-red { background-color: var(--pastel-red) !important; }
    .bg-pastel-yellow { background-color: var(--pastel-yellow) !important; }
    .bg-pastel-light { background-color: var(--pastel-light) !important; }
    .bg-pastel-secondary { background-color: var(--pastel-secondary) !important; }

    /* Botones Pastel */
    .btn-pastel-primary {
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-blue-dark));
        border: none;
        color: white !important;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-pastel-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(168, 216, 234, 0.4);
        color: white !important;
    }

    .btn-pastel-success {
        background: linear-gradient(135deg, var(--pastel-green), var(--pastel-green-dark));
        border: none;
        color: white !important;
        border-radius: 8px;
    }

    .btn-pastel-info {
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-blue-dark));
        border: none;
        color: white !important;
        border-radius: 6px;
    }

    .btn-pastel-warning {
        background: linear-gradient(135deg, var(--pastel-orange), var(--pastel-orange-dark));
        border: none;
        color: white !important;
        border-radius: 6px;
    }

    .btn-pastel-danger {
        background: linear-gradient(135deg, var(--pastel-purple), var(--pastel-purple-dark));
        border: none;
        color: white !important;
        border-radius: 6px;
    }

    .btn-pastel-red {
        background: linear-gradient(135deg, var(--pastel-red), var(--pastel-red-dark));
        border: none;
        color: white !important;
        border-radius: 6px;
    }

    .btn-pastel-light {
        background-color: var(--pastel-light);
        border: 1px solid #e0e0e0;
        color: #666 !important;
        border-radius: 8px;
    }

    /* Badges Mejorados */
    .badge-pastel-blue { 
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-blue-dark));
        color: white !important;
    }
    
    .badge-pastel-green { 
        background: linear-gradient(135deg, var(--pastel-green), var(--pastel-green-dark));
        color: white !important;
    }
    
    .badge-pastel-orange { 
        background: linear-gradient(135deg, var(--pastel-orange), var(--pastel-orange-dark));
        color: white !important;
    }
    
    .badge-pastel-purple { 
        background: linear-gradient(135deg, var(--pastel-purple), var(--pastel-purple-dark));
        color: white !important;
    }
    
    .badge-pastel-red { 
        background: linear-gradient(135deg, var(--pastel-red), var(--pastel-red-dark));
        color: white !important;
    }
    
    .badge-pastel-light { 
        background-color: var(--pastel-light);
        color: #666 !important;
        border: 1px solid #e0e0e0;
    }
    
    .badge-pastel-secondary { 
        background-color: var(--pastel-secondary);
        color: #666 !important;
    }

    /* Cards Mejoradas */
    .card-pastel-success {
        border: none;
        border-radius: 12px;
    }
    
    .card-pastel-warning {
        border: none;
        border-radius: 12px;
    }

    .shadow-soft {
        box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
    }

    /* Header Icons */
    .header-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .header-icon-sm {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Info Cards */
    .info-card {
        transition: all 0.3s ease;
        border: none;
    }
    
    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .info-icon {
        width: 24px;
        text-align: center;
    }

    .info-icon-small {
        width: 20px;
        text-align: center;
    }

    /* Avatar Circles */
    .avatar-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .avatar-sm {
        width: 40px;
        height: 40px;
    }

    /* Table Styles */
    .table-pastel {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .table-pastel thead th {
        border: none;
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table-row-pastel {
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
    }
    
    .table-row-pastel:hover {
        background: linear-gradient(90deg, var(--pastel-light), white);
        border-left-color: var(--pastel-blue);
        transform: scale(1.01);
    }

    /* Input Groups */
    .input-group-pastel .form-control-pastel {
        border: 1px solid #e0e0e0;
        border-right: none;
        border-radius: 8px 0 0 8px;
    }
    
    .input-group-pastel .btn {
        border-radius: 0 8px 8px 0;
        border: 1px solid #e0e0e0;
        border-left: none;
    }

    /* Empty States */
    .empty-state-icon {
        opacity: 0.6;
    }

    /* Toolbar */
    .toolbar-pastel {
        margin-bottom: 1.5rem;
    }

    /* Stats Cards */
    .stats-card {
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    }

    /* Paginación Pastel */
    .pagination-pastel .pagination {
        margin: 0;
    }

    .pagination-pastel .page-link {
        border: 1px solid #e0e0e0;
        color: #666;
        margin: 0 2px;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .pagination-pastel .page-item.active .page-link {
        background: linear-gradient(135deg, var(--pastel-blue), var(--pastel-blue-dark));
        border-color: var(--pastel-blue);
        color: white;
    }

    .pagination-pastel .page-link:hover {
        background-color: var(--pastel-light);
        border-color: var(--pastel-blue);
        color: #333;
    }

    .pagination-pastel .page-item.disabled .page-link {
        background-color: var(--pastel-light);
        color: var(--pastel-muted);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .btn-group-vertical {
            width: 100%;
        }
        
        .btn-group-vertical .btn {
            margin-bottom: 2px;
        }
        
        .info-card {
            margin-bottom: 10px;
        }
        
        .pagination-pastel .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .pagination-pastel .page-item {
            margin-bottom: 5px;
        }
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id, tipo) {
    Swal.fire({
        title: '¿Eliminar Registro?',
        html: `Está a punto de eliminar el registro de tipo:<br><strong>${tipo.toUpperCase()}</strong>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FFB7B7',
        cancelButtonColor: '#A8D8EA',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        background: '#F9F7F7',
        customClass: {
            confirmButton: 'btn-pastel-red',
            cancelButton: 'btn-pastel-primary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
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

    // Tooltips
    $('[title]').tooltip();

    // Efectos hover
    $('.btn, .info-card, .stats-card').hover(
        function() {
            $(this).css('transform', 'translateY(-2px)');
        },
        function() {
            $(this).css('transform', 'translateY(0)');
        }
    );
});



// SweetAlert para mensajes
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        position: 'top-end',
        toast: true,
        background: '#B6E2D3',
        iconColor: '#2e7d32'
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
        timer: 4000,
        showConfirmButton: true,
        background: '#FFB7B7',
        iconColor: '#c62828'
    });
@endif


</script>
@stop
