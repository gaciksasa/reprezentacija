@extends('layouts.app')

@section('title', 'Kategorije')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kategorije</h1>
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova kategorija
    </a>
    @endif
</div>

<div class="row">
    @forelse($categories as $category)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h2 class="card-title mb-0">{{ $category->name }}</h2>
            </div>
            <div class="card-body">
                
                <div class="mb-2">
                    <span class="text-muted">Slug: </span>
                    <span class="badge bg-secondary">{{ $category->slug }}</span>
                </div>

                @if($category->parent)
                    <div class="mb-2">
                        <span class="text-muted">Nadređena kategorija: </span>
                        <a href="{{ route('categories.show', $category->parent) }}">{{ $category->parent->name }}</a>
                    </div>
                @endif

                <div class="mb-2">
                    <span class="text-muted">Broj postova: </span>
                    <span class="badge bg-primary">{{ $category->posts->count() }}</span>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="{{ route('categories.show', $category) }}" class="btn btn-sm btn-info">
                    <i class="fas fa-eye"></i> Detalji
                </a>
                @if(Auth::check() && Auth::user()->hasEditAccess())
                <div class="btn-group">
                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Izmeni
                    </a>
                    <button type="button" class="btn btn-sm btn-danger" 
                            onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-category-{{ $category->id }}').submit()">
                        <i class="fas fa-trash"></i>
                    </button>
                    <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" class="d-none">
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
                <a href="{{ route('categories.create') }}" class="alert-link">Kreirajte prvu kategoriju</a>.
            @endif
        </div>
    </div>
    @endforelse
</div>
@endsection