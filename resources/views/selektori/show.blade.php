@extends('layouts.app')

@section('title', $selektor->ime_prezime)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $selektor->prezime }} {{ $selektor->ime }}</h1>
    <div>
        <a href="{{ route('selektori.edit', $selektor) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        <a href="{{ route('selektori.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Osnovni podaci</h5>
            </div>
            <div class="card-body">
                @if($selektor->fotografija_path)
                    <div class="text-center mb-3">
                        <img src="{{ asset('storage/' . $selektor->fotografija_path) }}" alt="{{ $selektor->ime_prezime }}" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                @else
                    <div class="text-center mb-3">
                        <img src="{{ asset('img/no-photo.jpg')}}" alt="No photo" class="img-fluid rounded" style="max-height: 200px;">
                    </div>
                @endif
                
                <table class="table">
                    <tr>
                        <th>Ime i prezime</th>
                        <td>{{ $selektor->prezime }} {{ $selektor->ime }}</td>
                    </tr>
                    @if($selektor->datum_rodjenja)
                    <tr>
                        <th>Datum rođenja</th>
                        <td>{{ $selektor->datum_rodjenja->format('d.m.Y') }}</td>
                    </tr>
                    @endif
                    @if($selektor->mesto_rodjenja)
                    <tr>
                        <th>Mesto rođenja</th>
                        <td>{{ $selektor->mesto_rodjenja }}</td>
                    </tr>
                    @endif
                    @if($selektor->datum_smrti)
                    <tr>
                        <th>Datum smrti</th>
                        <td>{{ $selektor->datum_smrti->format('d.m.Y') }}</td>
                    </tr>
                    @endif
                    @if($selektor->mesto_smrti)
                    <tr>
                        <th>Mesto smrti</th>
                        <td>{{ $selektor->mesto_smrti }}</td>
                    </tr>
                    @endif
                    @if($selektor->drzavljanstvo)
                    <tr>
                        <th>Državljanstvo</th>
                        <td>{{ $selektor->drzavljanstvo }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>

        <!-- Ukupna statistika -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Ukupna statistika</h5>
            </div>
            <div class="card-body">
                @php
                    $statistika = $selektor->statistika;
                @endphp
                
                @if($statistika['utakmice'] > 0)
                    <div class="row text-center">
                        <div class="col-4 mb-3">
                            <h3>{{ $statistika['utakmice'] }}</h3>
                            <p class="text-muted">Utakmice</p>
                        </div>
                        <div class="col-4 mb-3">
                            <h3>{{ $statistika['pobede'] }}</h3>
                            <p class="text-muted">Pobede</p>
                        </div>
                        <div class="col-4 mb-3">
                            <h3>{{ $statistika['remiji'] }}</h3>
                            <p class="text-muted">Remiji</p>
                        </div>
                        <div class="col-4 mb-3">
                            <h3>{{ $statistika['porazi'] }}</h3>
                            <p class="text-muted">Porazi</p>
                        </div>
                        <div class="col-4 mb-3">
                            <h3>{{ $statistika['datiGolovi'] }}</h3>
                            <p class="text-muted">Dati golovi</p>
                        </div>
                        <div class="col-4 mb-3">
                            <h3>{{ $statistika['primljeniGolovi'] }}</h3>
                            <p class="text-muted">Primljeni</p>
                        </div>
                    </div>
                    
                    <div class="text-center mt-2">
                        <h4>{{ $statistika['procenatPobeda'] }}%</h4>
                        <p class="text-muted">Procenat pobeda</p>
                    </div>
                @else
                    <p class="text-center text-muted">Nema podataka o utakmicama.</p>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Biografija -->
            @if($selektor->biografija)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Biografija</h5>
                    </div>
                    <div class="card-body">
                        {{ $selektor->biografija }}
                    </div>
                </div>
            @endif
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Mandati</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMandatModal">
                    <i class="fas fa-plus"></i> Dodaj mandat
                </button>
            </div>
            <div class="card-body">
                @if($selektor->mandati->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tim</th>
                                    <th>Period</th>
                                    <th>Utakmice</th>
                                    <th>Učinak</th>
                                    <th>Akcije</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selektor->mandati->sortByDesc('pocetak_mandata') as $mandat)
                                @php
                                    $statistika = $mandat->statistika;
                                @endphp
                                <tr>
                                    <td>{{ $mandat->tim->naziv }}</td>
                                    <td>
                                        {{ $mandat->pocetak_mandata->format('d.m.Y') }} - 
                                        {{ $mandat->kraj_mandata ? $mandat->kraj_mandata->format('d.m.Y') : 'danas' }}
                                        
                                        @if($mandat->v_d_status)
                                            <span class="badge bg-warning text-dark">v.d.</span>
                                        @endif
                                        
                                        <div class="small text-muted">{{ $mandat->trajanje }}</div>
                                    </td>
                                    <td>{{ $statistika['utakmice'] }}</td>
                                    <td>
                                        @if($statistika['utakmice'] > 0)
                                            {{ $statistika['pobede'] }}-{{ $statistika['remiji'] }}-{{ $statistika['porazi'] }}
                                            <div class="small text-muted">{{ $statistika['procenatPobeda'] }}% pobeda</div>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    onclick="editMandat({{ $mandat->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" 
                                                    onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-mandat-{{ $mandat->id }}').submit()">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-mandat-{{ $mandat->id }}" action="{{ route('selektori.obrisiMandat', $mandat) }}" method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-muted">Nema evidentiranih mandata.</p>
                @endif
            </div>
        </div>
        
        <!-- Utakmice po mandatima -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Utakmice</h5>
            </div>
            <div class="card-body">
                @php
                    $utakmice = [];
                    foreach ($selektor->mandati as $mandat) {
                        $utakmice = array_merge($utakmice, $mandat->utakmice()->toArray());
                    }
                    // Sort by date, newest first
                    usort($utakmice, function($a, $b) {
                        return strtotime($b['datum']) - strtotime($a['datum']);
                    });
                @endphp
                
                @if(count($utakmice) > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Datum</th>
                                    <th>Domaćin</th>
                                    <th>Rezultat</th>
                                    <th>Gost</th>
                                    <th>Takmičenje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(array_slice($utakmice, 0, 10) as $utakmica)
                                @php
                                    $domacin = App\Models\Tim::find($utakmica['domacin_id']);
                                    $gost = App\Models\Tim::find($utakmica['gost_id']);
                                    $takmicenje = App\Models\Takmicenje::find($utakmica['takmicenje_id']);
                                    $datum = new DateTime($utakmica['datum']);
                                @endphp
                                <tr>
                                    <td>{{ $datum->format('d.m.Y') }}</td>
                                    <td>{{ $domacin->naziv ?? 'Nepoznat' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('utakmice.show', $utakmica['id']) }}">
                                            <strong>{{ $utakmica['rezultat_domacin'] }} - {{ $utakmica['rezultat_gost'] }}</strong>
                                        </a>
                                    </td>
                                    <td>{{ $gost->naziv ?? 'Nepoznat' }}</td>
                                    <td>{{ $takmicenje->naziv ?? 'Nepoznato' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if(count($utakmice) > 10)
                        <div class="text-center mt-3">
                            <p>Prikazano 10 od {{ count($utakmice) }} utakmica.</p>
                        </div>
                    @endif
                @else
                    <p class="text-center text-muted">Nema evidentiranih utakmica za ovog selektora.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal za dodavanje novog mandata -->
<div class="modal fade" id="addMandatModal" tabindex="-1" aria-labelledby="addMandatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('selektori.dodajMandat', $selektor) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addMandatModalLabel">Dodaj novi mandat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tim_id" class="form-label">Tim *</label>
                        <select class="form-select" id="tim_id" name="tim_id" required>
                            <option value="">-- Izaberite tim --</option>
                            @foreach($timovi as $tim)
                                <option value="{{ $tim->id }}">{{ $tim->naziv }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pocetak_mandata" class="form-label">Početak mandata *</label>
                            <input type="date" class="form-control" id="pocetak_mandata" name="pocetak_mandata" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="kraj_mandata" class="form-label">Kraj mandata</label>
                            <input type="date" class="form-control" id="kraj_mandata" name="kraj_mandata">
                            <small class="form-text text-muted">Ostavite prazno ako je aktivan</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="v_d_status" name="v_d_status" value="1">
                            <label class="form-check-label" for="v_d_status">
                                Vršilac dužnosti (v.d.)
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="napomena" class="form-label">Napomena</label>
                        <textarea class="form-control" id="napomena" name="napomena" rows="3"></textarea>
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

<!-- Modal za izmenu mandata -->
<div class="modal fade" id="editMandatModal" tabindex="-1" aria-labelledby="editMandatModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editMandatForm" action="{{ route('selektori.edit', $selektor) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_mandat_id" name="edit_mandat_id">
                
                <div class="modal-header">
                    <h5 class="modal-title" id="editMandatModalLabel">Izmeni mandat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_tim_id" class="form-label">Tim *</label>
                        <select class="form-select" id="edit_tim_id" name="mandati[0][tim_id]" required>
                            <option value="">-- Izaberite tim --</option>
                            @foreach($timovi as $tim)
                                <option value="{{ $tim->id }}">{{ $tim->naziv }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_pocetak_mandata" class="form-label">Početak mandata *</label>
                            <input type="date" class="form-control" id="edit_pocetak_mandata" name="mandati[0][pocetak_mandata]" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_kraj_mandata" class="form-label">Kraj mandata</label>
                            <input type="date" class="form-control" id="edit_kraj_mandata" name="mandati[0][kraj_mandata]">
                            <small class="form-text text-muted">Ostavite prazno ako je aktivan</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="edit_v_d_status" name="mandati[0][v_d_status]" value="1">
                            <label class="form-check-label" for="edit_v_d_status">
                                Vršilac dužnosti (v.d.)
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_napomena" class="form-label">Napomena</label>
                        <textarea class="form-control" id="edit_napomena" name="mandati[0][napomena]" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Odustani</button>
                    <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Funkcija za popunjavanje forme za izmenu mandata
    function editMandat(mandatId) {
        // Pronađi podatke o mandatu
        const mandati = @json($selektor->mandati);
        const mandat = mandati.find(m => m.id === mandatId);
        
        if (mandat) {
            // Popuni formu
            document.getElementById('edit_mandat_id').value = mandat.id;
            document.getElementById('edit_tim_id').value = mandat.tim_id;
            document.getElementById('edit_pocetak_mandata').value = mandat.pocetak_mandata.split('T')[0];
            
            if (mandat.kraj_mandata) {
                document.getElementById('edit_kraj_mandata').value = mandat.kraj_mandata.split('T')[0];
            } else {
                document.getElementById('edit_kraj_mandata').value = '';
            }
            
            document.getElementById('edit_v_d_status').checked = mandat.v_d_status;
            document.getElementById('edit_napomena').value = mandat.napomena || '';
            
            // Ažurirati ime polja forme sa ID-om mandata
            document.getElementById('edit_tim_id').name = `mandati[${mandat.id}][tim_id]`;
            document.getElementById('edit_pocetak_mandata').name = `mandati[${mandat.id}][pocetak_mandata]`;
            document.getElementById('edit_kraj_mandata').name = `mandati[${mandat.id}][kraj_mandata]`;
            document.getElementById('edit_v_d_status').name = `mandati[${mandat.id}][v_d_status]`;
            document.getElementById('edit_napomena').name = `mandati[${mandat.id}][napomena]`;
            
            // Prikaži modal
            const editMandatModal = new bootstrap.Modal(document.getElementById('editMandatModal'));
            editMandatModal.show();
        }
    }
</script>
@endsection