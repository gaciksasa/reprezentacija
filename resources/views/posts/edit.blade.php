@extends('layouts.app')

@section('title', 'Izmeni objavu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni objavu: {{ $post->post_title }}</h1>
    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('posts.update', $post) }}" method="POST">
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
                <small class="form-text text-muted">Kratak opis objave koji se prikazuje u listama i rezultatima pretrage.</small>
                @error('post_excerpt')
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
                    <label for="post_type" class="form-label">Tip objave *</label>
                    <select class="form-select @error('post_type') is-invalid @enderror" 
                            id="post_type" name="post_type" required>
                        <option value="post" {{ old('post_type', $post->post_type) == 'post' ? 'selected' : '' }}>Članak</option>
                        <option value="page" {{ old('post_type', $post->post_type) == 'page' ? 'selected' : '' }}>Stranica</option>
                        <option value="attachment" {{ old('post_type', $post->post_type) == 'attachment' ? 'selected' : '' }}>Prilog</option>
                    </select>
                    @error('post_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>

<div class="mt-4">
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title mb-0">Informacije o objavi</h2>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3 fw-bold">ID:</div>
                <div class="col">{{ $post->id }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Slug:</div>
                <div class="col">{{ $post->post_name }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Datum kreiranja:</div>
                <div class="col">{{ $post->post_date ? $post->post_date->format('d.m.Y H:i') : '-' }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-3 fw-bold">Datum izmene:</div>
                <div class="col">{{ $post->post_modified ? $post->post_modified->format('d.m.Y H:i') : '-' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize editor if TinyMCE is available
        if (typeof tinymce !== 'undefined') {
            tinymce.init({
                selector: '#post_content',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                height: 500,
            });
        }
    });
</script>
@endsection