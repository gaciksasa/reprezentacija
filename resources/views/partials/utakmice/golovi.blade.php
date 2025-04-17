<div class="utakmice card mb-4">
    <div class="card-header text-center">
        <h2 class="card-title mb-0">Golovi</h2>
        @can('manageGolovi', $utakmica)
        <a href="{{ route('golovi.create', ['utakmica_id' => $utakmica->id]) }}" class="btn btn-sm btn-primary mt-2">
            <i class="fas fa-plus"></i> Dodaj
        </a>
        @endcan
    </div>
    <div class="card-body">
        @if($utakmica->golovi->count() > 0)
            <!-- Golovi -->
            <div class="row py-4">
                <div class="col-5 col-lg-4 text-end">
                    @php
                        // Domaći golovi
                        $domaciGolovi = $utakmica->golovi->where('tim_id', $utakmica->domacin_id)->sortBy('minut');
                    @endphp
                    
                    @if($domaciGolovi->count() > 0)
                        <ul class="list-unstyled">
                            @foreach($domaciGolovi as $gol)
                                <li class="py-1">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div>
                                            <span class="text-muted">{{ $gol->minut }}' </span>
                                            @if($gol->igrac_tip == 'protivnicki')
                                                @php 
                                                    $protivnickiIgrac = \App\Models\ProtivnickiIgrac::find($gol->igrac_id);
                                                @endphp
                                                @if($protivnickiIgrac)
                                                    @if($gol->penal)
                                                        <span>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</span> (p)
                                                    @elseif($gol->auto_gol)
                                                        <span>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</span> (ag)
                                                    @else
                                                        <span>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</span>
                                                    @endif
                                                @else
                                                    <span>Nepoznat igrač</span>
                                                @endif
                                            @else
                                                @if($gol->igrac)
                                                    <a href="{{ route('igraci.show', $gol->igrac->id) }}" class="text-decoration-none">
                                                        <span>
                                                            @if($gol->penal)
                                                                {{ $gol->igrac->prezime }} {{ $gol->igrac->ime }} (p)
                                                            @elseif($gol->auto_gol)
                                                                {{ $gol->igrac->prezime }} {{ $gol->igrac->ime }} (ag)
                                                            @else
                                                                {{ $gol->igrac->prezime }} {{ $gol->igrac->ime }}
                                                            @endif
                                                        </span>
                                                    </a>
                                                @else
                                                    <span>Nepoznat igrač</span>
                                                @endif
                                            @endif
                                        </div>
                                        @can('manage-gol')
                                        <form action="{{ route('golovi.destroy', $gol->id) }}" method="POST" class="d-inline ms-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Nema golova za domaći tim.</p>
                    @endif
                </div>
                
                <div class="col-2 col-lg-4"></div>
                
                <div class="col-5 col-lg-4">
                    @php
                        // Gostujući golovi
                        $gostujuciGolovi = $utakmica->golovi->where('tim_id', $utakmica->gost_id)->sortBy('minut');
                    @endphp
                    
                    @if($gostujuciGolovi->count() > 0)
                        <ul class="list-unstyled">
                            @foreach($gostujuciGolovi as $gol)
                                <li class="py-1">
                                    <div class="d-flex">
                                        @if(Auth::check() && Auth::user()->hasEditAccess())
                                        <form action="{{ route('golovi.destroy', $gol->id) }}" method="POST" class="d-inline me-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Da li ste sigurni?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                        @endif
                                        <div>
                                            <span class="text-muted">{{ $gol->minut }}' </span>
                                            @if($gol->igrac_tip == 'protivnicki')
                                                @php 
                                                    $protivnickiIgrac = \App\Models\ProtivnickiIgrac::find($gol->igrac_id);
                                                @endphp
                                                @if($protivnickiIgrac)
                                                    @if($gol->penal)
                                                        <span>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</span> (p)
                                                    @elseif($gol->auto_gol)
                                                        <span>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</span> (ag)
                                                    @else
                                                        <span>{{ $protivnickiIgrac->prezime }} {{ $protivnickiIgrac->ime }}</span>
                                                    @endif
                                                @else
                                                    <span>Nepoznat igrač</span>
                                                @endif
                                            @else
                                                @if($gol->igrac)
                                                    <a href="{{ route('igraci.show', $gol->igrac->id) }}" class="text-decoration-none">
                                                        <span>
                                                            @if($gol->penal)
                                                                {{ $gol->igrac->prezime }} {{ $gol->igrac->ime }} (p)
                                                            @elseif($gol->auto_gol)
                                                                {{ $gol->igrac->prezime }} {{ $gol->igrac->ime }} (ag)
                                                            @else
                                                                {{ $gol->igrac->prezime }} {{ $gol->igrac->ime }}
                                                            @endif
                                                        </span>
                                                    </a>
                                                @else
                                                    <span>Nepoznat igrač</span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">Nema golova za gostujući tim.</p>
                    @endif
                </div>
            </div>
        @else
            <div class="row py-4">
                <div class="col-12 text-center">
                    <p class="text-muted">Nema evidentiranih golova za ovu utakmicu.</p>
                </div>
            </div>
        @endif
    </div>
</div>