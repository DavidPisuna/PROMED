@extends('adminlte::page')

@section('title', 'Registros del Paciente')

@section('content_header')
<div class="d-flex justify-content-between align-items-center px-3 mt-3">
    <div>
        <h1 class="text-pastel-purple font-weight-bold">
            <i class="fas fa-clipboard-list mr-2"></i>Registros de Paciente
        </h1>
        <p class="text-muted mb-0">{{ $paciente->nombre_completo }}</p>
    </div>
    <a href="{{ route('admin.pacientes.index') }}" class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    {{-- Tarjeta de Información Superior (Estilo Estadísticas) --}}
    <div class="card border-0 shadow-sm mb-4 bg-pastel-light" style="border-radius: 15px;">
        <div class="card-body p-0">
            <div class="row no-gutters">
                <div class="col-md-1 bg-pastel-blue d-flex align-items-center justify-content-center p-4">
                    <i class="fas fa-user-injured fa-3x text-soft-primary"></i>
                </div>
                <div class="col-md-11">
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-3 border-right border-pastel">
                                <label class="small text-uppercase text-muted font-weight-bold">Paciente</label>
                                <p class="h5 mb-0 font-weight-bold text-dark">{{ $paciente->nombre_completo }}</p>
                                <span class="badge badge-pastel-purple text-dark">ID: {{ $paciente->id }}</span>
                            </div>
                            <div class="col-md-3 border-right border-pastel">
                                <label class="small text-uppercase text-muted font-weight-bold">Identificación</label>
                                <p class="mb-0 text-dark font-weight-bold">{{ $paciente->cedula_identidad }}</p>
                                <small class="text-muted">Cód: {{ $paciente->codigo_empleado }}</small>
                            </div>
                            <div class="col-md-3 border-right border-pastel">
                                <label class="small text-uppercase text-muted font-weight-bold">Sucursal y Estado</label>
                                <p class="mb-1 text-dark">{{ $paciente->sucursal->nombre ?? 'N/A' }}</p>
                                @if($paciente->activo)
                                    <span class="badge badge-pastel-green text-dark"><i class="fas fa-check mr-1"></i>Activo</span>
                                @else
                                    <span class="badge badge-pastel-red text-dark"><i class="fas fa-times mr-1"></i>Inactivo</span>
                                @endif
                            </div>
                            <div class="col-md-3 text-center d-flex flex-column justify-content-center">
                                <h3 class="text-soft-primary font-weight-bold mb-0">{{ $registros->total() }}</h3>
                                <small class="text-muted font-weight-bold">REGISTROS TOTALES</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Buscador y Acción --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="input-group input-group-pastel shadow-sm">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-white border-0"><i class="fas fa-search text-soft-primary"></i></span>
                </div>
                <input type="text" id="table_search" class="form-control border-0 py-4" placeholder="Buscar por médico, empresa o tipo de registro...">
            </div>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.registros.createFromPaciente', $paciente) }}" class="btn btn-pastel-blue btn-block shadow-sm h-100 d-flex align-items-center justify-content-center py-2">
                <i class="fas fa-plus-circle mr-2 fa-lg"></i> <strong>NUEVO REGISTRO MÉDICO</strong>
            </a>
        </div>
    </div>

    {{-- Tabla de Registros Estilo Pastel --}}
    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-pastel-blue border-0 py-3">
            <h5 class="card-title mb-0 font-weight-bold text-dark">
                <i class="fas fa-history mr-2 text-soft-primary"></i>Historial Clínico Reciente
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-pastel-light text-muted">
                        <tr>
                            <th class="border-0 px-4">Médico Atendente</th>
                            <th class="border-0">Empresa</th>
                            <th class="border-0 text-center">Tipo Evaluación</th>
                            <th class="border-0 text-center">Prioridad</th>
                            <th class="border-0 text-center">Fecha</th>
                            <th class="border-0 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registros as $registro)
                        <tr class="table-row-hover">
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-icon bg-pastel-purple text-soft-primary mr-3">
                                        <i class="fas fa-user-md"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark">{{ $registro->doctor->nombre_completo }}</div>
                                        <small class="text-muted">{{ $registro->doctor->especialidad }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark font-weight-bold">{{ $registro->empresa->nombre }}</div>
                                <small class="badge badge-pastel-light border text-muted">ID: {{ $registro->empresa_id }}</small>
                            </td>
                            <td class="text-center">
                                @php
                                    $config = [
                                        'ingreso' => ['bg' => 'badge-pastel-green', 'i' => 'fa-arrow-right'],
                                        'periodica' => ['bg' => 'badge-pastel-info', 'i' => 'fa-sync'],
                                        'retiro' => ['bg' => 'badge-pastel-red', 'i' => 'fa-arrow-left'],
                                        'reintegro' => ['bg' => 'badge-pastel-orange', 'i' => 'fa-undo']
                                    ][$registro->tipo] ?? ['bg' => 'badge-secondary', 'i' => 'fa-file'];
                                @endphp
                                <span class="badge {{ $config['bg'] }} py-2 px-3 text-dark">
                                    <i class="fas {{ $config['i'] }} mr-1"></i> {{ strtoupper($registro->tipo) }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($registro->atencion_prioritaria)
                                    <span class="badge badge-pastel-red pulse-red py-2 px-3">
                                        <i class="fas fa-exclamation-circle mr-1"></i> PRIORITARIA
                                    </span>
                                @else
                                    <span class="text-muted small font-weight-bold">NORMAL</span>
                                @endif
                            </td>
                            <td class="text-center font-weight-bold text-dark">
                                {{ $registro->fecha_ingreso?->format('d/m/Y') ?? 'N/A' }}
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-pastel shadow-sm">
                                    <a href="{{ route('admin.registros.show', $registro) }}" class="btn btn-outline-pastel-info btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.registros.edit', $registro) }}" class="btn btn-outline-pastel-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('admin.registros.pdf', $registro->id) }}" class="btn btn-outline-pastel-purple btn-sm" target="_blank" title="PDF"><i class="fas fa-file-pdf"></i></a>
                                    <a href="{{ route('admin.registros.duplicar', $registro) }}" class="btn btn-warning"><i class="fas fa-copy"></i></a>
                                    <button onclick="confirmDelete({{ $registro->id }}, '{{ $registro->tipo }}')" class="btn btn-outline-pastel-red btn-sm" title="Eliminar"><i class="fas fa-trash"></i></button>
                                </div>
                                <form id="delete-form-{{ $registro->id }}" action="{{ route('admin.registros.destroy', $registro) }}" method="POST" class="d-none">@csrf @method('DELETE')</form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 bg-pastel-light">
                                <i class="fas fa-folder-open fa-3x text-soft-muted mb-3"></i>
                                <h5 class="text-muted">No se encontraron registros médicos para este paciente</h5>
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
    :root {
        --pastel-blue: #e3f2fd;
        --pastel-green: #e8f5e8;
        --pastel-orange: #fff3e0;
        --pastel-purple: #f3e5f5;
        --pastel-red: #ffebee;
        --pastel-info: #e0f7fa;
        --pastel-light: #fafafa;
        --pastel-gray: #eceff1;
        --soft-primary: #90caf9;
        --soft-info: #80deea;
    }

    /* Fondos */
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-light { background-color: var(--pastel-light) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    
    /* Textos */
    .text-pastel-purple { color: #9d76e0 !important; }
    .text-soft-primary { color: var(--soft-primary) !important; }
    
    /* Badges Estilo Pastel */
    .badge-pastel-blue { background-color: var(--pastel-blue); color: #1976d2; }
    .badge-pastel-green { background-color: var(--pastel-green); color: #2e7d32; }
    .badge-pastel-orange { background-color: var(--pastel-orange); color: #ef6c00; }
    .badge-pastel-red { background-color: var(--pastel-red); color: #c62828; }
    .badge-pastel-purple { background-color: var(--pastel-purple); color: #7b1fa2; }
    .badge-pastel-info { background-color: var(--pastel-info); color: #00838f; }
    .badge-pastel-light { background-color: var(--pastel-gray); color: #546e7a; }

    /* Inputs y Botones */
    .input-group-pastel input { border-radius: 0 10px 10px 0 !important; }
    .input-group-pastel .input-group-text { border-radius: 10px 0 0 10px !important; }
    
    .btn-pastel-blue { background: var(--soft-primary); color: white; border-radius: 10px; border: none; }
    .btn-pastel-blue:hover { background: #64b5f6; color: white; transform: translateY(-1px); }
    
    .btn-pastel-gray { background: var(--pastel-gray); color: #546e7a; border-radius: 10px; }

    /* Tabla */
    .table-row-hover:hover { background-color: #f1f8ff !important; transition: 0.2s; }
    .avatar-icon { width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 10px; }
    .border-pastel { border-color: #e0e6ed !important; }

    /* Grupo de Botones Pastel */
    .btn-group-pastel .btn { border: 1px solid #e0e6ed; background: white; }
    .btn-outline-pastel-info:hover { background: var(--pastel-info); color: #00838f; }
    .btn-outline-pastel-warning:hover { background: var(--pastel-orange); color: #ef6c00; }
    .btn-outline-pastel-purple:hover { background: var(--pastel-purple); color: #7b1fa2; }
    .btn-outline-pastel-red:hover { background: var(--pastel-red); color: #c62828; }

    .pulse-red { animation: pulse 2s infinite; border: 1px solid #ef9a9a; }
    @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.6; } 100% { opacity: 1; } }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
        $('#table_search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });

    function confirmDelete(id, tipo) {
        Swal.fire({
            title: '¿Eliminar Registro?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef9a9a',
            cancelButtonColor: '#cfd8dc',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@stop