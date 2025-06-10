@extends('layouts.app')

@section('title', 'Reprezentativci')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Reprezentativci</h1>
    @if(Auth::check() && Auth::user()->hasEditAccess())
    <a href="{{ route('igraci.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novi igrač
    </a>
    @endif
</div>
<div class="igraci">
    <div class="card">
        <div class="card-body">
            <!-- Alphabetical Navigation Links -->
            <div class="mb-3 text-center">
                @foreach(range('A', 'Z') as $letter)
                    <a href="#{{ $letter }}" class="btn btn-sm btn-outline-secondary me-1">{{ $letter }}</a>
                @endforeach
            </div>

            <!-- Search Form -->
            <div class="mb-4">
                <form action="{{ route('igraci.index') }}" method="GET" class="row">
                    <div class="col-md-4 mb-2">
                        <input type="text" name="search" class="form-control" placeholder="Pretraži po imenu..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="period" class="form-select">
                            <option value="">Svi periodi</option>
                            <option value="1920-1940" {{ request('period') == '1920-1940' ? 'selected' : '' }}>1920-1940</option>
                            <option value="1941-1960" {{ request('period') == '1941-1960' ? 'selected' : '' }}>1941-1960</option>
                            <option value="1961-1980" {{ request('period') == '1961-1980' ? 'selected' : '' }}>1961-1980</option>
                            <option value="1981-2000" {{ request('period') == '1981-2000' ? 'selected' : '' }}>1981-2000</option>
                            <option value="2001-danas" {{ request('period') == '2001-danas' ? 'selected' : '' }}>2001-danas</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select name="active" class="form-select">
                            <option value="">Svi igrači</option>
                            <option value="1" {{ request('active') == '1' ? 'selected' : '' }}>Samo aktivni</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <button type="submit" class="btn btn-primary w-100">Filtriraj</button>
                    </div>
                </form>
            </div>

            <!-- Players List -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="40%">Igrač</th>
                            <th width="20%">Period</th>
                            <th width="10%" class="text-center">Utakmica</th>
                            <th width="10%" class="text-center">Golova</th>
                            @if(Auth::check() && Auth::user()->hasEditAccess())
                            <th width="20%">Akcije</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $currentLetter = '';
                        @endphp
                        
                        @forelse($igraci as $igrac)
                            @php
                                // Format the playing period
                                $period = '';
                                if($igrac->debitovao_za_tim) {
                                    $startYear = is_string($igrac->debitovao_za_tim) 
                                        ? substr($igrac->debitovao_za_tim, 0, 4)  // Extract year from string
                                        : $igrac->debitovao_za_tim->format('Y');  // Use format if it's a DateTime
                                        
                                    $endYear = $igrac->poslednja_utakmica 
                                        ? (is_string($igrac->poslednja_utakmica) 
                                            ? substr($igrac->poslednja_utakmica, 0, 4) 
                                            : $igrac->poslednja_utakmica->format('Y')) 
                                        : 'danas';
                                        
                                    $period = "$startYear/$endYear";
                                }
                            @endphp
                            
                            <tr>
                                <td>
                                    <a href="{{ route('igraci.show', $igrac->slug ?? $igrac->id) }}" class="text-decoration-none">
                                        <span class="text-player">{{ $igrac->prezime }} {{ $igrac->ime }}</span>
                                    </a>
                                </td>
                                <td>{{ $period }} @if($igrac->aktivan)
                                            <span class="ms-1 text-warning">★</span>
                                        @endif</td>
                                <td class="text-center">{{ $igrac->broj_nastupa }}</td>
                                <td class="text-center">{{ $igrac->broj_golova }}</td>
                                @if(Auth::check() && Auth::user()->hasEditAccess())
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('igraci.show', $igrac->slug ?? $igrac->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('igraci.edit', $igrac->slug ?? $igrac->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" 
                                                onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-igrac-{{ $igrac->id }}').submit()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-igrac-{{ $igrac->id }}" action="{{ route('igraci.destroy', $igrac->slug ?? $igrac->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Nema igrača u bazi podataka</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3 text-center">
                <p class="small text-muted">
                    <span class="text-warning">★</span> Aktivan igrač / Active player
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Croatian alphabet - 30 letters
            const hrvatskaAbeceda = [
                'A', 'B', 'C', 'Č', 'Ć', 'D', 'DŽ', 'Đ', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 
                'L', 'LJ', 'M', 'N', 'NJ', 'O', 'P', 'R', 'S', 'Š', 'T', 'U', 'V', 'Z', 'Ž'
            ];
            
            // Find the container where alphabet links are displayed
            const alfabetContainer = document.querySelector('.mb-3.text-center');
            
            // Clear existing alphabet links
            alfabetContainer.innerHTML = '';
            
            // Create and append new links for Croatian alphabet
            hrvatskaAbeceda.forEach(slovo => {
                const link = document.createElement('a');
                link.href = `#${slovo}`;
                link.className = 'btn btn-sm btn-outline-secondary me-1';
                link.textContent = slovo;
                alfabetContainer.appendChild(link);
            });
            
            // Dohvati sve alfabet linkove
            const alfabetLinks = document.querySelectorAll('.mb-3.text-center a.btn-sm');
            
            // Dodaj event listener na svaki link
            alfabetLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault(); // Sprečava standardno ponašanje linka
                    
                    const slovo = this.textContent; // Dobija slovo na koje je kliknuto
                    
                    // Ako je već aktivan link, ne radimo ništa (ostajemo na istom filteru)
                    if (this.classList.contains('btn-primary')) {
                        return;
                    }
                    
                    // Resetuj sve linkove na outline stil
                    alfabetLinks.forEach(l => {
                        l.classList.remove('btn-primary');
                        l.classList.add('btn-outline-secondary');
                    });
                    
                    // Označi trenutni link kao aktivan
                    this.classList.remove('btn-outline-secondary');
                    this.classList.add('btn-primary');
                    
                    // Filtriraj igrače
                    filterByFirstLetter(slovo);
                });
            });
            
            // Po učitavanju stranice, automatski klikni na slovo "A"
            const slovoA = document.querySelector('.mb-3.text-center a.btn-sm[href="#A"]');
            if (slovoA) {
                slovoA.click();
            }
            
            // Funkcija za filtriranje igrača po prvom slovu prezimena
            function filterByFirstLetter(slovo) {
                // Dohvati sve redove igrača (tr elementi u tbody)
                const igraciRedovi = document.querySelectorAll('table.table tbody tr');
                
                // Prolazi kroz sve redove
                igraciRedovi.forEach(red => {
                    // Proveri da li je prvi red koji ima prezime
                    if (red.querySelector('td:first-child a .text-player')) {
                        // Dohvati tekst prezimena
                        const prezimeTekst = red.querySelector('td:first-child a .text-player').textContent;
                        // Izdvoji prezime (pre razmaka)
                        const prezime = prezimeTekst.split(' ')[0];
                        
                        // Special handling for digraphs (LJ, NJ, DŽ)
                        let prikazati = false;
                        
                        if (slovo === 'LJ' && prezime.toUpperCase().startsWith('LJ')) {
                            prikazati = true;
                        } else if (slovo === 'NJ' && prezime.toUpperCase().startsWith('NJ')) {
                            prikazati = true;
                        } else if (slovo === 'DŽ' && prezime.toUpperCase().startsWith('DŽ')) {
                            prikazati = true;
                        } else if (slovo.length === 1) {
                            // For single letters, make sure we don't match the start of digraphs
                            const firstChar = prezime.charAt(0).toUpperCase();
                            const secondChar = prezime.charAt(1).toUpperCase();
                            
                            if (slovo === 'D' && secondChar === 'Ž') {
                                prikazati = false;
                            } else if (slovo === 'L' && secondChar === 'J') {
                                prikazati = false;
                            } else if (slovo === 'N' && secondChar === 'J') {
                                prikazati = false;
                            } else if (firstChar === slovo) {
                                prikazati = true;
                            }
                        }
                        
                        if (prikazati) {
                            red.style.display = ''; // Prikaži red
                        } else {
                            red.style.display = 'none'; // Sakrij red
                        }
                    } else if (red.cells.length === 1 && red.cells[0].id === slovo) {
                        // Ovo je zaglavlje slova (npr. red koji sadrži samo "A")
                        red.style.display = ''; // Prikaži red
                    } else if (red.cells.length === 1 && red.cells[0].id) {
                        // Ovo je zaglavlje nekog drugog slova
                        red.style.display = 'none'; // Sakrij red
                    }
                });
                
                // Ukloni element za paginaciju ako postoji
                const paginacija = document.querySelector('.d-flex.justify-content-center.mt-4');
                if (paginacija) {
                    paginacija.style.display = 'none';
                }
            }
            
            // Funkcija za resetovanje filtera - prikazuje sve igrače
            function resetFilter() {
                const igraciRedovi = document.querySelectorAll('table.table tbody tr');
                igraciRedovi.forEach(red => {
                    red.style.display = ''; // Prikaži sve redove
                });
            }
        });
    </script>
@endsection