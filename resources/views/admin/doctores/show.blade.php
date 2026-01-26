@extends('adminlte::page')

@section('title', 'Detalle Doctor')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1 class="text-primary"><i class="fas fa-user-md"></i> Detalle Doctor</h1>
    <a href="{{ route('admin.doctores.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
@stop

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3"><strong>Nombre Completo:</strong> {{ $doctor->nombre_completo }}</div>
            <div class="col-md-6 mb-3"><strong>Especialidad:</strong> {{ $doctor->especialidad }}</div>
            <div class="col-md-6 mb-3"><strong>Número Licencia:</strong> {{ $doctor->numero_licencia }}</div>
            <div class="col-md-6 mb-3"><strong>Teléfono:</strong> {{ $doctor->telefono ?? '-' }}</div>
            <div class="col-md-6 mb-3"><strong>Email:</strong> {{ $doctor->email ?? '-' }}</div>
            <div class="col-md-6 mb-3"><strong>Dirección:</strong> {{ $doctor->direccion ?? '-' }}</div>
            <div class="col-md-6 mb-3">
                <strong>Estado:</strong>
                <span class="badge {{ $doctor->activo ? 'badge-success' : 'badge-danger' }}">
                    {{ $doctor->activo ? 'Activo' : 'Inactivo' }}
                </span>
            </div>
        </div>
    </div>
</div>
@stop