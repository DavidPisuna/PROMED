@extends('adminlte::page')

@section('title', 'Notas de Evolución')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-notes-medical mr-2"></i>Notas de Evolución
    </h1>
    <div class="d-flex" style="gap: 10px;">
        <a href="{{ route('admin.notas.pdfByPaciente', $paciente) }}"
           target="_blank"
           class="btn btn-pastel-danger shadow-sm">
            <i class="fas fa-file-pdf mr-1"></i> PDF Evoluciones
        </a>
        <a href="{{ route('admin.notas.createFromPaciente', $paciente) }}"
           class="btn btn-pastel-green shadow-sm">
            <i class="fas fa-plus mr-1"></i> Nueva Nota
        </a>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">

    {{-- 🧑 RESUMEN DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-circle mr-2"></i>Datos del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-5 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark text-uppercase">
                        {{ $paciente->primer_apellido }} {{ $paciente->segundo_apellido }} 
                        {{ $paciente->primer_nombre }} {{ $paciente->segundo_nombre }}
                    </span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación</small>
                    <span class="h6 font-weight-bold">{{ $paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-2 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Edad</small>
                    <span class="h6 font-weight-bold">
                        {{ $paciente->fecha_nacimiento ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age . ' años' : 'N/A' }}
                    </span>
                </div>
                <div class="col-md-2">
                    <small class="text-muted d-block text-uppercase font-weight-bold">ID Paciente</small>
                    <span class="badge badge-pill badge-light border px-3">#{{ $paciente->id }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 📋 TABLA DE NOTAS --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted text-uppercase small">
                            <th class="pl-4">Fecha y Hora</th>
                            <th>Problemas Identificados</th>
                            <th>Médico Responsable</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notas as $nota)
                        <tr>
                            <td class="pl-4">
                                <div class="font-weight-bold text-dark">
                                    {{ \Carbon\Carbon::parse($nota->fecha)->format('d/m/Y') }}
                                </div>
                                <small class="text-muted"><i class="far fa-clock mr-1"></i>{{ \Carbon\Carbon::parse($nota->hora)->format('H:i A') }}</small>
                            </td>
                            <td class="align-middle">
                                <span class="text-uppercase" style="font-size: 0.9rem;">
                                    {{ Str::limit($nota->problemas ?? 'SIN PROBLEMAS REGISTRADOS', 60) }}
                                </span>
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <div class="bg-pastel-purple rounded-circle text-white mr-2 d-flex align-items-center justify-content-center" style="width: 30px; height: 30px; font-size: 10px;">
                                        {{ substr($nota->doctor->primer_nombre, 0, 1) }}{{ substr($nota->doctor->primer_apellido, 0, 1) }}
                                    </div>
                                    <span class="small font-weight-bold">DR(A). {{ strtoupper($nota->doctor->primer_apellido) }}</span>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.notas.show', $nota) }}" class="btn btn-light text-info border-0 mx-1 shadow-sm" title="Ver Detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.notas.edit', $nota) }}" class="btn btn-light text-warning border-0 mx-1 shadow-sm" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.notas.destroy', $nota) }}" method="POST" class="form-delete d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-light text-danger border-0 mx-1 shadow-sm btn-delete" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/6598/6598519.png" width="80" class="opacity-50 mb-3" style="filter: grayscale(1);">
                                <p class="text-muted">No se han encontrado notas de evolución para este paciente.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($notas->hasPages())
        <div class="card-footer bg-white border-top-0 d-flex justify-content-center">
            {{ $notas->links() }}
        </div>
        @endif
    </div>

    {{-- 🔙 BOTÓN VOLVER --}}
    <div class="mt-4">
        <a href="{{ route('admin.pacientes.index') }}" class="btn btn-pastel-gray shadow-sm ml-2">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>
</div>
@stop

@section('css')
<style>
    :root { 
        --pastel-blue: #A8D8EA; 
        --pastel-purple: #CAB8FF; 
        --pastel-green: #AAFFCC;
        --pastel-danger: #FFB3B3;
        --pastel-gray: #E3E3E3; 
    }
    
    .card-pastel { border: none; border-radius: 15px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .bg-light-soft { background-color: #fbfbfb; }

    .btn-pastel-green { background: var(--pastel-green); border: none; border-radius: 10px; font-weight: bold; color: #2d5a27; }
    .btn-pastel-danger { background: var(--pastel-danger); border: none; border-radius: 10px; font-weight: bold; color: #721c24; }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 10px; font-weight: bold; color: #555; }
    
    .btn-pastel-green:hover, .btn-pastel-danger:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.1); opacity: 0.9; }

    table thead th { border: none !important; }
    .table-hover tbody tr:hover { background-color: rgba(202, 184, 255, 0.05); }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // 1. Alerta de Éxito (si existe sesión)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Logrado!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif

        // 2. Confirmación de Eliminación con SweetAlert2
        $('.btn-delete').on('click', function(e) {
            let form = $(this).closest('form');
            
            Swal.fire({
                title: '¿Eliminar Nota?',
                text: "Esta acción no se puede deshacer y la nota desaparecerá del historial.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#FFB3B3',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'SÍ, ELIMINAR',
                cancelButtonText: 'CANCELAR',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@stop