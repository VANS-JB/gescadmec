@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-users"></i> Liste des Étudiants
    </h1>
    <a href="{{ route('etudiants.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouvelle Inscription
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom & Prénom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Niveau</th>
                        <th>Statut Paiement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($etudiants as $etudiant)
                    <tr>
                        <td>{{ $etudiant->id }}</td>
                        <td>
                            <strong>{{ $etudiant->nom }} {{ $etudiant->prenom }}</strong>
                        </td>
                        <td>{{ $etudiant->email }}</td>
                        <td>{{ $etudiant->telephone ?? 'Non renseigné' }}</td>
                        <td>
                            @if($etudiant->inscriptions->count() > 0)
                                @foreach($etudiant->inscriptions as $inscription)
                                    <span class="badge bg-info">{{ $inscription->niveau->nom }}</span>
                                @endforeach
                            @else
                                <span class="badge bg-secondary">Aucune inscription</span>
                            @endif
                        </td>
                        <td>
                            @if($etudiant->inscriptions->count() > 0)
                                @php
                                    $derniereInscription = $etudiant->inscriptions->last();
                                @endphp
                                <span class="badge 
                                    @if($derniereInscription->statut_paiement == 'soldé') bg-success
                                    @elseif($derniereInscription->statut_paiement == 'partiel') bg-warning
                                    @else bg-danger
                                    @endif">
                                    {{ ucfirst($derniereInscription->statut_paiement) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('etudiants.show', $etudiant->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($etudiants->isEmpty())
        <div class="text-center py-4">
            <i class="fas fa-users fa-3x text-muted mb-3"></i>
            <p class="text-muted">Aucun étudiant inscrit pour le moment.</p>
            <a href="{{ route('etudiants.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Inscrire le premier étudiant
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
