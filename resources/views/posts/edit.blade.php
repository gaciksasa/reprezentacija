@extends('layouts.app')

@section('title', 'Izmeni objavu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni objavu</h1>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('posts.update', $post->post_name) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="post_date" class="form-label">Datum objave</label>
                <input type="datetime-local" class="form-control @error('post_date') is-invalid @enderror" 
                    id="post_date" name="post_date" value="{{ old('post_date', $post->post_date ? $post->post_date->format('Y-m-d\TH:i') : '') }}">
                @error('post_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Ostavite prazno da zadržite trenutni datum.</small>
            </div>
            
            <div class="mb-3">
                <label for="post_title" class="form-label">Naslov *</label>
                <input type="text" class="form-control @error('post_title') is-invalid @enderror" 
                       id="post_title" name="post_title" value="{{ old('post_title', $post->post_title) }}" required>
                @error('post_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="post_content" class="form-label">Sadržaj *</label>
                <textarea class="form-control @error('post_content') is-invalid @enderror" 
                          id="post_content" name="post_content" rows="10" required>{{ old('post_content', $post->post_content) }}</textarea>
                @error('post_content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="post_excerpt" class="form-label">Izvod</label>
                <textarea class="form-control @error('post_excerpt') is-invalid @enderror" 
                          id="post_excerpt" name="post_excerpt" rows="3">{{ old('post_excerpt', $post->post_excerpt) }}</textarea>
                <small class="form-text text-muted">Kratak opis koji se prikazuje u listama objava. Ako se ostavi prazno, koristiće se deo sadržaja.</small>
                @error('post_excerpt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="featured_image" class="form-label">Glavna slika</label>
                    @if($post->featured_image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/uploads/' . $post->featured_image) }}" 
                                 alt="{{ $post->post_title }}" 
                                 class="img-thumbnail" style="max-height: 150px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="delete_featured_image" 
                                       name="delete_featured_image" 
                                       {{ old('delete_featured_image') ? 'checked' : '' }}>
                                <label class="form-check-label" for="delete_featured_image">
                                    Obriši trenutnu sliku
                                </label>
                            </div>
                        </div>
                    @endif
                    
                    <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                           id="featured_image" name="featured_image">
                    <small class="form-text text-muted">Otpremite novu sliku da zamenite postojeću.</small>
                    @error('featured_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="post_status" class="form-label">Status *</label>
                    <select class="form-select @error('post_status') is-invalid @enderror" 
                            id="post_status" name="post_status" required>
                        <option value="publish" {{ old('post_status', $post->post_status) == 'publish' ? 'selected' : '' }}>Objavljeno</option>
                        <option value="draft" {{ old('post_status', $post->post_status) == 'draft' ? 'selected' : '' }}>Nacrt</option>
                        <option value="pending" {{ old('post_status', $post->post_status) == 'pending' ? 'selected' : '' }}>Na čekanju</option>
                        <option value="private" {{ old('post_status', $post->post_status) == 'private' ? 'selected' : '' }}>Privatno</option>
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
                    <option value="post" {{ old('post_type', $post->post_type) == 'post' ? 'selected' : '' }}>Objava</option>
                    <option value="page" {{ old('post_type', $post->post_type) == 'page' ? 'selected' : '' }}>Stranica</option>
                </select>
                @error('post_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label class="form-label">Kategorije</label>
                <div class="card">
                    <div class="card-body" style="max-height: 200px; overflow-y: auto;">
                        @foreach($kategorije as $kategorija)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                    id="kategorija-{{ $kategorija->id }}" name="kategorije[]" 
                                    value="{{ $kategorija->id }}" 
                                    {{ in_array($kategorija->id, $selectedkategorije) ? 'checked' : '' }}>
                                <label class="form-check-label" for="kategorija-{{ $kategorija->id }}">
                                    {{ $kategorija->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('kategorije')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="post_name" class="form-label">Slug</label>
                <input type="text" class="form-control" id="post_name" value="{{ $post->post_name }}" disabled readonly>
                <small class="form-text text-muted">Slug se automatski generiše iz naslova.</small>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>
@endsection