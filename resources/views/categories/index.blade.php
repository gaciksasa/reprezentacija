@extends('layouts.app')

@section('title', 'Kategorije')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kategorije</h1>
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <div>
        <a href="{{ route('posts.index') }}" class="btn btn-info">
            <i class="fas fa-newspaper"></i> Vesti
        </a>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova kategorija
        </a>
    </div>
    @endif
</div>

<div class="row">
    @forelse($categories as $category)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header bg-info bg-opacity-25">
                <h3 class="card-title h5 mb-0">
                    <a href="{{ route('categories.show', $category) }}" class="text-decoration-none">
                        {{ $category->name }}
                    </a>
                </h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Slug:</strong> {{ $category->slug }}
                </div>
                
                @if($category->parent)
                <div class="mb-3">
                    <strong>Nadređena kategorija:</strong>
                    <a href="{{ route('categories.show', $category->parent) }}">
                        {{ $category->parent->name }}
                    </a>
                </div>
                @endif
                
                <div class="mb-3">
                    <strong>Broj objava:</strong> 
                    <span class="badge bg-primary">{{ $category->posts->count() }}</span>
                </div>
                
                @if($category->description)
                <div class="mb-3">
                    <strong>Opis:</strong>
                    <p class="card-text mt-1">
                        {{ Str::limit($category->description, 150) }}
                    </p>
                </div>
                @endif
                
                @if($category->children->count() > 0)
                <div class="mb-3">
                    <strong>Podkategorije:</strong>
                    <div class="mt-1">
                        @foreach($category->children as $child)
                            <a href="{{ route('categories.show', $child) }}" class="badge bg-secondary text-decoration-none me-1">
                                {{ $child->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('categories.show', $category) }}" class="btn btn-primary btn-sm">Detaljnije</a>
                    
                    @if(Auth::check() && Auth::user()->hasEditAccess())
                    <div class="btn-group">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
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
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            Nema kategorija u bazi podataka.
        </div>
    </div>
    @endforelse
</div>
@endsection