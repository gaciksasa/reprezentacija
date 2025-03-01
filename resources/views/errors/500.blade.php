@extends('layouts.app')

@section('title', 'Greška servera')

@section('content')
<div class="text-center my-5">
    <div class="display-1 text-muted mb-4">500</div>
    <h1 class="h2 mb-3">Greška servera</h1>
    <p class="h4 text-muted font-weight-normal mb-4">Izvinjavamo se, došlo je do interne greške na serveru.</p>
    <a href="{{ route('dashboard') }}" class="btn btn-primary">
        <i class="fas fa-home me-2"></i> Povratak na početnu
    </a>
</div>
@endsection