<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado de Inmunización #{{ $inmunizacion->id }}</title>
    <style>
        @page { margin: 1.5cm 1cm; }
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.4; font-size: 11px; }
        
        /* Colores Estilo Pastel */
        .bg-blue { background-color: #A8D8EA; }
        .bg-purple { background-color: #CAB8FF; }
        .text-purple { color: #6f42c1; }
        
        /* Encabezado */
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        .title { color: #6f42c1; font-size: 22px; font-weight: bold; text-transform: uppercase; margin: 0; }
        .subtitle { font-size: 10px; color: #666; text-transform: uppercase; letter-spacing: 1px; }
        
        .id-box { background: #f8f9fa; padding: 10px; border: 1px solid #dee2e6; border-radius: 8px; text-align: center; }
        .id-label { font-size: 9px; color: #999; text-transform: uppercase; font-weight: bold; }
        .id-number { font-size: 16px; color: #d9534f; font-weight: bold; }

        /* Secciones */
        .section-title { 
            padding: 6px 12px; 
            font-weight: bold; 
            border-radius: 4px; 
            margin-bottom: 12px;
            font-size: 12px;
            text-transform: uppercase;
        }

        /* Tablas de Datos */
        .data-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .data-table td { padding: 6px 10px; border-bottom: 1px solid #f2f2f2; vertical-align: top; }
        .label { font-size: 9px; font-weight: bold; color: #777; text-transform: uppercase; display: block; }
        .value { font-size: 11px; font-weight: bold; color: #333; }

        /* Tabla de Vacunas (La más importante) */
        .vacunas-table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        .vacunas-table th { 
            background-color: #CAB8FF; 
            color: white; 
            padding: 10px 6px; 
            text-align: left; 
            font-size: 10px;
            text-transform: uppercase;
            border: 1px solid #b8a6f0;
        }
        .vacunas-table td { 
            padding: 8px 6px; 
            border: 1px solid #eee; 
            font-size: 10px; 
            vertical-align: top;
            word-wrap: break-word;
        }
        .info-secundaria { font-size: 9px; color: #666; margin-top: 4px; line-height: 1.2; }
        .tag-esquema { font-weight: bold; color: #28a745; font-size: 8px; }

        /* Firmas */
        .signature-section { margin-top: 60px; width: 100%; }
        .signature-box { width: 45%; border-top: 1px solid #333; text-align: center; padding-top: 8px; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 9px; color: #aaa; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td style="width: 75%;">
                <h1 class="title">Certificado de Inmunización</h1>
                <div class="subtitle">Departamento de Salud Ocupacional</div>
            </td>
            <td style="width: 25%;">
                <div class="id-box">
                    <span class="id-label">Certificado No.</span><br>
                    <span class="id-number">{{ str_pad($inmunizacion->id, 6, '0', STR_PAD_LEFT) }}</span>
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title bg-blue">1. Datos del Paciente y Empresa</div>
    <table class="data-table">
        <tr>
            <td style="width: 50%;">
                <span class="label">Apellidos y Nombres:</span>
                <span class="value">{{ $inmunizacion->paciente->primer_nombre }} {{ $inmunizacion->paciente->primer_apellido }} {{ $inmunizacion->paciente->segundo_apellido }}</span>
            </td>
            <td style="width: 50%;">
                <span class="label">Identificación (C.I.):</span>
                <span class="value">{{ $inmunizacion->paciente->cedula_identidad }}</span>
            </td>
        </tr>
        <tr>
            <td>
                <span class="label">Empresa Solicitante:</span>
                <span class="value text-purple">{{ $inmunizacion->empresa->nombre }}</span>
            </td>
            <td>
                <span class="label">Fecha de Registro:</span>
                <span class="value">{{ $inmunizacion->created_at->format('d/m/Y') }}</span>
            </td>
        </tr>
    </table>

    <div class="section-title bg-purple" style="color: white;">2. Registro Técnico de Vacunación</div>
    <table class="vacunas-table">
        <thead>
            <tr>
                <th style="width: 30%;">Vacuna / Biológico</th>
                <th style="width: 10%;">Dosis</th>
                <th style="width: 15%;">Lote / Fecha</th>
                <th style="width: 25%;">Establecimiento / Responsable</th>
                <th style="width: 20%;">Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($inmunizacion->detalles as $detalle)
            <tr>
                <td>
                    <div class="value" style="text-transform: uppercase;">{{ $detalle->vacuna }}</div>
                    @if($detalle->esquema_completo)
                        <span class="tag-esquema">✓ ESQUEMA COMPLETO</span>
                    @endif
                </td>
                <td style="text-align: center;" class="value">{{ $detalle->dosis }}</td>
                <td>
                    <span class="label">Lote:</span> {{ $detalle->lote ?? 'S/L' }}<br>
                    <span class="label">Fecha:</span> {{ \Carbon\Carbon::parse($detalle->fecha)->format('d/m/Y') }}
                </td>
                <td>
                    <div class="info-secundaria">
                        <strong>Lugar:</strong> {{ $detalle->establecimiento_salud ?? 'N/R' }}<br>
                        <strong>Resp:</strong> {{ $detalle->responsable_vacunacion ?? 'N/R' }}
                    </div>
                </td>
                <td style="font-size: 9px; color: #555;">
                    {{ $detalle->observaciones ?? '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($inmunizacion->observaciones_generales)
    <div style="margin-top: 15px;">
        <span class="label">Observaciones Médicas Generales:</span>
        <div style="background: #fdfdfd; padding: 10px; border: 1px solid #eee; border-radius: 4px; font-size: 10px; margin-top: 5px;">
            {{ $inmunizacion->observaciones_generales }}
        </div>
    </div>
    @endif

    <table class="signature-section">
        <tr>
            <td class="signature-box">
                <span class="value">DR(A). {{ $inmunizacion->doctor->primer_nombre }} {{ $inmunizacion->doctor->primer_apellido }}</span><br>
                <span class="label">Firma Médico Responsable</span>
            </td>
            <td style="width: 10%;"></td>
            <td class="signature-box">
                <span class="value">{{ $inmunizacion->paciente->primer_nombre }} {{ $inmunizacion->paciente->primer_apellido }}</span><br>
                <span class="label">Firma del Paciente</span>
            </td>
        </tr>
    </table>

    <div style="text-align: right; margin-top: 30px; font-size: 10px;">
        Quito, {{ now()->format('d') }} de {{ now()->translatedFormat('F') }} del {{ now()->format('Y') }}
    </div>

    <div class="footer">
        Este certificado es un documento médico legal. Cualquier alteración anula su validez. <br>
        Generado por: {{ auth()->user()->name ?? 'Sistema' }} | Fecha y hora: {{ now()->format('d/m/Y H:i') }}
    </div>

</body>
</html>