@extends('adminlte::page')

@section('title', 'Detalle del Paciente')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-pastel-purple"><i class="fas fa-user-injured mr-2"></i>Detalle del Paciente</h1>
    <a href="{{ route('admin.pacientes.index') }}" class="btn btn-pastel-gray">
        <i class="fas fa-arrow-left mr-1"></i> Volver al Listado
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- Columna izquierda: Información principal --}}
        <div class="col-md-8">
            <div class="card card-pastel shadow-sm mb-4">
                <div class="card-header bg-pastel-blue text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-circle mr-2"></i>Información del Paciente
                    </h5>
                    <span class="badge badge-pastel">
                        ID: {{ $paciente->id }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- Información Personal --}}
                        <div class="col-md-6">
                            <div class="info-item mb-4">
                                <div class="info-label text-muted small">
                                    <i class="fas fa-user text-pastel-purple mr-1"></i> Nombre Completo
                                </div>
                                <div class="info-value font-weight-bold text-dark">
                                    {{ $paciente->nombre_completo }}
                                </div>
                            </div>

                            <div class="info-item mb-4">
                                <div class="info-label text-muted small">
                                    <i class="fas fa-address-card text-pastel-purple mr-1"></i> Cédula de Identidad
                                </div>
                                <div class="info-value text-dark">
                                    {{ $paciente->cedula_identidad }}
                                </div>
                            </div>

                            <div class="info-item mb-4">
                                <div class="info-label text-muted small">
                                    <i class="fas fa-id-badge text-pastel-purple mr-1"></i> Código Empleado
                                </div>
                                <div class="info-value text-dark">
                                    {{ $paciente->codigo_empleado }}
                                </div>
                            </div>

                            <div class="info-item mb-4">
                                <div class="info-label text-muted small">
                                    <i class="fas fa-venus-mars text-pastel-purple mr-1"></i> Sexo
                                </div>
                                <div class="info-value text-dark">
                                    @if($paciente->sexo == 'M')
                                        <span class="badge badge-pastel-blue">
                                            <i class="fas fa-male mr-1"></i> Masculino
                                        </span>
                                    @elseif($paciente->sexo == 'F')
                                        <span class="badge badge-pastel-pink">
                                            <i class="fas fa-female mr-1"></i> Femenino
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Información Médica y Asignación --}}
                        <div class="col-md-6">
                            <div class="info-item mb-4">
                                <div class="info-label text-muted small">
                                    <i class="fas fa-tint text-pastel-purple mr-1"></i> Grupo Sanguíneo
                                </div>
                                <div class="info-value text-dark">
                                    @if($paciente->grupo_sanguineo)
                                        <span class="badge badge-pastel-red">
                                            {{ $paciente->grupo_sanguineo }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-item mb-4">
                                <div class="info-label text-muted small">
                                    <i class="fas fa-hand-paper text-pastel-purple mr-1"></i> Lateralidad
                                </div>
                                <div class="info-value text-dark">
                                    @if($paciente->lateralidad)
                                        <span class="badge badge-pastel-orange">
                                            <i class="fas fa-hand-point-right mr-1"></i>
                                            {{ $paciente->lateralidad }}
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-item mb-4">
                                <div class="info-label text-muted small">
                                    <i class="fas fa-store text-pastel-purple mr-1"></i> Sucursal
                                </div>
                                <div class="info-value text-dark">
                                    @if($paciente->sucursal)
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-building text-pastel-blue mr-2"></i>
                                            <div>
                                                <strong>{{ $paciente->sucursal->nombre }}</strong>
                                                @if($paciente->sucursal->codigo)
                                                    <br><small class="text-muted">
                                                        Código: {{ $paciente->sucursal->codigo }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </div>
                            </div>

                            <div class="info-item mb-4">
                                <div class="info-label text-muted small">
                                    <i class="fas fa-toggle-on text-pastel-purple mr-1"></i> Estado
                                </div>
                                <div class="info-value">
                                    @if($paciente->activo)
                                        <span class="badge badge-pastel-green">
                                            <i class="fas fa-check-circle mr-1"></i> Activo
                                        </span>
                                    @else
                                        <span class="badge badge-pastel-red">
                                            <i class="fas fa-times-circle mr-1"></i> Inactivo
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Información Adicional --}}
                    <div class="row mt-4 pt-4 border-top">
                        <div class="col-md-6">
                            <div class="info-item mb-4">
                                <div class="info-label text-muted small">
                                    <i class="fas fa-birthday-cake text-pastel-purple mr-1"></i> Fecha de Nacimiento
                                </div>
                                <div class="info-value text-dark">
                                    @if($paciente->fecha_nacimiento)
                                        {{ $paciente->fecha_nacimiento->format('d/m/Y') }}
                                        @php
                                            $edad = \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age;
                                        @endphp
                                        <span class="badge badge-pastel-purple ml-2">
                                            {{ $edad }} años
                                        </span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item mb-4">
                                <div class="info-label text-muted small">
                                    <i class="fas fa-calendar-alt text-pastel-purple mr-1"></i> Fecha de Registro
                                </div>
                                <div class="info-value text-dark">
                                    {{ $paciente->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna derecha: Resumen y acciones --}}
        <div class="col-md-4">
            {{-- Resumen --}}
            <div class="card card-pastel shadow-sm mb-4">
                <div class="card-header bg-pastel-green text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-check mr-2"></i>Resumen
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-pastel-info mb-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Información del paciente:</strong>
                        <div class="small mt-2">
                            <div><strong>ID:</strong> {{ $paciente->id }}</div>
                            <div><strong>Estado:</strong> 
                                @if($paciente->activo)
                                    <span class="text-success">Activo</span>
                                @else
                                    <span class="text-danger">Inactivo</span>
                                @endif
                            </div>
                            <div><strong>Registrado hace:</strong> 
                                {{ $paciente->created_at->diffForHumans() }}
                            </div>
                            <div><strong>Última actualización:</strong> 
                                {{ $paciente->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    @if($paciente->fecha_nacimiento)
                    <div class="alert alert-pastel-success">
                        <i class="fas fa-user-md mr-2"></i>
                        <strong>Datos médicos:</strong>
                        <div class="small mt-2">
                            <div><strong>Edad:</strong> {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años</div>
                            @if($paciente->grupo_sanguineo)
                                <div><strong>Grupo sanguíneo:</strong> {{ $paciente->grupo_sanguineo }}</div>
                            @endif
                            @if($paciente->lateralidad)
                                <div><strong>Lateralidad:</strong> {{ $paciente->lateralidad }}</div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Acciones --}}
            <div class="card card-pastel shadow-sm">
                <div class="card-header bg-pastel-orange text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cogs mr-2"></i>Acciones
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <a href="{{ route('admin.pacientes.edit', $paciente) }}" 
                           class="btn btn-pastel-warning mb-3">
                            <i class="fas fa-edit mr-1"></i> Editar Paciente
                        </a>

                        <form action="{{ route('admin.pacientes.toggleActivo', $paciente) }}" 
                              method="POST" 
                              class="mb-3">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="btn btn-pastel-info w-100"
                                    onclick="return confirmToggle()">
                                <i class="fas fa-sync-alt mr-1"></i>
                                {{ $paciente->activo ? 'Desactivar' : 'Activar' }} Paciente
                            </button>
                        </form>

                        <button type="button" 
                                class="btn btn-pastel-danger"
                                onclick="confirmDelete()">
                            <i class="fas fa-trash-alt mr-1"></i> Eliminar Paciente
                        </button>

                        {{-- Formulario oculto para eliminar --}}
                        <form id="delete-form" 
                              action="{{ route('admin.pacientes.destroy', $paciente) }}" 
                              method="POST" 
                              style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>

            {{-- QR Code o identificador rápido --}}
            <div class="card card-pastel shadow-sm mt-4">
                <div class="card-header bg-pastel-purple text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-qrcode mr-2"></i>Identificador
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="avatar-paciente-grande mb-3">
                        @if($paciente->sexo == 'F')
                            <i class="fas fa-female fa-4x text-pastel-pink"></i>
                        @elseif($paciente->sexo == 'M')
                            <i class="fas fa-male fa-4x text-pastel-blue"></i>
                        @else
                            <i class="fas fa-user fa-4x text-pastel-purple"></i>
                        @endif
                    </div>
                    <div class="identificador-codigo">
                        <div class="text-muted small">Código único</div>
                        <div class="font-weight-bold text-dark">{{ $paciente->codigo_empleado }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    /* Paleta de colores pastel */
    :root {
        --pastel-blue: #e3f2fd;
        --pastel-purple: #f3e5f5;
        --pastel-green: #e8f5e8;
        --pastel-pink: #fce4ec;
        --pastel-orange: #fff3e0;
        --pastel-yellow: #fffde7;
        --pastel-red: #ffebee;
        --pastel-gray: #f5f5f5;
        --pastel-light: #fafafa;
        --pastel-info: #e3f2fd;
        --pastel-success: #e8f5e8;
        --pastel-warning: #fff3e0;
        --pastel-danger: #ffebee;
    }
    
    .text-pastel-purple {
        color: #7b1fa2 !important;
    }
    
    .bg-pastel-blue {
        background-color: var(--pastel-blue) !important;
    }
    
    .bg-pastel-green {
        background-color: var(--pastel-green) !important;
    }
    
    .bg-pastel-orange {
        background-color: var(--pastel-orange) !important;
    }
    
    .bg-pastel-purple {
        background-color: var(--pastel-purple) !important;
    }
    
    .bg-pastel-light {
        background-color: var(--pastel-light) !important;
    }
    
    /* Botones pastel */
    .btn-pastel-gray {
        background: linear-gradient(135deg, #e0e0e0, #d0d0d0) !important;
        border: none !important;
        color: #333 !important;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-pastel-gray:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .btn-pastel-warning {
        background: linear-gradient(135deg, #ffcc80, #ffb74d) !important;
        border: none !important;
        color: #333 !important;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-pastel-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(255, 167, 38, 0.3);
    }
    
    .btn-pastel-info {
        background: linear-gradient(135deg, #80deea, #4dd0e1) !important;
        border: none !important;
        color: #333 !important;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-pastel-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(77, 208, 225, 0.3);
    }
    
    .btn-pastel-danger {
        background: linear-gradient(135deg, #ef9a9a, #e57373) !important;
        border: none !important;
        color: #333 !important;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .btn-pastel-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(229, 115, 115, 0.3);
    }
    
    /* Badges pastel */
    .badge-pastel {
        background: #fff59d;
        color: #333;
        padding: 5px 10px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 0.85rem;
    }
    
    .badge-pastel-blue {
        background-color: var(--pastel-blue) !important;
        color: #1565c0 !important;
        border: 1px solid #bbdefb;
    }
    
    .badge-pastel-purple {
        background-color: var(--pastel-purple) !important;
        color: #7b1fa2 !important;
        border: 1px solid #e1bee7;
    }
    
    .badge-pastel-green {
        background-color: var(--pastel-green) !important;
        color: #2e7d32 !important;
        border: 1px solid #c8e6c9;
    }
    
    .badge-pastel-pink {
        background-color: var(--pastel-pink) !important;
        color: #ad1457 !important;
        border: 1px solid #f8bbd9;
    }
    
    .badge-pastel-orange {
        background-color: var(--pastel-orange) !important;
        color: #ef6c00 !important;
        border: 1px solid #ffe0b2;
    }
    
    .badge-pastel-red {
        background-color: var(--pastel-red) !important;
        color: #c62828 !important;
        border: 1px solid #ffcdd2;
    }
    
    /* Cards */
    .card-pastel {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    .card-pastel .card-header {
        border-radius: 15px 15px 0 0 !important;
        border: none;
        font-weight: 600;
        padding: 15px 20px;
    }
    
    .card-pastel .card-body {
        padding: 20px;
    }
    
    /* Info items */
    .info-item {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        margin-bottom: 5px;
        font-size: 0.9rem;
    }
    
    .info-value {
        font-size: 1.1rem;
        min-height: 28px;
    }
    
    /* Alertas pastel */
    .alert-pastel-info {
        background-color: var(--pastel-info);
        border: 2px solid #bbdefb;
        color: #0d47a1;
        border-radius: 10px;
        padding: 15px;
    }
    
    .alert-pastel-success {
        background-color: var(--pastel-success);
        border: 2px solid #c8e6c9;
        color: #1b5e20;
        border-radius: 10px;
        padding: 15px;
    }
    
    /* Avatar grande */
    .avatar-paciente-grande {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--pastel-light), #f0f0f0);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    /* Identificador código */
    .identificador-codigo {
        padding: 10px;
        background-color: var(--pastel-light);
        border-radius: 10px;
        border: 2px dashed #e0e0e0;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .btn-pastel-warning,
        .btn-pastel-info,
        .btn-pastel-danger {
            padding: 8px 15px;
            font-size: 0.9rem;
        }
        
        .avatar-paciente-grande {
            width: 80px;
            height: 80px;
        }
        
        .avatar-paciente-grande i {
            font-size: 3rem;
        }
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete() {
        Swal.fire({
            title: '¿Eliminar paciente?',
            html: `Esta acción no se puede deshacer<br>
                  <strong>{{ $paciente->nombre_completo }}</strong><br>
                  <small class="text-muted">Cédula: {{ $paciente->cedula_identidad }} | ID: {{ $paciente->id }}</small>`,
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
                document.getElementById('delete-form').submit();
            }
        });
    }
    
    function confirmToggle() {
        const esActivo = {{ $paciente->activo ? 'true' : 'false' }};
        const accion = esActivo ? 'desactivar' : 'activar';
        
        return Swal.fire({
            title: `¿${accion.charAt(0).toUpperCase() + accion.slice(1)} paciente?`,
            html: `El paciente <strong>{{ $paciente->nombre_completo }}</strong> será ${accion}do<br>
                  <small class="text-muted">Esta acción cambiará su estado en el sistema</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: esActivo ? '#ff9800' : '#4caf50',
            cancelButtonColor: '#9e9e9e',
            confirmButtonText: `Sí, ${accion}`,
            cancelButtonText: 'Cancelar',
            background: '#fafafa'
        }).then((result) => {
            return result.isConfirmed;
        });
    }
    
    $(document).ready(function() {
        // Efecto hover en botones
        $('.btn').hover(
            function() {
                $(this).css('transform', 'translateY(-2px)');
            },
            function() {
                $(this).css('transform', 'translateY(0)');
            }
        );
        
        // Tooltips para iconos
        $('[title]').tooltip();
        
        // SweetAlert para mensajes de sesión
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
    });
</script>
@stop