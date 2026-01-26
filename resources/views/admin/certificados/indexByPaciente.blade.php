@extends('adminlte::page')

@section('title', 'Certificados de Paciente')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-file-medical mr-2"></i>Certificados Médicos
    </h1>
    <div>
        <a href="{{ route('admin.certificados.createFromPaciente', $paciente) }}" class="btn btn-pastel-blue shadow-sm">
            <i class="fas fa-plus-circle mr-1"></i> Nuevo Certificado
        </a>
        <a href="{{ route('admin.pacientes.index') }}" class="btn btn-pastel-gray shadow-sm ml-2">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 CARD INFORMATIVA DEL PACIENTE (Estilo Resumen) --}}
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
                <div class="col-md-2 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación</small>
                    <span class="h6 font-weight-bold">{{ $paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-2 border-right text-center">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Edad</small>
                    <span class="badge badge-pill bg-pastel-purple px-3">
                        {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age }} años
                    </span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Contacto</small>
                    <span class="text-dark"><i class="fas fa-phone-alt fa-xs mr-1"></i> {{ $paciente->telefono ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 TABLA DE CERTIFICADOS --}}
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-list-ul mr-2"></i>Historial de Certificados
            </h5>
            <span class="badge badge-pastel-purple px-3 py-2">{{ $certificados->count() }} Registros</span>
        </div>
        
        <div class="card-body p-0">
            @if($certificados->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light text-muted">
                            <tr class="text-uppercase small">
                                <th class="pl-4">ID</th>
                                <th>Empresa</th>
                                <th>Doctor</th>
                                <th>Tipo / Aptitud</th>
                                <th>Fecha Emisión</th>
                                <th class="text-center pr-4">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificados as $certificado)
                            <tr>
                                <td class="pl-4 align-middle font-weight-bold">#{{ $certificado->id }}</td>
                                <td class="align-middle">
                                    <div class="d-flex flex-column">
                                        <span class="text-dark font-weight-bold">{{ strtoupper($certificado->empresa->nombre ?? 'N/A') }}</span>
                                        <small class="text-muted">{{ $certificado->puesto ?? 'Puesto no definido' }}</small>
                                    </div>
                                </td>
                                <td class="align-middle text-muted">
                                    DR. {{ strtoupper($certificado->doctor->primer_nombre ?? '') }} {{ strtoupper($certificado->doctor->primer_apellido ?? '') }}
                                </td>
                                <td class="align-middle">
                                    <span class="badge badge-pastel-blue text-uppercase mr-1">{{ $certificado->tipo }}</span>
                                    @php
                                        $aptitudClass = [
                                            'apto' => 'success',
                                            'no apto' => 'danger',
                                            'apto en observacion' => 'warning'
                                        ][$certificado->aptitud] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-{{ $aptitudClass }}">{{ ucfirst($certificado->aptitud) }}</span>
                                </td>
                                <td class="align-middle font-weight-500">
                                    {{ $certificado->fecha_emision ? $certificado->fecha_emision->format('d/m/Y') : '—' }}
                                </td>
                                <td class="align-middle text-center pr-4">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('admin.certificados.show', $certificado) }}" class="btn btn-sm btn-light border" title="Ver"><i class="fas fa-eye text-info"></i></a>
                                        <a href="{{ route('admin.certificados.edit', $certificado) }}" class="btn btn-sm btn-light border" title="Editar"><i class="fas fa-edit text-warning"></i></a>
                                        <a href="{{ route('admin.certificados.pdf', $certificado) }}" target="_blank" class="btn btn-sm btn-light border" title="PDF"><i class="fas fa-file-pdf text-danger"></i></a>
                                        <button type="button" class="btn btn-sm btn-light border btn-delete" data-id="{{ $certificado->id }}" title="Eliminar">
                                            <i class="fas fa-trash-alt text-muted"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('admin.certificados.destroy', $certificado) }}" method="POST" id="delete-form-{{ $certificado->id }}" class="d-none">
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
                    <img src="https://cdn-icons-png.flaticon.com/512/6598/6598519.png" alt="Sin datos" style="width: 120px; opacity: 0.5">
                    <h5 class="mt-3 text-muted">No se encontraron certificados</h5>
                    <p class="text-muted small">Comience creando un nuevo registro para este paciente.</p>
                </div>
            @endif
        </div>
        
        @if($certificados->hasPages())
        <div class="card-footer bg-white">
            {{ $certificados->links() }}
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
        --pastel-green: #B6E2D3;
        --pastel-gray: #E3E3E3;
        --pastel-light: #F9F7F7;
    }

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white !important; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .text-pastel-purple { color: #9b86d6 !important; }

    .btn-pastel-blue { background-color: var(--pastel-blue); border: none; color: #444; font-weight: 600; border-radius: 8px; }
    .btn-pastel-blue:hover { background-color: #96c7d9; color: #222; transform: translateY(-1px); }
    .btn-pastel-gray { background-color: var(--pastel-gray); border: none; color: #666; font-weight: 600; border-radius: 8px; }

    .badge-pastel-blue { background-color: #e1f2f9; color: #4a90a4; }
    .badge-pastel-purple { background-color: #f0ebff; color: #8e7cc3; }

    .table thead th { border-top: none; border-bottom: 2px solid #f4f4f4; }
    .table td { vertical-align: middle; border-top: 1px solid #f9f9f9; }
    
    /* Personalización SweetAlert2 */
    .swal2-popup-custom { border-radius: 15px !important; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Alerta de Eliminación
        $('.btn-delete').on('click', function() {
            const id = $(this).data('id');
            
            Swal.fire({
                title: '¿Estás seguro?',
                text: "El certificado #" + id + " será eliminado permanentemente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#CAB8FF', // Pastel Purple
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                customClass: { popup: 'swal2-popup-custom' },
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });

        // Alerta de Éxito (Si existe sesión)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Logrado!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2500,
                customClass: { popup: 'swal2-popup-custom' }
            });
        @endif
    });
</script>
@stop