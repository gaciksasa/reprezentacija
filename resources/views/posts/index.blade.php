@extends('layouts.app')

@section('title', 'Vesti')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Vesti</h1>
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <div>
        <a href="{{ route('kategorije.index') }}" class="btn btn-info">
            <i class="fas fa-tag"></i> Kategorije
        </a>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova vest
        </a>
    </div>
    @endif
</div>

<div class="posts row">
    @forelse($posts as $post)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            @if($post->featured_image)
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->post_title }}" class="card-img-top" style="height: 200px; object-fit: cover;">
            @else
            <div class="bg-light text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted"></i>
            </div>
            @endif
            <div class="card-body">
                <h3 class="card-title"><a href="{{ route('posts.show', $post->id) }}">{{ $post->post_title }}</a></h3>
                
                <div class="d-flex justify-content-between mb-2">
                    <p class="card-text small text-muted mb-0">
                        {{ \Carbon\Carbon::parse($post->post_date)->format('d.m.Y H:i') }}
                    </p>
                </div>
                
                @if($post->kategorije->count() > 0)
                <div class="mb-2">
                    @foreach($post->kategorije as $kategorija)
                        <a href="{{ route('kategorije.show', $kategorija) }}" class="badge bg-primary text-white me-1">
                            {{ $kategorija->name }}
                        </a>
                    @endforeach
                </div>
                @endif
                
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
    @empty
    <div class="col-12">
        <div class="alert alert-info">
            Nema objavljenih vesti.
        </div>
    </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $posts->links() }}
</div>
@endsection