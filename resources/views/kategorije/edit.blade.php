@extends('layouts.app')

@section('title', 'Izmeni kategoriju - ' . $kategorija->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Izmeni kategoriju: {{ $kategorija->name }}</h1>
    <div>
        <a href="{{ route('kategorije.show', $kategorija) }}" class="btn btn-info">
            <i class="fas fa-eye"></i> Pregledaj
        </a>
        <a href="{{ route('kategorije.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Nazad
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('kategorije.update', $kategorija) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Naziv kategorije *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $kategorija->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Opis kategorije</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="3">{{ old('description', $kategorija->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="parent_id" class="form-label">Nadređena kategorija</label>
                <select class="form-select @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                    <option value="">-- Bez nadređene kategorije --</option>
                    @foreach($parentKategorije as $parentKategorija)
                        <option value="{{ $parentKategorija->id }}" 
                                {{ old('parent_id', $kategorija->parent_id) == $parentKategorija->id ? 'selected' : '' }}>
                            {{ $parentKategorija->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Sačuvaj izmene</button>
            </div>
        </form>
    </div>
</div>
@endsection