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

<div class="card">
    <div class="card-body">
        @if($posts->count() > 0)
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('posts.show', $post->id) }}">{{ $post->post_title }}</a>
                                </h5>
                                <p class="card-text text-muted">
                                    <small>{{ $post->post_date->format('d.m.Y') }}</small>
                                </p>
                                <p class="card-text">
                                    {{ $post->post_excerpt ?: Str::limit(strip_tags($post->post_content), 150) }}
                                </p>
                            </div>
                            @if(Auth::check() && Auth::user()->hasEditAccess())
                            <div class="card-footer">
                                <div class="btn-group w-100">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Izmeni
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="document.getElementById('delete-post-{{ $post->id }}').submit()">
                                        <i class="fas fa-trash"></i> Obriši
                                    </button>
                                    <form id="delete-post-{{ $post->id }}" action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-center text-muted">Nema objavljenih vesti.</p>
        @endif
    </div>
</div>
@endsection