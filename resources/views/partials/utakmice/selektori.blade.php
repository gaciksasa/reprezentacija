<div class="utakmice card mb-4">
    <div class="card-header text-center">
        <h2 class="card-title mb-0">Selektori</h2>
    </div>
    <div class="card-body">
        <div class="row py-4 align-items-center">
            <div class="col-5 col-lg-4 text-end">
                @php
                    // Proveri da li je domaćin naš tim
                    $glavniTim = \App\Models\Tim::glavniTim()->first();
                    $nasTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
                    $domacinJeNasTim = in_array($utakmica->domacin_id, $nasTimIds);
                    
                    // Dohvati selektora protivničkog tima ako postoji
                    $domacinSelektor = null;
                    if (!$domacinJeNasTim) {
                        $domacinSelektor = \App\Models\ProtivnickiSelektor::where('utakmica_id', $utakmica->id)
                            ->where('tim_id', $utakmica->domacin_id)
                            ->first();
                    }
                    
                    // Ako je domaćin naš tim - pronađi selektor mandat za tu utakmicu
                    $domacinSelektorMandat = null;
                    $domacinSelektoriNaUtakmici = collect();
                    if ($domacinJeNasTim) {
                        // Pronađi selektor mandat koji je bio aktivan na datum utakmice
                        $domacinSelektorMandat = \App\Models\SelektorMandat::whereHas('tim', function($query) use ($nasTimIds) {
                            $query->whereIn('id', $nasTimIds);
                        })
                        ->where('pocetak_mandata', '<=', $utakmica->datum)
                        ->where(function($query) use ($utakmica) {
                            $query->whereNull('kraj_mandata')
                                  ->orWhere('kraj_mandata', '>=', $utakmica->datum);
                        })
                        ->with('selektor')
                        ->first();
                        
                        if ($domacinSelektorMandat) {
                            // Ako je komisija, dohvati sve članove komisije
                            if ($domacinSelektorMandat->komisija) {
                                $clanoviKomisijeCollection = $domacinSelektorMandat->clanoviKomisije();
                                // Učitaj selektor relacije za sve članove
                                $clanoviKomisijeCollection->load('selektor');
                                // Izdvoj selektore iz mandata
                                $domacinSelektoriNaUtakmici = $clanoviKomisijeCollection->map(function($mandat) {
                                    return $mandat->selektor;
                                });
                            } else {
                                // Ako nije komisija, samo dodaj jednog selektora
                                $domacinSelektoriNaUtakmici = collect([$domacinSelektorMandat->selektor]);
                            }
                        }
                    }
                @endphp
                
                @if($domacinJeNasTim && $domacinSelektorMandat && $domacinSelektoriNaUtakmici->count() > 0)
                    <div class="d-flex align-items-center justify-content-end">
                        <div>
                            @foreach($domacinSelektoriNaUtakmici as $index => $selektor_obj)
                                <a href="{{ route('selektori.show', $selektor_obj) }}">
                                    {{ $selektor_obj->prezime }} {{ $selektor_obj->ime }}
                                </a>
                                @if($index < $domacinSelektoriNaUtakmici->count() - 1)
                                    <br>
                                @endif
                            @endforeach
                            
                            @if($domacinSelektorMandat->v_d_status)
                                <small class="text-muted d-block">(v.d.)</small>
                            @endif
                        </div>
                    </div>
                @elseif(!$domacinJeNasTim && $domacinSelektor)
                    <div class="d-flex align-items-center justify-content-end">
                        <div>
                            @php
                                // Razdvajamo selektore po zarezima i prikazujemo ih jedan ispod drugog
                                $selektori = explode(',', $domacinSelektor->ime_prezime);
                            @endphp
                            
                            @foreach($selektori as $index => $selektorIme)
                                <span>{{ trim($selektorIme) }}</span>
                                @if($index < count($selektori) - 1)
                                    <br>
                                @endif
                            @endforeach
                            
                            @if($domacinSelektor->napomena)
                                <small class="text-muted d-block">{{ $domacinSelektor->napomena }}</small>
                            @endif
                        </div>
                        @if(Auth::check() && Auth::user()->hasEditAccess())
                        <div class="btn-group ms-2">
                            <a href="{{ route('protivnicki-selektori.edit', $domacinSelektor->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('protivnicki-selektori/'.$domacinSelektor->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                @elseif(!$domacinJeNasTim && Auth::check() && Auth::user()->hasEditAccess())
                    <a href="{{ route('protivnicki-selektori.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Dodaj selektora
                    </a>
                @else
                    <p class="text-muted mb-0">Nema podataka o selektoru</p>
                @endif
            </div>
            
            <div class="col-2 col-lg-4"></div>
            
            <div class="col-5 col-lg-4">
                @php
                    // Proveri da li je gost naš tim
                    $gostJeNasTim = in_array($utakmica->gost_id, $nasTimIds);
                    
                    // Dohvati selektora protivničkog tima ako postoji
                    $gostSelektor = null;
                    if (!$gostJeNasTim) {
                        $gostSelektor = \App\Models\ProtivnickiSelektor::where('utakmica_id', $utakmica->id)
                            ->where('tim_id', $utakmica->gost_id)
                            ->first();
                    }
                    
                    // Ako je gost naš tim - pronađi selektor mandat za tu utakmicu
                    $gostSelektorMandat = null;
                    $gostSelektoriNaUtakmici = collect();
                    if ($gostJeNasTim) {
                        // Pronađi selektor mandat koji je bio aktivan na datum utakmice
                        $gostSelektorMandat = \App\Models\SelektorMandat::whereHas('tim', function($query) use ($nasTimIds) {
                            $query->whereIn('id', $nasTimIds);
                        })
                        ->where('pocetak_mandata', '<=', $utakmica->datum)
                        ->where(function($query) use ($utakmica) {
                            $query->whereNull('kraj_mandata')
                                  ->orWhere('kraj_mandata', '>=', $utakmica->datum);
                        })
                        ->with('selektor')
                        ->first();
                        
                        if ($gostSelektorMandat) {
                            // Ako je komisija, dohvati sve članove komisije
                            if ($gostSelektorMandat->komisija) {
                                $clanoviKomisijeCollection = $gostSelektorMandat->clanoviKomisije();
                                // Učitaj selektor relacije za sve članove
                                $clanoviKomisijeCollection->load('selektor');
                                // Izdvoj selektore iz mandata
                                $gostSelektoriNaUtakmici = $clanoviKomisijeCollection->map(function($mandat) {
                                    return $mandat->selektor;
                                });
                            } else {
                                // Ako nije komisija, samo dodaj jednog selektora
                                $gostSelektoriNaUtakmici = collect([$gostSelektorMandat->selektor]);
                            }
                        }
                    }
                @endphp
                
                @if($gostJeNasTim && $gostSelektorMandat && $gostSelektoriNaUtakmici->count() > 0)
                    <div class="d-flex align-items-center">
                        <div>
                            @foreach($gostSelektoriNaUtakmici as $index => $selektor_obj)
                                <a href="{{ route('selektori.show', $selektor_obj) }}">
                                    {{ $selektor_obj->prezime }} {{ $selektor_obj->ime }}
                                </a>
                                @if($index < $gostSelektoriNaUtakmici->count() - 1)
                                    <br>
                                @endif
                            @endforeach
                            
                            @if($gostSelektorMandat->v_d_status)
                                <small class="text-muted d-block">(v.d.)</small>
                            @endif
                        </div>
                    </div>
                @elseif(!$gostJeNasTim && $gostSelektor)
                    <div class="d-flex align-items-center">
                        <div>
                            @php
                                // Razdvajamo selektore po zarezima i prikazujemo ih jedan ispod drugog
                                $selektori = explode(',', $gostSelektor->ime_prezime);
                            @endphp
                            
                            @foreach($selektori as $index => $selektorIme)
                                <span>{{ trim($selektorIme) }}</span>
                                @if($index < count($selektori) - 1)
                                    <br>
                                @endif
                            @endforeach
                            
                            @if($gostSelektor->napomena)
                                <small class="text-muted d-block">{{ $gostSelektor->napomena }}</small>
                            @endif
                        </div>
                        @if(Auth::check() && Auth::user()->hasEditAccess())
                        <div class="btn-group ms-2">
                            <a href="{{ route('protivnicki-selektori.edit', $gostSelektor->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ url('protivnicki-selektori/'.$gostSelektor->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                @elseif(!$gostJeNasTim && Auth::check() && Auth::user()->hasEditAccess())
                    <a href="{{ route('protivnicki-selektori.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> Dodaj selektora
                    </a>
                @else
                    <p class="text-muted mb-0">Nema podataka o selektoru</p>
                @endif
            </div>
        </div>
    </div>
</div>