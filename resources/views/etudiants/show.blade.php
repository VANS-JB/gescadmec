@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-user"></i> Fiche de l'Étudiant
    </h1>
    <div>
        <a href="{{ route('etudiants.edit', $etudiant->id) }}" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Informations Personnelles
                </h5>
            </div>
            <div class="card-body">
                <p><strong>Nom:</strong> {{ $etudiant->nom }}</p>
                <p><strong>Prénom:</strong> {{ $etudiant->prenom }}</p>
                <p><strong>Email:</strong> {{ $etudiant->email }}</p>
                <p><strong>Téléphone:</strong> {{ $etudiant->telephone ?? 'Non renseigné' }}</p>
                <p><strong>Adresse:</strong> {{ $etudiant->adresse ?? 'Non renseignée' }}</p>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-comments"></i> Besoins Exprimés
                </h5>
            </div>
            <div class="card-body">
                @if($etudiant->besoins->count() > 0)
                    @foreach($etudiant->besoins as $besoin)
                        <div class="border-bottom pb-2 mb-2">
                            <p class="mb-1"><strong>{{ $besoin->date_soumission_formatee }}</strong></p>
                            <p class="mb-1">{{ $besoin->description }}</p>
                            <span class="badge 
                                @if($besoin->statut == 'résolu') bg-success
                                @elseif($besoin->statut == 'en_cours') bg-warning
                                @else bg-secondary
                                @endif">
                                {{ ucfirst($besoin->statut) }}
                            </span>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted">Aucun besoin exprimé pour le moment.</p>
                @endif
                <a href="{{ route('besoins.create') }}?etudiant_id={{ $etudiant->id }}" class="btn btn-sm btn-success mt-2">
                    <i class="fas fa-plus"></i> Ajouter un besoin
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-clipboard-list"></i> Historique des Inscriptions
                </h5>
            </div>
            <div class="card-body">
                @if($etudiant->inscriptions->count() > 0)
                    @foreach($etudiant->inscriptions as $inscription)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    {{ $inscription->niveau->nom }}
                                    <span class="badge 
                                        @if($inscription->statut_paiement == 'soldé') bg-success
                                        @elseif($inscription->statut_paiement == 'partiel') bg-warning
                                        @else bg-danger
                                        @endif float-end">
                                        {{ ucfirst($inscription->statut_paiement) }}
                                    </span>
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Période:</strong> 
                                            {{ $inscription->date_debut_formatee }} - 
                                            {{ $inscription->date_fin_formatee }}
                                        </p>
                                        <p><strong>Jours restants:</strong> 
                                            <span class="badge 
                                                @if($inscription->jours_restants > 30) bg-success
                                                @elseif($inscription->jours_restants > 0) bg-warning
                                                @else bg-danger
                                                @endif">
                                                {{ $inscription->jours_restants }} jours
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Montant total:</strong> 
                                            {{ number_format($inscription->montant_total, 0, ',', ' ') }} FCFA
                                        </p>
                                        <p><strong>Montant versé:</strong> 
                                            {{ number_format($inscription->montant_verse, 0, ',', ' ') }} FCFA
                                        </p>
                                        <p><strong>Reste à payer:</strong> 
                                            {{ number_format($inscription->reste_a_payer, 0, ',', ' ') }} FCFA
                                        </p>
                                    </div>
                                </div>
                                
                                @if($inscription->paiements->count() > 0)
                                    <h6 class="mt-3">Historique des Paiements:</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Montant</th>
                                                    <th>Méthode</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($inscription->paiements as $paiement)
                                                    <tr>
                                                        <td>{{ $paiement->date_paiement_formatee }}</td>
                                                        <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                                        <td>{{ ucfirst($paiement->methode_paiement) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                                
                                @if($inscription->reste_a_payer > 0)
                                    <a href="{{ route('paiements.create') }}?inscription_id={{ $inscription->id }}" 
                                       class="btn btn-sm btn-success">
                                        <i class="fas fa-money-bill-wave"></i> Ajouter un paiement
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucune inscription pour cet étudiant.</p>
                        <a href="{{ route('inscriptions.create') }}?etudiant_id={{ $etudiant->id }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Créer une inscription
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
