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

<div class="utakmice card mb-4">
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <div class="card-header text-center">
        <h2 class="card-title mb-0">Sastavi</h2>
        <a href="{{ route('sastavi.index', ['utakmica_id' => $utakmica->id]) }}" class="btn btn-primary">
            <i class="fas fa-users"></i> Upravljaj sastavima
        </a>  
    </div>
    @endif
    <div class="card-body">
        <div class="row py-4 align-items-center">
            <div class="col-4 text-center">
                <a href="{{ route('timovi.show', $utakmica->domacin) }}" class="text-decoration-none">
                    @if($utakmica->domacin && $utakmica->domacin->grb_url)
                        <img src="{{ asset('storage/grbovi/' . $utakmica->domacin->grb_url) }}" alt="{{ $utakmica->domacin->naziv }}" class="img-fluid mb-2" style="max-height: 100px;">
                    @endif
                    @if($domacinJeNasTim)
                        <h1>{{ $utakmica->domacin->naziv }}</h1>
                    @else
                        <h1>{{ $utakmica->protivnik_prikazno_ime }}</h1>
                    @endif
                </a>
            </div>
            <div class="col-4 text-center">
                <div class="display-3 fw-bold">
                    {{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}
                    @if($utakmica->imao_jedanaesterce)
                        <div class="fs-5 mt-1">
                            ({{ $utakmica->jedanaesterci_domacin }} - {{ $utakmica->jedanaesterci_gost }} pen)
                        </div>
                    @endif
                </div>
                <div class="text-muted">
                    {{ $utakmica->poluvremenskiRezultat }}
                </div>
            </div>
            <div class="col-4 text-center">
                <a href="{{ route('timovi.show', $utakmica->gost) }}" class="text-decoration-none">
                    @if($utakmica->gost && $utakmica->gost->grb_url)
                        <img src="{{ asset('storage/grbovi/' . $utakmica->gost->grb_url) }}" alt="{{ $utakmica->gost->naziv }}" class="img-fluid mb-2" style="max-height: 100px;">
                    @endif
                    @if($domacinJeNasTim)
                        <h1>{{ $utakmica->protivnik_prikazno_ime }}</h1>
                    @else
                        <h1>{{ $utakmica->gost->naziv }}</h1>
                    @endif
                </a>
            </div>
        </div>

        @include('partials.utakmice.sastavi_lista')
    </div>
</div>