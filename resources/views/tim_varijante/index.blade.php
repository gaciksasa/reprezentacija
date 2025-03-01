@extends('layouts.app')

@section('title', 'Istorijski nazivi reprezentacije')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Istorijski nazivi reprezentacije</h1>
    <div>
        <a href="{{ route('tim-varijante.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novi istorijski naziv
        </a>
        <a href="{{ route('timovi.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad na timove
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Glavni tim</h5>
    </div>
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-2 text-center">
                @if($glavniTim->grb_url)
                    <img src="{{ $glavniTim->grb_url }}" alt="{{ $glavniTim->naziv }}" class="img-fluid mb-2" style="max-height: 80px;">
                @endif
            </div>
            <div class="col-md-4">
                <h4>{{ $glavniTim->naziv }}</h4>
                @if($glavniTim->skraceni_naziv)
                    <p><strong>Skraćeni naziv:</strong> {{ $glavniTim->skraceni_naziv }}</p>
                @endif
                <p><strong>Zemlja:</strong> {{ $glavniTim->zemlja }}</p>
            </div>
            <div class="col-md-3">
                <p><strong>Aktivno od:</strong> {{ $glavniTim->aktivan_od ? $glavniTim->aktivan_od->format('d.m.Y') : 'Nije definisano' }}</p>
                <p><strong>Aktivno do:</strong> {{ $glavniTim->aktivan_do ? $glavniTim->aktivan_do->format('d.m.Y') : 'Danas' }}</p>
            </div>
            <div class="col-md-3">
                <a href="{{ route('timovi.show', $glavniTim) }}" class="btn btn-info btn-sm mb-1 w-100">
                    <i class="fas fa-eye"></i> Pogledaj tim
                </a>
                <a href="{{ route('timovi.edit', $glavniTim) }}" class="btn btn-warning btn-sm w-100">
                    <i class="fas fa-edit"></i> Izmeni tim
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Istorijski nazivi tima</h5>
    </div>
    <div class="card-body">
        @if($varijante->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Grb</th>
                            <th>Naziv</th>
                            <th>Skraćeno</th>
                            <th>Zemlja</th>
                            <th>Period</th>
                            <th>Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($varijante as $varijanta)
                        <tr>
                            <td class="text-center">
                                @if($varijanta->grb_url)
                                    <img src="{{ $varijanta->grb_url }}" alt="{{ $varijanta->naziv }}" height="40">
                                @endif
                            </td>
                            <td>{{ $varijanta->naziv }}</td>
                            <td>{{ $varijanta->skraceni_naziv }}</td>
                            <td>{{ $varijanta->zemlja }}</td>
                            <td>
                                {{ $varijanta->aktivan_od ? $varijanta->aktivan_od->format('d.m.Y') : '' }} - 
                                {{ $varijanta->aktivan_do ? $varijanta->aktivan_do->format('d.m.Y') : 'Danas' }}
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('tim-varijante.edit', $varijanta) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-varijanta-{{ $varijanta->id }}').submit()">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <form id="delete-varijanta-{{ $varijanta->id }}" action="{{ route('tim-varijante.destroy', $varijanta) }}" 
                                        method="POST" class="d-none">
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
            <p class="text-center text-muted">Nema definisanih istorijskih naziva tima.</p>
        @endif
    </div>
</div>
@endsection