@extends('layouts.app')

@section('title', $post->post_title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary mb-2">
            <i class="fas fa-arrow-left"></i> Nazad na sve vesti
        </a>
        <h1 class="mt-2">{{ $post->post_title }}</h1>
        <p class="text-muted">Objavljeno: {{ $post->post_date->format('d.m.Y H:i') }}</p>
    </div>
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <div>
        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Da li ste sigurni?')">
                <i class="fas fa-trash"></i> Obriši
            </button>
        </form>
    </div>
    @endif
</div>

<div class="card">
    <div class="card-body">
        @if($post->featured_image)
        <div class="text-center mb-4">
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->post_title }}" class="img-fluid rounded" style="width: 100%;">
        </div>
        @endif
        
        @if($post->post_excerpt)
        <div class="lead mb-4">
            {{ $post->post_excerpt }}
        </div>
        <hr>
        @endif
        
        <div class="post-content">
            {!! $post->post_content !!}
        </div>
    </div>
</div>
@endsection