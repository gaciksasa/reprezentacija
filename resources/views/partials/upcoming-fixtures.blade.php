<!-- Match Display Section -->
<div class="matches-container mb-5">
    <div class="row">
        <!-- Last Match -->
        @if($poslednjaMec)
        <div class="col-md-4 mb-3">
            <div class="match-card last-match h-100">
                <div class="match-header">
                    <h2 class="match-title text-center">POSLEDNJA UTAKMICA</h2>
                </div>
                <div class="match-content">
                    <div class="match-competition text-center mb-2">
                        {{ $poslednjaMec->takmicenje ? $poslednjaMec->takmicenje->naziv : 'Prijateljska utakmica' }}
                    </div>
                    <div class="match-venue text-center mb-1">
                        {{ $poslednjaMec->stadion ?? 'Stadion nije naveden' }}
                    </div>
                    <div class="match-date text-center mb-4">
                        {{ $poslednjaMec->datum->format('d.m.Y') }}
                    </div>
                    
                    <div class="match-teams">
                        <div class="team home-team text-center">
                            <img src="{{ $poslednjaMec->domacin->grb_url ? asset('storage/grbovi/' . $poslednjaMec->domacin->grb_url) : asset('img/no-image.png') }}" 
                                alt="{{ $poslednjaMec->domacin->naziv }}" class="team-logo">
                            <div class="team-name">{{ $poslednjaMec->domacin->naziv }}</div>
                        </div>
                        
                        <div class="match-score">
                            <div class="score-result">
                                <span class="score-home">{{ $poslednjaMec->rezultat_domacin }}</span> 
                                <span class="score-divider">·</span> 
                                <span class="score-away">{{ $poslednjaMec->rezultat_gost }}</span>
                            </div>
                            <div class="match-status">FT</div>
                        </div>
                        
                        <div class="team away-team text-center">
                            <img src="{{ $poslednjaMec->gost->grb_url ? asset('storage/grbovi/' . $poslednjaMec->gost->grb_url) : asset('img/no-image.png') }}" 
                                alt="{{ $poslednjaMec->gost->naziv }}" class="team-logo">
                            <div class="team-name">{{ $poslednjaMec->gost->naziv }}</div>
                        </div>
                    </div>
                </div>
                <div class="match-footer">
                    <a href="{{ route('utakmice.show', $poslednjaMec) }}" class="btn btn-outline-primary w-100">IZVEŠTAJ UTAKMICE</a>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Next Match -->
        @if($sledeciMec)
        <div class="col-md-4 mb-3">
            <div class="match-card next-match h-100">
                <div class="match-header">
                    <h2 class="match-title text-center">SLEDEĆA UTAKMICA</h2>
                </div>
                <div class="match-content">
                    <div class="match-competition text-center mb-2">
                        {{ $sledeciMec->takmicenje ? $sledeciMec->takmicenje->naziv : 'Prijateljska utakmica' }}
                    </div>
                    
                    <div class="match-teams vs-format">
                        <div class="team home-team text-center">
                            <img src="{{ $sledeciMec->domacin->grb_url ? asset('storage/grbovi/' . $sledeciMec->domacin->grb_url) : asset('img/no-image.png') }}" 
                                alt="{{ $sledeciMec->domacin->naziv }}" class="team-logo">
                            <div class="team-abbr">{{ $sledeciMec->domacin->skraceni_naziv ?? substr($sledeciMec->domacin->naziv, 0, 3) }}</div>
                        </div>
                        
                        <div class="match-vs">
                            <span>vs</span>
                        </div>
                        
                        <div class="team away-team text-center">
                            <img src="{{ $sledeciMec->gost->grb_url ? asset('storage/grbovi/' . $sledeciMec->gost->grb_url) : asset('img/no-image.png') }}" 
                                alt="{{ $sledeciMec->gost->naziv }}" class="team-logo">
                            <div class="team-abbr">{{ $sledeciMec->gost->skraceni_naziv ?? substr($sledeciMec->gost->naziv, 0, 3) }}</div>
                        </div>
                    </div>
                    
                    <div class="match-date-time text-center my-3">
                        <div class="match-date">{{ $sledeciMec->datum->format('d.m.Y') }}</div>
                        <div class="match-time">{{ $sledeciMec->vreme ?? '20:45' }}</div>
                    </div>
                    
                    <div class="countdown-container">
                        <div class="countdown-label text-center text-muted small mb-1">
                            <span>Odbrojavanje</span>
                        </div>
                        <div class="countdown" data-target-date="{{ $sledeciMec->datum->format('Y-m-d') }} {{ $sledeciMec->vreme ?? '20:45' }}">
                            <div class="countdown-item">
                                <div class="countdown-value days">00</div>
                                <div class="countdown-label">dana</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-value hours">00</div>
                                <div class="countdown-label">sati</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-value minutes">00</div>
                                <div class="countdown-label">min</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-value seconds">00</div>
                                <div class="countdown-label">sec</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="match-footer">
                    <a href="{{ route('utakmice.show', $sledeciMec) }}" class="btn btn-outline-primary w-100">DETALJI UTAKMICE</a>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Following Match -->
        @if($nakonSledecegMec)
        <div class="col-md-4 mb-3">
            <div class="match-card following-match h-100">
                <div class="match-header">
                    <h2 class="match-title text-center">NAREDNA UTAKMICA</h2>
                </div>
                <div class="match-content">
                    <div class="match-competition text-center mb-2">
                        {{ $nakonSledecegMec->takmicenje ? $nakonSledecegMec->takmicenje->naziv : 'Prijateljska utakmica' }}
                    </div>
                    <div class="match-venue text-center mb-1">
                        {{ $nakonSledecegMec->stadion ?? 'Stadion nije naveden' }}
                    </div>
                    <div class="match-date text-center mb-4">
                        {{ $nakonSledecegMec->datum->format('d.m.Y') }}
                    </div>
                    
                    <div class="match-teams">
                        <div class="team home-team text-center">
                            <img src="{{ $nakonSledecegMec->domacin->grb_url ? asset('storage/grbovi/' . $nakonSledecegMec->domacin->grb_url) : asset('img/no-image.png') }}" 
                                alt="{{ $nakonSledecegMec->domacin->naziv }}" class="team-logo">
                            <div class="team-name">{{ $nakonSledecegMec->domacin->naziv }}</div>
                        </div>
                        
                        <div class="match-time-display">
                            {{ $nakonSledecegMec->vreme ?? '20:45' }}
                        </div>
                        
                        <div class="team away-team text-center">
                            <img src="{{ $nakonSledecegMec->gost->grb_url ? asset('storage/grbovi/' . $nakonSledecegMec->gost->grb_url) : asset('img/no-image.png') }}" 
                                alt="{{ $nakonSledecegMec->gost->naziv }}" class="team-logo">
                            <div class="team-name">{{ $nakonSledecegMec->gost->naziv }}</div>
                        </div>
                    </div>
                </div>
                <div class="match-footer">
                    <a href="{{ route('utakmice.show', $nakonSledecegMec) }}" class="btn btn-outline-primary w-100">DETALJI UTAKMICE</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>