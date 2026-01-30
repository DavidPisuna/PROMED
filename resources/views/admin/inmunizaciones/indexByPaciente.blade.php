@extends('adminlte::page')

@section('title', 'Inmunizaciones del Paciente')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-syringe mr-2"></i>Historial de Inmunizaciones
    </h1>
    <div>
        <a href="{{ route('admin.inmunizaciones.createFromPaciente', $paciente) }}" class="btn btn-pastel-blue shadow-sm">
            <i class="fas fa-plus-circle mr-1"></i> Nuevo Registro
        </a>
        <a href="{{ route('admin.pacientes.index') }}" class="btn btn-pastel-gray shadow-sm ml-2">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-user-circle mr-2"></i>Resumen del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center text-center text-md-left">
                <div class="col-md-4 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($paciente->primer_nombre) }} {{ strtoupper($paciente->segundo_nombre) }} 
                        {{ strtoupper($paciente->primer_apellido) }} {{ strtoupper($paciente->segundo_apellido) }}
                    </span>
                </div>
                <div class="col-md-3 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación</small>
                    <span class="h6 font-weight-bold">{{ $paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-2 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Edad</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">
                        {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} AÑOS
                    </span>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Empresa Activa</small>
                    <span class="text-dark font-weight-bold">{{ strtoupper($paciente->sucursal->nombre ?? 'SIN EMPRESA') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 TABLA DE INMUNIZACIONES --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-clipboard-list mr-2"></i>Registros Guardados
            </h5>
            <span class="badge badge-pastel-purple px-3 py-2">{{ $inmunizaciones->total() }} REGISTROS</span>
        </div>
        
        <div class="card-body p-0">
            @if($inmunizaciones->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light text-muted">
                            <tr class="text-uppercase small">
                                <th class="pl-4">ID</th>
                                <th>Empresa / Doctor</th>
                                <th>Resumen de Vacunas</th>
                                <th>Fecha Registro</th>
                                <th class="text-center pr-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inmunizaciones as $inmunizacion)
                            <tr>
                                <td class="pl-4 align-middle font-weight-bold">#{{ $inmunizacion->id }}</td>
                                <td class="align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="text-dark font-weight-bold">{{ strtoupper($inmunizacion->empresa->nombre ?? 'N/A') }}</span>
                                        <small class="text-muted">DR. {{ strtoupper($inmunizacion->doctor->primer_nombre ?? '') }} {{ strtoupper($inmunizacion->doctor->primer_apellido ?? '') }}</small>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    {{-- Listamos brevemente las vacunas de este registro --}}
                                    @foreach($inmunizacion->detalles as $detalle)
                                        <span class="badge badge-pastel-blue mb-1" style="font-size: 0.75rem;">
                                            {{ strtoupper($detalle->vacuna) }} ({{ $detalle->dosis }})
                                        </span>
                                    @endforeach
                                </td>
                                <td class="align-middle font-weight-500">
                                    {{ $inmunizacion->created_at->format('d/m/Y') }}
                                </td>
                                <td class="align-middle text-center pr-4">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('admin.inmunizaciones.show', $inmunizacion) }}" class="btn btn-sm btn-light border" title="Ver Detalles">
                                            <i class="fas fa-eye text-info"></i>
                                        </a>
                                        <a href="{{ route('admin.inmunizaciones.edit', $inmunizacion) }}" class="btn btn-sm btn-light border" title="Ver Detalles">
                                            <i class="fas fa-edit text-warning"></i>
                                        </a>
                                        <a href="{{ route('admin.inmunizaciones.pdf', $inmunizacion) }}" target="_blank" class="btn btn-sm btn-light border" title="Generar PDF">
                                            <i class="fas fa-file-pdf text-danger"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-light border btn-delete" data-id="{{ $inmunizacion->id }}" title="Eliminar Registro">
                                            <i class="fas fa-trash-alt text-muted"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.inmunizaciones.destroy', $inmunizacion) }}" method="POST" id="delete-form-{{ $inmunizacion->id }}" class="d-none">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/2311/2311746.png" alt="Sin datos" style="width: 100px; opacity: 0.4">
                    <h5 class="mt-3 text-muted">No hay vacunas registradas</h5>
                    <p class="text-muted small">Haz clic en "Nuevo Registro" para empezar.</p>
                </div>
            @endif
        </div>
        
        @if($inmunizaciones->hasPages())
        <div class="card-footer bg-white">
            {{ $inmunizaciones->links() }}
        </div>
        @endif
    </div>
</div>
@stop

@section('css')
<style>
    :root {
        --pastel-blue: #A8D8EA;
        --pastel-purple: #CAB8FF;
        --pastel-gray: #E3E3E3;
    }

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-purple { color: #9b86d6 !important; }

    .btn-pastel-blue { background-color: var(--pastel-blue); border: none; color: #444; font-weight: 600; border-radius: 8px; }
    .btn-pastel-blue:hover { background-color: #96c7d9; transform: translateY(-1px); }
    .btn-pastel-gray { background-color: var(--pastel-gray); border: none; color: #666; font-weight: 600; border-radius: 8px; }

    .badge-pastel-blue { background-color: #e1f2f9; color: #4a90a4; border: 1px solid #c9e6f1; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white !important; }

    .table thead th { border-top: none; border-bottom: 2px solid #f4f4f4; }
    .table td { vertical-align: middle; border-top: 1px solid #f9f9f9; }
    .swal2-popup-custom { border-radius: 15px !important; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // 1. Efecto Mayúsculas (si hubiera inputs en esta vista, por ahora queda para consistencia)
        $(document).on('input', 'input[type="text"]', function() {
            this.value = this.value.toUpperCase();
        });

        // 2. SweetAlert de Eliminación
        $('.btn-delete').on('click', function() {
            const id = $(this).data('id');
            
            Swal.fire({
                title: '¿ELIMINAR REGISTRO?',
                text: "Se borrará la inmunización #" + id + " y todas las vacunas asociadas a ella.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#CAB8FF', // Purple
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'SÍ, ELIMINAR',
                cancelButtonText: 'CANCELAR',
                customClass: { popup: 'swal2-popup-custom' },
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });

        // 3. Alerta de Éxito
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡OPERACIÓN EXITOSA!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000,
                customClass: { popup: 'swal2-popup-custom' }
            });
        @endif
    });
</script>
@stop