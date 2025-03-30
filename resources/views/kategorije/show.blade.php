@extends('layouts.app')

@section('title', $kategorija->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kategorija: {{ $kategorija->name }} ({{ $kategorija->posts->count() }})</h1>
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
@if($kategorija->posts->count() > 0)
<div class="row">
    @foreach($kategorija->posts as $post)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            @if($post->featured_image)
            <img src="{{ asset('storage/uploads/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->post_title }}" style="max-height: 200px; object-fit: cover;">
            @endif
            <div class="card-body">
                <h3 class="card-title"><a href="{{ route('posts.show', $post) }}">{{ $post->post_title }}</a></h3>
                <div class="d-flex justify-content-between mb-2">
                    <p class="card-text small text-muted mb-0">
                        {{ \Carbon\Carbon::parse($post->post_date)->format('d.m.Y H:i') }}
                    </p>
                </div>
                <p class="card-text">
                    {{ Str::limit(html_entity_decode(strip_tags($post->post_excerpt ?: $post->post_content)), 150) }}
                </p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-sm">Detaljnije</a>
                    
                    @if(Auth::check() && Auth::user()->hasEditAccess())
                    <div class="btn-group">
                        <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" 
                                onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-post-{{ $post->id }}').submit()">
                            <i class="fas fa-trash"></i>
                        </button>
                        <form id="delete-post-{{ $post->id }}" action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p class="text-center text-muted">Nema postova u ovoj kategoriji.</p>
@endif
@endsection