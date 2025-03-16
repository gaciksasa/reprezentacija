@extends('layouts.app')

@section('title', 'Dodaj selektora')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novog selektora</h1>
    <a href="{{ route('selektori.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('selektori.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <h4 class="mb-3">Osnovni podaci</h4>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ime" class="form-label">Ime *</label>
                    <input type="text" class="form-control @error('ime') is-invalid @enderror" 
                           id="ime" name="ime" value="{{ old('ime') }}" required>
                    @error('ime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="prezime" class="form-label">Prezime *</label>
                    <input type="text" class="form-control @error('prezime') is-invalid @enderror" 
                           id="prezime" name="prezime" value="{{ old('prezime') }}" required>
                    @error('prezime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum_rodjenja" class="form-label">Datum rođenja</label>
                    <input type="date" class="form-control @error('datum_rodjenja') is-invalid @enderror" 
                           id="datum_rodjenja" name="datum_rodjenja" value="{{ old('datum_rodjenja') }}">
                    @error('datum_rodjenja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="mesto_rodjenja" class="form-label">Mesto rođenja</label>
                    <input type="text" class="form-control @error('mesto_rodjenja') is-invalid @enderror" 
                           id="mesto_rodjenja" name="mesto_rodjenja" value="{{ old('mesto_rodjenja') }}">
                    @error('mesto_rodjenja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum_smrti" class="form-label">Datum smrti</label>
                    <input type="date" class="form-control @error('datum_smrti') is-invalid @enderror" 
                           id="datum_smrti" name="datum_smrti" value="{{ old('datum_smrti') }}">
                    @error('datum_smrti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="mesto_smrti" class="form-label">Mesto smrti</label>
                    <input type="text" class="form-control @error('mesto_smrti') is-invalid @enderror" 
                           id="mesto_smrti" name="mesto_smrti" value="{{ old('mesto_smrti') }}">
                    @error('mesto_smrti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="drzavljanstvo" class="form-label">Državljanstvo</label>
                <input type="text" class="form-control @error('drzavljanstvo') is-invalid @enderror" 
                       id="drzavljanstvo" name="drzavljanstvo" value="{{ old('drzavljanstvo') }}">
                @error('drzavljanstvo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="biografija" class="form-label">Biografija</label>
                <textarea class="form-control @error('biografija') is-invalid @enderror" 
                          id="biografija" name="biografija" rows="3">{{ old('biografija') }}</textarea>
                @error('biografija')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="fotografija" class="form-label">Fotografija</label>
                <input type="file" class="form-control @error('fotografija') is-invalid @enderror" 
                       id="fotografija" name="fotografija">
                @error('fotografija')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <hr>
            
            <h4 class="mb-3">Prvi mandat</h4>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tim_id" class="form-label">Tim *</label>
                    <select class="form-select @error('tim_id') is-invalid @enderror" 
                            id="tim_id" name="tim_id" required>
                        <option value="">-- Izaberite tim --</option>
                        @foreach($timovi as $tim)
                            <option value="{{ $tim->id }}" {{ old('tim_id') == $tim->id ? 'selected' : '' }}>
                                {{ $tim->naziv }}
                            </option>
                        @endforeach
                    </select>
                    @error('tim_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
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
                    <small class="form-text text-muted">Ostavite prazno ako je selektor trenutno aktivan</small>
                    @error('kraj_mandata')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="v_d_status" name="v_d_status" value="1" {{ old('v_d_status') ? 'checked' : '' }}>
                    <label class="form-check-label" for="v_d_status">
                        Vršilac dužnosti (v.d.)
                    </label>
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
                <button type="submit" class="btn btn-primary">Sačuvaj selektora</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
</script>
@endsection