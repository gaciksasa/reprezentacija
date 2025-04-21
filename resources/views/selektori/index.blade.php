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
                            // Prvo prikupljamo sve mandate i pravilno ih sortiramo po početku mandata
                            $sviMandati = collect();
                            
                            // Dodajemo mandate komisija
                            foreach($selektori as $selektor) {
                                $komisijaMandate = $selektor->mandati->where('komisija', true);
                                
                                foreach($komisijaMandate as $mandat) {
                                    // Dodaj samo jednom za jednu komisiju (po početku mandata i timu)
                                    $kljuc = $mandat->tim_id . '-' . $mandat->pocetak_mandata->format('Y-m-d');
                                    
                                    if (!isset($komisije[$kljuc])) {
                                        $komisije[$kljuc] = [
                                            'tim_id' => $mandat->tim_id,
                                            'tim_naziv' => $mandat->tim->naziv,
                                            'pocetak' => $mandat->pocetak_mandata,
                                            'kraj' => $mandat->kraj_mandata,
                                            'glavni_selektor' => $mandat->glavni_selektor ? $selektor : null,
                                            'clanovi' => $mandat->glavni_selektor ? [] : [$selektor],
                                            'statistika' => $mandat->statistika,
                                            'mandat_id' => $mandat->id,
                                            'tip' => 'komisija'
                                        ];
                                        
                                        // Dodaj komisiju u sve mandate za sortiranje
                                        $sviMandati->push((object)[
                                            'id' => $kljuc,
                                            'pocetak_mandata' => $mandat->pocetak_mandata,
                                            'tip' => 'komisija'
                                        ]);
                                    } else {
                                        if ($mandat->glavni_selektor) {
                                            $komisije[$kljuc]['glavni_selektor'] = $selektor;
                                        } else {
                                            $komisije[$kljuc]['clanovi'][] = $selektor;
                                        }
                                    }
                                }
                            }
                            
                            // Dodajemo pojedinačne mandate
                            foreach($selektori as $selektor) {
                                $pojedinacniMandati = $selektor->mandati->where('komisija', false);
                                
                                foreach($pojedinacniMandati as $mandat) {
                                    $mandat->selektor = $selektor;
                                    $sviMandati->push($mandat);
                                }
                            }
                            
                            // Sortiramo sve mandate po datumu početka, od najnovijih ka najstarijim
                            $sviMandati = $sviMandati->sortByDesc(function($mandat) {
                                return $mandat->pocetak_mandata->timestamp;
                            });
                        @endphp
                        
                        @foreach($sviMandati as $mandat)
                            @if(isset($mandat->tip) && $mandat->tip === 'komisija')
                                @php
                                    $komisija = $komisije[$mandat->id];
                                @endphp
                                <tr>
                                    <td>
                                        @if($komisija['glavni_selektor'])
                                            <a href="{{ route('selektori.show', $komisija['glavni_selektor']) }}">
                                                {{ $komisija['glavni_selektor']->prezime }} {{ $komisija['glavni_selektor']->ime }}
                                            </a><br>
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
                            @else
                                <tr>
                                    <td>
                                        <a href="{{ route('selektori.show', $mandat->selektor) }}">
                                            {{ $mandat->selektor->prezime }} {{ $mandat->selektor->ime }}
                                        </a>
                                        @if($mandat->kraj_mandata === null)
                                            <span class="badge bg-success">Aktivan</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $mandat->pocetak_mandata->format('d.m.Y') }} - 
                                        {{ $mandat->kraj_mandata ? $mandat->kraj_mandata->format('d.m.Y') : 'danas' }}
                                        
                                        @if($mandat->v_d_status)
                                            <span class="badge bg-warning text-dark">v.d.</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $mandatStatistika = $mandat->statistika;
                                        @endphp
                                        
                                        @if($mandatStatistika['utakmice'] > 0)
                                            {{ $mandatStatistika['utakmice'] }} utakmice<br>
                                            {{ $mandatStatistika['pobede'] }}-{{ $mandatStatistika['remiji'] }}-{{ $mandatStatistika['porazi'] }}
                                            ({{ $mandatStatistika['procenatPobeda'] }}%)
                                        @else
                                            -
                                        @endif
                                    </td>
                                    @if(Auth::check() && Auth::user()->hasEditAccess())
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('selektori.show', $mandat->selektor) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('selektori.edit', $mandat->selektor) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-mandat-{{ $mandat->id }}').submit()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-mandat-{{ $mandat->id }}" 
                                                    action="{{ route('selektori.obrisiMandat', $mandat->id) }}" 
                                                    method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                            @endif
                        @endforeach

                        @if(empty($komisije) && $sviMandati->count() == 0)
                        <tr>
                            <td colspan="{{ Auth::check() && Auth::user()->hasEditAccess() ? '4' : '3' }}" class="text-center">
                                Nema selektora u bazi podataka
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection