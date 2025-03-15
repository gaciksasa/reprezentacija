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