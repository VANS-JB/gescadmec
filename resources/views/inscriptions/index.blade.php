@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>
        <i class="fas fa-clipboard-list"></i> Liste des Inscriptions
    </h1>
    <div>
        <a href="{{ route('inscriptions.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nouvelle Inscription
        </a>
        <a href="{{ route('etudiants.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Nouvel Étudiant
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
                        <th>Période</th>
                        <th>Montant Total</th>
                        <th>Versé</th>
                        <th>Reste</th>
                        <th>Statut</th>
                        <th>Jours Restants</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscriptions as $inscription)
                    <tr>
                        <td>{{ $inscription->id }}</td>
                        <td>
                            <strong>{{ $inscription->etudiant->nom }} {{ $inscription->etudiant->prenom }}</strong>
                            <br>
                            <small class="text-muted">{{ $inscription->etudiant->email }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $inscription->niveau->nom }}</span>
                        </td>
                        <td>
                            <small>
                                {{ $inscription->date_debut_formatee }}<br>
                                au {{ $inscription->date_fin_formatee }}
                            </small>
                        </td>
                        <td>
                            {{ number_format($inscription->montant_total, 0, ',', ' ') }} FCFA
                        </td>
                        <td>
                            <span class="text-success">
                                {{ number_format($inscription->montant_verse, 0, ',', ' ') }} FCFA
                            </span>
                        </td>
                        <td>
                            <span class="text-danger">
                                {{ number_format($inscription->reste_a_payer, 0, ',', ' ') }} FCFA
                            </span>
                        </td>
                        <td>
                            <span class="badge 
                                @if($inscription->statut_paiement == 'soldé') bg-success
                                @elseif($inscription->statut_paiement == 'partiel') bg-warning
                                @else bg-danger
                                @endif">
                                {{ ucfirst($inscription->statut_paiement) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $joursRestants = $inscription->jours_restants;
                            @endphp
                            <span class="badge 
                                @if($joursRestants > 30) bg-success
                                @elseif($joursRestants > 0) bg-warning
                                @else bg-danger
                                @endif">
                                {{ $joursRestants }} jours
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('inscriptions.show', $inscription->id) }}" class="btn btn-sm btn-info" title="Voir détails">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if($inscription->reste_a_payer > 0)
                                <a href="{{ route('paiements.create') }}?inscription_id={{ $inscription->id }}" 
                                   class="btn btn-sm btn-success" title="Ajouter paiement">
                                    <i class="fas fa-money-bill-wave"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($inscriptions->isEmpty())
        <div class="text-center py-4">
            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
            <p class="text-muted">Aucune inscription enregistrée pour le moment.</p>
            <a href="{{ route('inscriptions.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Créer la première inscription
            </a>
        </div>
        @endif
    </div>
</div>
@endsection