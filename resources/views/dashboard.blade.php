@extends('layouts.app')

@section('title', 'Početna')

@section('content')

<!-- News Carousel -->
<section id="newsCarousel" class="news-carousel carousel slide carousel-fade my-3" data-bs-ride="carousel">
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
</section>

<!-- Include the upcoming fixtures section -->
@include('partials.upcoming-fixtures')

<!-- Category News Tabs -->
<section class="category-news-tabs card mb-3">
    <div class="card-header">
        @if(count($kategorije) > 0)
        <ul class="nav nav-tabs card-header-tabs" id="newsCategories" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all-news" 
                        type="button" role="tab" aria-controls="all-news" aria-selected="true">
                    Sve vesti
                </button>
            </li>
            @foreach($kategorije as $index => $kategorija)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="{{ $kategorija->slug }}-tab" data-bs-toggle="tab" 
                            data-bs-target="#{{ $kategorija->slug }}" type="button" role="tab" 
                            aria-controls="{{ $kategorija->slug }}" aria-selected="false">
                        {{ $kategorija->name }}
                    </button>
                </li>
            @endforeach
        </ul>
        </div>        
    <div class="tab-content mt-4" id="newsCategoriesContent">
        <div class="tab-pane fade show active" id="all-news" role="tabpanel" aria-labelledby="all-tab">
            <div class="row">
                @foreach($poslednjiPostovi as $post)
                <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/uploads/' . $post->featured_image) }}" 
                                        class="card-img-top" alt="{{ $post->post_title }}" 
                                        style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h3 class="card-title">
                                    <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">
                                        {{ $post->post_title }}
                                    </a>
                                </h3>
                                <div class="d-flex justify-content-between mb-2">
                                    <p class="card-text small text-muted mb-0">
                                        {{ \Carbon\Carbon::parse($post->post_date)->format('d.m.Y H:i') }}
                                    </p>
                                </div>
                                <p class="card-text">
                                    {{ Str::limit(html_entity_decode(strip_tags($post->post_excerpt ?: $post->post_content)), 150) }}
                                </p>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-primary">
                                    Detaljnije
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        @foreach($kategorije as $kategorija)
            <div class="tab-pane fade" id="{{ $kategorija->slug }}" role="tabpanel" 
                    aria-labelledby="{{ $kategorija->slug }}-tab">
                <div class="row">
                    @if($kategorija->latest_posts->count() > 0)
                        @foreach($kategorija->latest_posts as $post)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/uploads/' . $post->featured_image) }}" 
                                                class="card-img-top" alt="{{ $post->post_title }}" 
                                                style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">
                                                {{ $post->post_title }}
                                            </a>
                                        </h5>
                                        <p class="card-text small text-muted">
                                            {{ $post->post_date->format('d.m.Y') }}
                                        </p>
                                        <p class="card-text">
                                            {{ Str::limit(html_entity_decode(strip_tags($post->post_excerpt ?: $post->post_content)), 100) }}
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent border-0">
                                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-primary">
                                            Detaljnije
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <p class="text-center text-muted">Nema vesti u ovoj kategoriji.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
        @else
            <p class="text-center text-muted">Trenutno nema vesti razvrstanih po kategorijama.</p>
        @endif
    </div>
</section>

<!-- Bilansi -->
<section class="bilansi">
    <div class="row mt-3 mb-3">
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
</section>

<!-- Statistika -->
<section class="statistika">
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
</section>
@endsection

@section('styles')
<style>
/* Match cards styling */
.matches-container {
    margin: 2rem 0;
}

.match-card {
    background-color: #fff;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 1.5rem;
    transition: transform 0.2s;
}

.match-card:hover {
    transform: translateY(-5px);
}

.match-header {
    margin-bottom: 1.5rem;
}

.match-title {
    color: #c80036;
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    font-family: 'Teko', sans-serif;
}

.match-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.match-competition {
    color: #0C1844;
    font-weight: 600;
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
}

.match-venue, .match-date {
    color: #666;
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
}

.match-teams {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 1.5rem 0;
}

