@extends('app.bootstrap.template')

@section('hero')
<div class="hero-section">
    <div class="hero-content">
        <h1 class="display-3 fw-bold mb-4">Descubre Tu Próxima Aventura</h1>
        <p class="lead fs-4 mb-4 text-light opacity-75">Explora destinos exclusivos y experiencias inolvidables curadas solo para ti.</p>
        
        <form action="{{ route('main') }}" method="get" class="search-box d-flex shadow-lg">
            <input type="text" name="q" class="form-control search-input" placeholder="Buscar destino, tipo de viaje..." value="{{ $q ?? '' }}">
            <button type="submit" class="btn search-btn">BUSCAR</button>
            @foreach(request()->except(['page', 'q']) as $item => $value)
                <input type="hidden" name="{{ $item }}" value="{{ $value }}" >
            @endforeach
        </form>
    </div>
</div>
@endsection

@section('modalcontent')
<!-- Filter Modals (kept same logic, just styling tweaks if needed, mainly relying on Bootstrap) -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom-0">
        <h1 class="modal-title fs-5 font-serif">Ordenar por</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="list-group list-group-flush rounded-bottom-4">
            <a class="list-group-item list-group-item-action py-3 px-4" href="{{ route('main', array_merge(['field' => 1, 'order' => 2], request()->except('field', 'order', 'page'))) }}">Más recientes</a>
            <a class="list-group-item list-group-item-action py-3 px-4" href="{{ route('main', array_merge(['field' => 1, 'order' => 1], request()->except('field', 'order', 'page'))) }}">Más antiguos</a>
            <a class="list-group-item list-group-item-action py-3 px-4" href="{{ route('main', array_merge(['field' => 2, 'order' => 1], request()->except('field', 'order', 'page'))) }}">Precio: Menor a Mayor</a>
            <a class="list-group-item list-group-item-action py-3 px-4" href="{{ route('main', array_merge(['field' => 2, 'order' => 2], request()->except('field', 'order', 'page'))) }}">Precio: Mayor a Menor</a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="filterModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header border-bottom-0">
        <h1 class="modal-title fs-5 font-serif">Filtrar búsqueda</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <form action="{{ route('main') }}" method="get">
            <input type="hidden" name="field" value="{{ request('field') }}">
            <input type="hidden" name="order" value="{{ request('order') }}">
            <input type="hidden" name="q" value="{{ request('q') }}">
            
            <div class="mb-4">
                <label for="tipo_id" class="form-label fw-bold text-muted small text-uppercase">Tipo de Viaje</label>
                <select name="tipo_id" id="tipo_id" class="form-select form-select-lg">
                    <option value="" @if($tipo_id == null) selected @endif>Todos los tipos</option>
                    @foreach($tipos as $id => $nombre)
                        <option value="{{ $id }}" @if($id == $tipo_id) selected @endif>{{ $nombre }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-muted small text-uppercase">Rango de Precio</label>
                <div class="d-flex text-muted small mb-2 justify-content-between">
                    <span>Min $</span><span>Max $</span>
                </div>
                <div class="input-group">
                    <input type="number" class="form-control" name="desde" value="{{ $desde }}" placeholder="0">
                    <span class="input-group-text bg-white border-start-0 border-end-0 text-muted">-</span>
                    <input type="number" class="form-control" name="hasta" value="{{ $hasta }}" placeholder="Max">
                </div>
            </div>
            
            <div class="d-grid">
                <input type="submit" class="btn btn-primary btn-lg" value="Ver Resultados">
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="h3 mb-0">Destinos Destacados</h2>
        <p class="text-muted mb-0">Seleccionados cuidadosamente para ti</p>
    </div>
    <div class="btn-group">
        <button class="btn btn-outline-secondary rounded-pill px-3 me-2" data-bs-toggle="modal" data-bs-target="#orderModal">
            <i class="bi bi-sort-down me-1"></i> Ordenar
        </button>
        <button class="btn btn-outline-secondary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#filterModal">
            <i class="bi bi-sliders me-1"></i> Filtrar
        </button>
    </div>
</div>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @forelse($vacaciones as $vacacion)
        <div class="col">
            <div class="card card-vacacion h-100">
                @php
                    $bgImage = $vacacion->fotos ? asset('storage/' . $vacacion->fotos) : 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80';
                @endphp
                <div style="position: relative;">
                    <img src="{{ $bgImage }}" class="card-img-top" alt="{{ $vacacion->titulo }}">
                    <span class="badge badge-custom position-absolute top-0 end-0 m-3 rounded-pill text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                        {{ $vacacion->tipo->nombre ?? 'Viaje' }}
                    </span>
                </div>
                
                <div class="card-body p-4 d-flex flex-column">
                    <div class="mb-2 text-gold small fw-bold text-uppercase">
                        <i class="bi bi-geo-alt-fill me-1"></i> {{ $vacacion->pais }}
                    </div>
                    <h5 class="card-title fw-bold mb-3">{{ $vacacion->titulo }}</h5>
                    <p class="card-text text-muted small line-clamp-3 mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $vacacion->descripcion }}
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-end pt-3 border-top border-light">
                        <div>
                            <span class="d-block text-muted small">Desde</span>
                            <span class="h4 fw-bold text-dark mb-0">${{ number_format($vacacion->precio_pp, 0) }}</span>
                        </div>
                        <a href="{{ route('vacacion.show', $vacacion->id) }}" class="btn btn-link text-decoration-none text-gold fw-bold p-0 stretched-link">
                            Explorar <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="py-5">
                <i class="bi bi-search display-1 text-light mb-4"></i>
                <h3 class="text-muted">No encontramos lo que buscas.</h3>
                <p class="text-muted">Prueba a ajustar tus filtros de búsqueda.</p>
                <a href="{{ route('main') }}" class="btn btn-outline-primary mt-3">Ver todos los paquetes</a>
            </div>
        </div>
    @endforelse
</div>

@if($hasPagination)
    <div class="d-flex justify-content-center mt-5">
        {{ $vacaciones->onEachSide(1)->links() }}
    </div>
@endif

@endsection

@section('styles')
<style>
    /* Pagination Customization */
    .pagination .page-link {
        color: var(--primary-color);
        border: none;
        margin: 0 5px;
        border-radius: 5px;
    }
    .pagination .active .page-link {
        background-color: var(--secondary-color);
        color: white;
    }
</style>
@endsection