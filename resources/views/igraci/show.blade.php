@extends('layouts.app')

@section('title', $igrac->ime_prezime)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $igrac->prezime }} {{ $igrac->ime }}</h1>
    <div>
        <a href="{{ route('igraci.edit', $igrac) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        <a href="{{ route('igraci.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Osnovni podaci</h5>
            </div>
            <div class="card-body">
                <div class="row">
                @if($igrac->fotografija_path)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $igrac->fotografija_path) }}" alt="{{ $igrac->prezime }} {{ $igrac->ime }}" 
                         class="img-fluid rounded">
                </div>
                @else
                    <div class="bg-light d-flex justify-content-center align-items-center rounded" style="width: 100%;">
                        <i class="fas fa-user fa-5x text-secondary"></i>
                    </div>
                @endif
            
            

                <table class="table">
                    <tr>
                        <th>Prezime i ime</th>
                        <td>{{ $igrac->prezime }} {{ $igrac->ime }}</td>
                    </tr>
                    <tr>
                        <th>Pozicija</th>
                        <td>{{ $igrac->pozicija ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Datum rođenja</th>
                        <td>{{ $igrac->datum_rodjenja ? $igrac->datum_rodjenja->format('d.m.Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Mesto rođenja</th>
                        <td>{{ $igrac->mesto_rodjenja ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Debitovao za reprezentaciju</th>
                        <td>{{ $igrac->debitovao_za_tim ? $igrac->debitovao_za_tim->format('d.m.Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Trenutni klub</th>
                        <td>
                            @if(isset($igrac->trenutniKlub) && $igrac->trenutniKlub)
                                {{ $igrac->trenutniKlub->klub }}
                                @if($igrac->trenutniKlub->drzava_kluba)
                                    <small>({{ $igrac->trenutniKlub->drzava_kluba }})</small>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Statistika za reprezentaciju</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h3>{{ $igrac->broj_nastupa }}</h3>
                        <p class="text-muted">Nastupi</p>
                    </div>
                    <div class="col-6 mb-3">
                        <h3>{{ $igrac->broj_golova }}</h3>
                        <p class="text-muted">Golovi</p>
                    </div>
                    <div class="col-6">
                        <h3>{{ $igrac->broj_zutih_kartona }}</h3>
                        <p class="text-muted">Žuti kartoni</p>
                    </div>
                    <div class="col-6">
                        <h3>{{ $igrac->broj_crvenih_kartona }}</h3>
                        <p class="text-muted">Crveni kartoni</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Klubovi u karijeri</h5>
            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addClubModal">
                <i class="fas fa-plus"></i> Dodaj klub
            </button>
        </div>
        <div class="card-body">
        @if($igrac->bivsiKlubovi->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Klub</th>
                        <th>Država</th>
                        <th>Sezona</th>
                        <th>Stepen takmičenja</th>
                        <th>Nastupi</th>
                        <th>Golovi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($igrac->bivsiKlubovi->sortByDesc('id') as $klub)
                    <tr>
                        <td>{{ $klub->naziv }}</td>
                        <td>{{ $klub->drzava ?? '-' }}</td>
                        <td>{{ $klub->sezona ?? '-' }}</td>
                        <td>{{ $klub->stepen_takmicenja ?? '-' }}</td>
                        <td align="right">{{ $klub->broj_nastupa ?? '-' }}</td>
                        <td align="right">{{ $klub->broj_golova ?? '-' }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" 
                                    onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-klub-{{ $klub->id }}').submit()">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-klub-{{ $klub->id }}" action="{{ route('igraci.deleteClub', $klub) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>                    
                    @endforeach
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td align="right">{{ $igrac->bivsiKlubovi->sum('broj_nastupa') }}</td>
                        <td align="right">{{ $igrac->bivsiKlubovi->sum('broj_golova') }}</td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        @else
            <p class="text-center text-muted">Nema evidentiranih klubova za ovog igrača.</p>
        @endif
        </div>
    </div>
        
        <!-- Kartice za utakmice i golove -->
        <div class="card mb-4">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="nastupi-tab" data-bs-toggle="tab" data-bs-target="#nastupi" type="button" role="tab">
                            Nastupi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="golovi-tab" data-bs-toggle="tab" data-bs-target="#golovi" type="button" role="tab">
                            Golovi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="kartoni-tab" data-bs-toggle="tab" data-bs-target="#kartoni" type="button" role="tab">
                            Kartoni
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="nastupi" role="tabpanel">
                        @if($igrac->sastavi->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Datum</th>
                                            <th>Utakmica</th>
                                            <th>Takmičenje</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($igrac->sastavi->sortByDesc('utakmica.datum') as $sastav)
                                        <tr>
                                            <td>{{ $sastav->utakmica ? $sastav->utakmica->datum->format('d.m.Y') : '-' }}</td>
                                            <td>
                                                @if($sastav->utakmica)
                                                    <a href="{{ route('utakmice.show', $sastav->utakmica) }}">
                                                        @php
                                                            $domacin = $sastav->utakmica->domacin_id ? \App\Models\Tim::find($sastav->utakmica->domacin_id) : null;
                                                            $gost = $sastav->utakmica->gost_id ? \App\Models\Tim::find($sastav->utakmica->gost_id) : null;
                                                        @endphp
                                                        {{ $domacin ? $domacin->naziv : '?' }} 
                                                        {{ $sastav->utakmica->rezultat_domacin }}-{{ $sastav->utakmica->rezultat_gost }} 
                                                        {{ $gost ? $gost->naziv : '?' }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $sastav->utakmica && $sastav->utakmica->takmicenje ? $sastav->utakmica->takmicenje->naziv : '-' }}</td>
                                            <td>
                                                @if($sastav->starter)
                                                    <span class="badge bg-success">Starter</span>
                                                @else
                                                    <span class="badge bg-secondary">Rezerva</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih nastupa za ovog igrača.</p>
                        @endif
                    </div>
                    
                    <div class="tab-pane fade" id="golovi" role="tabpanel">
                        @if($igrac->golovi->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Datum</th>
                                            <th>Utakmica</th>
                                            <th>Minut</th>
                                            <th>Tip</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($igrac->golovi->sortByDesc('utakmica.datum') as $gol)
                                        <tr>
                                            <td>{{ $gol->utakmica ? $gol->utakmica->datum->format('d.m.Y') : '-' }}</td>
                                            <td>
                                                @if($gol->utakmica)
                                                    <a href="{{ route('utakmice.show', $gol->utakmica) }}">
                                                        @php
                                                            $domacin = $gol->utakmica->domacin_id ? \App\Models\Tim::find($gol->utakmica->domacin_id) : null;
                                                            $gost = $gol->utakmica->gost_id ? \App\Models\Tim::find($gol->utakmica->gost_id) : null;
                                                        @endphp
                                                        {{ $domacin ? $domacin->naziv : '?' }} 
                                                        {{ $gol->utakmica->rezultat_domacin }}-{{ $gol->utakmica->rezultat_gost }} 
                                                        {{ $gost ? $gost->naziv : '?' }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $gol->minut }}′</td>
                                            <td>
                                                @if($gol->auto_gol)
                                                    <span class="badge bg-warning text-dark">Autogol</span>
                                                @elseif($gol->penal)
                                                    <span class="badge bg-info">Penal</span>
                                                @else
                                                    <span class="badge bg-success">Iz igre</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih golova za ovog igrača.</p>
                        @endif
                    </div>
                    
                    <div class="tab-pane fade" id="kartoni" role="tabpanel">
                        @if($igrac->kartoni->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Datum</th>
                                            <th>Utakmica</th>
                                            <th>Minut</th>
                                            <th>Tip kartona</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($igrac->kartoni->sortByDesc('utakmica.datum') as $karton)
                                        <tr>
                                            <td>{{ $karton->utakmica ? $karton->utakmica->datum->format('d.m.Y') : '-' }}</td>
                                            <td>
                                                @if($karton->utakmica)
                                                    <a href="{{ route('utakmice.show', $karton->utakmica) }}">
                                                        @php
                                                            $domacin = $karton->utakmica->domacin_id ? \App\Models\Tim::find($karton->utakmica->domacin_id) : null;
                                                            $gost = $karton->utakmica->gost_id ? \App\Models\Tim::find($karton->utakmica->gost_id) : null;
                                                        @endphp
                                                        {{ $domacin ? $domacin->naziv : '?' }} 
                                                        {{ $karton->utakmica->rezultat_domacin }}-{{ $karton->utakmica->rezultat_gost }} 
                                                        {{ $gost ? $gost->naziv : '?' }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $karton->minut }}′</td>
                                            <td>
                                                @if($karton->tip == 'zuti')
                                                    <span class="badge bg-warning text-dark">Žuti</span>
                                                @else
                                                    <span class="badge bg-danger">Crveni</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-center text-muted">Nema evidentiranih kartona za ovog igrača.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal za dodavanje novog kluba -->
<div class="modal fade" id="addClubModal" tabindex="-1" aria-labelledby="addClubModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('igraci.updateClub', $igrac) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addClubModalLabel">Dodaj klub u karijeri</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="klub" class="form-label">Klub *</label>
                        <input type="text" class="form-control" id="klub" name="klub" required>
                    </div>
                    <div class="mb-3">
                        <label for="drzava_kluba" class="form-label">Država kluba</label>
                        <input type="text" class="form-control" id="drzava_kluba" name="drzava_kluba">
                    </div>
                    <div class="mb-3">
                        <label for="sezona" class="form-label">Sezona *</label>
                        <input type="text" class="form-control" id="sezona" name="sezona" placeholder="npr. 1989-90" required>
                        <small class="form-text text-muted">Format: YYYY-YY (npr. 1989-90)</small>
                    </div>
                    <div class="mb-3">
                        <label for="stepen_takmicenja" class="form-label">Stepen takmičenja</label>
                        <input type="text" class="form-control" id="stepen_takmicenja" name="stepen_takmicenja">
                    </div>
                    <div class="mb-3">
                        <label for="broj_nastupa" class="form-label">Broj nastupa</label>
                        <input type="number" class="form-control" id="broj_nastupa" name="broj_nastupa" min="0">
                    </div>
                    <div class="mb-3">
                        <label for="broj_golova" class="form-label">Broj golova</label>
                        <input type="number" class="form-control" id="broj_golova" name="broj_golova" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
                    <button type="submit" class="btn btn-primary">Sačuvaj</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection