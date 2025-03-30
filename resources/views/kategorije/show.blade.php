@extends('layouts.app')

@section('title', $kategorija->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kategorija: {{ $kategorija->name }} ({{$kategorija->posts->count()}})</h1>
    <div>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <a href="{{ route('kategorije.edit', $kategorija) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        @endif
        <a href="{{ route('kategorije.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

@if($kategorija->description || $kategorija->parent || $kategorija->children->count() > 0)
<div class="card mb-4">
    <div class="card-body">
        @if($kategorija->description)
            <div class="mb-4">
                <p>{{ $kategorija->description }}</p>
            </div>
        @endif

        <div class="d-flex flex-wrap gap-2 mb-3">
            @if($kategorija->parent)
                <a href="{{ route('kategorije.show', $kategorija->parent) }}" class="badge bg-primary text-decoration-none">
                    {{ $kategorija->parent->name }}
                </a>
            @endif

            @foreach($kategorija->children as $child)
                <a href="{{ route('kategorije.show', $child) }}" class="badge bg-secondary text-decoration-none">
                    {{ $child->name }}
                </a>
            @endforeach
        </div>
    </div>
</div>
@endif

@if($kategorija->posts->count() > 0)
    <div class="row">
        @foreach($kategorija->posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                @if($post->featured_image)
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->post_title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                @else
                <div class="bg-light text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted"></i>
                </div>
                @endif
                    <div class="card-body">
                        <h3 class="card-title">
                            <a href="{{ route('posts.show', $post) }}">
                                {{ $post->post_title }}
                            </a>
                        </h3>
                        <p class="text-muted small">{{ $post->post_date->format('d.m.Y H:i') }}</p>
                        
                        <p class="card-text">
                            {{ Str::limit(html_entity_decode(strip_tags($post->post_excerpt ?: $post->post_content)), 150) }}
                        </p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-primary btn-sm">Detaljnije</a>
                        
                        @if(Auth::check() && Auth::user()->hasEditAccess())
                        <div>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button" class="btn btn-danger"
                                    onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-post-{{ $post->id }}').submit()">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-post-{{ $post->id }}" action="{{ route('posts.destroy', $post) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="alert alert-info">
        <p class="mb-0">Nema objava u ovoj kategoriji.</p>
    </div>
@endif
@endsection