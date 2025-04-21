@extends('layouts.app')

@section('title', 'Nova selektorska komisija')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Nova selektorska komisija</h1>
    <a href="{{ route('selektori.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('selektor-komisija.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <strong>Reprezentacija:</strong> {{ $glavniTim->naziv }}
                <input type="hidden" name="tim_id" value="{{ $glavniTim->id }}">
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pocetak_mandata" class="form-label">Početak mandata *</label>
                    <input type="date" class="form-control @error('pocetak_mandata') is-invalid @enderror"
                           id="pocetak_mandata" name="pocetak_mandata" value="{{ old('pocetak_mandata') }}" required>
                    @error('pocetak_mandata')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="kraj_mandata" class="form-label">Kraj mandata</label>
                    <input type="date" class="form-control @error('kraj_mandata') is-invalid @enderror"
                           id="kraj_mandata" name="kraj_mandata" value="{{ old('kraj_mandata') }}">
                    <small class="form-text text-muted">Ostavite prazno ako je komisija trenutno aktivna</small>
                    @error('kraj_mandata')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-4">
                <label for="glavni_selektor_id" class="form-label">Glavni selektor komisije *</label>
                <select class="form-select @error('glavni_selektor_id') is-invalid @enderror"
                        id="glavni_selektor_id" name="glavni_selektor_id" required onchange="toggleNoviGlavniSelektor()">
                    <option value="">-- Izaberite glavnog selektora --</option>
                    @foreach($selektori as $selektor)
                        <option value="{{ $selektor->id }}" {{ old('glavni_selektor_id') == $selektor->id ? 'selected' : '' }}>
                            {{ $selektor->prezime }} {{ $selektor->ime }}
                        </option>
                    @endforeach
                    <option value="novi" {{ old('glavni_selektor_id') == 'novi' ? 'selected' : '' }}>-- Dodaj novog selektora --</option>
                </select>
                @error('glavni_selektor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <!-- Polja za novog glavnog selektora -->
                <div id="novi-glavni-selektor" class="mt-3" style="{{ old('glavni_selektor_id') == 'novi' ? '' : 'display: none;' }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="novi_selektor_ime" class="form-label">Ime *</label>
                            <input type="text" class="form-control @error('novi_selektor.ime') is-invalid @enderror"
                                  id="novi_selektor_ime" name="novi_selektor[ime]" value="{{ old('novi_selektor.ime') }}">
                            @error('novi_selektor.ime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="novi_selektor_prezime" class="form-label">Prezime *</label>
                            <input type="text" class="form-control @error('novi_selektor.prezime') is-invalid @enderror"
                                  id="novi_selektor_prezime" name="novi_selektor[prezime]" value="{{ old('novi_selektor.prezime') }}">
                            @error('novi_selektor.prezime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Ostali članovi komisije</label>
                <div class="card">
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        <h6>Postojeći selektori:</h6>
                        @foreach($selektori as $selektor)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                    id="clan-{{ $selektor->id }}" name="clanovi_komisije[]" 
                                    value="{{ $selektor->id }}" 
                                    {{ in_array($selektor->id, old('clanovi_komisije', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="clan-{{ $selektor->id }}">
                                    {{ $selektor->prezime }} {{ $selektor->ime }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
                @error('clanovi_komisije')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
                
                <div class="mt-3">
                    <h6>Dodaj nove članove komisije:</h6>
                    <div id="novi-clanovi-container">
                        @if(old('novi_clanovi'))
                            @foreach(old('novi_clanovi') as $index => $noviClan)
                                <div class="row novi-clan-row mb-2">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control @error('novi_clanovi.'.$index.'.ime') is-invalid @enderror" 
                                               name="novi_clanovi[{{ $index }}][ime]" placeholder="Ime" 
                                               value="{{ $noviClan['ime'] ?? '' }}">
                                        @error('novi_clanovi.'.$index.'.ime')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control @error('novi_clanovi.'.$index.'.prezime') is-invalid @enderror" 
                                               name="novi_clanovi[{{ $index }}][prezime]" placeholder="Prezime" 
                                               value="{{ $noviClan['prezime'] ?? '' }}">
                                        @error('novi_clanovi.'.$index.'.prezime')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-clan-btn">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row novi-clan-row mb-2">
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="novi_clanovi[0][ime]" placeholder="Ime">
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="novi_clanovi[0][prezime]" placeholder="Prezime">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-clan-btn">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <button type="button" class="btn btn-secondary mt-2" id="add-clan-btn">
                        <i class="fas fa-plus"></i> Dodaj novog člana
                    </button>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="napomena" class="form-label">Napomena</label>
                <textarea class="form-control @error('napomena') is-invalid @enderror"
                        id="napomena" name="napomena" rows="3">{{ old('napomena') }}</textarea>
                @error('napomena')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj selektorsku komisiju</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Automatski odaberi glavnog selektora u listi članova komisije
        const glavniSelektor = document.getElementById('glavni_selektor_id');
        glavniSelektor.addEventListener('change', function() {
            toggleNoviGlavniSelektor();
            const selektorId = this.value;
            if (selektorId && selektorId !== 'novi') {
                const checkboxId = 'clan-' + selektorId;
                const checkbox = document.getElementById(checkboxId);
                if (checkbox) {
                    checkbox.checked = true;
                }
            }
        });
        
        // Inicijalno stanje - proveri da li je potrebno prikazati polja za novog selektora
        toggleNoviGlavniSelektor();
        
        // Automatski odaberi trenutno izabranog glavnog selektora
        if (glavniSelektor.value && glavniSelektor.value !== 'novi') {
            const checkboxId = 'clan-' + glavniSelektor.value;
            const checkbox = document.getElementById(checkboxId);
            if (checkbox) {
                checkbox.checked = true;
            }
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
        
        // Dodavanje i uklanjanje novih članova komisije
        const container = document.getElementById('novi-clanovi-container');
        const addBtn = document.getElementById('add-clan-btn');
        let clanCounter = @if(old('novi_clanovi')) {{ count(old('novi_clanovi')) }} @else 1 @endif;
        
        // Funkcija za dodavanje novog reda
        addBtn.addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.className = 'row novi-clan-row mb-2';
            newRow.innerHTML = `
                <div class="col-md-5">
                    <input type="text" class="form-control" name="novi_clanovi[${clanCounter}][ime]" placeholder="Ime">
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="novi_clanovi[${clanCounter}][prezime]" placeholder="Prezime">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-clan-btn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(newRow);
            clanCounter++;
            
            // Dodaj event listener za novo dugme za uklanjanje
            newRow.querySelector('.remove-clan-btn').addEventListener('click', function() {
                newRow.remove();
            });
        });
        
        // Dodaj event listener za postojeća dugmad za uklanjanje
        document.querySelectorAll('.remove-clan-btn').forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.novi-clan-row').remove();
            });
        });
    });
    
    // Funkcija za prikazivanje/sakrivanje polja za novog glavnog selektora
    function toggleNoviGlavniSelektor() {
        const glavniSelektor = document.getElementById('glavni_selektor_id');
        const noviSelektorDiv = document.getElementById('novi-glavni-selektor');
        
        if (glavniSelektor.value === 'novi') {
            noviSelektorDiv.style.display = 'block';
        } else {
            noviSelektorDiv.style.display = 'none';
        }
    }
</script>
@endsection