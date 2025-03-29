@extends('layouts.app')

@section('title', 'Izmena vesti')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmena vesti</h1>
    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="post_title" class="form-label">Naslov *</label>
                <input type="text" class="form-control @error('post_title') is-invalid @enderror" 
                       id="post_title" name="post_title" value="{{ old('post_title', $post->post_title) }}" required>
                @error('post_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="post_excerpt" class="form-label">Kratak opis</label>
                <textarea class="form-control @error('post_excerpt') is-invalid @enderror no-tinymce" 
                          id="post_excerpt" name="post_excerpt" rows="3">{{ old('post_excerpt', $post->post_excerpt) }}</textarea>
                @error('post_excerpt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="post_content" class="form-label">Sadržaj *</label>
                <textarea class="form-control @error('post_content') is-invalid @enderror" 
                          id="post_content" name="post_content" rows="10">{{ old('post_content', $post->post_content) }}</textarea>
                @error('post_content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
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
                
                <div class="col-md-6 mb-3">
                    <label for="post_type" class="form-label">Tip *</label>
                    <select class="form-select @error('post_type') is-invalid @enderror" 
                            id="post_type" name="post_type" required>
                        <option value="post" {{ old('post_type', $post->post_type) == 'post' ? 'selected' : '' }}>Vest</option>
                        <option value="page" {{ old('post_type', $post->post_type) == 'page' ? 'selected' : '' }}>Stranica</option>
                    </select>
                    @error('post_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('delete-post').submit()">
                    Obriši vest
                </button>
            </div>
        </form>
        
        <form id="delete-post" action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection