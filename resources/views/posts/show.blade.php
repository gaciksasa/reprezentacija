@extends('layouts.app')

@section('title', $post->post_title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $post->post_title }}</h1>
    <div>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Da li ste sigurni da želite obrisati ovaj post?')">
                <i class="fas fa-trash"></i> Obriši
            </button>
        </form>
        @endif
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="mb-3 text-muted">
            <span><i class="fas fa-calendar"></i> {{ $post->post_date->format('d.m.Y') }}</span>
            @if($post->author)
            <span class="ms-3"><i class="fas fa-user"></i> {{ $post->author->name }}</span>
            @endif
        </div>
        
        <div class="post-content">
            {!! $post->post_content !!}
        </div>
    </div>
</div>
@endsection