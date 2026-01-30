@extends('app.bootstrap.template')

@section('content')
<div class="container px-4 py-5">
    <div class="border-bottom pb-2 mb-4">
        <h2 class="text-primary">Categoría: {{ $tipo->nombre }}</h2>
        <p class="text-muted">Explora nuestros paquetes de tipo {{ strtolower($tipo->nombre) }}</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 align-items-stretch g-4 py-3">
        @forelse($vacaciones as $vacacion)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                    @php
                        $bgImage = $vacacion->fotos ? asset('storage/' . $vacacion->fotos) : 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
                    @endphp
                    <div class="card-img-top" style="height: 200px; background-image: url('{{ $bgImage }}'); background-size: cover; background-position: center;"></div>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                             <span class="badge bg-primary rounded-pill">{{ $vacacion->tipo->nombre ?? 'General' }}</span>
                             <span class="text-muted small"><i class="bi bi-geo-alt"></i> {{ $vacacion->pais }}</span>
                        </div>
                        <h5 class="card-title fw-bold">{{ $vacacion->titulo }}</h5>
                        <p class="card-text text-muted text-truncate" style="max-height: 3em;">{{ $vacacion->descripcion }}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top">
                            <span class="fs-5 fw-bold text-success">${{ number_format($vacacion->precio_pp, 2) }} <small class="text-muted fs-6 fw-normal">/pp</small></span>
                            <a href="{{ route('vacacion.show', $vacacion->id) }}" class="btn btn-outline-primary rounded-pill px-4">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h3 class="text-muted">No hay paquetes en esta categoría aún.</h3>
                <a href="{{ route('main') }}" class="btn btn-outline-primary mt-3">Ver todos los paquetes</a>
            </div>
        @endforelse
    </div>

    @if($hasPagination)
        <div class="d-flex justify-content-center mt-4">
            {{ $vacaciones->links() }}
        </div>
    @endif
</div>
@endsection