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
                        @php
                            // Grupišemo selektore po mandatima koji su deo komisije
                            $komisije = [];
                            $samostalniSelektori = [];
                            
                            foreach($selektori as $selektor) {
                                // Proveriti da li je u komisiji koja već postoji u nizu
                                $komisijskiMandat = $selektor->mandati->where('komisija', true)->first();
                                
                                if ($komisijskiMandat) {
                                    $kljuc = $komisijskiMandat->tim_id . '-' . $komisijskiMandat->pocetak_mandata->format('Y-m-d');
                                    
                                    if (!isset($komisije[$kljuc])) {
                                        $komisije[$kljuc] = [
                                            'tim_id' => $komisijskiMandat->tim_id,
                                            'tim_naziv' => $komisijskiMandat->tim->naziv,
                                            'pocetak' => $komisijskiMandat->pocetak_mandata,
                                            'kraj' => $komisijskiMandat->kraj_mandata,
                                            'glavni_selektor' => null,
                                            'clanovi' => [],
                                            'statistika' => $komisijskiMandat->statistika,
                                            'mandat_id' => $komisijskiMandat->id
                                        ];
                                    }
                                    
                                    if ($komisijskiMandat->glavni_selektor) {
                                        $komisije[$kljuc]['glavni_selektor'] = $selektor;
                                    } else {
                                        $komisije[$kljuc]['clanovi'][] = $selektor;
                                    }
                                } else {
                                    $samostalniSelektori[] = $selektor;
                                }
                            }
                        @endphp
                        
                        {{-- Prvo prikazujemo komisije --}}
                        @foreach($komisije as $komisija)
                        <tr>
                            <td>
                                <strong>Selektorska komisija:</strong><br>
                                @if($komisija['glavni_selektor'])
                                    <a href="{{ route('selektori.show', $komisija['glavni_selektor']) }}">
                                        {{ $komisija['glavni_selektor']->prezime }} {{ $komisija['glavni_selektor']->ime }}
                                    </a>
                                    <span class="badge bg-primary">Glavni</span><br>
                                @endif
                                
                                @foreach($komisija['clanovi'] as $clan)
                                    <a href="{{ route('selektori.show', $clan) }}">
                                        {{ $clan->prezime }} {{ $clan->ime }}
                                    </a><br>
                                @endforeach
                            </td>
                            <td>
                                {{ $komisija['pocetak']->format('d.m.Y') }} - 
                                {{ $komisija['kraj'] ? $komisija['kraj']->format('d.m.Y') : 'danas' }}
                            </td>
                            <td>
                                @if($komisija['statistika']['utakmice'] > 0)
                                    {{ $komisija['statistika']['utakmice'] }} utakmice<br>
                                    {{ $komisija['statistika']['pobede'] }}-{{ $komisija['statistika']['remiji'] }}-{{ $komisija['statistika']['porazi'] }}
                                    ({{ $komisija['statistika']['procenatPobeda'] }}%)
                                @else
                                    -
                                @endif
                            </td>
                            @if(Auth::check() && Auth::user()->hasEditAccess())
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('selektor-komisija.edit', $komisija['mandat_id']) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                        
                        {{-- Zatim prikazujemo samostalne selektore --}}
                        @foreach($samostalniSelektori as $selektor)
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
                                    
                                    @if($selektor->mandati->where('komisija', false)->count() > 1)
                                        <span class="badge bg-info">{{ $selektor->mandati->where('komisija', false)->count() }} mandata</span>
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
                        @endforeach

                        @if(count($komisije) == 0 && count($samostalniSelektori) == 0)
                        <tr>
                            <td colspan="5" class="text-center">Nema selektora u bazi podataka</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection