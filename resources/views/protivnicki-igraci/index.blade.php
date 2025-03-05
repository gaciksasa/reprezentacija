@extends('layouts.app')

@section('title', 'Protivnički igrači')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Protivnički igrači</h1>
    <div>
        <a href="{{ route('protivnicki-igraci.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $tim->id]) }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Dodaj igrača
        </a>
        <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad na utakmicu
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Detalji utakmice</h5>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4 text-md-end">
                <h5>{{ $utakmica->domacin->naziv }}</h5>
            </div>
            <div class="col-md-4 text-center">
                <div class="display-5">{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</div>
                <div class="text-muted">{{ $utakmica->datum->format('d.m.Y') }}</div>
                <div>{{ $utakmica->takmicenje->naziv }}</div>
            </div>
            <div class="col-md-4">
                <h5>{{ $utakmica->gost->naziv }}</h5>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Igrači tima: {{ $tim->naziv }}</h5>
    </div>
    <div class="card-body">
        @if($protivnickiIgraci->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ime i prezime</th>
                            <th>Kapiten</th>
                            <th>Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($protivnickiIgraci as $igrac)
                        <tr>
                            <td>{{ $igrac->ime }} {{ $igrac->prezime }}</td>
                            <td>
                                @if($igrac->kapiten)
                                    <span class="badge bg-primary">Da</span>
                                @else
                                    <span class="badge bg-secondary">Ne</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('protivnicki-igraci.edit', $igrac) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="document.getElementById('delete-igrac-{{ $igrac->id }}').submit()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-igrac-{{ $igrac->id }}" action="{{ route('protivnicki-igraci.destroy', $igrac) }}" method="POST" class="d-none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center text-muted">Nema evidentiranih igrača za ovaj tim na ovoj utakmici.</p>
        @endif
    </div>
</div>
@endsection