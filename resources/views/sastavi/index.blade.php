@extends('layouts.app')

@section('title', 'Sastavi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Sastavi</h1>
    @if(isset($utakmica))
        <div>
            @php
                // Dobavi glavni tim (Srbija i alijasi)
                $glavniTim = \App\Models\Tim::glavniTim()->first();
                $glavniTimIds = $glavniTim ? $glavniTim->getSviIdTimova() : [];
                
                // Proveri da li je domaći tim "naš" tim
                $domaciJeNasTim = in_array($utakmica->domacin_id, $glavniTimIds);
                
                // Proveri da li je gostujući tim "naš" tim
                $gostJeNasTim = in_array($utakmica->gost_id, $glavniTimIds);
            @endphp
            <a href="{{ route('utakmice.show', $utakmica) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Nazad na utakmicu
            </a>
        </div>
    @else
        <a href="{{ route('utakmice.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    @endif
</div>

@if(isset($utakmica))
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
                    <div>
                        @if($utakmica->takmicenje)
                            {{ $utakmica->takmicenje->naziv }}
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <h5>{{ $utakmica->gost->naziv }}</h5>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ $utakmica->domacin->naziv }}</h5>
                    @if($domaciJeNasTim)
                        <a href="{{ route('sastavi.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Dodaj igrača
                        </a>
                    @else
                        <a href="{{ route('protivnicki-igraci.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->domacin_id]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Dodaj igrača
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if($domaciJeNasTim)
                        @if($domaciSastav->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Igrač</th>
                                            <th>Starter</th>
                                            <th>Akcije</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($domaciSastav as $sastav)
                                        <tr>
                                            <td>{{ $sastav->igrac->ime }} {{ $sastav->igrac->prezime }}</td>
                                            <td>
                                                @if($sastav->starter)
                                                    <span class="badge bg-success">Da</span>
                                                @else
                                                    <span class="badge bg-secondary">Ne</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <!--<a href="{{ route('sastavi.edit', $sastav) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>-->
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            onclick="document.getElementById('delete-sastav-{{ $sastav->id }}').submit()">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-sastav-{{ $sastav->id }}" action="{{ route('sastavi.destroy', $sastav) }}" method="POST" class="d-none">
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
                            <p class="text-center text-muted">Nema evidentiranih igrača u sastavu domaćeg tima.</p>
                        @endif
                    @else
                        @php
                            // Dobavi protivničke igrače za domaći tim
                            $domaciProtivnickiIgraci = \App\Models\ProtivnickiIgrac::where('utakmica_id', $utakmica->id)
                                                    ->where('tim_id', $utakmica->domacin_id)
                                                    ->get();
                        @endphp
                        
                        @if($domaciProtivnickiIgraci->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Igrač</th>
                                            <th>Kapiten</th>
                                            <th>Akcije</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($domaciProtivnickiIgraci as $igrac)
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
                                                            onclick="document.getElementById('delete-protivnicki-igrac-{{ $igrac->id }}').submit()">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-protivnicki-igrac-{{ $igrac->id }}" action="{{ route('protivnicki-igraci.destroy', $igrac) }}" method="POST" class="d-none">
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
                            <p class="text-center text-muted">Nema evidentiranih igrača u sastavu domaćeg tima.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ $utakmica->gost->naziv }}</h5>
                    @if($gostJeNasTim)
                        <a href="{{ route('sastavi.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Dodaj igrača
                        </a>
                    @else
                        <a href="{{ route('protivnicki-igraci.create', ['utakmica_id' => $utakmica->id, 'tim_id' => $utakmica->gost_id]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Dodaj igrača
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if($gostJeNasTim)
                        @if($gostujuciSastav->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Igrač</th>
                                            <th>Starter</th>
                                            <th>Akcije</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gostujuciSastav as $sastav)
                                        <tr>
                                            <td>{{ $sastav->igrac->ime }} {{ $sastav->igrac->prezime }}</td>
                                            <td>
                                                @if($sastav->starter)
                                                    <span class="badge bg-success">Da</span>
                                                @else
                                                    <span class="badge bg-secondary">Ne</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('sastavi.edit', $sastav) }}" class="btn btn-sm btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            onclick="document.getElementById('delete-sastav-{{ $sastav->id }}').submit()">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-sastav-{{ $sastav->id }}" action="{{ route('sastavi.destroy', $sastav) }}" method="POST" class="d-none">
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
                            <p class="text-center text-muted">Nema evidentiranih igrača u sastavu gostujućeg tima.</p>
                        @endif
                    @else
                        @php
                            // Dobavi protivničke igrače za gostujući tim
                            $gostujuciProtivnickiIgraci = \App\Models\ProtivnickiIgrac::where('utakmica_id', $utakmica->id)
                                                      ->where('tim_id', $utakmica->gost_id)
                                                      ->get();
                        @endphp
                        
                        @if($gostujuciProtivnickiIgraci->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Igrač</th>
                                            <th>Kapiten</th>
                                            <th>Akcije</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($gostujuciProtivnickiIgraci as $igrac)
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
                                                            onclick="document.getElementById('delete-protivnicki-igrac-{{ $igrac->id }}').submit()">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id="delete-protivnicki-igrac-{{ $igrac->id }}" action="{{ route('protivnicki-igraci.destroy', $igrac) }}" method="POST" class="d-none">
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
                            <p class="text-center text-muted">Nema evidentiranih igrača u sastavu gostujućeg tima.</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@else
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Izaberite utakmicu</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                <thead>
                        <tr>
                            <th>Datum</th>
                            <th>Domaćin</th>
                            <th>Rezultat</th>
                            <th>Gost</th>
                            <th>Takmičenje</th>
                            <th>Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($utakmice as $u)
                        <tr>
                            <td>{{ $u->datum->format('d.m.Y') }}</td>
                            <td>{{ $u->domacin->naziv }}</td>
                            <td class="text-center">{{ $u->rezultat_domacin }} - {{ $u->rezultat_gost }}</td>
                            <td>{{ $u->gost->naziv }}</td>
                            <td>
                                @if($u->takmicenje)
                                    {{ $u->takmicenje->naziv }}
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('sastavi.index', ['utakmica_id' => $u->id]) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-users"></i> Sastavi
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $utakmice->links() }}
            </div>
        </div>
    </div>
@endif
@endsection