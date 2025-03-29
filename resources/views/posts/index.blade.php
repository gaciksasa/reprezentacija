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
                <h3 class="card-title"><a href="{{ route('posts.show', $post->id) }}">{{ $post->post_title }}</a></h3>
                <p class="card-text small text-muted">
                    {{ \Carbon\Carbon::parse($post->post_date)->format('d.m.Y H:i') }}
                </p>
                <p class="card-text">
                    {{ Str::limit(strip_tags($post->post_excerpt ?: $post->post_content), 150) }}
                </p>
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary btn-md">Detaljnije</a>
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