.team-logo {
    height: 80px;
    width: auto;
    max-width: 80px;
    object-fit: contain;
    margin-bottom: 0.5rem;
}

.team-name {
    color: #0C1844;
    font-family: "Teko",sans-serif;
    font-size: 2rem;
    font-weight: 500;
    text-transform: uppercase;
}

.team-abbr {
    color: #0C1844;
    font-family: "Teko",sans-serif;
    font-size: 3rem;
    font-weight: 500;
    text-transform: uppercase;
}

.match-score {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.score-result {
    font-size: 2.5rem;
    font-weight: 700;
    color: #0C1844;
    font-family: 'Teko', sans-serif;
}

.score-divider {
    margin: 0 0.5rem;
    color: #999;
}

.match-status {
    background-color: #f5f5f5;
    border-radius: 4px;
    color: #878d97;
    font-size: 1.25rem;
    font-weight: 700;
    padding: 0.2rem 0.5rem;
    margin-top: 0.25rem;
}

.match-vs {
    color: #878d97;
    font-size: 1.2rem;
    font-weight: 600;
    text-transform: lowercase;
}

.vs-format {
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin: 1rem 0;
}

.match-time-display {
    font-size: 1.25rem;
    font-weight: 700;
    padding: 0.25rem 0.75rem;
    background-color: #f5f5f5;
    border-radius: 4px;
    margin: 0.5rem auto;
    display: inline-block;
}

.match-date-time {
    background-color: #f5f5f5;
    border-radius: 4px;
    padding: 0.5rem;
}

.match-footer {
    margin-top: auto;
    padding-top: 1rem;
}

.btn-outline-primary {
    border-color: #0C1844;
    color: #0C1844;
}

.btn-outline-primary:hover {
    background-color: #0C1844;
    color: #fff;
}

.btn-primary {
    background-color: #0C1844;
    border-color: #0C1844;
}

.btn-primary:hover {
    background-color: #0C1844;
    border-color: #0C1844;
}

/* Countdown styling */
.countdown-container {
    margin-top: 0;
}

.countdown-digit {
    font-size: 1.75rem;
    font-weight: 700;
    color: #c80036;
    font-family: 'Teko', sans-serif;
}

.countdown-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: #666;
}

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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Find all countdown elements
    const countdownElements = document.querySelectorAll('.countdown');
    
    countdownElements.forEach(function(element) {
        const targetDate = element.getAttribute('data-target-date');
        if (!targetDate) return;
        
        // Set the target date
        const countDownDate = new Date(targetDate).getTime();
        
        // Find elements within this countdown
        const daysElement = element.querySelector('.days');
        const hoursElement = element.querySelector('.hours');
        const minutesElement = element.querySelector('.minutes');
        const secondsElement = element.querySelector('.seconds');
        
        if (!daysElement || !hoursElement || !minutesElement || !secondsElement) return;
        
        // Set initial countdown values
        updateCountdown();
        
        // Update the countdown every 1 second
        const countdownTimer = setInterval(updateCountdown, 1000);
        
        function updateCountdown() {
            // Get current date and time
            const now = new Date().getTime();
            
            // Find the distance between now and the countdown date
            const distance = countDownDate - now;
            
            // If the countdown is over, show zeros and stop the timer
            if (distance < 0) {
                clearInterval(countdownTimer);
                daysElement.innerHTML = "00";
                hoursElement.innerHTML = "00";
                minutesElement.innerHTML = "00";
                secondsElement.innerHTML = "00";
                return;
            }
            
            // Calculate weeks
            const weeks = Math.floor(distance / (1000 * 60 * 60 * 24 * 7));
            
            // Time calculations for days, hours, minutes and seconds
            const days = Math.floor((distance % (1000 * 60 * 60 * 24 * 7)) / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            
            // Display the results with leading zeros
            daysElement.innerHTML = weeks < 10 ? "0" + weeks : weeks;
            hoursElement.innerHTML = days < 10 ? "0" + days : days;
            minutesElement.innerHTML = hours < 10 ? "0" + hours : hours;
            secondsElement.innerHTML = minutes < 10 ? "0" + minutes : minutes;
        }
    });
});
</script>
@endsection