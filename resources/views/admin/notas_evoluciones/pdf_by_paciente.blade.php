<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Notas de Evolución</title>

<style>
    body {
        font-family: DejaVu Sans;
        font-size: 11px;
    }

    .titulo {
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 10px;
    }

    .datos-paciente {
        border: 1px solid #000;
        padding: 8px;
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #000;
        padding: 6px;
        vertical-align: top;
    }

    th {
        background-color: #f0f0f0;
        text-align: center;
    }

    .firma {
        margin-top: 40px;
        text-align: center;
    }
</style>
</head>

<body>

<div class="titulo">
    NOTAS DE EVOLUCIÓN – DEPARTAMENTO MÉDICO
</div>

{{-- DATOS PACIENTE --}}
<div class="datos-paciente">
    <strong>Paciente:</strong>
    {{ $paciente->primer_apellido }} {{ $paciente->segundo_apellido }}
    {{ $paciente->primer_nombre }} {{ $paciente->segundo_nombre }}
    <br>

    <strong>Cédula:</strong> {{ $paciente->cedula_identidad }} &nbsp;&nbsp;
    <strong>Sexo:</strong> {{ $paciente->sexo ?? 'N/A' }} &nbsp;&nbsp;

    <strong>Edad:</strong>
    {{ $paciente->fecha_nacimiento
        ? \Carbon\Carbon::parse($paciente->fecha_nacimiento)->age . ' años'
        : 'N/A'
    }}
</div>

{{-- TABLA DE EVOLUCIONES --}}
<table>
    <thead>
        <tr>
            <th width="10%">Fecha</th>
            <th width="8%">Hora</th>
            <th width="22%">Problemas</th>
            <th width="40%">Evolución Clínica</th>
            <th width="20%">Médico</th>
        </tr>
    </thead>

    <tbody>
    @forelse($notas as $nota)
        <tr>
            <td align="center">{{ $nota->fecha }}</td>
            <td align="center">{{ $nota->hora }}</td>
            <td>{{ $nota->problemas }}</td>
            <td>{!! nl2br(e($nota->evolucion)) !!}</td>
            <td>
                DR(A). {{ $nota->doctor->primer_nombre }}
                {{ $nota->doctor->primer_apellido }}
                <br>
                <small>{{ $nota->empresa->nombre }}</small>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="5" align="center">
                No existen notas de evolución registradas
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<div class="firma">
    _______________________________<br>
    FIRMA Y SELLO DEL MÉDICO
</div>

</body>
</html>
