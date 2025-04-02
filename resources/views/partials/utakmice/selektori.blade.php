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
                @endphp
                
                @if($domacinJeNasTim && isset($selektor) && $selektor)
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="{{ route('selektori.show', $selektor->selektor) }}" class="text-decoration-none">
                            <span>{{ $selektor->selektor->ime_prezime }}</span>
                        </a>
                        @if($selektor->v_d_status)
                            <span class="badge bg-warning text-dark ms-1">v.d.</span>
                        @endif
                    </div>
                @elseif(!$domacinJeNasTim && $domacinSelektor)
                    <div class="d-flex align-items-center justify-content-end">
                        <div>
                            <span>{{ $domacinSelektor->ime_prezime }}</span>
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
                @endphp
                
                @if($gostJeNasTim && isset($selektor) && $selektor)
                    <div class="d-flex align-items-center">
                        <a href="{{ route('selektori.show', $selektor->selektor) }}" class="text-decoration-none">
                            <span>{{ $selektor->selektor->ime_prezime }}</span>
                        </a>
                        @if($selektor->v_d_status)
                            <span class="badge bg-warning text-dark ms-1">v.d.</span>
                        @endif
                    </div>
                @elseif(!$gostJeNasTim && $gostSelektor)
                    <div class="d-flex align-items-center">
                        <div>
                            <span>{{ $gostSelektor->ime_prezime }}</span>
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