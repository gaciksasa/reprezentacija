@extends('layouts.app')

@section('title', 'Utakmice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Utakmice</h1>
    <a href="{{ route('utakmice.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nova utakmica
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Datum</th>
                        <th>Takmičenje</th>
                        <th>Domaćin</th>
                        <th>Rezultat</th>
                        <th>Gost</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($utakmice as $utakmica)
                    <tr>
                        <td>{{ $utakmica->datum->format('d.m.Y') }}</td>
                        <td>
                            @if($utakmica->takmicenje)
                                {{ $utakmica->takmicenje->naziv }}
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('timovi.show', $utakmica->domacin) }}">
                                {{ $utakmica->domacin->naziv }}
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('utakmice.show', $utakmica) }}" class="text-decoration-none">
                                <strong>{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</strong>
                                @if($utakmica->imao_jedanaesterce)
                                    <small class="d-block">
                                        ({{ $utakmica->jedanaesterci_domacin }}-{{ $utakmica->jedanaesterci_gost }} pen)
                                    </small>
                                @endif
                                @if($utakmica->poluvreme_rezultat_domacin !== null && $utakmica->poluvreme_rezultat_gost !== null)
                                    <small class="text-muted d-block">
                                        ({{ $utakmica->poluvreme_rezultat_domacin }} - {{ $utakmica->poluvreme_rezultat_gost }})
                                    </small>
                                @endif
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('timovi.show', $utakmica->gost) }}">
                                {{ $utakmica->gost->naziv }}
                            </a>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    Akcije
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('utakmice.show', $utakmica) }}">
                                            <i class="fas fa-eye"></i> Detalji
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('utakmice.edit', $utakmica) }}">
                                            <i class="fas fa-edit"></i> Izmeni
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('utakmice.destroy', $utakmica) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Da li ste sigurni?')">
                                                <i class="fas fa-trash"></i> Obriši
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Nema utakmica u bazi podataka</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-4">
            {{ $utakmice->links() }}
        </div>
    </div>
</div>
@endsection