@extends('layouts.app')

@section('title', 'Nova objava')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Nova objava</h1>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label for="post_title" class="form-label">Naslov *</label>
                <input type="text" class="form-control @error('post_title') is-invalid @enderror" 
                       id="post_title" name="post_title" value="{{ old('post_title') }}" required>
                @error('post_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="post_content" class="form-label">Sadržaj *</label>
                <textarea class="form-control @error('post_content') is-invalid @enderror" 
                          id="post_content" name="post_content" rows="10" required>{{ old('post_content') }}</textarea>
                @error('post_content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="post_excerpt" class="form-label">Izvod</label>
                <textarea class="form-control @error('post_excerpt') is-invalid @enderror" 
                          id="post_excerpt" name="post_excerpt" rows="3">{{ old('post_excerpt') }}</textarea>
                <small class="form-text text-muted">Kratak opis koji se prikazuje u listama objava. Ako se ostavi prazno, koristiće se deo sadržaja.</small>
                @error('post_excerpt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="featured_image" class="form-label">Glavna slika</label>
                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                           id="featured_image" name="featured_image">
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="post_status" class="form-label">Status *</label>
                    <select class="form-select @error('post_status') is-invalid @enderror" 
                            id="post_status" name="post_status" required>
                        <option value="publish" {{ old('post_status') == 'publish' ? 'selected' : '' }}>Objavljeno</option>
                        <option value="draft" {{ old('post_status') == 'draft' ? 'selected' : '' }}>Nacrt</option>
                        <option value="pending" {{ old('post_status') == 'pending' ? 'selected' : '' }}>Na čekanju</option>
                        <option value="private" {{ old('post_status') == 'private' ? 'selected' : '' }}>Privatno</option>
                    </select>
                    @error('post_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="post_type" class="form-label">Tip *</label>
                <select class="form-select @error('post_type') is-invalid @enderror" 
                        id="post_type" name="post_type" required>
                    <option value="post" {{ old('post_type', 'post') == 'post' ? 'selected' : '' }}>Objava</option>
                    <option value="page" {{ old('post_type') == 'page' ? 'selected' : '' }}>Stranica</option>
                </select>
                @error('post_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Kategorije</label>
                <div class="card">
                    <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                        @if($categories->count() > 0)
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="category-{{ $category->id }}" 
                                           name="categories[]" 
                                           value="{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category-{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <p class="text-muted mb-0">Nema dostupnih kategorija. <a href="{{ route('categories.create') }}">Dodajte kategoriju</a>.</p>
                        @endif
                    </div>
                </div>
                @error('categories')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj objavu</button>
            </div>
        </form>
    </div>
</div>
@endsection