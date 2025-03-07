@extends('layouts.app')

@section('title', 'Bilansi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Bilans protiv reprezentacija od 1920 do danas</h1>
    <a href="{{ route('timovi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novi tim
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Država</th>
                        <th class="text-center">Ut</th>
                        <th class="text-center">W</th>
                        <th class="text-center">D</th>
                        <th class="text-center">L</th>
                        <th class="text-center">G</th>
                        <th class="text-center">A</th>
                        <th class="text-center">+/-</th>
                        <th class="text-center">g/m</th>
                        <th class="text-center">g/m</th>
                        <th class="text-center">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($timovi as $tim)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($tim->zastava_url)
                                    <img src="{{ zastava_url($tim->zastava_url) }}" alt="{{ $tim->naziv }}" height="12" class="me-2">
                                @endif
                                <a href="{{ route('timovi.show', $tim) }}">
                                    {{ $tim->naziv }}
                                </a>
                            </div>
                        </td>
                        <td class="text-center">{{ $tim->stats['ut'] }}</td>
                        <td class="text-center">{{ $tim->stats['w'] }}</td>
                        <td class="text-center">{{ $tim->stats['d'] }}</td>
                        <td class="text-center">{{ $tim->stats['l'] }}</td>
                        <td class="text-center">{{ $tim->stats['g'] }}</td>
                        <td class="text-center">{{ $tim->stats['a'] }}</td>
                        <td class="text-center {{ $tim->stats['diff'] > 0 ? 'text-success' : ($tim->stats['diff'] < 0 ? 'text-danger' : '') }}">
                            {{ $tim->stats['diff'] > 0 ? '+' : '' }}{{ $tim->stats['diff'] }}
                        </td>
                        <td class="text-center">{{ $tim->stats['g_per_match'] }}</td>
                        <td class="text-center">{{ $tim->stats['a_per_match'] }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('timovi.show', $tim) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('timovi.edit', $tim) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-tim-{{ $tim->id }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-tim-{{ $tim->id }}" action="{{ route('timovi.destroy', $tim) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center">Nema timova u bazi podataka</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection