@extends('layouts.app')

@section('title', 'Vesti')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Vesti</h1>
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <a href="{{ route('posts.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova vest
    </a>
    @endif
</div>

<div class="row">
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
                <h5 class="card-title">{{ $post->post_title }}</h5>
                <p class="card-text small text-muted">
                    {{ \Carbon\Carbon::parse($post->post_date)->format('d.m.Y H:i') }}
                </p>
                <p class="card-text">
                    {{ Str::limit(strip_tags($post->post_excerpt ?: $post->post_content), 150) }}
                </p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-sm">Pročitaj više</a>
                
                @if(Auth::check() && Auth::user()->hasEditAccess())
                <div class="mt-2">
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Izmeni
                    </a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Da li ste sigurni?')">
                            <i class="fas fa-trash"></i> Obriši
                        </button>
                    </form>
                </div>
                @endif
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