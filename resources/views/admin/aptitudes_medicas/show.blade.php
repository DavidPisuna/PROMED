{{-- Aptitudes Médicas --}}
<div class="card shadow-sm mb-3">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
        <div>
            <i class="fas fa-user-md"></i> Aptitudes Médicas
        </div>
        <a href="{{ route('admin.aptitudes_medicas.create', $registro) }}" class="btn btn-sm btn-light">
            <i class="fas fa-plus"></i> Agregar Aptitud
        </a>
    </div>

    <div class="card-body">
        @if($registro->aptitudesMedicas->count())
            @foreach($registro->aptitudesMedicas as $aptitud)
                <div class="mb-4 p-3 border rounded shadow-sm">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            Aptitud: 
                            @if($aptitud->aptitud == 'apto') <span class="text-success">Apto</span>
                            @elseif($aptitud->aptitud == 'apto_observacion') <span class="text-warning">Apto con Observación</span>
                            @elseif($aptitud->aptitud == 'apto_limitaciones') <span class="text-orange">Apto con Limitaciones</span>
                            @else <span class="text-danger">No Apto</span> @endif
                        </h5>

                        <div>
                            <a href="{{ route('admin.aptitudes_medicas.edit', [$registro, $aptitud]) }}" class="btn btn-sm btn-primary me-1">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('admin.aptitudes_medicas.destroy', [$registro, $aptitud]) }}" method="POST" class="d-inline-block eliminar-aptitud">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($aptitud->observaciones)
                        <p><strong>Observaciones:</strong> {{ $aptitud->observaciones }}</p>
                    @endif

                    @if($aptitud->recomendaciones_tratamiento)
                        <p><strong>Recomendaciones / Tratamiento:</strong> {{ $aptitud->recomendaciones_tratamiento }}</p>
                    @endif

                    <p class="text-muted small mb-0">
                        Registrado: {{ $aptitud->created_at->format('d/m/Y H:i') }} |
                        Última actualización: {{ $aptitud->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            @endforeach
        @else
            <div class="text-center py-4">
                <i class="fas fa-user-md fa-2x text-muted mb-3"></i>
                <p class="text-muted">No hay aptitudes médicas registradas.</p>
                <a href="{{ route('admin.aptitudes_medicas.create', $registro) }}" class="btn btn-success mt-2">
                    <i class="fas fa-plus"></i> Registrar Primera Aptitud
                </a>
            </div>
        @endif
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Confirmación SweetAlert para eliminar aptitud
    document.querySelectorAll('.eliminar-aptitud').forEach(form => {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            Swal.fire({
                title: '¿Eliminar esta aptitud médica?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if(result.isConfirmed){
                    form.submit();
                }
            });
        });
    });
</script>
@endpush