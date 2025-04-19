@extends('layouts.app')

@section('title', 'Izmeni utakmicu')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni utakmicu</h1>
    <a href="{{ route('utakmice.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('utakmice.update', $utakmica) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum" class="form-label">Datum *</label>
                    <input type="date" class="form-control @error('datum') is-invalid @enderror" 
                           id="datum" name="datum" value="{{ old('datum', $utakmica->datum->format('Y-m-d')) }}" required>
                    @error('datum')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="vreme" class="form-label">Vreme</label>
                <input type="time" class="form-control @error('vreme') is-invalid @enderror" 
                    id="vreme" name="vreme" value="{{ old('vreme', $utakmica->vreme) }}">
                @error('vreme')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="takmicenje" class="form-label">Takmičenje *</label>
                <input type="text" class="form-control @error('takmicenje') is-invalid @enderror" 
                    id="takmicenje" name="takmicenje" value="{{ old('takmicenje', $utakmica->takmicenje ? $utakmica->takmicenje->naziv : '') }}" required>
                @error('takmicenje')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="domacin_id" class="form-label">Domaćin *</label>
                    <select class="form-select @error('domacin_id') is-invalid @enderror" 
                            id="domacin_id" name="domacin_id" required>
                        <option value="">-- Izaberite domaći tim --</option>
                        @foreach($timovi as $tim)
                            <option value="{{ $tim->id }}" {{ old('domacin_id', $utakmica->domacin_id) == $tim->id ? 'selected' : '' }}>
                                {{ $tim->naziv }}
                            </option>
                        @endforeach
                    </select>
                    @error('domacin_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="gost_id" class="form-label">Gost *</label>
                    <select class="form-select @error('gost_id') is-invalid @enderror" 
                            id="gost_id" name="gost_id" required>
                        <option value="">-- Izaberite gostujući tim --</option>
                        @foreach($timovi as $tim)
                            <option value="{{ $tim->id }}" {{ old('gost_id', $utakmica->gost_id) == $tim->id ? 'selected' : '' }}>
                                {{ $tim->naziv }}
                            </option>
                        @endforeach
                    </select>
                    @error('gost_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="protivnik_alijas" class="form-label">Alternativni naziv protivničkog tima</label>
                <input type="text" class="form-control @error('protivnik_alijas') is-invalid @enderror" 
                    id="protivnik_alijas" name="protivnik_alijas" value="{{ old('protivnik_alijas', $utakmica->protivnik_alijas) }}">
                <small class="form-text text-muted">Npr. "Češka" ili "SSSR"</small>
                @error('protivnik_alijas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="stadion" class="form-label">Stadion</label>
                <input type="text" class="form-control @error('stadion') is-invalid @enderror" 
                       id="stadion" name="stadion" value="{{ old('stadion', $utakmica->stadion) }}">
                @error('stadion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="sudija" class="form-label">Sudija</label>
                <input type="text" class="form-control @error('sudija') is-invalid @enderror" 
                       id="sudija" name="sudija" value="{{ old('sudija', $utakmica->sudija) }}">
                @error('sudija')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="publika" class="form-label">Publika</label>
                <input type="text" class="form-control @error('publika') is-invalid @enderror" 
                       id="publika" name="publika" value="{{ old('publika', $utakmica->publika) }}">
                @error('publika')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="imao_jedanaesterce" name="imao_jedanaesterce" 
                        {{ old('imao_jedanaesterce', $utakmica->imao_jedanaesterce) ? 'checked' : '' }}
                        onchange="togglePenaltyFields()">
                    <label class="form-check-label" for="imao_jedanaesterce">
                        Imao jedanaesterce (penale)
                    </label>
                </div>
            </div>

            <div id="penalty-fields" class="row" style="{{ old('imao_jedanaesterce', $utakmica->imao_jedanaesterce) ? '' : 'display: none;' }}">
                <div class="col-md-6 mb-3">
                    <label for="jedanaesterci_domacin" class="form-label">Penali domaćin</label>
                    <input type="number" class="form-control @error('jedanaesterci_domacin') is-invalid @enderror" 
                        id="jedanaesterci_domacin" name="jedanaesterci_domacin" 
                        value="{{ old('jedanaesterci_domacin', $utakmica->jedanaesterci_domacin) }}" min="0" max="20">
                    @error('jedanaesterci_domacin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="jedanaesterci_gost" class="form-label">Penali gost</label>
                    <input type="number" class="form-control @error('jedanaesterci_gost') is-invalid @enderror" 
                        id="jedanaesterci_gost" name="jedanaesterci_gost" 
                        value="{{ old('jedanaesterci_gost', $utakmica->jedanaesterci_gost) }}" min="0" max="20">
                    @error('jedanaesterci_gost')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>

<div class="mt-4">
    <div class="card mb-4">
        <div class="card-header">
            <h2 class="card-title mb-0">Trenutni rezultat: {{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</h2>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Rezultat utakmice se automatski ažurira na osnovu unetih golova.
            </div>
            
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('golovi.create', ['utakmica_id' => $utakmica->id]) }}" class="btn btn-primary">
                    <i class="fas fa-futbol"></i> Dodaj gol
                </a>
                <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-secondary">
                    <i class="fas fa-eye"></i> Pogledaj detalje utakmice
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Configure date inputs to use dd.mm.yyyy format
    document.addEventListener('DOMContentLoaded', function() {
        // Get date inputs
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
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            const dateInputs = document.querySelectorAll('input[name$="_display"]');
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
    
    // Existing function for toggling penalty fields
    function togglePenaltyFields() {
        const hasShootout = document.getElementById('imao_jedanaesterce').checked;
        document.getElementById('penalty-fields').style.display = hasShootout ? 'flex' : 'none';
        
        if (!hasShootout) {
            document.getElementById('jedanaesterci_domacin').value = '';
            document.getElementById('jedanaesterci_gost').value = '';
        }
    }
</script>
@endsection