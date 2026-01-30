@extends('adminlte::page')

@section('title', 'Gestión de Pacientes')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-user-injured mr-2"></i>Gestión de Pacientes
    </h1>
    <a href="{{ route('admin.pacientes.create') }}" class="btn btn-pastel-blue btn-rounded shadow-sm px-4">
        <i class="fas fa-plus-circle mr-1"></i> Nuevo Paciente
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    {{-- Estadísticas --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="info-box bg-pastel-blue shadow-sm card-hover">
                <span class="info-box-icon bg-soft-primary"><i class="fas fa-users text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted small">Total Pacientes</span>
                    <span class="info-box-number text-dark h5 mb-0">{{ $pacientes->total() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-green shadow-sm card-hover">
                <span class="info-box-icon bg-soft-success"><i class="fas fa-check-circle text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted small">Activos</span>
                    <span class="info-box-number text-dark h5 mb-0">{{ $pacientes->where('activo', true)->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-orange shadow-sm card-hover">
                <span class="info-box-icon bg-soft-warning"><i class="fas fa-pause-circle text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted small">Inactivos</span>
                    <span class="info-box-number text-dark h5 mb-0">{{ $pacientes->where('activo', false)->count() }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="info-box bg-pastel-purple shadow-sm card-hover">
                <span class="info-box-icon bg-soft-info"><i class="fas fa-hospital text-white"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted small">Sucursales</span>
                    <span class="info-box-number text-dark h5 mb-0">{{ $pacientes->pluck('sucursal_id')->unique()->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Buscador --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body bg-pastel-light py-3">
            <div class="row align-items-end">
                <div class="col-md-6">
                    <label class="small font-weight-bold text-muted ml-2">BUSCAR PACIENTE</label>
                    <div class="input-group shadow-xs rounded-pill bg-white px-2 py-1">
                        <input type="text" id="table_search" class="form-control border-0 bg-transparent" placeholder="Nombre, DNI o código...">
                        <div class="input-group-append">
                            <span class="text-muted align-self-center mr-2"><i class="fas fa-search"></i></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="small font-weight-bold text-muted ml-2">ESTADO</label>
                    <select id="estado_filter" class="form-control border-0 shadow-xs rounded-pill custom-select">
                        <option value="">Todos</option>
                        <option value="activo">🟢 Activos</option>
                        <option value="inactivo">🔴 Inactivos</option>
                    </select>
                </div>
                <div class="col-md-3 text-right pb-1">
                    <button id="btnLimpiarFiltros" class="btn btn-link text-muted small"><i class="fas fa-eraser"></i> Limpiar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-pastel-light">
                        <tr>
                            <th class="text-center border-0 py-3">ID</th>
                            <th class="border-0 py-3">Paciente</th>
                            <th class="border-0 py-3">Sucursal</th>
                            <th class="text-center border-0 py-3">Estado</th>
                            <th class="text-center border-0 py-3">Gestión Clínica</th>
                            <th class="text-center border-0 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pacientes as $paciente)
                        <tr class="table-row-hover" 
                            data-search="{{ strtolower($paciente->nombre . ' ' . $paciente->dni . ' ' . $paciente->codigo_empleado) }}"
                            data-estado="{{ $paciente->activo ? 'activo' : 'inactivo' }}">
                            <td class="text-center text-soft-primary font-weight-bold">#{{ $paciente->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-paciente mr-3">
                                        <i class="fas fa-user-circle fa-2x text-soft-primary"></i>
                                    </div>
                                    <div>
                                        <span class="d-block font-weight-bold text-dark">{{ $paciente->nombre }}</span>
                                        <small class="text-muted">DNI: {{ $paciente->dni ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="text-dark"><i class="fas fa-store text-soft-warning mr-1 small"></i> {{ $paciente->sucursal->nombre ?? 'Sin sucursal' }}</span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.pacientes.toggleActivo', $paciente) }}" method="POST" class="d-inline">
                                    @csrf @method('PUT')
                                    <button type="button" class="btn btn-sm toggle-estado {{ $paciente->activo ? 'badge-pastel-green' : 'badge-pastel-red' }} border-0 px-3"
                                            data-paciente-nombre="{{ $paciente->nombre }}"
                                            data-activo="{{ $paciente->activo }}">
                                        {{ $paciente->activo ? 'ACTIVO' : 'INACTIVO' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-xs">
                                    <a href="{{ route('admin.pacientes.vistaIndividual', $paciente) }}" class="btn btn-white btn-sm border-pastel" title="Ver Expediente Completo">
                                        <i class="fas fa-folder-open text-info"></i>
                                    </a>
                                    <a href="{{ route('admin.certificados.byPaciente', $paciente) }}" class="btn btn-white btn-sm border-pastel" title="Certificados">
                                        <i class="fas fa-file-medical text-success"></i>
                                    </a>
                                    <a href="{{ route('admin.inmunizaciones.byPaciente', $paciente) }}" class="btn btn-white btn-sm border-pastel" title="Vacunas">
                                        <i class="fas fa-syringe text-danger"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="{{ route('admin.pacientes.show', $paciente) }}" class="btn btn-light btn-sm mr-1 shadow-xs rounded"><i class="fas fa-eye text-primary"></i></a>
                                    <a href="{{ route('admin.pacientes.edit', $paciente) }}" class="btn btn-light btn-sm shadow-xs rounded"><i class="fas fa-edit text-warning"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No hay registros</td></tr>
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
    :root {
        --pastel-blue: #e3f2fd; --pastel-green: #e8f5e8; --pastel-orange: #fff3e0;
        --pastel-purple: #f3e5f5; --pastel-red: #ffebee; --pastel-light: #fafafa;
        --soft-primary: #90caf9; --soft-success: #a5d6a7; --soft-warning: #ffcc80;
    }
    .text-pastel-purple { color: #6a1b9a !important; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-green { background-color: var(--pastel-green) !important; }
    .bg-pastel-orange { background-color: var(--pastel-orange) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    .bg-pastel-light { background-color: var(--pastel-light) !important; }
    .text-soft-primary { color: var(--soft-primary) !important; }
    .bg-soft-primary { background-color: var(--soft-primary) !important; }
    .bg-soft-success { background-color: var(--soft-success) !important; }
    .bg-soft-warning { background-color: var(--soft-warning) !important; }
    .bg-soft-info { background-color: #81d4fa !important; }

    .btn-pastel-blue { background-color: var(--soft-primary) !important; color: white !important; border-radius: 50px; }
    .badge-pastel-green { background-color: var(--pastel-green) !important; color: #2e7d32 !important; border-radius: 20px; }
    .badge-pastel-red { background-color: var(--pastel-red) !important; color: #c62828 !important; border-radius: 20px; }
    
    .border-pastel { border: 1px solid #e3f2fd !important; }
    .shadow-xs { box-shadow: 0 2px 4px rgba(0,0,0,0.05) !important; }
    .card { border-radius: 15px !important; }
    .avatar-paciente { background: #f0f7ff; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; }
    .table-row-hover:hover { background-color: #fcfdff !important; transition: 0.2s; }
</style>
@stop