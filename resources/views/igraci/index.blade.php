@extends('layouts.app')

@section('title', 'Igrači')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Igrači</h1>
    <a href="{{ route('igraci.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novi igrač
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ime i prezime</th>
                        <th>Tim</th>
                        <th>Pozicija</th>
                        <th>Klub</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($igraci as $igrac)
                    <tr>
                        <td>
                            <a href="{{ route('igraci.show', $igrac) }}">
                                {{ $igrac->ime }} {{ $igrac->prezime }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('timovi.show', $igrac->tim) }}">
                                {{ $igrac->tim->naziv }}
                            </a>
                        </td>
                        <td>{{ $igrac->pozicija ?? '-' }}</td>
                        <td>
                            @if($igrac->klub)
                                {{ $igrac->klub }}
                                @if($igrac->drzava_kluba)
                                    <small>({{ $igrac->drzava_kluba }})</small>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('igraci.show', $igrac) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('igraci.edit', $igrac) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-igrac-{{ $igrac->id }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-igrac-{{ $igrac->id }}" action="{{ route('igraci.destroy', $igrac) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Nema igrača u bazi podataka</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $igraci->links() }}
        </div>
    </div>
</div>
@endsection