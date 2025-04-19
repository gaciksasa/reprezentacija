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
                    
                    // Ako je domaćin naš tim i imamo selektor mandat
                    $domacinSelektorMandat = null;
                    $domacinSelektoriNaUtakmici = collect();
                    if ($domacinJeNasTim && isset($selektor) && $selektor) {
                        $domacinSelektorMandat = $selektor;
                        // Proverimo da li je komisija i dohvatimo sve članove
                        if ($domacinSelektorMandat->komisija) {
                            $domacinSelektoriNaUtakmici = $domacinSelektorMandat->clanoviKomisije();
                        } else {
                            $domacinSelektoriNaUtakmici = collect([$domacinSelektorMandat]);
                        }
                    }
                @endphp
                
                @if($domacinJeNasTim && $domacinSelektorMandat)
                    <div class="d-flex align-items-center justify-content-end">
                        <div>
                            @if($domacinSelektoriNaUtakmici->count() > 1)
                                <div><small class="text-muted">Selektorska komisija:</small></div>
                            @endif
                            
                            @foreach($domacinSelektoriNaUtakmici as $mandat)
                                <div class="mb-1">
                                    <a href="{{ route('selektori.show', $mandat->selektor) }}" class="text-decoration-none">
                                        <span>{{ $mandat->selektor->ime_prezime }}</span>
                                    </a>
                                    <span class="text-muted ms-1">({{ $mandat->getBrojUtakmiceZaDatum($utakmica->datum) }})</span>
                                    
                                    @if($mandat->glavni_selektor)
                                        <span class="badge bg-primary ms-1">glavni</span>
                                    @endif
                                    
                                    @if($mandat->v_d_status)
                                        <span class="badge bg-warning text-dark ms-1">v.d.</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                <!-- Kod za protivničke selektore koji se nalaze u sekciji za domaći tim -->
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
                    
                    // Ako je gost naš tim i imamo selektor mandat
                    $gostSelektorMandat = null;
                    $gostSelektoriNaUtakmici = collect();
                    if ($gostJeNasTim && isset($selektor) && $selektor) {
                        $gostSelektorMandat = $selektor;
                        // Proverimo da li je komisija i dohvatimo sve članove
                        if ($gostSelektorMandat->komisija) {
                            $gostSelektoriNaUtakmici = $gostSelektorMandat->clanoviKomisije();
                        } else {
                            $gostSelektoriNaUtakmici = collect([$gostSelektorMandat]);
                        }
                    }
                @endphp
                
                @if($gostJeNasTim && $gostSelektorMandat)
                    <div class="d-flex align-items-center">
                        <div>
                            @if($gostSelektoriNaUtakmici->count() > 1)
                                <div><small class="text-muted">Selektorska komisija:</small></div>
                            @endif
                            
                            @foreach($gostSelektoriNaUtakmici as $mandat)
                                <div class="mb-1">
                                    <a href="{{ route('selektori.show', $mandat->selektor) }}" class="text-decoration-none">
                                        <span>{{ $mandat->selektor->ime_prezime }}</span>
                                    </a>
                                    <span class="text-muted ms-1">({{ $mandat->getBrojUtakmiceZaDatum($utakmica->datum) }})</span>
                                    
                                    @if($mandat->glavni_selektor)
                                        <span class="badge bg-primary ms-1">glavni</span>
                                    @endif
                                    
                                    @if($mandat->v_d_status)
                                        <span class="badge bg-warning text-dark ms-1">v.d.</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                <!-- Kod za protivničke selektore koji se nalaze u sekciji za gostujući tim -->
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