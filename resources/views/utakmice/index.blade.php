@extends('layouts.app')

@section('title', 'Utakmice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Utakmice
    @if(isset($dekada))
        u periodu {{ $dekada }}
    @endif
    </h1>
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <a href="{{ route('utakmice.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova utakmica
    </a>
    @endif
</div>

@if($utakmice->where('datum', '>', now())->count() > 0)
<div class="utakmice card mb-4">
    <div class="card-header">
        <h2 class="card-title mb-0">Predstojeće utakmice</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th class="d-none d-lg-table-cell">Takmičenje</th>
                        <th>Domaćin</th>
                        <th>Gost</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($utakmice->where('datum', '>', now())->sortBy('datum') as $utakmica)
                    <tr>
                        <td>{{ $utakmica->datum->format('d.m.Y') }}</td>
                        <td class="d-none d-lg-table-cell">
                            @if($utakmica->takmicenje)
                                {{ $utakmica->takmicenje->naziv }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('timovi.show', $utakmica->domacin) }}">
                                {{ $utakmica->domacin->naziv }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('timovi.show', $utakmica->gost) }}">
                                {{ $utakmica->gost->naziv }}
                            </a>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <a href="{{ route('utakmice.edit', $utakmica) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-utakmica-{{ $utakmica->id }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-utakmica-{{ $utakmica->id }}" action="{{ route('utakmice.destroy', $utakmica) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<div class="utakmice card">
    <div class="card-header">
        <h2 class="card-title mb-0">Prethodne utakmice</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th class="d-none d-lg-table-cell">Takmičenje</th>
                        <th>Domaćin</th>
                        <th>Rezultat</th>
                        <th>Gost</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($utakmice->where('datum', '<=', now())->sortByDesc('datum') as $utakmica)
                    <tr class="align-middle">
                        <td>{{ $utakmica->datum->format('d.m.Y') }}</td>
                        <td class="d-none d-lg-table-cell">
                            @if($utakmica->takmicenje)
                                {{ $utakmica->takmicenje->naziv }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('timovi.show', $utakmica->domacin) }}">
                                {{ $utakmica->domacin->naziv }}
                            </a>
                        </td>
                        <td class="text-center">
                            <strong>{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</strong>
                            @if($utakmica->imao_jedanaesterce)
                                <small class="d-block">
                                    ( {{ $utakmica->jedanaesterci_domacin }} - {{ $utakmica->jedanaesterci_gost }} pen )
                                </small>
                            @endif
                            <!-- <small class="text-muted d-block">
                                {{ $utakmica->poluvremenskiRezultat }}
                            </small> -->
                        </td>
                        <td>
                            <a href="{{ route('timovi.show', $utakmica->gost) }}">
                                {{ $utakmica->gost->naziv }}
                            </a>
                        </td>
                        
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <a href="{{ route('utakmice.edit', $utakmica) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-utakmica-{{ $utakmica->id }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-utakmica-{{ $utakmica->id }}" action="{{ route('utakmice.destroy', $utakmica) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </div>
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $utakmice->links() }}
        </div>
    </div>
</div>
@endsection