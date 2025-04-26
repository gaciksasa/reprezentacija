@extends('layouts.app')

@section('title', 'Dodaj novi post')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novi post</h1>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="postForm">
            @csrf
            
            <div class="mb-3">
                <label for="post_date" class="form-label">Datum objave</label>
                <input type="datetime-local" class="form-control @error('post_date') is-invalid @enderror" 
                    id="post_date" name="post_date" value="{{ old('post_date') }}">
                @error('post_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Ostavite prazno za trenutni datum.</small>
            </div>
            
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
                          id="post_content" name="post_content" rows="10">{{ old('post_content') }}</textarea>
                @error('post_content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="post_excerpt" class="form-label">Kratak opis</label>
                <textarea class="form-control @error('post_excerpt') is-invalid @enderror no-tinymce" 
                          id="post_excerpt" name="post_excerpt" rows="3">{{ old('post_excerpt') }}</textarea>
                @error('post_excerpt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="featured_image" class="form-label">Naslovna slika</label>
                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                       id="featured_image" name="featured_image">
                @error('featured_image')
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
                                    {{ in_array($kategorija->id, old('kategorije', [])) ? 'checked' : '' }}>
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
                <label for="post_status" class="form-label">Status *</label>
                <select class="form-select @error('post_status') is-invalid @enderror" 
                        id="post_status" name="post_status" required>
                    <option value="publish" {{ old('post_status') == 'publish' ? 'selected' : '' }}>Objavljeno</option>
                    <option value="draft" {{ old('post_status') == 'draft' ? 'selected' : '' }}>Nacrt</option>
                </select>
                @error('post_status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj post</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#post_content',
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            height: 500,
            setup: function(editor) {
                // Fix validation issue by ensuring the content is updated on submit
                editor.on('change', function() {
                    tinymce.triggerSave();
                });
            }
        });
        
        // Handle form submission to ensure TinyMCE content is saved
        document.getElementById('postForm').addEventListener('submit', function() {
            // Make sure TinyMCE updates the textarea before submitting
            tinymce.triggerSave();
        });
    }
});
</script>
@endsection