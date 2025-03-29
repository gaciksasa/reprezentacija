@extends('layouts.app')

@section('title', 'Početna')

@section('content')
<!-- News Carousel -->
<div class="card mb-4 p-0">
    <div class="card-body p-0">
        <div id="newsCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                @foreach($poslednjiPostovi as $index => $post)
                    <button type="button" data-bs-target="#newsCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            <div class="carousel-inner">
            @foreach($poslednjiPostovi as $index => $post)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ $post->featured_image ? asset('storage/uploads/' . $post->featured_image) : asset('img/no-image.png') }}" class="d-block w-100" alt="{{ $post->post_title }}" style="max-height: 400px; object-fit: cover;">
                    <div class="carousel-caption">
                        <h2><a href="{{ route('posts.show', $post->id) }}">{{ $post->post_title }}</a></h2>
                        <p class="text-dark">{{ Str::limit(html_entity_decode(strip_tags($post->post_excerpt ?: $post->post_content)), 150) }}</p>
                    </div>
                </div>
            @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Prethodni</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Sledeći</span>
            </button>
        </div>
    </div>
</div>

<div class="row mt-4 mb-3">
    <div class="col-md-4 mb-2">
        <div class="card">
            <div class="card-body text-center p-5">
                <h2 class="card-title">Bilansi</h2>
                <p class="display-4">{{ $brojTimova }}</p>
                <a href="{{ route('timovi.index') }}" class="btn btn-primary">Prikaži sve</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card">
            <div class="card-body text-center p-5">
                <h2 class="card-title">Reprezentativci</h2>
                <p class="display-4">{{ $brojIgraca }}</p>
                <a href="{{ route('igraci.index') }}" class="btn btn-primary">Prikaži sve</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card">
            <div class="card-body text-center p-5">
                <h2 class="card-title">Utakmice</h2>
                <p class="display-4">{{ $brojUtakmica }}</p>
                <a href="{{ route('utakmice.index') }}" class="btn btn-primary">Prikaži sve</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title mb-0">Poslednje utakmice</h2>
            </div>
            <div class="card-body">
                <div class="list-group border-0">
                    @foreach($poslednjeUtakmice as $utakmica)
                    <a href="{{ route('utakmice.show', $utakmica) }}" class="list-group-item list-group-item-action border-0 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $utakmica->domacin->naziv }}</strong> 
                                {{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }} 
                                <strong>{{ $utakmica->gost->naziv }}</strong>
                            </div>
                            <small>{{ $utakmica->datum->format('d.m.Y') }}</small>
                        </div>
                        <small class="text-muted">
                            @if($utakmica->takmicenje)
                                {{ $utakmica->takmicenje->naziv }}
                            @endif
                        </small>
                    </a>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('utakmice.index') }}" class="btn btn-primary">Sve utakmice</a>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title mb-0">Najbolji strelci</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            @foreach($strelci as $index => $strelac)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a href="{{ route('igraci.show', $strelac->id) }}">{{ $strelac->prezime }} {{ $strelac->ime }}</a></td>
                                <td class="text-end">{{ $strelac->broj_golova }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="card-title mb-0">Najviše nastupa</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            @foreach($najviseNastupa as $index => $igrac)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><a href="{{ route('igraci.show', $igrac->id) }}">{{ $igrac->prezime }} {{ $igrac->ime }}</a></td>
                                <td class="text-end">{{ $igrac->broj_nastupa }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.carousel-item {
    height: 400px;
}
.carousel-caption {
    background-color: rgba(0, 0, 0, 0.6);
    border-radius: 10px;
    padding: 20px;
}
</style>
@endsection