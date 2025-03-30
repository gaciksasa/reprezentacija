@extends('layouts.app')

@section('title', 'Kategorije')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kategorije</h1>
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <a href="{{ route('kategorije.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova kategorija
    </a>
    @endif
</div>

<div class="row">
    @forelse($kategorije as $kategorija)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h2 class="card-title mb-0">{{ $kategorija->name }}</h2>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Slug:</strong> <span class="badge bg-light text-dark">{{ $kategorija->slug }}</span></p>
                
                @if($kategorija->parent)
                <p class="mb-2"><strong>Nadređena kategorija:</strong> {{ $kategorija->parent->name }}</p>
                @endif
                
                <p class="mb-2"><strong>Broj postova:</strong> {{ $kategorija->posts->count() }}</p>
                
                @if($kategorija->description)
                <div class="mt-3">
                    <p>{{ Str::limit($kategorija->description, 150) }}</p>
                </div>
                @endif
            </div>
            <div class="card-footer">
                <div class="btn-group">
                    <a href="{{ route('kategorije.show', $kategorija->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> Detalji
                    </a>
                    @if(Auth::check() && Auth::user()->hasEditAccess())
                    <a href="{{ route('kategorije.edit', $kategorija->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Izmeni
                    </a>
                    <button type="button" class="btn btn-sm btn-danger" 
                            onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-kategorija-{{ $kategorija->id }}').submit()">
                        <i class="fas fa-trash"></i>
                    </button>
                    <form id="delete-kategorija-{{ $kategorija->id }}" action="{{ route('kategorije.destroy', $kategorija->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            Nema evidentiranih kategorija. 
            @if(Auth::check() && Auth::user()->hasEditAccess())
            <a href="{{ route('kategorije.create') }}">Kreirajte prvu kategoriju</a>.
            @endif
        </div>
    </div>
    @endforelse
</div>
@endsection