@extends('layouts.app')

@section('title', 'Stranica nije pronađena')

@section('content')
<div class="text-center my-5">
    <div class="display-1 text-muted mb-4">404</div>
    <h1 class="h2 mb-3">Stranica nije pronađena</h1>
    <p class="h4 text-muted font-weight-normal mb-4">Izvinjavamo se, ali tražena stranica ne postoji.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">
        <i class="fas fa-home me-2"></i> Povratak na početnu
    </a>
</div>
@endsection