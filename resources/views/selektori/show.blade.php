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
                                <th>Tim</th>
                                <th>Period</th>
                                <th>Status</th>
                                <th>Utakmice</th>
                                <th>Učinak</th>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <th>Akcije</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($selektor->mandati->sortByDesc('pocetak_mandata') as $mandat)
                            <tr>
                                <td>{{ $mandat->tim->naziv }}</td>
                                <td>
                                    {{ $mandat->pocetak_mandata->format('d.m.Y') }} - 
                                    {{ $mandat->kraj_mandata ? $mandat->kraj_mandata->format('d.m.Y') : 'danas' }}
                                </td>
                                <td>
                                    @if($mandat->komisija)
                                        <span class="badge bg-info">Komisija</span>
                                        @if($mandat->glavni_selektor)
                                            <span class="badge bg-primary">Glavni</span>
                                        @endif
                                    @elseif($mandat->v_d_status)
                                        <span class="badge bg-warning text-dark">v.d.</span>
                                    @else
                                        <span class="badge bg-success">Samostalni</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $mandatStatistika = $mandat->statistika;
                                    @endphp
                                    {{ $mandatStatistika['utakmice'] }}
                                </td>
                                <td>
                                    @if($mandatStatistika['utakmice'] > 0)
                                        {{ $mandatStatistika['pobede'] }}-{{ $mandatStatistika['remiji'] }}-{{ $mandatStatistika['porazi'] }}
                                    @else
                                        -
                                    @endif
                                </td>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <td>
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
                    // Collect all utakmice from all mandates
                    $allUtakmice = collect();
                    foreach ($selektor->mandati as $mandat) {
                        $mandatUtakmice = $mandat->utakmice();
                        $allUtakmice = $allUtakmice->concat($mandatUtakmice);
                    }
                    
                    // Sort by date, newest first
                    $allUtakmice = $allUtakmice->sortByDesc('datum');
                    
                    // Manually paginate
                    $perPage = 20;
                    $currentPage = request()->query('page', 1);
                    $currentPageItems = $allUtakmice->forPage($currentPage, $perPage);
                    
                    // Create a LengthAwarePaginator
                    $utakmicePaginator = new \Illuminate\Pagination\LengthAwarePaginator(
                        $currentPageItems,
                        $allUtakmice->count(),
                        $perPage,
                        $currentPage,
                        ['path' => request()->url(), 'query' => request()->query()]
                    );
                @endphp
                
                @if($allUtakmice->count() > 0)
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
                                @foreach($utakmicePaginator as $utakmica)
                                <tr>
                                    <td>{{ $utakmica->datum->format('d.m.Y') }}</td>
                                    <td>{{ $utakmica->domacin->naziv ?? 'Nepoznat' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('utakmice.show', $utakmica->id) }}">
                                            <strong>{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</strong>
                                        </a>
                                    </td>
                                    <td>{{ $utakmica->gost->naziv ?? 'Nepoznat' }}</td>
                                    <td class="d-none d-lg-table-cell">{{ $utakmica->takmicenje->naziv ?? 'Nepoznato' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $utakmicePaginator->links() }}
                    </div>
                @else
                    <p class="text-center text-muted">Nema evidentiranih utakmica za ovog selektora.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal za dodavanje novog mandata -->
<div class="modal fade" id="addMandatModal" tabindex="-1" aria-labelledby="addMandatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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

                    <!-- Polja za selektorsku komisiju -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="komisija" name="komisija" value="1" 
                                onchange="toggleKomisijaFields()">
                            <label class="form-check-label" for="komisija">
                                Selektorska komisija
                            </label>
                        </div>
                    </div>

                    <div id="komisija-fields" style="display: none;">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="glavni_selektor" name="glavni_selektor" value="1">
                                <label class="form-check-label" for="glavni_selektor">
                                    Glavni selektor u komisiji
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Ostali članovi komisije</label>
                            <select class="form-select" id="selektori_ids" name="selektori_ids[]" multiple>
                                @foreach($ostaliSelektori as $drugiSelektor)
                                    <option value="{{ $drugiSelektor->id }}">
                                        {{ $drugiSelektor->prezime }} {{ $drugiSelektor->ime }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Držite CTRL za višestruki izbor</small>
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Funkcije za prikazivanje/sakrivanje polja za selektorsku komisiju
        window.toggleKomisijaFields = function() {
            const isKomisija = document.getElementById('komisija').checked;
            document.getElementById('komisija-fields').style.display = isKomisija ? 'block' : 'none';
        }
        
        // Dodavanje event listenera
        const komisijaCheckbox = document.getElementById('komisija');
        if (komisijaCheckbox) {
            komisijaCheckbox.addEventListener('change', toggleKomisijaFields);
        }
        
        // Configure date inputs to use dd.mm.yyyy format
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
                const value = this.value;
                if (value) {
                    // Check if the input matches the dd.mm.yyyy format
                    const dateRegex = /^(\d{1,2})\.(\d{1,2})\.(\d{4})$/;
                    const match = value.match(dateRegex);
                    
                    if (match) {
                        const day = match[1].padStart(2, '0');
                        const month = match[2].padStart(2, '0');
                        const year = match[3];
                        
                        // Format for display
                        this.value = `${day}.${month}.${year}`;
                        
                        // Create hidden input for form submission in yyyy-mm-dd format
                        let hiddenInput = document.getElementById(`${this.id}_hidden`);
                        if (!hiddenInput) {
                            hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = this.name;
                            hiddenInput.id = `${this.id}_hidden`;
                            this.parentNode.appendChild(hiddenInput);
                            
                            // Change the name of the text input so it doesn't conflict
                            this.name = `${this.name}_display`;
                        }
                        
                        hiddenInput.value = `${year}-${month}-${day}`;
                    }
                }
            });
            
            // Replace the date input with the text input
            input.parentNode.replaceChild(textInput, input);
        });
        
        // Intercept form submission to validate date format
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
</script>
@endsection