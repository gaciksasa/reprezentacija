<div class="utakmice card mb-4">
    <div class="card-header text-center">
        <h2 class="card-title mb-0">Izmene</h2>
        @if(Auth::check() && Auth::user()->hasEditAccess())
        <div class="btn-group mt-2">
            <a href="{{ route('izmene.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Domaćin
            </a>
            <a href="{{ route('izmene.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Gost
            </a>
        </div>
        @endif
    </div>
    <div class="card-body">
        @php
            // Dobavi sve izmene (i regularne i protivničke)
            $sveIzmene = $utakmica->izmene->concat($utakmica->protivnickeIzmene)->sortBy('minut');
            
            // Grupiši izmene po timu
            $domaceIzmene = $sveIzmene->where('tim_id', $utakmica->domacin_id);
            $gostujuceIzmene = $sveIzmene->where('tim_id', $utakmica->gost_id);
        @endphp
        
        @if($sveIzmene->count() > 0)
            <!-- Izmene -->
            <div class="row py-4">
                <div class="col-5 col-lg-4 text-end">
                    @if($domaceIzmene->count() > 0)
                        <ul class="list-unstyled">
                            @foreach($domaceIzmene as $izmena)
                                <li class="py-1">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div>
                                            <span class="text-muted">{{ $izmena->minut }}' </span>
                                            <i class="fas fa-arrow-right text-success"></i> 
                                            @if(get_class($izmena) === 'App\Models\Izmena')
                                                <a href="{{ route('igraci.show', $izmena->igracIn->id) }}" class="text-decoration-none">
                                                    {{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}
                                                </a>
                                            @else
                                                {{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}
                                            @endif
                                            <br>
                                            <span class="text-muted ps-4">
                                                <i class="fas fa-arrow-left text-danger"></i> 
                                                @if(get_class($izmena) === 'App\Models\Izmena')
                                                    <a href="{{ route('igraci.show', $izmena->igracOut->id) }}" class="text-decoration-none">
                                                        {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                                    </a>
                                                @else
                                                    {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                                @endif
                                            </span>
                                        </div>
                                        @if(Auth::check() && Auth::user()->hasEditAccess())
                                        <form action="{{ route('izmene.destroy', $izmena->id) }}" method="POST" class="d-inline ms-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Nema izmena za domaći tim.</p>
                    @endif
                </div>
                
                <div class="col-2 col-lg-4"></div>
                
                <div class="col-5 col-lg-4">
                    @if($gostujuceIzmene->count() > 0)
                        <ul class="list-unstyled">
                            @foreach($gostujuceIzmene as $izmena)
                                <li class="py-1">
                                    <div class="d-flex align-items-center justify-content-start">
                                        @if(Auth::check() && Auth::user()->hasEditAccess())
                                        <form action="{{ route('izmene.destroy', $izmena->id) }}" method="POST" class="d-inline me-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <div>
                                            <span class="text-muted">{{ $izmena->minut }}' </span>
                                            <i class="fas fa-arrow-right text-success"></i> 
                                            @if(get_class($izmena) === 'App\Models\Izmena')
                                                <a href="{{ route('igraci.show', $izmena->igracIn->id) }}" class="text-decoration-none">
                                                    {{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}
                                                </a>
                                            @else
                                                {{ $izmena->igracIn->prezime }} {{ $izmena->igracIn->ime }}
                                            @endif
                                            <br>
                                            <span class="text-muted ps-4">
                                                <i class="fas fa-arrow-left text-danger"></i> 
                                                @if(get_class($izmena) === 'App\Models\Izmena')
                                                    <a href="{{ route('igraci.show', $izmena->igracOut->id) }}" class="text-decoration-none">
                                                        {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                                    </a>
                                                @else
                                                    {{ $izmena->igracOut->prezime }} {{ $izmena->igracOut->ime }}
                                                @endif
                                            </span>
                                        </div>
                                        
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Nema izmena za gostujući tim.</p>
                    @endif
                </div>
            </div>
        @else
            <div class="row py-4">
                <div class="col-12 text-center">
                    <p class="text-muted">Nema evidentiranih izmena za ovu utakmicu.</p>
                </div>
            </div>
        @endif
    </div>
</div>