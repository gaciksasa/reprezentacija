<div class="matches-container my-4">
    <div class="row">
        <!-- Last Match -->
        <div class="col-lg-4 my-3">
            <div class="match-card h-100">
                <div class="match-header">
                    <h3 class="match-title text-center">Prethodni meč</h3>
                    @if($poslednjaMec)
                        <div class="match-competition text-center">
                            {{ $poslednjaMec->takmicenje->naziv ?? '' }}
                        </div>
                        <div class="match-venue text-center">
                            {{ $poslednjaMec->stadion ?? '' }}
                        </div>
                        <div class="match-date text-center">
                            {{ $poslednjaMec->datum ? strtoupper($poslednjaMec->datum->format('d.m.Y')) : '' }}
                        </div>
                    @endif
                </div>
                
                @if($poslednjaMec)
                <div class="match-content">
                    <div class="match-teams">
                        <div class="team-home text-center">
                            @if($poslednjaMec->domacin->grb_url)
                                <img src="{{ grb_url($poslednjaMec->domacin->grb_url) }}" alt="{{ $poslednjaMec->domacin->naziv }}" class="team-logo">
                            @endif
                            <div class="team-name">{{ strtoupper($poslednjaMec->domacin->skraceni_naziv) }}</div>
                        </div>
                        
                        <div class="match-score text-center">
                            <div class="score-result">
                                {{ $poslednjaMec->rezultat_domacin }} - {{ $poslednjaMec->rezultat_gost }}
                            </div>
                            <div class="match-status">{{ $poslednjaMec->poluvremenski_rezultat }}</div>
                        </div>
                        
                        <div class="team-away text-center">
                            @if($poslednjaMec->gost->grb_url)
                                <img src="{{ grb_url($poslednjaMec->gost->grb_url) }}" alt="{{ $poslednjaMec->gost->naziv }}" class="team-logo">
                            @endif
                            <div class="team-name">{{ strtoupper($poslednjaMec->gost->skraceni_naziv) }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="match-footer text-center">
                    <a href="{{ route('utakmice.show', $poslednjaMec->id) }}" class="btn btn-primary">Detaljnije</a>
                </div>
                @else
                <div class="text-center py-4">No previous match data</div>
                @endif
            </div>
        </div>
        
        <!-- Next Match -->
        <div class="col-lg-4">
            <div class="match-card h-100">
                <div class="match-header">
                    <h3 class="match-title text-center">Sledeći meč</h3>
                    @if($sledeciMec)
                        <div class="match-competition text-center">
                            {{ $sledeciMec->takmicenje->naziv ?? '' }}
                        </div>
                        <div class="match-venue text-center">
                            {{ $poslednjaMec->stadion ?? '' }}
                        </div>
                        <div class="match-date text-center">
                            {{ strtoupper($sledeciMec->datum->format('d.m.Y')) }}
                        </div>
                        <div class="vs-format text-center">
                            <div class="team-home text-center">
                                @if($sledeciMec->domacin->grb_url)
                                    <img src="{{ grb_url($sledeciMec->domacin->grb_url) }}" alt="{{ $sledeciMec->domacin->naziv }}" class="team-logo">
                                @endif
                                <div class="team-abbr">{{ substr(strtoupper($sledeciMec->domacin->skraceni_naziv ?? $sledeciMec->domacin->naziv), 0, 3) }}</div>
                            </div>
                            
                            <div class="match-time text-center">
                                <div class="match-time-display">
                                    {{ $sledeciMec->vreme ?? '' }} {{ $sledeciMec->vreme ? '' : '' }}
                                </div>
                            </div>
                            
                            <div class="team-away text-center">
                                @if($sledeciMec->gost->grb_url)
                                    <img src="{{ grb_url($sledeciMec->gost->grb_url) }}" alt="{{ $sledeciMec->gost->naziv }}" class="team-logo">
                                @endif
                                <div class="team-abbr">{{ substr(strtoupper($sledeciMec->gost->skraceni_naziv ?? $sledeciMec->gost->naziv), 0, 3) }}</div>
                            </div>
                        </div>

                        <div class="countdown-container">
                            <div class="countdown" data-target-date="{{ $sledeciMec->datum->format('Y-m-d') }} {{ $sledeciMec->vreme ?? '' }}">
                                <div class="d-flex justify-content-center">
                                    <div class="countdown-item text-center px-2">
                                        <div class="countdown-digit days">00</div>
                                        <div class="countdown-label">NEDELJA</div>
                                    </div>
                                    <div class="countdown-item text-center px-2">
                                        <div class="countdown-digit hours">00</div>
                                        <div class="countdown-label">DANA</div>
                                    </div>
                                    <div class="countdown-item text-center px-2">
                                        <div class="countdown-digit minutes">00</div>
                                        <div class="countdown-label">SATI</div>
                                    </div>
                                    <div class="countdown-item text-center px-2">
                                        <div class="countdown-digit seconds">00</div>
                                        <div class="countdown-label">MINUTA</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="match-footer text-center">
                    @if($sledeciMec)
                    <a href="{{ route('utakmice.show', $sledeciMec->id) }}" class="btn btn-primary">Detaljnije</a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Following Match -->
        <div class="col-lg-4 my-3">
            <div class="match-card h-100">
                <div class="match-header">
                    <h3 class="match-title text-center">Sledeći meč</h3>
                    @if($nakonSledecegMec)
                        <div class="match-competition text-center">
                            {{ $nakonSledecegMec->takmicenje->naziv ?? '' }}
                        </div>
                        <div class="match-venue text-center">
                            {{ $nakonSledecegMec->stadion ?? '' }}
                        </div>
                        <div class="match-date text-center">
                            {{ $nakonSledecegMec->datum ? strtoupper($nakonSledecegMec->datum->format('d.m.Y')) : '' }}
                        </div>
                    @endif
                </div>
                
                @if($nakonSledecegMec)
                <div class="match-content">
                    <div class="match-teams">
                        <div class="team-home text-center">
                            @if($nakonSledecegMec->domacin->grb_url)
                                <img src="{{ grb_url($nakonSledecegMec->domacin->grb_url) }}" alt="{{ $nakonSledecegMec->domacin->naziv }}" class="team-logo">
                            @endif
                            <div class="team-name">{{ strtoupper($nakonSledecegMec->domacin->skraceni_naziv) }}</div>
                        </div>
                        
                        <div class="match-time text-center">
                            <div class="match-time-display">
                                {{ $nakonSledecegMec->vreme ?? '19:45' }}
                            </div>
                        </div>
                        
                        <div class="team-away text-center">
                            @if($nakonSledecegMec->gost->grb_url)
                                <img src="{{ grb_url($nakonSledecegMec->gost->grb_url) }}" alt="{{ $nakonSledecegMec->gost->naziv }}" class="team-logo">
                            @endif
                            <div class="team-name">{{ strtoupper($nakonSledecegMec->gost->skraceni_naziv) }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="match-footer text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-secondary" disabled>Rasprodato</button>
                        <a href="{{ route('utakmice.show', $nakonSledecegMec->id) }}" class="btn btn-primary">Detaljnije</a>
                    </div>
                </div>
                @else
                <div class="text-center py-4">No upcoming match data</div>
                @endif
            </div>
        </div>
    </div>
</div>