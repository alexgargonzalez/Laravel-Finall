@extends('app.bootstrap.template')

@section('content')

<div class="row pt-4">
    <div class="col-md-8">
        @php
            $bgImage = $vacacion->fotos ? asset('storage/' . $vacacion->fotos) : 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
        @endphp
        <img src="{{ $bgImage }}" class="img-fluid rounded mb-4 w-100" style="max-height: 500px; object-fit: cover;" alt="{{ $vacacion->titulo }}">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
             <div>
                <span class="badge bg-primary fs-6">{{ $vacacion->tipo->nombre ?? 'General' }}</span>
                <span class="text-muted ms-2"><i class="bi bi-geo-alt-fill"></i> {{ $vacacion->pais }}</span>
             </div>
             <div class="h3 text-success fw-bold">
                ${{ number_format($vacacion->precio_pp, 2) }} <small class="text-muted fs-6 mb-0"> por persona</small>
             </div>
        </div>

        <h1 class="display-4 fw-bold mb-3">{{ $vacacion->titulo }}</h1>
        <p class="lead text-muted">{{ $vacacion->descripcion }}</p>

        @auth
           <form action="{{ route('reserva.store') }}" method="POST" class="mt-4 mb-5">
                @csrf
                <input type="hidden" name="vacacion_id" value="{{ $vacacion->id }}">
                <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-ticket-perforated-fill me-2" viewBox="0 0 16 16">
                      <path d="M0 4.5A1.5 1.5 0 0 1 1.5 3h13A1.5 1.5 0 0 1 16 4.5V6a.5.5 0 0 1-.5.5 1.5 1.5 0 0 0 0 3 .5.5 0 0 1 .5.5v1.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 11.5V10a.5.5 0 0 1 .5-.5 1.5 1.5 0 1 0 0-3A.5.5 0 0 1 0 6V4.5Zm4-1v1h1v-1H4Zm1 3v-1H4v1h1Zm7 0v-1h-1v1h1Zm-1-2h1v-1h-1v1Zm-6 3H4v1h1v-1Zm7 1v-1h-1v1h1Zm-7 1H4v1h1v-1Zm7 1v-1h-1v1h1Zm-8 1v1h1v-1H4Zm8 1h1v-1h-1v1Z"/>
                    </svg> Reservar Ahora
                </button>
           </form>
        @else 
            <div class="alert alert-info mt-4">
                <a href="{{ route('login') }}" class="fw-bold">Inicia sesión</a> para reservar este viaje.
            </div>
        @endauth
        
        <hr class="my-5">
        
        <h3 class="mb-4">Comentarios y Reseñas</h3>
        @forelse($vacacion->comentarios as $comentario)
            <div class="card mb-3 border-0 shadow-sm bg-light">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="card-subtitle mb-2 text-primary fw-bold">{{ $comentario->user->name ?? 'Usuario' }}</h6>
                        <small class="text-muted">{{ $comentario->created_at->format('d/m/Y') }}</small>
                    </div>
                    <p class="card-text">{{ $comentario->texto }}</p>
                    @if(Auth::id() == $comentario->user_id)
                        <div class="text-end">
                            <form action="{{ route('comentario.destroy', $comentario->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm text-danger p-0">Eliminar</button>
                            </form>
                            <a href="{{ route('comentario.edit', $comentario->id) }}" class="btn btn-link btn-sm p-0 ms-2">Editar</a>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted fst-italic">Aún no hay comentarios. ¡Sé el primero en opinar si has viajado!</p>
        @endforelse

        @auth
            <div class="card mt-4 border-light shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Deja tu comentario</h5>
                    <form method="post" action="{{ route('comentario.store') }}">
                        @csrf
                        <input type="hidden" name="vacacion_id" value="{{ $vacacion->id }}">
                        <div class="mb-3">
                            <textarea class="form-control" id="texto" name="texto" rows="3" placeholder="Comparte tu experiencia..." required>{{ old('texto') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Publicar Comentario</button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
    
    <div class="col-md-4">
        <div class="sticky-top" style="top: 2rem;">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-center text-uppercase text-muted mb-3">Detalles</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            País
                            <span class="fw-bold">{{ $vacacion->pais }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Tipo
                            <span class="fw-bold">{{ $vacacion->tipo->nombre ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Precio
                            <span class="fw-bold text-success">${{ number_format($vacacion->precio_pp, 2) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
