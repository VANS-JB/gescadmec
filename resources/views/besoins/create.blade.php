@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>
            <i class="fas fa-comment-medical"></i> Nouveau Besoin
        </h1>
        <p class="lead">Enregistrer un besoin exprimé par un étudiant</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('besoins.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="etudiant_id" class="form-label">Étudiant *</label>
                        <select class="form-select @error('etudiant_id') is-invalid @enderror" 
                                id="etudiant_id" name="etudiant_id" required>
                            <option value="">Sélectionnez un étudiant</option>
                            @foreach($etudiants as $etudiant)
                                <option value="{{ $etudiant->id }}" 
                                    {{ old('etudiant_id', request('etudiant_id')) == $etudiant->id ? 'selected' : '' }}>
                                    {{ $etudiant->nom }} {{ $etudiant->prenom }} - {{ $etudiant->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('etudiant_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_soumission" class="form-label">Date de Soumission *</label>
                        <input type="date" class="form-control @error('date_soumission') is-invalid @enderror" 
                               id="date_soumission" name="date_soumission" value="{{ old('date_soumission', date('Y-m-d')) }}" required>
                        @error('date_soumission')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="description" class="form-label">Description du Besoin *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="8" 
                                  placeholder="Décrivez en détail le besoin exprimé par l'étudiant..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Décrivez précisément le besoin, la demande ou la difficulté exprimée par l'étudiant.
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Enregistrer le Besoin
                    </button>
                    <a href="{{ route('besoins.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection