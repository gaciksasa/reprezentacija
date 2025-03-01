@extends('layouts.app')

@section('title', 'Stadioni')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Stadioni</h1>
    <a href="{{ route('stadioni.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novi stadion
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Naziv</th>
                        <th>Grad</th>
                        <th>Zemlja</th>
                        <th>Kapacitet</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stadioni as $stadion)
                    <tr>
                        <td>
                            <a href="{{ route('stadioni.show', $stadion) }}">
                                {{ $stadion->naziv }}
                            </a>
                        </td>
                        <td>{{ $stadion->grad }}</td>
                        <td>{{ $stadion->zemlja }}</td>
                        <td>{{ $stadion->kapacitet ? number_format($stadion->kapacitet) : '-' }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('stadioni.show', $stadion) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('stadioni.edit', $stadion) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-stadion-{{ $stadion->id }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-stadion-{{ $stadion->id }}" action="{{ route('stadioni.destroy', $stadion) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Nema stadiona u bazi podataka</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection