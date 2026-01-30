@extends('app.bootstrap.template')

@section('content')
<div class="container">
    <h2 class="mb-4">Mis Reservas</h2>
    
    @if($reservas->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm bg-white rounded">
                <thead class="table-light">
                    <tr>
                        <th>Paquete</th>
                        <th>Destino</th>
                        <th>Fecha de Reserva</th>
                        <th>Precio/pp</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservas as $reserva)
                        <tr>
                            <td>
                                <a href="{{ route('vacacion.show', $reserva->vacacion_id) }}" class="fw-bold text-decoration-none">
                                    {{ $reserva->vacacion->titulo }}
                                </a>
                            </td>
                            <td>{{ $reserva->vacacion->pais }}</td>
                            <td>{{ $reserva->created_at->format('d/m/Y') }}</td>
                            <td>${{ number_format($reserva->vacacion->precio_pp, 2) }}</td>
                            <td>
                                <form action="{{ route('reserva.destroy', $reserva->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas cancelar esta reserva?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancelar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
             {{ $reservas->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">
            <h4>No tienes reservas activas.</h4>
            <p>¡Explora nuestros paquetes y encuentra tu próxima aventura!</p>
            <a href="{{ route('main') }}" class="btn btn-primary">Ver Paquetes</a>
        </div>
    @endif
</div>
@endsection
