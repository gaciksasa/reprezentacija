@extends('layouts.app')

@section('title', 'Izmeni kategoriju')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni kategoriju: {{ $category->name }}</h1>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Naziv *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="parent_id" class="form-label">Nadređena kategorija</label>
                <select class="form-select @error('parent_id') is-invalid @enderror" 
                        id="parent_id" name="parent_id">
                    <option value="">-- Nema nadređenu kategoriju --</option>
                    @foreach($parentCategories as $parentCategory)
                        <option value="{{ $parentCategory->id }}" 
                                {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                            {{ $parentCategory->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Opis</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                <input type="text" class="form-control" id="slug" value="{{ $category->slug }}" disabled readonly>
                <small class="form-text text-muted">Slug će se automatski generisati iz naziva.</small>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>

@if($category->posts->count() > 0)
<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Postovi u kategoriji</h5>
    </div>
    <div class="card-body">
        <div class="list-group">
            @foreach($category->posts as $post)
                <a href="{{ route('posts.show', $post) }}" class="list-group-item list-group-item-action">
                    {{ $post->post_title }}
                    <small class="text-muted d-block">
                        Objavljeno: {{ $post->post_date->format('d.m.Y H:i') }}
                    </small>
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection