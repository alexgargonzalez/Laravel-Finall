@extends('app.bootstrap.template')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Paquetes Vacacionales</h2>
        <a href="{{ route('vacacion.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Nuevo Paquete
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover shadow-sm bg-white rounded">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>País</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vacaciones as $vacacion)
                    <tr>
                        <td>{{ $vacacion->id }}</td>
                        <td>{{ $vacacion->titulo }}</td>
                        <td>{{ $vacacion->tipo->nombre ?? 'N/A' }}</td>
                        <td>{{ $vacacion->pais }}</td>
                        <td>${{ number_format($vacacion->precio_pp, 2) }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('vacacion.show', $vacacion->id) }}" class="btn btn-sm btn-info text-white">Ver</a>
                                <a href="{{ route('vacacion.edit', $vacacion->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('vacacion.destroy', $vacacion->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este paquete?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-0 rounded-end">Borrar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        {{ $vacaciones->links() }}
    </div>
</div>
@endsection