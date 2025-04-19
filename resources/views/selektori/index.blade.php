@extends('layouts.app')

@section('title', 'Selektori')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Selektori</h1>
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <div>
        <a href="{{ route('selektor-komisija.create') }}" class="btn btn-info me-2">
            <i class="fas fa-users"></i> Nova komisija
        </a>
        <a href="{{ route('selektori.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novi selektor
        </a>
    </div>
    @endif
</div>

<div class="selektori">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Selektor</th>
                            <th>Period</th>
                            <th>Statistika</th>
                            @if(Auth::check() && Auth::user()->hasEditAccess())
                            <th>Akcije</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($selektori as $selektor)
                        <tr>
                            <td>
                                <a href="{{ route('selektori.show', $selektor) }}">
                                    {{ $selektor->prezime }} {{ $selektor->ime }}
                                </a>
                                @if($selektor->aktivan)
                                    <span class="badge bg-success">Aktivan</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $prviMandat = $selektor->prviMandat;
                                    $poslednjiMandat = $selektor->poslednjiMandat;
                                @endphp
                                
                                @if($prviMandat && $poslednjiMandat)
                                    {{ $prviMandat->pocetak_mandata->format('d.m.Y') }} - 
                                    {{ $poslednjiMandat->kraj_mandata ? $poslednjiMandat->kraj_mandata->format('d.m.Y') : 'danas' }}
                                    
                                    @if($selektor->mandati->count() > 1)
                                        <span class="badge bg-info">{{ $selektor->mandati->count() }} mandata</span>
                                    @endif
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @php
                                    $statistika = $selektor->statistika;
                                @endphp
                                
                                @if($statistika['utakmice'] > 0)
                                    {{ $statistika['utakmice'] }} utakmice<br>
                                    {{ $statistika['pobede'] }}-{{ $statistika['remiji'] }}-{{ $statistika['porazi'] }}
                                    ({{ $statistika['procenatPobeda'] }}%)
                                @else
                                    -
                                @endif
                            </td>
                            @if(Auth::check() && Auth::user()->hasEditAccess())
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('selektori.show', $selektor) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('selektori.edit', $selektor) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-selektor-{{ $selektor->id }}').submit()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-selektor-{{ $selektor->id }}" action="{{ route('selektori.destroy', $selektor) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Nema selektora u bazi podataka</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection