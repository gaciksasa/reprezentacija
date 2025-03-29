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

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between">
        <span>
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
        </span>
        <span>
            <strong>Tip:</strong> {{ $post->post_type }}
        </span>
        <span>
            <strong>Datum objave:</strong> {{ $post->post_date ? $post->post_date->format('d.m.Y H:i') : '-' }}
        </span>
    </div>
    <div class="card-body">
        @if($post->post_excerpt)
            <div class="mb-4">
                <h5>Izvod:</h5>
                <div class="bg-light p-3 rounded">
                    {{ $post->post_excerpt }}
                </div>
            </div>
        @endif
        
        <div class="post-content">
            {!! $post->post_content !!}
        </div>
    </div>
    <div class="card-footer text-muted">
        <div class="row">
            <div class="col-md-6">
                <strong>ID:</strong> {{ $post->id }}
            </div>
            <div class="col-md-6">
                <strong>Slug:</strong> {{ $post->post_name }}
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <strong>Kreiran:</strong> {{ $post->post_date ? $post->post_date->format('d.m.Y H:i') : '-' }}
            </div>
            <div class="col-md-6">
                <strong>Zadnja izmena:</strong> {{ $post->post_modified ? $post->post_modified->format('d.m.Y H:i') : '-' }}
            </div>
        </div>
    </div>
</div>

@endsection