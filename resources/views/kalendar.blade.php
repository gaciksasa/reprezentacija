@extends('layouts.app')

@section('title', 'Kalendar utakmica')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Kalendar utakmica</h1>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('kalendar') }}" method="GET" class="row">
            <div class="col-md-5 mb-3 mb-md-0">
                <label for="godina" class="form-label">Godina</label>
                <select class="form-select" id="godina" name="godina">
                    @for($i = 2020; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}" {{ $godina == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-5 mb-3 mb-md-0">
                <label for="mesec" class="form-label">Mesec</label>
                <select class="form-select" id="mesec" name="mesec">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $mesec == $i ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Prikaži</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            Utakmice za {{ date('F Y', mktime(0, 0, 0, $mesec, 1, $godina)) }}
        </h5>
    </div>
    <div class="card-body">
        @if($utakmice->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Takmičenje</th>
                            <th>Domaćin</th>
                            <th>Rezultat</th>
                            <th>Gost</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($utakmice as $utakmica)
                            <tr>
                                <td>{{ $utakmica->datum->format('d.m.Y') }}</td>
                                <td>{{ $utakmica->takmicenje->naziv }}</td>
                                <td>
                                    <a href="{{ route('timovi.show', $utakmica->domacin) }}">
                                        {{ $utakmica->domacin->naziv }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <strong>{{ $utakmica->rezultat_domacin }} - {{ $utakmica->rezultat_gost }}</strong>
                                </td>
                                <td>
                                    <a href="{{ route('timovi.show', $utakmica->gost) }}">
                                        {{ $utakmica->gost->naziv }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                Nema utakmica za izabrani period.
            </div>
        @endif
    </div>
</div>
@endsection