<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="{{ url('assets/img/favicon.ico') }}">
        <title>
            @yield('title', 'FlyPacks | Viajes Exclusivos')
        </title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        
        <!-- Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        
        <!-- Custom CSS -->
        <link rel="stylesheet" href="{{ url('assets/css/styles.css') }}">
        @yield('styles')
    </head>
    <body>
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-transparent-scrolled confirm-scroll"> 
            <div class="container">
                <a class="navbar-brand fs-3 fst-italic" href="{{ url('/') }}">
                    <i class="bi bi-airplane-engines me-2 text-gold"></i>
                    @yield('navbar', 'FlyPacks')
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('reserva.index') }}">Mis Reservas</a>
                            </li>
                            @if(Auth::user()->rol == 'admin' || Auth::user()->rol == 'advanced')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAdmin" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Admin
                                </a>
                                <ul class="dropdown-menu border-0 shadow" aria-labelledby="navbarDropdownAdmin">
                                    <li><a class="dropdown-item" href="{{ route('vacacion.create') }}">Crear Paquete</a></li>
                                    <li><a class="dropdown-item" href="{{ route('vacacion.index') }}">Gestionar Paquetes</a></li>
                                    @if(Auth::user()->rol == 'admin')
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('user.index') }}">Usuarios</a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                        @endauth
                    </ul>
                    
                    <ul class="navbar-nav ms-auto align-items-center">
                         <li class="nav-item me-3">
                            <a class="nav-link" href="{{ route('about') }}">Nosotros</a>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="btn btn-outline-light rounded-pill px-4" href="{{ route('login') }}">Acceder</a>
                            </li>
                        @else
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="avatar-circle me-2">{{ substr(Auth::user()->name, 0, 1) }}</div>
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow" aria-labelledby="userDropdown">
                                    <li><span class="dropdown-header text-muted">Cuenta</span></li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('home') }}">Perfil</a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                         <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Cerrar Sesión
                                        </a>
                                    </li>
                                </ul>
                                <form id="logout-form" action="{{ route('logout') }}" method="post" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="main-wrapper">
             @yield('hero')
            
            <div class="container my-5 content-container">
                @if(session('mensajeTexto'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-success border-5" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('mensajeTexto') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @error('mensajeTexto')
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 border-start border-danger border-5" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @enderror

                @yield('modalcontent')
                @yield('content')
            </div>
        </div>

        <footer class="bg-dark text-white py-5 mt-auto">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <h4 class="h5 font-serif mb-3 text-gold">FlyPacks</h4>
                        <p class="text-muted small">Descubre los destinos más exclusivos y vive experiencias inolvidables. Tu viaje de ensueño comienza aquí.</p>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h4 class="h5 font-serif mb-3 text-gold">Enlaces</h4>
                        <ul class="list-unstyled text-muted small">
                            <li><a href="{{ route('main') }}" class="text-decoration-none text-muted hover-gold">Destinos</a></li>
                            <li><a href="#" class="text-decoration-none text-muted hover-gold">Ofertas</a></li>
                            <li><a href="{{ route('about') }}" class="text-decoration-none text-muted hover-gold">Sobre Nosotros</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4 mb-4">
                        <h4 class="h5 font-serif mb-3 text-gold">Contacto</h4>
                        <p class="text-muted small">
                            <i class="bi bi-envelope me-2"></i> info@flypacks.com<br>
                            <i class="bi bi-telephone me-2"></i> +34 900 123 456
                        </p>
                    </div>
                </div>
                <div class="text-center text-muted small border-top border-secondary pt-4">
                    &copy; {{ date('Y') }} FlyPacks. Todos los derechos reservados.
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
            crossorigin="anonymous"></script>
        
        <script>
            // Navbar scroll effect
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('.navbar');
                if (window.scrollY > 50) {
                    nav.classList.add('bg-dark', 'shadow-sm');
                    nav.classList.remove('bg-transparent', 'py-3');
                } else {
                    nav.classList.remove('bg-dark', 'shadow-sm');
                    nav.classList.add('bg-transparent', 'py-3');
                }
            });
            // Init state
            document.querySelector('.navbar').classList.add('bg-transparent', 'py-3', 'transition-all');
        </script>
        
        <script src="{{ url('assets/js/main.js') }}"></script>
        @yield('scritps')
    </body>
</html>