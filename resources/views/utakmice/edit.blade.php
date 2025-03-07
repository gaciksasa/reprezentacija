@extends('layouts.app')

@section('title', isset($utakmica) ? 'Izmeni utakmicu' : 'Nova utakmica')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>{{ isset($utakmica) ? 'Izmeni utakmicu' : 'Dodaj novu utakmicu' }}</h1>
    <a href="{{ route('utakmice.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Nazad
    </a>
</div>

<form action="{{ isset($utakmica) ? route('matches.update', $utakmica) : route('matches.store') }}" method="POST">
    @csrf
    @if(isset($utakmica))
        @method('PUT')
    @endif

    <!-- Tabs for different sections -->
    <ul class="nav nav-tabs mb-3" id="matchEditorTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="osnovni-podaci-tab" data-bs-toggle="tab" data-bs-target="#osnovni-podaci" type="button" role="tab">
                Osnovni podaci
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="sastavi-tab" data-bs-toggle="tab" data-bs-target="#sastavi" type="button" role="tab">
                Sastavi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="golovi-tab" data-bs-toggle="tab" data-bs-target="#golovi" type="button" role="tab">
                Golovi
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="izmene-tab" data-bs-toggle="tab" data-bs-target="#izmene" type="button" role="tab">
                Izmene
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="kartoni-tab" data-bs-toggle="tab" data-bs-target="#kartoni" type="button" role="tab">
                Kartoni
            </button>
        </li>
    </ul>

    <div class="tab-content" id="matchEditorContent">
        <!-- Tab 1: Basic Match Info -->
        <div class="tab-pane fade show active" id="osnovni-podaci" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="datum" class="form-label">Datum *</label>
                            <input type="date" class="form-control @error('datum') is-invalid @enderror" 
                                id="datum" name="datum" value="{{ old('datum', isset($utakmica) ? $utakmica->datum->format('Y-m-d') : '') }}" required>
                            @error('datum')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="vreme" class="form-label">Vreme</label>
                            <input type="time" class="form-control @error('vreme') is-invalid @enderror" 
                                id="vreme" name="vreme" value="{{ old('vreme', isset($utakmica) ? $utakmica->vreme?->format('H:i') : '') }}">
                            @error('vreme')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="takmicenje_id" class="form-label">Takmičenje *</label>
                        <select class="form-select @error('takmicenje_id') is-invalid @enderror" 
                                id="takmicenje_id" name="takmicenje_id" required>
                            <option value="">-- Izaberite takmičenje --</option>
                            @foreach($takmicenja as $takmicenje)
                                <option value="{{ $takmicenje->id }}" 
                                    {{ old('takmicenje_id', isset($utakmica) ? $utakmica->takmicenje_id : '') == $takmicenje->id ? 'selected' : '' }}>
                                    {{ $takmicenje->naziv }}
                                    @if($takmicenje->sezona) ({{ $takmicenje->sezona }}) @endif
                                </option>
                            @endforeach
                        </select>
                        @error('takmicenje_id')
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
                                    <option value="{{ $tim->id }}" 
                                        {{ old('domacin_id', isset($utakmica) ? $utakmica->domacin_id : '') == $tim->id ? 'selected' : '' }}>
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
                                    <option value="{{ $tim->id }}" 
                                        {{ old('gost_id', isset($utakmica) ? $utakmica->gost_id : '') == $tim->id ? 'selected' : '' }}>
                                        {{ $tim->naziv }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gost_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rezultat_domacin" class="form-label">Golovi domaćina</label>
                            <input type="number" class="form-control @error('rezultat_domacin') is-invalid @enderror" 
                                id="rezultat_domacin" name="rezultat_domacin" value="{{ old('rezultat_domacin', isset($utakmica) ? $utakmica->rezultat_domacin : 0) }}" min="0">
                            @error('rezultat_domacin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="rezultat_gost" class="form-label">Golovi gosta</label>
                            <input type="number" class="form-control @error('rezultat_gost') is-invalid @enderror" 
                                id="rezultat_gost" name="rezultat_gost" value="{{ old('rezultat_gost', isset($utakmica) ? $utakmica->rezultat_gost : 0) }}" min="0">
                            @error('rezultat_gost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="poluvreme_rezultat_domacin" class="form-label">Golovi domaćina (poluvreme)</label>
                            <input type="number" class="form-control @error('poluvreme_rezultat_domacin') is-invalid @enderror" 
                                id="poluvreme_rezultat_domacin" name="poluvreme_rezultat_domacin" 
                                value="{{ old('poluvreme_rezultat_domacin', isset($utakmica) ? $utakmica->poluvreme_rezultat_domacin : '') }}" min="0">
                            @error('poluvreme_rezultat_domacin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="poluvreme_rezultat_gost" class="form-label">Golovi gosta (poluvreme)</label>
                            <input type="number" class="form-control @error('poluvreme_rezultat_gost') is-invalid @enderror" 
                                id="poluvreme_rezultat_gost" name="poluvreme_rezultat_gost" 
                                value="{{ old('poluvreme_rezultat_gost', isset($utakmica) ? $utakmica->poluvreme_rezultat_gost : '') }}" min="0">
                            @error('poluvreme_rezultat_gost')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="stadion_id" class="form-label">Stadion</label>
                        <select class="form-select @error('stadion_id') is-invalid @enderror" 
                                id="stadion_id" name="stadion_id">
                            <option value="">-- Izaberite stadion --</option>
                            @foreach($stadioni as $stadion)
                                <option value="{{ $stadion->id }}" 
                                    {{ old('stadion_id', isset($utakmica) ? $utakmica->stadion_id : '') == $stadion->id ? 'selected' : '' }}>
                                    {{ $stadion->naziv }}, {{ $stadion->grad }}
                                </option>
                            @endforeach
                        </select>
                        @error('stadion_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="sudija_id" class="form-label">Sudija</label>
                        <select class="form-select @error('sudija_id') is-invalid @enderror" 
                                id="sudija_id" name="sudija_id">
                            <option value="">-- Izaberite sudiju --</option>
                            @foreach($sudije as $sudija)
                                <option value="{{ $sudija->id }}" 
                                    {{ old('sudija_id', isset($utakmica) ? $utakmica->sudija_id : '') == $sudija->id ? 'selected' : '' }}>
                                    {{ $sudija->ime }} {{ $sudija->prezime }}
                                </option>
                            @endforeach
                        </select>
                        @error('sudija_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="publika" class="form-label">Publika</label>
                        <input type="text" class="form-control @error('publika') is-invalid @enderror" 
                            id="publika" name="publika" value="{{ old('publika', isset($utakmica) ? $utakmica->publika : '') }}">
                        @error('publika')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="sezona" class="form-label">Sezona</label>
                        <input type="text" class="form-control @error('sezona') is-invalid @enderror" 
                            id="sezona" name="sezona" value="{{ old('sezona', isset($utakmica) ? $utakmica->sezona : '') }}">
                        @error('sezona')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tab 2: Lineups -->
        <div class="tab-pane fade" id="sastavi" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Sastav domaćina</h4>
                            <div id="domaci-sastav-container">
                                @if(isset($utakmica) && $utakmica->sastavi->where('tim_id', $utakmica->domacin_id)->count() > 0)
                                    @foreach($utakmica->sastavi->where('tim_id', $utakmica->domacin_id) as $index => $sastav)
                                        <div class="row mb-2 sastav-row">
                                            <input type="hidden" name="sastavi[{{ $index }}][tim_id]" value="{{ $utakmica->domacin_id }}">
                                            
                                            <div class="col-md-7">
                                                <select class="form-select" name="sastavi[{{ $index }}][igrac_id]" required>
                                                    <option value="">-- Izaberite igrača --</option>
                                                    @foreach($igraciDomacina as $igrac)
                                                        <option value="{{ $igrac->id }}" {{ $sastav->igrac_id == $igrac->id ? 'selected' : '' }}>
                                                            {{ $igrac->ime }} {{ $igrac->prezime }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                        name="sastavi[{{ $index }}][starter]" value="1" 
                                                        {{ $sastav->starter ? 'checked' : '' }}>
                                                    <label class="form-check-label">Starter</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-sm btn-danger remove-sastav">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="mt-2">
                                <button type="button" class="btn btn-primary btn-sm" id="add-domaci-igrac">
                                    <i class="fas fa-plus"></i> Dodaj igrača
                                </button>
                                
                                <div class="mt-3">
    <label for="domaci-selektor" class="form-label">Selektor</label>
    <input type="text" class="form-control" id="domaci-selektor" name="domaci_selektor" 
        value="{{ isset($utakmica) && $utakmica->sastavi->where('tim_id', $utakmica->domacin_id)->first() ? $utakmica->sastavi->where('tim_id', $utakmica->domacin_id)->first()->selektor : '' }}">
</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h4>Sastav gosta</h4>
                            <div id="gostujuci-sastav-container">
                                @if(isset($utakmica) && $utakmica->sastavi->where('tim_id', $utakmica->gost_id)->count() > 0)
                                    @foreach($utakmica->sastavi->where('tim_id', $utakmica->gost_id) as $index => $sastav)
                                        <div class="row mb-2 sastav-row">
                                            <input type="hidden" name="sastavi[{{ $index + 100 }}][tim_id]" value="{{ $utakmica->gost_id }}">
                                            
                                            <div class="col-md-7">
                                                <select class="form-select" name="sastavi[{{ $index + 100 }}][igrac_id]" required>
                                                    <option value="">-- Izaberite igrača --</option>
                                                    @foreach($igraciGosta as $igrac)
                                                        <option value="{{ $igrac->id }}" {{ $sastav->igrac_id == $igrac->id ? 'selected' : '' }}>
                                                            {{ $igrac->ime }} {{ $igrac->prezime }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                        name="sastavi[{{ $index + 100 }}][starter]" value="1" 
                                                        {{ $sastav->starter ? 'checked' : '' }}>
                                                    <label class="form-check-label">Starter</label>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-sm btn-danger remove-sastav">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <div class="mt-2">
                                <button type="button" class="btn btn-primary btn-sm" id="add-gost-igrac">
                                    <i class="fas fa-plus"></i> Dodaj igrača
                                </button>
                                
                                <div class="mt-3">
                                    <label for="gost-selektor" class="form-label">Selektor</label>
                                    <input type="text" class="form-control" id="gost-selektor" name="gost_selektor" 
                                        value="{{ isset($utakmica) && $utakmica->sastavi->where('tim_id', $utakmica->gost_id)->first() ? $utakmica->sastavi->where('tim_id', $utakmica->gost_id)->first()->selektor : '' }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tab 3: Goals -->
        <div class="tab-pane fade" id="golovi" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div id="golovi-container">
                        @if(isset($utakmica) && $utakmica->golovi->count() > 0)
                            @foreach($utakmica->golovi as $index => $gol)
                                <div class="row mb-3 gol-row">
                                    <div class="col-md-3">
                                        <label class="form-label">Tim</label>
                                        <select class="form-select gol-tim-select" name="golovi[{{ $index }}][tim_id]" required>
                                            <option value="">-- Izaberite tim --</option>
                                            <option value="{{ $utakmica->domacin_id }}" {{ $gol->tim_id == $utakmica->domacin_id ? 'selected' : '' }}>
                                                {{ $utakmica->domacin->naziv }}
                                            </option>
                                            <option value="{{ $utakmica->gost_id }}" {{ $gol->tim_id == $utakmica->gost_id ? 'selected' : '' }}>
                                                {{ $utakmica->gost->naziv }}
                                            </option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label">Igrač</label>
                                        <select class="form-select gol-igrac-select" name="golovi[{{ $index }}][igrac_id]" required>
                                            <option value="">-- Izaberite igrača --</option>
                                            @if($gol->tim_id == $utakmica->domacin_id)
                                                @foreach($igraciDomacina as $igrac)
                                                    <option value="{{ $igrac->id }}" {{ $gol->igrac_id == $igrac->id ? 'selected' : '' }}>
                                                        {{ $igrac->ime }} {{ $igrac->prezime }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach($igraciGosta as $igrac)
                                                    <option value="{{ $igrac->id }}" {{ $gol->igrac_id == $igrac->id ? 'selected' : '' }}>
                                                        {{ $igrac->ime }} {{ $igrac->prezime }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label class="form-label">Minut</label>
                                        <input type="number" class="form-control" name="golovi[{{ $index }}][minut]" 
                                            value="{{ $gol->minut }}" min="1" max="120" required>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label class="form-label">Tip gola</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="golovi[{{ $index }}][penal]" 
                                                    id="penal{{ $index }}" value="1" {{ $gol->penal ? 'checked' : '' }}>
                                                <label class="form-check-label" for="penal{{ $index }}">Penal</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="golovi[{{ $index }}][auto_gol]" 
                                                    id="auto_gol{{ $index }}" value="1" {{ $gol->auto_gol ? 'checked' : '' }}>
                                                <label class="form-check-label" for="auto_gol{{ $index }}">Autogol</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-1">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-sm btn-danger d-block remove-gol">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <button type="button" class="btn btn-primary btn-sm" id="add-gol">
                        <i class="fas fa-plus"></i> Dodaj gol
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Tab 4: Substitutions -->
        <div class="tab-pane fade" id="izmene" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div id="izmene-container">
                        @if(isset($utakmica) && $utakmica->izmene->count() > 0)
                            @foreach($utakmica->izmene as $index => $izmena)
                                <div class="row mb-3 izmena-row">
                                    <div class="col-md-2">
                                        <label class="form-label">Tim</label>
                                        <select class="form-select izmena-tim-select" name="izmene[{{ $index }}][tim_id]" required>
                                            <option value="">-- Izaberite tim --</option>
                                            <option value="{{ $utakmica->domacin_id }}" {{ $izmena->tim_id == $utakmica->domacin_id ? 'selected' : '' }}>
                                                {{ $utakmica->domacin->naziv }}
                                            </option>
                                            <option value="{{ $utakmica->gost_id }}" {{ $izmena->tim_id == $utakmica->gost_id ? 'selected' : '' }}>
                                                {{ $utakmica->gost->naziv }}
                                            </option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label class="form-label">Igrač koji izlazi</label>
                                        <select class="form-select izmena-igrac-out-select" name="izmene[{{ $index }}][igrac_out_id]" required>
                                            <option value="">-- Izaberite igrača --</option>
                                            @if($izmena->tim_id == $utakmica->domacin_id)
                                                @foreach($igraciDomacina as $igrac)
                                                    <option value="{{ $igrac->id }}" {{ $izmena->igrac_out_id == $igrac->id ? 'selected' : '' }}>
                                                        {{ $igrac->ime }} {{ $igrac->prezime }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach($igraciGosta as $igrac)
                                                    <option value="{{ $igrac->id }}" {{ $izmena->igrac_out_id == $igrac->id ? 'selected' : '' }}>
                                                        {{ $igrac->ime }} {{ $igrac->prezime }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label class="form-label">Igrač koji ulazi</label>
                                        <select class="form-select izmena-igrac-in-select" name="izmene[{{ $index }}][igrac_in_id]" required>
                                            <option value="">-- Izaberite igrača --</option>
                                            @if($izmena->tim_id == $utakmica->domacin_id)
                                                @foreach($igraciDomacina as $igrac)
                                                    <option value="{{ $igrac->id }}" {{ $izmena->igrac_in_id == $igrac->id ? 'selected' : '' }}>
                                                        {{ $igrac->ime }} {{ $igrac->prezime }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach($igraciGosta as $igrac)
                                                    <option value="{{ $igrac->id }}" {{ $izmena->igrac_in_id == $igrac->id ? 'selected' : '' }}>
                                                        {{ $igrac->ime }} {{ $igrac->prezime }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label class="form-label">Minut</label>
                                        <input type="number" class="form-control" name="izmene[{{ $index }}][minut]" 
                                            value="{{ $izmena->minut }}" min="1" max="120" required>
                                    </div>
                                    
                                    <div class="col-md-1">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-sm btn-danger d-block remove-izmena">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <button type="button" class="btn btn-primary btn-sm" id="add-izmena">
                        <i class="fas fa-plus"></i> Dodaj izmenu
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Tab 5: Cards -->
        <div class="tab-pane fade" id="kartoni" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div id="kartoni-container">
                        @if(isset($utakmica) && $utakmica->kartoni->count() > 0)
                            @foreach($utakmica->kartoni as $index => $karton)
                                <div class="row mb-3 karton-row">
                                    <div class="col-md-3">
                                        <label class="form-label">Tim</label>
                                        <select class="form-select karton-tim-select" name="kartoni[{{ $index }}][tim_id]" required>
                                            <option value="">-- Izaberite tim --</option>
                                            <option value="{{ $utakmica->domacin_id }}" {{ $karton->tim_id == $utakmica->domacin_id ? 'selected' : '' }}>
                                                {{ $utakmica->domacin->naziv }}
                                            </option>
                                            <option value="{{ $utakmica->gost_id }}" {{ $karton->tim_id == $utakmica->gost_id ? 'selected' : '' }}>
                                                {{ $utakmica->gost->naziv }}
                                            </option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label">Igrač</label>
                                        <select class="form-select karton-igrac-select" name="kartoni[{{ $index }}][igrac_id]" required>
                                            <option value="">-- Izaberite igrača --</option>
                                            @if($karton->tim_id == $utakmica->domacin_id)
                                                @foreach($igraciDomacina as $igrac)
                                                    <option value="{{ $igrac->id }}" {{ $karton->igrac_id == $igrac->id ? 'selected' : '' }}>
                                                        {{ $igrac->ime }} {{ $igrac->prezime }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach($igraciGosta as $igrac)
                                                    <option value="{{ $igrac->id }}" {{ $karton->igrac_id == $igrac->id ? 'selected' : '' }}>
                                                        {{ $igrac->ime }} {{ $igrac->prezime }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label class="form-label">Tip kartona</label>
                                        <select class="form-select" name="kartoni[{{ $index }}][tip]" required>
                                            <option value="zuti" {{ $karton->tip == 'zuti' ? 'selected' : '' }}>Žuti</option>
                                            <option value="crveni" {{ $karton->tip == 'crveni' ? 'selected' : '' }}>Crveni</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <label class="form-label">Minut</label>
                                        <input type="number" class="form-control" name="kartoni[{{ $index }}][minut]" 
                                            value="{{ $karton->minut }}" min="1" max="120" required>
                                    </div>
                                    
                                    <div class="col-md-1">
                                        <label class="form-label">&nbsp;</label>
                                        <button type="button" class="btn btn-sm btn-danger d-block remove-karton">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <button type="button" class="btn btn-primary btn-sm" id="add-karton">
                        <i class="fas fa-plus"></i> Dodaj karton
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <button type="submit" class="btn btn-primary btn-lg">Sačuvaj utakmicu</button>
    </div>
</form>
@endsection

@section('scripts')
<script>
    // Dynamic player loading when teams change
    function loadPlayers() {
        const domacin_id = $('#domacin_id').val();
        const gost_id = $('#gost_id').val();
        
        if (domacin_id && gost_id) {
            $.ajax({
                url: '{{ route("matches.loadPlayers") }}',
                type: 'GET',
                data: {
                    domacin_id: domacin_id,
                    gost_id: gost_id
                },
                success: function(data) {
                    // Store players data globally for dynamic forms
                    window.igraciDomacina = data.domacin;
                    window.igraciGosta = data.gost;
                    
                    // Update existing player dropdowns
                    updatePlayerDropdowns();
                }
            });
        }
    }
    
    function updatePlayerDropdowns() {
        // Update lineup dropdowns
        // ...additional code to update all player dropdowns in all tabs
    }
    
    // Add/remove lineup players
    let domaciSastavCount = {{ isset($utakmica) ? $utakmica->sastavi->where('tim_id', $utakmica->domacin_id)->count() : 0 }};
    let gostiSastavCount = {{ isset($utakmica) ? $utakmica->sastavi->where('tim_id', $utakmica->gost_id)->count() : 0 }};
    
    $('#add-domaci-igrac').click(function() {
        // Add player to home team lineup
        const newIndex = domaciSastavCount++;
        const html = `
            <div class="row mb-2 sastav-row">
                <input type="hidden" name="sastavi[${newIndex}][tim_id]" value="${$('#domacin_id').val()}">
                
                <div class="col-md-7">
                    <select class="form-select" name="sastavi[${newIndex}][igrac_id]" required>
                        <option value="">-- Izaberite igrača --</option>
                        ${generatePlayerOptions(window.igraciDomacina)}
                    </select>
                </div>
                
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sastavi[${newIndex}][starter]" value="1" checked>
                        <label class="form-check-label">Starter</label>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger remove-sastav">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        $('#domaci-sastav-container').append(html);
    });
    
    // Similar functions for other dynamic forms (goals, substitutions, cards)
    
    $(document).ready(function() {
        // Initialize team change handlers
        $('#domacin_id, #gost_id').change(loadPlayers);
        
        // Dynamic form handlers
        $(document).on('click', '.remove-sastav', function() {
            $(this).closest('.sastav-row').remove();
        });
        
        // Add handlers for other dynamic forms

        function generatePlayerOptions(players) {
            if (!players) return '';
            
            return players.map(player => {
                return `<option value="${player.id}">${player.ime} ${player.prezime}</option>`;
            }).join('');
        }
    });
</script>
@endsection