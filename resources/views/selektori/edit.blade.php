@extends('layouts.app')

@section('title', 'Izmeni selektora - ' . $selektor->ime_prezime)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni selektora: {{ $selektor->ime_prezime }}</h1>
    <a href="{{ route('selektori.show', $selektor) }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('selektori.update', $selektor) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <h4 class="mb-3">Osnovni podaci</h4>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ime" class="form-label">Ime *</label>
                    <input type="text" class="form-control @error('ime') is-invalid @enderror" 
                           id="ime" name="ime" value="{{ old('ime', $selektor->ime) }}" required>
                    @error('ime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="prezime" class="form-label">Prezime *</label>
                    <input type="text" class="form-control @error('prezime') is-invalid @enderror" 
                           id="prezime" name="prezime" value="{{ old('prezime', $selektor->prezime) }}" required>
                    @error('prezime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum_rodjenja" class="form-label">Datum rođenja</label>
                    <input type="date" class="form-control @error('datum_rodjenja') is-invalid @enderror" 
                           id="datum_rodjenja" name="datum_rodjenja" 
                           value="{{ old('datum_rodjenja', $selektor->datum_rodjenja ? $selektor->datum_rodjenja->format('Y-m-d') : '') }}">
                    @error('datum_rodjenja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="mesto_rodjenja" class="form-label">Mesto rođenja</label>
                    <input type="text" class="form-control @error('mesto_rodjenja') is-invalid @enderror" 
                           id="mesto_rodjenja" name="mesto_rodjenja" value="{{ old('mesto_rodjenja', $selektor->mesto_rodjenja) }}">
                    @error('mesto_rodjenja')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="datum_smrti" class="form-label">Datum smrti</label>
                    <input type="date" class="form-control @error('datum_smrti') is-invalid @enderror" 
                           id="datum_smrti" name="datum_smrti" 
                           value="{{ old('datum_smrti', $selektor->datum_smrti ? $selektor->datum_smrti->format('Y-m-d') : '') }}">
                    @error('datum_smrti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="mesto_smrti" class="form-label">Mesto smrti</label>
                    <input type="text" class="form-control @error('mesto_smrti') is-invalid @enderror" 
                           id="mesto_smrti" name="mesto_smrti" value="{{ old('mesto_smrti', $selektor->mesto_smrti) }}">
                    @error('mesto_smrti')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="drzavljanstvo" class="form-label">Državljanstvo</label>
                <input type="text" class="form-control @error('drzavljanstvo') is-invalid @enderror" 
                       id="drzavljanstvo" name="drzavljanstvo" value="{{ old('drzavljanstvo', $selektor->drzavljanstvo) }}">
                @error('drzavljanstvo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="biografija" class="form-label">Biografija</label>
                <textarea class="form-control @error('biografija') is-invalid @enderror" 
                          id="biografija" name="biografija" rows="3">{{ old('biografija', $selektor->biografija) }}</textarea>
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
                
                @if($selektor->fotografija_path)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $selektor->fotografija_path) }}" alt="{{ $selektor->ime_prezime }}" class="img-thumbnail" style="max-height: 100px">
                        <p class="small text-muted">Trenutna fotografija. Otpremite novu da je zamenite.</p>
                    </div>
                @endif
            </div>
            
            <hr>
            
            <h4 class="mb-3">Mandati</h4>
            
            @if($selektor->mandati->count() > 0)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Mandati se mogu upravljati na stranici za pregled selektora.
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Ovaj selektor nema evidentirane mandate. Dodajte ih na stranici za pregled selektora.
                </div>
            @endif
            
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>

@if($selektor->mandati->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Pregled mandata</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tim</th>
                            <th>Period</th>
                            <th>Status</th>
                            <th>Napomena</th>
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
                                @if($mandat->v_d_status)
                                    <span class="badge bg-warning text-dark">v.d.</span>
                                @else
                                    <span class="badge bg-success">Stalni</span>
                                @endif
                            </td>
                            <td>{{ $mandat->napomena }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
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
        
        // Apply the same date formatting to the dates in the mandates table
        document.querySelectorAll('.table tr td:nth-child(2)').forEach(cell => {
            const text = cell.textContent.trim();
            if (text.includes('-')) {
                const dates = text.split('-').map(date => {
                    date = date.trim();
                    // Only try to convert if it looks like a date in yyyy-mm-dd format
                    if (/^\d{4}-\d{2}-\d{2}$/.test(date)) {
                        const [year, month, day] = date.split('-');
                        return `${day}.${month}.${year}`;
                    }
                    return date;
                });
                cell.textContent = dates.join(' - ');
            }
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