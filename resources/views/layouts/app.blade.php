// resources/views/layouts/app.blade.php

<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reprezentacija - @yield('title', 'Fudbalska statistika')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
    <script src="https://cdn.tiny.cloud/1/2d8d0z568l75o82jphit2mlssygij2v5xxuk0ev3ai9lv60g/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Only initialize TinyMCE for authenticated admin users
            @if(Auth::check() && Auth::user()->is_admin)
            tinymce.init({
                selector: 'textarea',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                height: 500,
                // If you want to exclude certain textareas, you can use:
                // selector: 'textarea:not(.no-tinymce)',
            });
            @endif
        });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Reprezentacija</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Početna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('utakmice.index') }}">Utakmice</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('timovi.index') }}">Bilansi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('igraci.index') }}">Reprezentativci</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('selektori.index') }}">Selektori</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Ostalo
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('takmicenja.index') }}">Takmičenja</a></li>
                            <li><a class="dropdown-item" href="{{ route('stadioni.index') }}">Stadioni</a></li>
                            <li><a class="dropdown-item" href="{{ route('sudije.index') }}">Sudije</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('statistika') }}">Statistika</a></li>
                            <li><a class="dropdown-item" href="{{ route('kalendar') }}">Kalendar</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex ms-auto me-2" action="{{ route('pretraga') }}" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Pretraga..." aria-label="Pretraga">
                    <button class="btn btn-outline-light" type="submit">Traži</button>
                </form>
                <ul class="navbar-nav">
                    @if (Auth::check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if (Auth::user()->is_admin)
                                    <li><span class="dropdown-item text-muted">Administrator</span></li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Odjavi se</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Prijava</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registracija</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mb-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Reprezentacija</h5>
                    <p>Baza podataka fudbalskih reprezentacija i utakmica</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p>&copy; {{ date('Y') }} Reprezentacija. Sva prava zadržana.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>