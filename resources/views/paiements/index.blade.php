@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-money-bill-wave"></i> Gestion des Paiements
    </h1>
    <div>
        <a href="{{ route('paiements.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nouveau Paiement
        </a>
        <a href="{{ route('paiements.statistiques') }}" class="btn btn-info">
            <i class="fas fa-chart-bar"></i> Statistiques
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Étudiant</th>
                        <th>Niveau</th>
                        <th>Montant</th>
                        <th>Date Paiement</th>
                        <th>Méthode</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paiements as $paiement)
                    <tr>
                        <td>{{ $paiement->id }}</td>
                        <td>
                            <strong>{{ $paiement->inscription->etudiant->nom }} {{ $paiement->inscription->etudiant->prenom }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $paiement->inscription->niveau->nom }}</span>
                        </td>
                        <td>
                            <strong>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</strong>
                        </td>
                        <td>{{ $paiement->date_paiement_formatee }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst($paiement->methode_paiement) }}</span>
                        </td>
                        <td>
                            <a href="{{ route('inscriptions.show', $paiement->inscription_id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Voir
                            </a>
                            <button class="btn btn-sm btn-warning" onclick="imprimerRecu({{ $paiement->id }})">
                                <i class="fas fa-print"></i> Reçu
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($paiements->isEmpty())
        <div class="text-center py-4">
            <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
            <p class="text-muted">Aucun paiement enregistré pour le moment.</p>
            <a href="{{ route('paiements.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Enregistrer le premier paiement
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
