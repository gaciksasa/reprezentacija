@extends('layouts.app')

@section('title', 'Timovi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Timovi</h1>
    <a href="{{ route('timovi.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novi tim
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Zastava</th>
                        <th>Naziv</th>
                        <th>Zemlja</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($timovi as $tim)
                    <tr>
                        <td>
                            @if($tim->zastava_url)
                                <img src="{{ $tim->zastava_url }}" alt="{{ $tim->naziv }}" height="30">
                            @else
                                <div class="bg-light text-center" style="width: 45px; height: 30px;">
                                    <small>Nema</small>
                                </div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('timovi.show', $tim) }}">
                                {{ $tim->naziv }}
                                @if($tim->skraceni_naziv)
                                    <small>({{ $tim->skraceni_naziv }})</small>
                                @endif
                            </a>
                        </td>
                        <td>{{ $tim->zemlja }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('timovi.show', $tim) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('timovi.edit', $tim) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-tim-{{ $tim->id }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-tim-{{ $tim->id }}" action="{{ route('timovi.destroy', $tim) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Nema timova u bazi podataka</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection