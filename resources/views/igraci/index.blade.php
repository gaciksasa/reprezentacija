@extends('layouts.app')

@section('title', 'Reprezentativci')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Reprezentativci</h1>
    <a href="{{ route('igraci.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novi igrač
    </a>
</div>

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
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th width="40%">Igrač</th>
                        <th width="20%">Period</th>
                        <th width="10%" class="text-center">Utakmica</th>
                        <th width="10%" class="text-center">Golova</th>
                        <th width="20%">Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentLetter = '';
                    @endphp
                    
                    @forelse($igraci as $igrac)
                        @php
                            // Create alphabet dividers
                            $firstLetter = mb_strtoupper(mb_substr($igrac->prezime, 0, 1));
                            if($firstLetter != $currentLetter) {
                                $currentLetter = $firstLetter;
                                echo '<tr><td colspan="5" class="bg-light text-primary" id="'.$currentLetter.'"><strong>'.$currentLetter.'</strong></td></tr>';
                            }
                            
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
                                <a href="{{ route('igraci.show', $igrac) }}" class="text-decoration-none">
                                    <span class="text-danger fw-bold">{{ $igrac->prezime }} {{ $igrac->ime }}</span>
                                    @if($igrac->aktivan)
                                        <span class="ms-1 text-warning">★</span>
                                    @endif
                                </a>
                            </td>
                            <td>{{ $period }}</td>
                            <td class="text-center">{{ $igrac->broj_nastupa }}</td>
                            <td class="text-center">{{ $igrac->broj_golova }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('igraci.show', $igrac) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('igraci.edit', $igrac) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="if(confirm('Da li ste sigurni?')) document.getElementById('delete-igrac-{{ $igrac->id }}').submit()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-igrac-{{ $igrac->id }}" action="{{ route('igraci.destroy', $igrac) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nema igrača u bazi podataka</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $igraci->links() }}
        </div>
        
        <div class="mt-3 text-center">
            <p class="small text-muted">
                <span class="text-warning">★</span> Aktivan igrač / Active player
            </p>
        </div>
    </div>
</div>
@endsection