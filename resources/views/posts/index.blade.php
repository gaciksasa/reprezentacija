@extends('layouts.app')

@section('title', 'Objave')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Objave</h1>
    <div>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nova objava
        </a>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naslov</th>
                        <th>Status</th>
                        <th>Tip</th>
                        <th>Datum</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>
                            <a href="{{ route('posts.show', $post) }}">
                                {{ Str::limit($post->post_title, 50) }}
                            </a>
                        </td>
                        <td>
                            @if($post->post_status == 'publish')
                                <span class="badge bg-success">Objavljeno</span>
                            @elseif($post->post_status == 'draft')
                                <span class="badge bg-warning text-dark">Nacrt</span>
                            @elseif($post->post_status == 'pending')
                                <span class="badge bg-info">Na čekanju</span>
                            @else
                                <span class="badge bg-secondary">{{ $post->post_status }}</span>
                            @endif
                        </td>
                        <td>{{ $post->post_type }}</td>
                        <td>{{ $post->post_date ? $post->post_date->format('d.m.Y H:i') : '-' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-post-{{ $post->id }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-post-{{ $post->id }}" action="{{ route('posts.destroy', $post) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Nema objava u bazi podataka</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection