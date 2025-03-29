@extends('layouts.app')

@section('title', 'Izmeni vest')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni vest</h1>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
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
            
            <div class="mb-4">
                <label for="featured_image" class="form-label">Naslovna slika</label>
                @if($post->featured_image)
                    <div class="mb-2">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->post_title }}" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" class="form-check-input" id="delete_featured_image" name="delete_featured_image">
                        <label class="form-check-label" for="delete_featured_image">Ukloni trenutnu sliku</label>
                    </div>
                @endif
                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                       id="featured_image" name="featured_image" accept="image/*">
                <small class="form-text text-muted">Preporučena veličina: 1200 x 630 piksela</small>
                @error('featured_image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="post_excerpt" class="form-label">Kratak opis</label>
                <textarea class="form-control @error('post_excerpt') is-invalid @enderror" 
                          id="post_excerpt" name="post_excerpt" rows="3">{{ old('post_excerpt', $post->post_excerpt) }}</textarea>
                @error('post_excerpt')
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
            
            <input type="hidden" name="post_type" value="{{ $post->post_type }}">
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Show/hide the file input based on the delete checkbox
        const deleteCheckbox = document.getElementById('delete_featured_image');
        const fileInput = document.getElementById('featured_image');
        
        if (deleteCheckbox) {
            deleteCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    fileInput.setAttribute('disabled', 'disabled');
                } else {
                    fileInput.removeAttribute('disabled');
                }
            });
        }
    });
</script>
@endsection