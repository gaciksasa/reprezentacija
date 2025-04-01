@extends('layouts.app')

@section('title', $post->post_title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $post->post_title }}</h1>
    <div>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        @endif
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

<div class="post-details row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-body">
                @if($post->featured_image)
                    <img src="{{ asset('storage/uploads/' . $post->featured_image) }}" 
                         alt="{{ $post->post_title }}" 
                         class="img-fluid mb-4">
                @endif
                <div class="post-content">
                    {!! $post->post_content !!}
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Detalji</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <strong>Status:</strong>
                        @if($post->post_status == 'publish')
                            <span class="badge bg-success">Objavljeno</span>
                        @elseif($post->post_status == 'draft')
                            <span class="badge bg-warning text-dark">Nacrt</span>
                        @elseif($post->post_status == 'pending')
                            <span class="badge bg-info">Na čekanju</span>
                        @else
                            <span class="badge bg-secondary">{{ $post->post_status }}</span>
                        @endif
                    </li>
                    <li class="list-group-item">
                        <strong>Tip:</strong>
                        @if($post->post_type == 'post')
                            <span class="badge bg-primary">Objava</span>
                        @elseif($post->post_type == 'page')
                            <span class="badge bg-info">Stranica</span>
                        @else
                            <span class="badge bg-secondary">{{ $post->post_type }}</span>
                        @endif
                    </li>
                    <li class="list-group-item">
                        <strong>Autor:</strong>
                        @if($post->author)
                            {{ $post->author->name }}
                        @else
                            Nepoznat
                        @endif
                    </li>
                    <li class="list-group-item">
                        <strong>Objavljeno:</strong>
                        {{ $post->post_date->format('d.m.Y H:i') }}
                    </li>
                    <li class="list-group-item">
                        <strong>Poslednja izmena:</strong>
                        {{ $post->post_modified->format('d.m.Y H:i') }}
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Kategorije</h5>
            </div>
            <div class="card-body">
                @if($post->kategorije->count() > 0)
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($post->kategorije as $kategorija)
                            <a href="{{ route('kategorije.show', $kategorija) }}" class="btn btn-sm btn-outline-primary">
                                {{ $kategorija->name }}
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">Nema dodeljenih kategorija.</p>
                @endif
            </div>
        </div>
        
        @if($post->post_excerpt)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Izvod</h5>
            </div>
            <div class="card-body">
                {{ $post->post_excerpt }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection