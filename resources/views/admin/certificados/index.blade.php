@extends('adminlte::page')

@section('title', 'Lista de Certificados')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-file-medical mr-2"></i>Listado de Certificados Médicos
    </h1>
    {{-- Nota: El botón de crear usualmente se accede desde la ficha del paciente, 
         pero si tienes una ruta general, puedes activarla aquí --}}
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    <div class="card card-pastel shadow-lg">
        <div class="card-header bg-white border-bottom">
            <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                <i class="fas fa-list-ul mr-2"></i>Registros Generados
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tablaCertificados">
                    <thead>
                        <tr class="text-muted">
                            <th class="border-top-0">PACIENTE</th>
                            <th class="border-top-0">EMPRESA</th>
                            <th class="border-top-0">TIPO</th>
                            <th class="border-top-0">FECHA EMISIÓN</th>
                            <th class="border-top-0 text-center">APTITUD</th>
                            <th class="border-top-0 text-center">ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($certificados as $certificado)
                        <tr>
                            <td class="align-middle">
                                <div class="d-flex flex-column">
                                    <span class="font-weight-bold text-dark">{{ strtoupper($certificado->paciente->primer_nombre) }} {{ strtoupper($certificado->paciente->primer_apellido) }}</span>
                                    <small class="text-muted"><i class="fas fa-id-card mr-1"></i>{{ $certificado->paciente->cedula_identidad }}</small>
                                </div>
                            </td>
                            <td class="align-middle text-uppercase">
                                {{ $certificado->empresa->nombre }}
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-pastel-gray text-dark px-2 py-1">
                                    {{ strtoupper($certificado->tipo) }}
                                </span>
                            </td>
                            <td class="align-middle">
                                {{ $certificado->fecha_emision ? \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="align-middle text-center">
                                @php
                                    $badgeClass = match($certificado->aptitud) {
                                        'apto' => 'bg-pastel-green',
                                        'no apto' => 'bg-danger text-white',
                                        default => 'bg-pastel-purple text-white'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} px-3 py-1 shadow-sm">
                                    {{ strtoupper($certificado->aptitud) }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <div class="btn-group shadow-sm" role="group">
                                    <a href="{{ route('admin.certificados.show', $certificado->id) }}" class="btn btn-sm btn-outline-info" title="Ver Detalle">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.certificados.pdf', $certificado->id) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Descargar PDF">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('admin.certificados.edit', $certificado->id) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.certificados.destroy', $certificado->id) }}" method="POST" class="d-inline form-eliminar">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-pastel-red" title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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
        --pastel-blue: #A8D8EA;
        --pastel-purple: #CAB8FF;
        --pastel-green: #B6E2D3;
        --pastel-gray: #f0f0f0;
        --pastel-red: #ffb3b3;
    }

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; }
    .bg-pastel-green { background-color: var(--pastel-green) !important; color: #2d5a27; }
    .bg-pastel-gray { background-color: var(--pastel-gray) !important; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .text-pastel-blue { color: #6fb9d6 !important; }

    .table thead th {
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        border-bottom: 2px solid var(--pastel-gray);
    }

    .btn-outline-pastel-red {
        color: #ff6b6b;
        border-color: #ffb3b3;
    }

    .btn-outline-pastel-red:hover {
        background-color: #ffb3b3;
        color: white;
    }

    .btn-group .btn {
        border-width: 1.5px;
        margin: 0 1px;
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Inicializar DataTable (opcional pero recomendado)
        $('#tablaCertificados').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json" },
            "order": [[3, "desc"]] // Ordenar por fecha por defecto
        });

        // Confirmación de eliminación
        $('.form-eliminar').submit(function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿ESTÁS SEGURO?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ffb3b3',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'SÍ, ELIMINAR',
                cancelButtonText: 'CANCELAR',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });

        // Mostrar alerta de éxito de Laravel
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡ÉXITO!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@stop