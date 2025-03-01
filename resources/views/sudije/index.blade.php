@extends('layouts.app')

@section('title', 'Sudije')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Sudije</h1>
    <a href="{{ route('sudije.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova sudija
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Ime i prezime</th>
                        <th>Nacionalnost</th>
                        <th>Broj utakmica</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sudije as $sudija)
                    <tr>
                        <td>
                            <a href="{{ route('sudije.show', $sudija) }}">
                                {{ $sudija->ime }} {{ $sudija->prezime }}
                            </a>
                        </td>
                        <td>{{ $sudija->nacionalnost }}</td>
                        <td>{{ $sudija->utakmice->count() }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('sudije.show', $sudija) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('sudije.edit', $sudija) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-sudija-{{ $sudija->id }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-sudija-{{ $sudija->id }}" action="{{ route('sudije.destroy', $sudija) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Nema sudija u bazi podataka</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection