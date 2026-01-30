<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carnet de Inmunización</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .titulo {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitulo {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .tabla th, .tabla td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        .tabla th {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .seccion {
            font-weight: bold;
            margin: 10px 0 5px;
        }

        .firma {
            margin-top: 40px;
            text-align: center;
        }

        .firma div {
            border-top: 1px solid #000;
            width: 250px;
            margin: 0 auto;
            padding-top: 5px;
        }
    </style>
</head>
<body>

{{-- ENCABEZADO --}}
<div class="titulo">
    CARNET DE INMUNIZACIÓN
</div>

<div class="subtitulo">
    {{ $inmunizacion->empresa->nombre ?? '—' }}
</div>

{{-- DATOS DEL PACIENTE --}}
<table class="tabla">
    <tr>
        <th>Paciente</th>
        <td colspan="3">
            {{ $inmunizacion->paciente->primer_apellido }}
            {{ $inmunizacion->paciente->segundo_apellido }}
            {{ $inmunizacion->paciente->primer_nombre }}
            {{ $inmunizacion->paciente->segundo_nombre }}
        </td>
    </tr>
    <tr>
        <th>Cédula</th>
        <td>{{ $inmunizacion->paciente->cedula_identidad }}</td>

        <th>Edad</th>
        <td>{{ $inmunizacion->paciente->edad }} años</td>
    </tr>
    <tr>
        <th>Sexo</th>
        <td>{{ $inmunizacion->paciente->sexo ?? '—' }}</td>

        <th>Fecha Emisión</th>
        <td>{{ now()->format('d/m/Y') }}</td>
    </tr>
</table>

{{-- TABLA DE VACUNAS --}}
<div class="seccion">REGISTRO DE VACUNACIÓN</div>

<table class="tabla">
    <thead>
        <tr>
            <th>Vacuna</th>
            <th>Dosis</th>
            <th>Fecha Aplicación</th>
            <th>Lote</th>
            <th>Profesional</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $inmunizacion->nombre_vacuna }}</td>
            <td>{{ $inmunizacion->dosis }}</td>
            <td>
                {{ $inmunizacion->fecha_aplicacion
                    ? $inmunizacion->fecha_aplicacion->format('d/m/Y')
                    : '—' }}
            </td>
            <td>{{ $inmunizacion->lote ?? '—' }}</td>
            <td>{{ $inmunizacion->doctor->nombre ?? '—' }}</td>
        </tr>
    </tbody>
</table>

{{-- OBSERVACIONES --}}
<div class="seccion">OBSERVACIONES</div>

<table class="tabla">
    <tr>
        <td style="height: 60px; text-align: left;">
            {{ $inmunizacion->observaciones ?? 'Sin observaciones' }}
        </td>
    </tr>
</table>

{{-- FIRMA --}}
<div class="firma">
    <div>
        {{ $inmunizacion->doctor->nombre ?? 'MÉDICO RESPONSABLE' }}<br>
        <small>Firma y sello</small>
    </div>
</div>

</body>
</html>
