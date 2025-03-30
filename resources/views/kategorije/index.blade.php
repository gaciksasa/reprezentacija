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
                
                <div class="mb-2">
                    <span class="text-muted">Slug: </span>
                    <span class="badge bg-secondary">{{ $kategorija->slug }}</span>
                </div>

                @if($kategorija->parent)
                    <div class="mb-2">
                        <span class="text-muted">Nadređena kategorija: </span>
                        <a href="{{ route('kategorije.show', $kategorija->parent) }}">{{ $kategorija->parent->name }}</a>
                    </div>
                @endif

                <div class="mb-2">
                    <span class="text-muted">Broj postova: </span>
                    <span class="badge bg-primary">{{ $kategorija->posts->count() }}</span>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('kategorije.show', $kategorija) }}" class="btn btn-sm btn-info">
                    <i class="fas fa-eye"></i> Detalji
                </a>
                @if(Auth::check() && Auth::user()->hasEditAccess())
                <div class="btn-group">
                    <a href="{{ route('kategorije.edit', $kategorija) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Izmeni
                    </a>
                    <button type="button" class="btn btn-sm btn-danger" 
                            onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-Kategorija-{{ $kategorija->id }}').submit()">
                        <i class="fas fa-trash"></i>
                    </button>
                    <form id="delete-Kategorija-{{ $kategorija->id }}" action="{{ route('kategorije.destroy', $kategorija) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            Nema kategorija u bazi podataka. 
            @if(Auth::check() && Auth::user()->hasEditAccess())
                <a href="{{ route('kategorije.create') }}" class="alert-link">Kreirajte prvu kategoriju</a>.
            @endif
        </div>
    </div>
    @endforelse
</div>
@endsection