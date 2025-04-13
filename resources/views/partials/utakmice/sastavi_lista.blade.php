<div class="row py-4 align-items-center">
    <div class="col-5 col-lg-4 text-end">
        @php
            $domaciSastav = $utakmica->sastavi->where('tim_id', $utakmica->domacin_id)
                ->sortBy('redosled')
                ->sortByDesc('starter');
            $domaciProtivnickiIgraci = $utakmica->protivnickiIgraci->where('tim_id', $utakmica->domacin_id)
                ->sortBy('redosled');
            $imaDomacihIgraca = $domaciSastav->count() > 0 || $domaciProtivnickiIgraci->count() > 0;
            
            // Dobavi glavni tim (izabrani tim)
            $glavniTim = \App\Models\Tim::glavniTim()->first();
            $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
            $domacinJeNasTim = in_array($utakmica->domacin_id, $glavniTimIds);
        @endphp
        @if($imaDomacihIgraca)
            <ul class="list-unstyled" id="domaci-sastav-lista" style="text-align: right">
                @foreach($domaciSastav as $sastav)
                    <li class="py-1 sortable-item" data-id="{{ $sastav->id }}">
                        @if($sastav->starter)
                            <div class="d-flex align-items-center" style="justify-content: flex-end;">
                                <a href="{{ route('igraci.show', $sastav->igrac->id) }}" class="text-decoration-none">
                                    <span>
                                        {{ $sastav->igrac->prezime }} {{ $sastav->igrac->ime }}
                                        @if($sastav->kapiten) <small>(C)</small> @endif
                                        <small class="text-muted">({{ $sastav->igrac->getBrojNastupaDoDatuma($utakmica->datum) }})</small>
                                    </span>
                                </a>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <div class="handle ms-4" style="cursor: move; opacity: 0.5;"><i class="fas fa-grip-vertical"></i></div>  
                                <a href="{{ route('sastavi.edit', $sastav->id) }}" class="btn btn-sm btn-warning ms-4">
                                    <i class="fas fa-edit"></i>
                                </a>                            
                                <form action="{{ route('sastavi.destroy', $sastav->id) }}" method="POST" class="d-inline ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        @endif
                    </li>
                @endforeach
                
                @foreach($domaciProtivnickiIgraci->where('u_sastavu', true) as $igrac)
                    <li class="py-1 sortable-item" data-id="p{{ $igrac->id }}">
                        <div class="d-flex align-items-center" style="justify-content: flex-end;">
                            <span>
                                {{ $igrac->prezime }} {{ $igrac->ime }} 
                                @if($igrac->kapiten) <small>(C)</small> @endif
                            </span>
                            @if(Auth::check() && Auth::user()->hasEditAccess())
                            <div class="handle ms-4" style="cursor: move; opacity: 0.5;"><i class="fas fa-grip-vertical"></i></div>
                            <form action="{{ route('protivnicki-igraci.destroy', $igrac->id) }}" method="POST" class="d-inline ms-4">
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
            <p class="text-center text-muted">Nema evidentiranih igrača za domaći tim.</p>
        @endif
    </div>
    <div class="col-2 col-lg-4"></div>
    <div class="col-5 col-lg-4">
        @php
            $gostujuciSastav = $utakmica->sastavi->where('tim_id', $utakmica->gost_id)
            ->sortBy('redosled')
            ->sortByDesc('starter');
            $gostujuciProtivnickiIgraci = $utakmica->protivnickiIgraci->where('tim_id', $utakmica->gost_id)
                ->sortBy('redosled');
            $imaGostujucihIgraca = $gostujuciSastav->count() > 0 || $gostujuciProtivnickiIgraci->count() > 0;
            $gostJeNasTim = in_array($utakmica->gost_id, $glavniTimIds);
        @endphp
        @if($imaGostujucihIgraca)
            <ul class="list-unstyled" id="gostujuci-sastav-lista">
                @foreach($gostujuciSastav as $sastav)
                    <li class="py-1 sortable-item" data-id="{{ $sastav->id }}">
                        @if($sastav->starter)
                            <div class="d-flex align-items-center">
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <form action="{{ route('sastavi.destroy', $sastav->id) }}" method="POST" class="d-inline me-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                <a href="{{ route('sastavi.edit', $sastav->id) }}" class="btn btn-sm btn-warning me-4">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div class="handle me-4" style="cursor: move; opacity: 0.5;"><i class="fas fa-grip-vertical"></i></div>
                                @endif
                                <a href="{{ route('igraci.show', $sastav->igrac->id) }}" class="text-decoration-none">
                                    <span>
                                        {{ $sastav->igrac->prezime }} {{ $sastav->igrac->ime }}
                                        @if($sastav->kapiten) <small>(C)</small> @endif
                                        <small class="text-muted">({{ $sastav->igrac->getBrojNastupaDoDatuma($utakmica->datum) }})</small>
                                    </span>
                                </a>
                            </div>
                        @endif
                    </li>
                @endforeach
                
                @foreach($gostujuciProtivnickiIgraci->where('u_sastavu', true) as $igrac)
                    <li class="py-1 sortable-item" data-id="p{{ $igrac->id }}">
                        <div class="d-flex align-items-center">
                            @if(Auth::check() && Auth::user()->hasEditAccess())
                            <form action="{{ route('protivnicki-igraci.destroy', $igrac->id) }}" method="POST" class="d-inline me-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                            <div class="handle me-4" style="cursor: move; opacity: 0.5;"><i class="fas fa-grip-vertical"></i></div>
                            @endif
                            <span>
                                {{ $igrac->prezime }} {{ $igrac->ime }} 
                                @if($igrac->kapiten) <small>(C)</small> @endif
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-center text-muted">Nema evidentiranih igrača za gostujući tim.</p>
        @endif
    </div>
</div>