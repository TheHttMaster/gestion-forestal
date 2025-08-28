<x-app-layout>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Gestión de Áreas Geográficas</h1>
                <a href="{{ route('areas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva Área
                </a>
            </div>

            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('areas.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Buscar..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="tipo" class="form-control">
                                    <option value="">Todos los tipos</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{ $tipo }}" {{ request('tipo') == $tipo ? 'selected' : '' }}>
                                            {{ ucfirst($tipo) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="activo" class="form-control">
                                    <option value="">Todos</option>
                                    <option value="1" {{ request('activo') == '1' ? 'selected' : '' }}>Activas</option>
                                    <option value="0" {{ request('activo') == '0' ? 'selected' : '' }}>Inactivas</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-filter"></i> Filtrar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabla de áreas -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Código</th>
                                    <th>Tipo</th>
                                    <th>Área Padre</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($areas as $area)
                                <tr>
                                    <td>{{ $area->nombre }}</td>
                                    <td>{{ $area->codigo }}</td>
                                    <td>
                                        <span class="badge bg-secondary">{{ ucfirst($area->tipo) }}</span>
                                    </td>
                                    <td>{{ $area->padre->nombre ?? '-' }}</td>
                                    <td>
                                        <span class="badge {{ $area->activo ? 'bg-success' : 'bg-danger' }}">
                                            {{ $area->activo ? 'Activa' : 'Inactiva' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('areas.edit', $area) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm {{ $area->activo ? 'btn-danger' : 'btn-success' }} toggle-status"
                                                    data-url="{{ route('areas.toggle-status', $area) }}">
                                                <i class="fas {{ $area->activo ? 'fa-times' : 'fa-check' }}"></i>
                                            </button>
                                            <form action="{{ route('areas.destroy', $area) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
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
                    
                    <!-- Paginación -->
                    <div class="d-flex justify-content-center">
                        {{ $areas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle status
    $('.toggle-status').click(function() {
        const url = $(this).data('url');
        const button = $(this);
        
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    // Recargar la página para ver los cambios
                    location.reload();
                } else {
                    alert(response.message);
                }
            }
        });
    });

    // Eliminar área
    $('.delete-form').submit(function(e) {
        e.preventDefault();
        
        if (confirm('¿Está seguro de eliminar esta área?')) {
            const form = $(this);
            
            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
});
</script>
@endpush