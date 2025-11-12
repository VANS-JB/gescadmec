@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-clipboard-list"></i> Détails de l'Inscription
    </h1>
    <div>
        @if($inscription->reste_a_payer > 0)
            <a href="{{ route('paiements.create') }}?inscription_id={{ $inscription->id }}" 
               class="btn btn-success">
                <i class="fas fa-money-bill-wave"></i> Ajouter un Paiement
            </a>
        @endif
        <a href="{{ route('inscriptions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-graduate"></i> Informations de l'Étudiant
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Nom & Prénom:</strong></td>
                        <td>{{ $inscription->etudiant->nom }} {{ $inscription->etudiant->prenom }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $inscription->etudiant->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Téléphone:</strong></td>
                        <td>{{ $inscription->etudiant->telephone ?? 'Non renseigné' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Adresse:</strong></td>
                        <td>{{ $inscription->etudiant->adresse ?? 'Non renseignée' }}</td>
                    </tr>
                </table>
                <a href="{{ route('etudiants.show', $inscription->etudiant->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Voir fiche complète
                </a>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-calendar-alt"></i> Période de Formation
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Date de début:</strong></td>
                        <td>{{ $inscription->date_debut_formatee }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date de fin:</strong></td>
                        <td>{{ $inscription->date_fin_formatee }}</td>
                    </tr>
                    <tr>
                        <td><strong>Durée totale:</strong></td>
                        <td>{{ $inscription->date_debut->diffInDays($inscription->date_fin) }} jours</td>
                    </tr>
                    <tr>
                        <td><strong>Jours restants:</strong></td>
                        <td>
                            <span class="badge 
                                @if($inscription->jours_restants > 30) bg-success
                                @elseif($inscription->jours_restants > 0) bg-warning
                                @else bg-danger
                                @endif">
                                {{ $inscription->jours_restants }} jours
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line"></i> Informations de Formation
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td width="40%"><strong>Niveau:</strong></td>
                        <td>
                            <span class="badge bg-info">{{ $inscription->niveau->nom }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Prix total:</strong></td>
                        <td>{{ number_format($inscription->montant_total, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    <tr>
                        <td><strong>Statut paiement:</strong></td>
                        <td>
                            <span class="badge 
                                @if($inscription->statut_paiement == 'soldé') bg-success
                                @elseif($inscription->statut_paiement == 'partiel') bg-warning
                                @else bg-danger
                                @endif">
                                {{ ucfirst($inscription->statut_paiement) }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="card mt-4">
            <div class="card-header bg-warning text-white">
                <h5 class="mb-0">
                    <i class="fas fa-money-bill-wave"></i> Détails des Paiements
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <table class="table table-sm">
                        <tr class="table-light">
                            <td><strong>Montant total à payer:</strong></td>
                            <td class="text-end">{{ number_format($inscription->montant_total, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr class="table-success">
                            <td><strong>Total déjà versé:</strong></td>
                            <td class="text-end">{{ number_format($inscription->montant_verse, 0, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr class="table-danger">
                            <td><strong>Reste à payer:</strong></td>
                            <td class="text-end">{{ number_format($inscription->reste_a_payer, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    </table>
                </div>
                
                @if($inscription->paiements->count() > 0)
                    <h6>Historique des paiements:</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Méthode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($inscription->paiements as $paiement)
                                    <tr>
                                        <td>{{ $paiement->date_paiement_formatee }}</td>
                                        <td>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($paiement->methode_paiement) }}</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="imprimerRecu({{ $paiement->id }})">
                                                <i class="fas fa-print"></i> Reçu
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-money-bill-wave fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Aucun paiement enregistré pour cette inscription.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Section pour les besoins de l'étudiant -->
<div class="card mt-4">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">
            <i class="fas fa-comments"></i> Besoins Exprimés par l'Étudiant
        </h5>
    </div>
    <div class="card-body">
        @if($inscription->etudiant->besoins->count() > 0)
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inscription->etudiant->besoins as $besoin)
                            <tr>
                                <td>{{ $besoin->date_soumission_formatee }}</td>
                                <td>{{ Str::limit($besoin->description, 150) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($besoin->statut == 'résolu') bg-success
                                        @elseif($besoin->statut == 'en_cours') bg-warning
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($besoin->statut) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-3">
                <i class="fas fa-comments fa-2x text-muted mb-2"></i>
                <p class="text-muted">Aucun besoin exprimé par cet étudiant.</p>
                <a href="{{ route('besoins.create') }}?etudiant_id={{ $inscription->etudiant->id }}" 
                   class="btn btn-sm btn-success">
                    <i class="fas fa-plus"></i> Ajouter un besoin
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function imprimerRecu(paiementId) {
    window.open(`/recu/${paiementId}`, '_blank');
}
</script>
@endpush
