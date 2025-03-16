@extends('layouts.app')

@section('title', 'Dodaj igrača')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Dodaj novog igrača</h1>
    <a href="{{ route('igraci.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('igraci.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                <div class="col-md-4 mb-3">
                    <label for="pozicija" class="form-label">Pozicija *</label>
                    <select class="form-select @error('pozicija') is-invalid @enderror"
                        id="pozicija" name="pozicija" required>
                        <option value="">-- Izaberite poziciju --</option>
                        @foreach($pozicije as $pozicija)
                        <option value="{{ $pozicija }}" {{ old('pozicija') == $pozicija ? 'selected' : '' }}>
                            {{ $pozicija }}
                        </option>
                        @endforeach
                    </select>
                    @error('pozicija')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="visina" class="form-label">Visina (cm)</label>
                    <input type="number" class="form-control @error('visina') is-invalid @enderror"
                        id="visina" name="visina" value="{{ old('visina') }}" min="140" max="220">
                    @error('visina')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4 mb-3">
                    <label for="fotografija" class="form-label">Fotografija</label>
                    <input type="file" class="form-control @error('fotografija') is-invalid @enderror"
                        id="fotografija" name="fotografija">
                    @error('fotografija')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <h4 class="mt-4 mb-3">Lični podaci</h4>

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
                <label for="biografija" class="form-label">Biografija</label>
                <textarea class="form-control @error('biografija') is-invalid @enderror"
                    id="biografija" name="biografija" rows="4">{{ old('biografija') }}</textarea>
                @error('biografija')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="aktivan" name="aktivan" value="1" {{ old('aktivan') ? 'checked' : '' }}>
                    <label class="form-check-label" for="aktivan">
                        Aktivan igrač
                    </label>
                </div>
            </div>

            <hr>
            <h4 class="mb-3">Bivši klubovi</h4>

            <div id="bivsi-klubovi-container">
                <div class="bivsi-klub-row mb-4">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Naziv kluba</label>
                            <input type="text" class="form-control" name="bivsi_klubovi[0][naziv]">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Država kluba</label>
                            <input type="text" class="form-control" name="bivsi_klubovi[0][drzava]">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Sezona</label>
                            <input type="text" class="form-control" name="bivsi_klubovi[0][sezona]" placeholder="npr. 1989-90">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Stepen takmičenja</label>
                            <input type="text" class="form-control" name="bivsi_klubovi[0][stepen_takmicenja]">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Broj nastupa</label>
                            <input type="number" class="form-control" name="bivsi_klubovi[0][broj_nastupa]" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Broj golova</label>
                            <input type="number" class="form-control" name="bivsi_klubovi[0][broj_golova]" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <button type="button" class="btn btn-secondary" id="add-klub-btn">
                    <i class="fas fa-plus"></i> Dodaj bivši klub
                </button>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Sačuvaj igrača</button>
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
        
        // Existing club functionality should remain as is
        const container = document.getElementById('bivsi-klubovi-container');
        const addButton = document.getElementById('add-klub-btn');
        let klubCounter = 1;

        // Add new club row
        addButton.addEventListener('click', function() {
            const newRow = document.querySelector('.bivsi-klub-row').cloneNode(true);

            // Update all input names with new index
            const inputs = newRow.querySelectorAll('input');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[0\]/, `[${klubCounter}]`));
                    input.value = ''; // Clear values
                }
            });

            // Configure remove button
            const removeBtn = newRow.querySelector('.remove-klub-btn');
            removeBtn.style.display = 'block';
            removeBtn.addEventListener('click', function() {
                newRow.remove();
            });

            container.appendChild(newRow);
            klubCounter++;
        });

        // Hide first remove button initially
        const firstRemoveBtn = document.querySelector('.bivsi-klub-row .remove-klub-btn');
        if (firstRemoveBtn) {
            firstRemoveBtn.style.display = 'none';
        }

        // Set up event delegation for future remove buttons
        container.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-klub-btn')) {
                e.target.closest('.bivsi-klub-row').remove();
            }
        });
    });
</script>
@endsection