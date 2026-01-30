@extends('app.bootstrap.template')

@section('content')
<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-4">Descubre el Mundo con <span class="text-gold">FlyPacks</span></h1>
            <p class="lead text-muted mb-4">Somos más que una agencia de viajes. Somos arquitectos de sueños, diseñando experiencias inolvidables que conectan corazones con destinos.</p>
            <p class="text-secondary">Fundada en 2026, FlyPacks nació con una misión simple: hacer que el lujo y la aventura sean accesibles para todos. Desde playas vírgenes hasta cumbres nevadas, seleccionamos personalmente cada destino para garantizar calidad, seguridad y recuerdos imborrables.</p>
            <a href="{{ route('main') }}" class="btn btn-primary btn-lg mt-3">Explora nuestros paquetes</a>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden mt-4 mt-lg-0">
                <img src="https://images.unsplash.com/photo-1500835556837-99ac94a94552?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Viajeros felices" class="img-fluid">
            </div>
        </div>
    </div>

    <div class="row align-items-center p-5 rounded-4 shadow-sm bg-white my-5">
        <div class="col-md-4 text-center border-end">
            <h2 class="display-1 fw-bold text-gold">50+</h2>
            <p class="text-uppercase fw-bold text-muted small">Destinos Exclusivos</p>
        </div>
        <div class="col-md-4 text-center border-end">
            <h2 class="display-1 fw-bold text-dark">10k</h2>
            <p class="text-uppercase fw-bold text-muted small">Viajeros Felices</p>
        </div>
        <div class="col-md-4 text-center">
            <h2 class="display-1 fw-bold text-gold">24/7</h2>
            <p class="text-uppercase fw-bold text-muted small">Soporte Premium</p>
        </div>
    </div>

    <div class="mb-5">
        <h2 class="text-center font-serif mb-5">¿Por qué elegirnos?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="mb-3 text-gold display-5"><i class="bi bi-star-fill"></i></div>
                    <h4 class="card-title fw-bold">Calidad Premium</h4>
                    <p class="card-text text-muted">Solo trabajamos con los mejores hoteles y aerolíneas para asegurar tu confort.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="mb-3 text-gold display-5"><i class="bi bi-shield-check"></i></div>
                    <h4 class="card-title fw-bold">Seguridad Total</h4>
                    <p class="card-text text-muted">Tu inversión y tu bienestar están protegidos con nuestros seguros de viaje integrales.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center p-4">
                    <div class="mb-3 text-gold display-5"><i class="bi bi-heart-fill"></i></div>
                    <h4 class="card-title fw-bold">Atención Personalizada</h4>
                    <p class="card-text text-muted">Acompañamiento experto antes, durante y después de tu viaje.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection