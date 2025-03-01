@extends('layouts.app')

@section('title', 'Takmičenja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Takmičenja</h1>
    <a href="{{ route('takmicenja.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novo takmičenje
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Naziv</th>
                        <th>Sezona</th>
                        <th>Organizator</th>
                        <th>Broj utakmica</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($takmicenja as $takmicenje)
                    <tr>
                        <td>
                            <a href="{{ route('takmicenja.show', $takmicenje) }}">
                                {{ $takmicenje->naziv }}
                            </a>
                        </td>
                        <td>{{ $takmicenje->sezona ?? '-' }}</td>
                        <td>{{ $takmicenje->organizator ?? '-' }}</td>
                        <td>{{ $takmicenje->utakmice->count() }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('takmicenja.show', $takmicenje) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('takmicenja.edit', $takmicenje) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-takmicenje-{{ $takmicenje->id }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-takmicenje-{{ $takmicenje->id }}" action="{{ route('takmicenja.destroy', $takmicenje) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Nema takmičenja u bazi podataka</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection