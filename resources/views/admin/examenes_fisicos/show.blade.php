@extends('adminlte::page')

@section('title', 'Ver Exámenes Físicos')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="m-0">Exámenes Físicos - Registro #{{ $registro->id }}</h1>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Registro de Exámenes</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="accordion" id="examenesAccordion">
                    @foreach($regiones as $region => $items)
                    <div class="card">
                        <div class="card-header py-2" id="heading{{ ucfirst($region) }}">
                            <h2 class="mb-0">
                                <button class="btn btn-block text-left d-flex justify-content-between align-items-center collapsed" 
                                        type="button" 
                                        data-toggle="collapse" 
                                        data-target="#collapse{{ ucfirst($region) }}" 
                                        aria-expanded="false" 
                                        aria-controls="collapse{{ ucfirst($region) }}">
                                    <span class="font-weight-bold">
                                        <i class="fas fa-chevron-down mr-2"></i>
                                        {{ ucfirst($region) }}
                                    </span>
                                    <span class="badge badge-info">{{ count($items) }} items</span>
                                </button>
                            </h2>
                        </div>

                        <div id="collapse{{ ucfirst($region) }}" 
                             class="collapse" 
                             aria-labelledby="heading{{ ucfirst($region) }}" 
                             data-parent="#examenesAccordion">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($items as $item)
                                    @php
                                        $examen = $examenes[$region]->firstWhere('item', $item) ?? null;
                                        $valor = $examen->valor ?? 0;
                                        $observacion = $examen->observacion ?? '';
                                        $itemId = $region . '_' . $item;
                                    @endphp
                                    <div class="col-md-6 mb-3">
                                        <div class="examen-item card border">
                                            <div class="card-body py-2">
                                                <div class="d-flex align-items-start">
                                                    <div class="custom-control custom-switch mr-3">
                                                        <input type="checkbox" 
                                                               class="custom-control-input" 
                                                               id="{{ $itemId }}"
                                                               {{ $valor ? 'checked' : '' }}
                                                               disabled>
                                                        <label class="custom-control-label" for="{{ $itemId }}"></label>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <label class="font-weight-bold mb-1">
                                                            {{ ucfirst(str_replace('_', ' ', $item)) }}
                                                        </label>
                                                        @if($observacion)
                                                        <div class="observacion-container mt-2">
                                                            <textarea class="form-control form-control-sm" rows="2" readonly>{{ $observacion }}</textarea>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Resumen rápido -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Resumen Rápido</h3>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @foreach($regiones as $region => $items)
                    @php
                        $totalItems = count($items);
                        $itemsMarcados = 0;
                        foreach($items as $item) {
                            $examen = $examenes[$region]->firstWhere('item', $item) ?? null;
                            if($examen && $examen->valor) $itemsMarcados++;
                        }
                    @endphp
                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-box bg-light">
                            <span class="info-box-icon"><i class="fas fa-clipboard-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">{{ ucfirst($region) }}</span>
                                <span class="info-box-number">{{ $itemsMarcados }}/{{ $totalItems }}</span>
                                <div class="progress">
                                    <div class="progress-bar bg-info" style="width: {{ $totalItems > 0 ? ($itemsMarcados/$totalItems)*100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Expandir/contraer acordeón
    const accordionButtons = document.querySelectorAll('#examenesAccordion .card-header button');
    accordionButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const icon = btn.querySelector('i.fas');
            icon.classList.toggle('fa-chevron-down');
            icon.classList.toggle('fa-chevron-up');
        });
    });
});
</script>

<style>
.examen-item {
    transition: all 0.3s ease;
}
.examen-item:hover {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}
.info-box {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    border-radius: .25rem;
}
</style>
@stop