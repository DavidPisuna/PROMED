@extends('adminlte::page')

@section('title', 'Detalle del Certificado')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-file-medical mr-2"></i>Detalle del Certificado
    </h1>
    <div>
        <a href="{{ route('admin.certificados.pdf', $certificado) }}" class="btn btn-danger shadow-sm mr-2">
            <i class="fas fa-file-pdf mr-1"></i> Exportar PDF
        </a>
        <a href="{{ route('admin.certificados.edit', $certificado) }}" class="btn btn-warning shadow-sm mr-2">
            <i class="fas fa-edit mr-1"></i> Editar
        </a>
        <a href="{{ route('admin.certificados.byPaciente', $certificado->paciente_id) }}"
            class="btn btn-pastel-gray shadow-sm">
            <i class="fas fa-arrow-left mr-1"></i> Volver
        </a>

    </div>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">

    {{-- 🔹 CARD PRINCIPAL: INFORMACIÓN DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-circle mr-2"></i>Datos del Paciente</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-5 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($certificado->paciente->primer_nombre) }} {{ strtoupper($certificado->paciente->primer_apellido) }}
                    </span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Identificación</small>
                    <span class="h6 font-weight-bold">{{ $certificado->paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Puesto Evaluado</small>
                    <span class="text-dark font-weight-bold text-uppercase">{{ $certificado->puesto ?? 'NO ESPECIFICADO' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Columna Izquierda: Detalles del Certificado --}}
        <div class="col-md-7">
            <div class="card card-pastel shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                        <i class="fas fa-clipboard-check mr-2"></i>Evaluación Médica
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <label class="text-muted small font-weight-bold">TIPO DE EVALUACIÓN</label>
                            <div class="h5"><span class="badge bg-pastel-purple px-3">{{ $certificado->tipo }}</span></div>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small font-weight-bold">FECHA EMISIÓN</label>
                            <p class="font-weight-bold">{{ optional($certificado->fecha_emision)->format('d/m/Y') ?? '—' }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold"><i class="fas fa-stethoscope mr-2 text-info"></i>Aptitud Médica</label>
                        <div class="p-3 rounded border bg-light">
                            <span class="badge badge-warning text-uppercase mb-2">{{ $certificado->aptitud }}</span>
                            <p class="mb-0 text-muted">{{ $certificado->observa_aptitud ?? 'Sin observaciones de aptitud.' }}</p>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <label class="font-weight-bold"><i class="fas fa-notes-medical mr-2 text-danger"></i>Recomendaciones</label>
                        <div class="p-3 rounded border">
                            <strong class="small text-uppercase">Descripción:</strong>
                            <p>{{ $certificado->descripcion_reco ?? 'N/A' }}</p>
                            <hr>
                            <strong class="small text-uppercase">Observaciones adicionales:</strong>
                            <p class="mb-0">{{ $certificado->observa_reco ?? 'Sin observaciones adicionales.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Empresa y Doctor --}}
        <div class="col-md-5">
            <div class="card card-pastel shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="mb-0 font-weight-bold"><i class="fas fa-building mr-2 text-primary"></i>Entidad y Profesional</h6>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="text-muted small font-weight-bold">EMPRESA / RAZÓN SOCIAL</label>
                        <p class="text-uppercase font-weight-bold text-primary">{{ $certificado->empresa->razon_social }}</p>
                    </div>
                    <hr>
                    <div>
                        <label class="text-muted small font-weight-bold">MÉDICO EVALUADOR</label>
                        <div class="d-flex align-items-center">
                            <div class="mr-3">
                                <i class="fas fa-user-md fa-3x text-pastel-blue"></i>
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-0">DR. {{ strtoupper($certificado->doctor->primer_nombre) }} {{ strtoupper($certificado->doctor->primer_apellido) }}</h6>
                                <small class="text-muted">{{ $certificado->doctor->especialidad ?? 'MEDICINA DEL TRABAJO' }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="btnEliminar" class="btn btn-outline-danger btn-block shadow-sm">
                <i class="fas fa-trash-alt mr-2"></i>ANULAR CERTIFICADO
            </button>
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
        --pastel-gray: #E3E3E3;
    }

    .card-pastel { border: none; border-radius: 12px; overflow: hidden; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-pastel-purple { background-color: var(--pastel-purple) !important; color: white; }
    .bg-light-soft { background-color: #fcfcfc; }
    .text-pastel-blue { color: #6fb9d6 !important; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    .btn-pastel-gray:hover { background: #d4d4d4; }

    .border-right { border-right: 1px solid #dee2e6 !important; }

    @media (max-width: 768px) {
        .border-right { border-right: none !important; border-bottom: 1px solid #dee2e6 !important; margin-bottom: 10px; padding-bottom: 10px; }
    }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Ejemplo de uso de SweetAlert para una acción de eliminación
        $('#btnEliminar').on('click', function() {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción no se puede revertir y anulará el certificado.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#E3E3E3',
                confirmButtonText: 'Sí, anular',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Anulado', 'El certificado ha sido marcado como nulo.', 'success');
                }
            });
        });

        // Notificación de éxito si vienes de un guardado (opcional)
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Logrado!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@stop