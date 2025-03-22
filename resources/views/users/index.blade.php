@extends('layouts.app')

@section('title', 'Upravljanje korisnicima')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Korisnici</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Novi korisnik
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Ime</th>
                        <th>Email</th>
                        <th>Uloga</th>
                        <th>Datum registracije</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger">Administrator</span>
                            @elseif($user->role === 'editor')
                                <span class="badge bg-warning text-dark">Urednik</span>
                            @else
                                <span class="badge bg-secondary">Korisnik</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(Auth::id() !== $user->id)
                                <button type="button" class="btn btn-sm btn-danger" 
                                        onclick="document.getElementById('delete-user-{{ $user->id }}').submit()">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-user-{{ $user->id }}" action="{{ route('users.destroy', $user) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Nema korisnika u bazi podataka</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection