@extends('layouts.app')

@section('title', $selektor->ime_prezime)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ $selektor->prezime }} {{ $selektor->ime }}</h1>
    <div>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <a href="{{ route('selektori.edit', $selektor) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Izmeni
        </a>
        @endif
        <a href="{{ route('selektori.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

<div class="selektori row">
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mb-0">Osnovni podaci</h2>
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
                <h2 class="card-title mb-0">Ukupna statistika</h2>
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
    
    <div class="col-lg-8">
        <!-- Biografija -->
            @if($selektor->biografija)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h2 class="card-title mb-0">Biografija</h2>
                    </div>
                    <div class="card-body">
                        {!! $selektor->biografija !!}
                    </div>
                </div>
            @endif
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h2 class="card-title mb-0">Mandati</h2>
                @if(Auth::check() && Auth::user()->hasEditAccess())
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMandatModal">
                    <i class="fas fa-plus"></i> Dodaj mandat
                </button>
                @endif
            </div>
            <div class="card-body">
                @if($selektor->mandati->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Period</th>
                                    <th>Utakmice</th>
                                    <th>Učinak</th>
                                    @if(Auth::check() && Auth::user()->hasEditAccess())
                                    <th>Akcije</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($selektor->mandati->sortByDesc('pocetak_mandata') as $mandat)
                                @php
                                    $statistika = $mandat->statistika;
                                @endphp
                                <tr>
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
                                    @if(Auth::check() && Auth::user()->hasEditAccess())
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
                                    @endif
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
                <h2 class="card-title mb-0">Utakmice</h2>
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
                                    <th class="d-none d-lg-table-cell">Takmičenje</th>
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
                                    <td class="d-none d-lg-table-cell">{{ $takmicenje->naziv ?? 'Nepoznato' }}</td>
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
            
            // Format and set dates in the dd.mm.yyyy format
            let pocetakDatum = '';
            if (mandat.pocetak_mandata) {
                const date = new Date(mandat.pocetak_mandata);
                const day = date.getDate().toString().padStart(2, '0');
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const year = date.getFullYear();
                pocetakDatum = `${day}.${month}.${year}`;
            }
            
            let krajDatum = '';
            if (mandat.kraj_mandata) {
                const date = new Date(mandat.kraj_mandata);
                const day = date.getDate().toString().padStart(2, '0');
                const month = (date.getMonth() + 1).toString().padStart(2, '0');
                const year = date.getFullYear();
                krajDatum = `${day}.${month}.${year}`;
            }
            
            // Create date input fields
            const pocetakInput = document.getElementById('edit_pocetak_mandata');
            const krajInput = document.getElementById('edit_kraj_mandata');
            
            // Convert the date fields to text fields if they aren't already
            if (pocetakInput.type === 'date') {
                // Create a text replacement for pocetak_mandata
                const pocetakTextInput = document.createElement('input');
                pocetakTextInput.type = 'text';
                pocetakTextInput.id = 'edit_pocetak_mandata';
                pocetakTextInput.className = pocetakInput.className;
                pocetakTextInput.placeholder = 'dd.mm.yyyy';
                pocetakTextInput.required = pocetakInput.required;
                pocetakTextInput.value = pocetakDatum;
                
                // Add event listener for format conversion
                pocetakTextInput.addEventListener('blur', function() {
                    convertDateFormat(this);
                });
                
                // Replace the date input
                pocetakInput.parentNode.replaceChild(pocetakTextInput, pocetakInput);
            } else {
                // Just update the value if it's already a text input
                pocetakInput.value = pocetakDatum;
            }
            
            if (krajInput.type === 'date') {
                // Create a text replacement for kraj_mandata
                const krajTextInput = document.createElement('input');
                krajTextInput.type = 'text';
                krajTextInput.id = 'edit_kraj_mandata';
                krajTextInput.className = krajInput.className;
                krajTextInput.placeholder = 'dd.mm.yyyy';
                krajTextInput.value = krajDatum;
                
                // Add event listener for format conversion
                krajTextInput.addEventListener('blur', function() {
                    convertDateFormat(this);
                });
                
                // Replace the date input
                krajInput.parentNode.replaceChild(krajTextInput, krajInput);
            } else {
                // Just update the value if it's already a text input
                krajInput.value = krajDatum;
            }
            
            document.getElementById('edit_v_d_status').checked = Boolean(mandat.v_d_status);
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
    
    // Helper function to convert date format
    function convertDateFormat(inputElement) {
        const value = inputElement.value;
        if (value) {
            // Check if the input matches the dd.mm.yyyy format
            const dateRegex = /^(\d{1,2})\.(\d{1,2})\.(\d{4})$/;
            const match = value.match(dateRegex);
            
            if (match) {
                const day = match[1].padStart(2, '0');
                const month = match[2].padStart(2, '0');
                const year = match[3];
                
                // Format for display
                inputElement.value = `${day}.${month}.${year}`;
                
                // Create hidden input for form submission in yyyy-mm-dd format
                let hiddenInput = document.getElementById(`${inputElement.id}_hidden`);
                if (!hiddenInput) {
                    hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = inputElement.name;
                    hiddenInput.id = `${inputElement.id}_hidden`;
                    inputElement.parentNode.appendChild(hiddenInput);
                    
                    // Change the name of the text input so it doesn't conflict
                    inputElement.name = `${inputElement.name}_display`;
                }
                
                hiddenInput.value = `${year}-${month}-${day}`;
            }
        }
    }
    
    // Add date format conversion to the "Add Mandate" modal too
    document.addEventListener('DOMContentLoaded', function() {
        // Convert all date inputs to use dd.mm.yyyy format
        const dateInputs = document.querySelectorAll('input[type="date"]');
        
        dateInputs.forEach(function(input) {
            // Create a text input to replace the date input
            const textInput = document.createElement('input');
            textInput.type = 'text';
            textInput.name = input.name;
            textInput.id = input.id;
            textInput.className = input.className;
            textInput.placeholder = 'dd.mm.yyyy';
            textInput.required = input.required;
            
            // Copy any existing value, converting from yyyy-mm-dd to dd.mm.yyyy
            if (input.value) {
                const dateParts = input.value.split('-');
                if (dateParts.length === 3) {
                    textInput.value = `${dateParts[2]}.${dateParts[1]}.${dateParts[0]}`;
                }
            }
            
            // Add event listener to format input and convert back to yyyy-mm-dd for form submission
            textInput.addEventListener('blur', function() {
                convertDateFormat(this);
            });
            
            // Replace the date input with the text input
            input.parentNode.replaceChild(textInput, input);
        });
        
        // Intercept both form submissions to validate date format
        const forms = document.querySelectorAll('form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function(e) {
                const dateInputs = this.querySelectorAll('input[name$="_display"]');
                let valid = true;
                
                dateInputs.forEach(function(input) {
                    if (input.value) {
                        const dateRegex = /^(\d{1,2})\.(\d{1,2})\.(\d{4})$/;
                        if (!dateRegex.test(input.value)) {
                            valid = false;
                            input.classList.add('is-invalid');
                            
                            // Add error message if not already present
                            let nextElement = input.nextElementSibling;
                            if (!nextElement || !nextElement.classList.contains('invalid-feedback')) {
                                const errorMsg = document.createElement('div');
                                errorMsg.className = 'invalid-feedback';
                                errorMsg.textContent = 'Format datuma mora biti dd.mm.yyyy';
                                input.parentNode.insertBefore(errorMsg, input.nextSibling);
                            }
                        }
                    }
                });
                
                if (!valid) {
                    e.preventDefault();
                }
            });
        });
    });
</script>
@endsection