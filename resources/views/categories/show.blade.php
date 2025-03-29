@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $category->name }}</h1>
    <div>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        @endif
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detalji kategorije</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>Naziv:</th>
                        <td>{{ $category->name }}</td>
                    </tr>
                    <tr>
                        <th>Slug:</th>
                        <td>{{ $category->slug }}</td>
                    </tr>
                    <tr>
                        <th>Nadređena kategorija:</th>
                        <td>
                            @if($category->parent)
                                <a href="{{ route('categories.show', $category->parent) }}">
                                    {{ $category->parent->name }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Broj postova:</th>
                        <td>{{ $category->posts->count() }}</td>
                    </tr>
                    <tr>
                        <th>Kreirano:</th>
                        <td>{{ $category->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Poslednja izmena:</th>
                        <td>{{ $category->updated_at->format('d.m.Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        @if($category->description)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Opis</h5>
            </div>
            <div class="card-body">
                {{ $category->description }}
            </div>
        </div>
        @endif
        
        @if($category->children->count() > 0)
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Podkategorije</h5>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @foreach($category->children as $child)
                        <a href="{{ route('categories.show', $child) }}" class="list-group-item list-group-item-action">
                            {{ $child->name }}
                            <span class="badge bg-secondary float-end">{{ $child->posts->count() }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Postovi u kategoriji</h5>
            </div>
            <div class="card-body">
                @if($category->posts->count() > 0)
                    <div class="list-group">
                        @foreach($category->posts as $post)
                            <a href="{{ route('posts.show', $post) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-1">{{ $post->post_title }}</h5>
                                    <small>{{ $post->post_date->format('d.m.Y') }}</small>
                                </div>
                                @if($post->post_excerpt)
                                    <p class="mb-1">{{ Str::limit(strip_tags($post->post_excerpt), 150) }}</p>
                                @else
                                    <p class="mb-1">{{ Str::limit(strip_tags($post->post_content), 150) }}</p>
                                @endif
                                <small>
                                    Status: 
                                    @if($post->post_status == 'publish')
                                        <span class="badge bg-success">Objavljeno</span>
                                    @elseif($post->post_status == 'draft')
                                        <span class="badge bg-warning text-dark">Nacrt</span>
                                    @elseif($post->post_status == 'pending')
                                        <span class="badge bg-info">Na čekanju</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $post->post_status }}</span>
                                    @endif
                                </small>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted">Nema postova u ovoj kategoriji.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection