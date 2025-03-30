@extends('layouts.app')

@section('title', $kategorija->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $kategorija->name }}</h1>
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

<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mb-0">Detalji kategorije</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Naziv</th>
                        <td>{{ $kategorija->name }}</td>
                    </tr>
                    <tr>
                        <th>Slug</th>
                        <td>{{ $kategorija->slug }}</td>
                    </tr>
                    @if($kategorija->parent)
                    <tr>
                        <th>Nadređena kategorija</th>
                        <td>
                            <a href="{{ route('kategorije.show', $kategorija->parent) }}">
                                {{ $kategorija->parent->name }}
                            </a>
                        </td>
                    </tr>
                    @endif
                    @if($kategorija->description)
                    <tr>
                        <th>Opis</th>
                        <td>{{ $kategorija->description }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        @if($kategorija->children->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h2 class="card-title mb-0">Podkategorije</h2>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($kategorija->children as $child)
                    <li class="list-group-item">
                        <a href="{{ route('kategorije.show', $child) }}">{{ $child->name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mb-0">Članci u kategoriji</h2>
            </div>
            <div class="card-body">
                @if($kategorija->posts->count() > 0)
                    <div class="list-group">
                        @foreach($kategorija->posts as $post)
                            <a href="{{ route('posts.show', $post) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{ $post->post_title }}</h5>
                                    <small>{{ $post->post_date->format('d.m.Y') }}</small>
                                </div>
                                <p class="mb-1">{{ Str::limit(strip_tags($post->post_excerpt ?: $post->post_content), 150) }}</p>
                                <small class="text-muted">
                                    Status: {{ ucfirst($post->post_status) }}
                                </small>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted">Nema članaka u ovoj kategoriji.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection