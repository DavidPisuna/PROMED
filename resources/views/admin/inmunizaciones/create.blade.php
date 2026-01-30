@extends('adminlte::page')

@section('title', 'Registro de Inmunizaciones')

@section('content_header')
<div class="d-flex justify-content-between align-items-center flex-wrap">
    <h1 class="text-pastel-purple font-weight-bold">
        <i class="fas fa-syringe mr-2"></i>Nueva Inmunización
    </h1>
    <a href="{{ route('admin.inmunizaciones.byPaciente', $paciente->id) }}"
        class="btn btn-pastel-gray shadow-sm">
        <i class="fas fa-arrow-left mr-1"></i> Volver a la lista
    </a>
</div>
@stop

@section('content')
<div class="container-fluid pb-4">
    {{-- 🔹 RESUMEN DEL PACIENTE --}}
    <div class="card card-pastel shadow-sm mb-4">
        <div class="card-header bg-pastel-blue py-2">
            <h6 class="mb-0 font-weight-bold text-white"><i class="fas fa-user-circle mr-2"></i>Paciente Seleccionado</h6>
        </div>
        <div class="card-body bg-light-soft py-3">
            <div class="row align-items-center">
                <div class="col-md-5 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Nombre Completo</small>
                    <span class="h6 font-weight-bold text-dark">
                        {{ strtoupper($paciente->primer_nombre) }} {{ strtoupper($paciente->segundo_nombre) }} 
                        {{ strtoupper($paciente->primer_apellido) }} {{ strtoupper($paciente->segundo_apellido) }}
                    </span>
                </div>
                <div class="col-md-3 border-right">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Cédula</small>
                    <span class="h6 font-weight-bold">{{ $paciente->cedula_identidad }}</span>
                </div>
                <div class="col-md-4">
                    <small class="text-muted d-block text-uppercase font-weight-bold">Empresa asignada</small>
                    <span class="text-dark font-weight-500">{{ strtoupper($paciente->sucursal->nombre ?? 'SIN SUCURSAL') }}</span>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.inmunizaciones.store') }}" method="POST" id="inmunizacionForm">
        @csrf
        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

        {{-- 🔹 SECCIÓN 1: CABECERA --}}
        <div class="card card-pastel shadow-sm mb-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                    <i class="fas fa-hospital-user mr-2"></i>Información General
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Empresa Solicitante <span class="text-danger">*</span></label>
                            <select name="empresa_id" class="form-control form-control-pastel select2" required>
                                <option value="">-- SELECCIONE --</option>
                                @foreach($empresas as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                                        {{ strtoupper($empresa->nombre) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Médico Responsable <span class="text-danger">*</span></label>
                            <select name="doctor_id" class="form-control form-control-pastel" required>
                                <option value="">-- SELECCIONE --</option>
                                @foreach($doctores as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        DR(A). {{ strtoupper($doctor->primer_nombre) }} {{ strtoupper($doctor->primer_apellido) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">Observaciones Generales</label>
                            <textarea name="observaciones_generales" rows="1" class="form-control form-control-pastel text-uppercase">{{ old('observaciones_generales') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 🔹 SECCIÓN 2: DETALLES DE VACUNAS --}}
        <div class="card card-pastel shadow-lg">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 font-weight-bold text-pastel-blue">
                    <i class="fas fa-list-ol mr-2"></i>Registro de Vacunas Aplicadas
                </h5>
                <button type="button" id="btnAddVacuna" class="btn btn-sm btn-success shadow-sm rounded-pill px-3">
                    <i class="fas fa-plus mr-1"></i> AÑADIR VACUNA
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="tablaVacunas">
                        <thead class="bg-light">
                            <tr>
                                <th style="width: 200px;">Vacuna <span class="text-danger">*</span></th>
                                <th style="width: 130px;">Dosis <span class="text-danger">*</span></th>
                                <th style="width: 150px;">Fecha</th>
                                <th style="width: 120px;">Lote</th>
                                <th>Responsable/Establecimiento</th>
                                <th class="text-center">Esquema</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="vacunasContainer">
                            <tr class="vacuna-row">
                                <td>
                                    <input type="text" name="vacunas[0][vacuna]" class="form-control form-control-sm text-uppercase" required placeholder="Ej: HEPATITIS B">
                                </td>
                                <td>
                                    <select name="vacunas[0][dosis]" class="form-control form-control-sm" required>
                                        <option value="1° DOSIS">1° DOSIS</option>
                                        <option value="2° DOSIS">2° DOSIS</option>
                                        <option value="3° DOSIS">3° DOSIS</option>
                                        <option value="REFUERZO">REFUERZO</option>
                                        <option value="ÚNICA">ÚNICA</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="date" name="vacunas[0][fecha]" class="form-control form-control-sm" value="{{ date('Y-m-d') }}">
                                </td>
                                <td>
                                    <input type="text" name="vacunas[0][lote]" class="form-control form-control-sm text-uppercase" placeholder="Lote">
                                </td>
                                <td>
                                    <input type="text" name="vacunas[0][establecimiento_salud]" class="form-control form-control-sm text-uppercase mb-1" placeholder="Establecimiento">
                                    <input type="text" name="vacunas[0][responsable_vacunacion]" class="form-control form-control-sm text-uppercase" placeholder="Responsable">
                                </td>
                                <td class="text-center">
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input type="checkbox" name="vacunas[0][esquema_completo]" value="1" class="custom-control-input" id="esquema0">
                                        <label class="custom-control-label font-weight-normal" for="esquema0">Completo</label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm border-0 btn-remove" disabled>
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white d-flex justify-content-end py-3">
                <button type="button" id="btnCancelar" class="btn btn-pastel-gray mr-2 px-4">CANCELAR</button>
                <button type="submit" class="btn btn-pastel-blue px-5 shadow-sm">
                    <i class="fas fa-save mr-2"></i>GUARDAR INMUNIZACIONES
                </button>
            </div>
        </div>
    </form>
</div>
@stop

@section('css')
<style>
    :root { --pastel-blue: #A8D8EA; --pastel-purple: #CAB8FF; --pastel-gray: #E3E3E3; }
    .card-pastel { border: none; border-radius: 12px; }
    .bg-pastel-blue { background-color: var(--pastel-blue) !important; }
    .bg-light-soft { background-color: #fafafa; }
    .text-pastel-purple { color: #8e7cc3 !important; }
    .text-pastel-blue { color: #5fa8c3 !important; }
    
    .form-control-pastel { border-radius: 8px; border: 1.5px solid #dce4ec; transition: all 0.3s ease; }
    .form-control-pastel:focus { border-color: var(--pastel-blue); box-shadow: 0 0 8px rgba(168, 216, 234, 0.4); }

    .btn-pastel-blue { background: var(--pastel-blue); border: none; border-radius: 8px; font-weight: bold; color: #2c3e50; }
    .btn-pastel-blue:hover { background: #91c9de; transform: translateY(-1px); }
    .btn-pastel-gray { background: var(--pastel-gray); border: none; border-radius: 8px; font-weight: bold; color: #555; }
    
    #tablaVacunas thead th { font-size: 0.85rem; text-transform: uppercase; color: #666; border-top: none; }
    .vacuna-row td { vertical-align: middle; padding: 12px 8px; }
</style>
@stop

@section('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        let rowCount = 1;

        // 1. Agregar Fila Dinámica
        $('#btnAddVacuna').on('click', function() {
            let newRow = `
            <tr class="vacuna-row">
                <td><input type="text" name="vacunas[${rowCount}][vacuna]" class="form-control form-control-sm text-uppercase" required placeholder="Vacuna"></td>
                <td>
                    <select name="vacunas[${rowCount}][dosis]" class="form-control form-control-sm" required>
                        <option value="1° DOSIS">1° DOSIS</option>
                        <option value="2° DOSIS">2° DOSIS</option>
                        <option value="3° DOSIS">3° DOSIS</option>
                        <option value="REFUERZO">REFUERZO</option>
                        <option value="ÚNICA">ÚNICA</option>
                    </select>
                </td>
                <td><input type="date" name="vacunas[${rowCount}][fecha]" class="form-control form-control-sm" value="{{ date('Y-m-d') }}"></td>
                <td><input type="text" name="vacunas[${rowCount}][lote]" class="form-control form-control-sm text-uppercase" placeholder="Lote"></td>
                <td>
                    <input type="text" name="vacunas[${rowCount}][establecimiento_salud]" class="form-control form-control-sm text-uppercase mb-1" placeholder="Establecimiento">
                    <input type="text" name="vacunas[${rowCount}][responsable_vacunacion]" class="form-control form-control-sm text-uppercase" placeholder="Responsable">
                </td>
                <td class="text-center">
                    <div class="custom-control custom-checkbox mt-2">
                        <input type="checkbox" name="vacunas[${rowCount}][esquema_completo]" value="1" class="custom-control-input" id="esquema${rowCount}">
                        <label class="custom-control-label font-weight-normal" for="esquema${rowCount}">Completo</label>
                    </div>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-outline-danger btn-sm border-0 btn-remove">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>`;
            $('#vacunasContainer').append(newRow);
            rowCount++;
        });

        // 2. Eliminar Fila
        $(document).on('click', '.btn-remove', function() {
            $(this).closest('tr').remove();
        });

        // 3. Mayúsculas automáticas
        $(document).on('input', 'input[type="text"], textarea', function() {
            this.value = this.value.toUpperCase();
        });

        // 4. Confirmación de Envío
        $('#inmunizacionForm').on('submit', function(e) {
            e.preventDefault();
            if (!this.checkValidity()) {
                this.reportValidity();
                return;
            }
            
            Swal.fire({
                title: '¿GUARDAR INMUNIZACIONES?',
                text: "Se registrarán todas las vacunas de la lista.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#A8D8EA',
                confirmButtonText: 'SÍ, GUARDAR',
                cancelButtonText: 'REVISAR',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) this.submit();
            });
        });

        // 5. Botón Cancelar
        $('#btnCancelar').on('click', function () {
            Swal.fire({
                title: '¿DESCARTAR?',
                text: "Se perderán los datos ingresados.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'SÍ, SALIR'
            }).then((result) => {
                if (result.isConfirmed) window.location.href = "{{ route('admin.inmunizaciones.byPaciente', $paciente) }}";
            });
        });
    });
</script>
@stop