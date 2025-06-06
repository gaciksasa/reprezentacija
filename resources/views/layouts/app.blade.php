<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fudbalska statistika Srbije - @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&family=Teko:wght@300..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
    <link href="{{ asset('../resources/css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tiny.cloud/1/2d8d0z568l75o82jphit2mlssygij2v5xxuk0ev3ai9lv60g/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    
    <!-- CSRF Token za Ajax pozive -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script>
    // Add TinyMCE configuration
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize TinyMCE for users with editing rights (admin or editor)
        @if(Auth::check() && Auth::user()->hasEditAccess())
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: 'textarea:not(.no-tinymce)',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                height: 500,
                setup: function(editor) {
                    editor.on('change', function() {
                        tinymce.triggerSave();
                    });
                }
            });
        }
        @endif
    });
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary text-light py-4 mb-4">
        <div class="container">
            <a class="navbar-brand h2 text-light mb-0" href="{{ route('dashboard') }}">fss.co.rs</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Početna</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index') }}">Vesti</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Utakmice
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('utakmice.index') }}">Sve utakmice</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '2020-2029') }}">2020-danas</a></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '2010-2019') }}">2010-2019</a></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '2000-2009') }}">2000-2009</a></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '1990-1999') }}">1990-1999</a></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '1980-1989') }}">1980-1989</a></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '1970-1979') }}">1970-1979</a></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '1960-1969') }}">1960-1969</a></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '1950-1959') }}">1950-1959</a></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '1940-1949') }}">1940-1949</a></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '1930-1939') }}">1930-1939</a></li>
                            <li><a class="dropdown-item" href="{{ route('utakmice.dekada', '1920-1929') }}">1920-1929</a></li>
                        </ul>
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
                    <!--<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Ostalo
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('takmicenja.index') }}">Takmičenja</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('statistika') }}">Statistika</a></li>
                            <li><a class="dropdown-item" href="{{ route('kalendar') }}">Kalendar</a></li>
                        </ul>
                    </li>-->
                </ul>
                <!--<form class="d-flex ms-auto me-2" action="{{ route('pretraga') }}" method="GET">
                    <input class="form-control me-2" type="search" name="query" placeholder="Pretraga..." aria-label="Pretraga">
                    <button class="btn btn-outline-light" type="submit">Traži</button>
                </form>-->
                <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @can('admin')
                                <li><span class="dropdown-item text-muted">Administrator</span></li>
                                <li><hr class="dropdown-divider"></li>
                            @endcan
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
                @endif
                </ul>
            </div>
        </div>
    </nav>
     
    <div class="container my-5">
    @yield('content')
    </div>

    <div class="copyright py-4 mt-auto">
        <div class="container">
            <div class="row g-4 align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <h2 class="text-white">fss.co.rs</h2>
                </div>
                <div class="col-md-6 text-center text-md-end text-body">
                    <span>&copy; {{ date('Y') }} fss.co.rs - Sva prava zadržana.</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>