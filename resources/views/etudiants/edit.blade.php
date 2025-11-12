@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>
            <i class="fas fa-edit"></i> Modifier l'Étudiant
        </h1>
        <p class="lead">Modifier les informations de {{ $etudiant->prenom }} {{ $etudiant->nom }}</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">Informations Personnelles</h4>
                    
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom *</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" value="{{ old('nom', $etudiant->nom) }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom *</label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                               id="prenom" name="prenom" value="{{ old('prenom', $etudiant->prenom) }}" required>
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $etudiant->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h4 class="mb-3">Coordonnées</h4>
                    
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control @error('telephone') is-invalid @enderror" 
                               id="telephone" name="telephone" value="{{ old('telephone', $etudiant->telephone) }}">
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea class="form-control @error('adresse') is-invalid @enderror" 
                                  id="adresse" name="adresse" rows="4">{{ old('adresse', $etudiant->adresse) }}</textarea>
                        @error('adresse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Section des inscriptions existantes -->
            @if($etudiant->inscriptions->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <h4 class="mb-3">
                        <i class="fas fa-history"></i> Historique des Inscriptions
                    </h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Niveau</th>
                                    <th>Date Début</th>
                                    <th>Date Fin</th>
                                    <th>Montant Total</th>
                                    <th>Versé</th>
                                    <th>Reste</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($etudiant->inscriptions as $inscription)
                                <tr>
                                    <td>
                                        <span class="badge bg-info">{{ $inscription->niveau->nom }}</span>
                                    </td>
                                    <td>{{ $inscription->date_debut_formatee }}</td>
                                    <td>{{ $inscription->date_fin_formatee }}</td>
                                    <td>{{ number_format($inscription->montant_total, 0, ',', ' ') }} FCFA</td>
                                    <td class="text-success">{{ number_format($inscription->montant_verse, 0, ',', ' ') }} FCFA</td>
                                    <td class="text-danger">{{ number_format($inscription->reste_a_payer, 0, ',', ' ') }} FCFA</td>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Section des besoins existants -->
            @if($etudiant->besoins->count() > 0)
            <div class="row mt-4">
                <div class="col-12">
                    <h4 class="mb-3">
                        <i class="fas fa-comments"></i> Besoins Exprimés
                    </h4>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($etudiant->besoins as $besoin)
                                <tr>
                                    <td>{{ $besoin->date_soumission_formatee }}</td>
                                    <td>
                                        <div style="max-width: 300px;">
                                            {{ Str::limit($besoin->description, 100) }}
                                            @if(strlen($besoin->description) > 100)
                                                <button class="btn btn-sm btn-link p-0" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalDescription{{ $besoin->id }}">
                                                    Voir plus
                                                </button>
                                            @endif
                                        </div>
                                    </td>
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

                                <!-- Modal pour la description complète -->
                                <div class="modal fade" id="modalDescription{{ $besoin->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Description complète du besoin</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Date:</strong> {{ $besoin->date_soumission_formatee }}</p>
                                                <p><strong>Statut:</strong> 
                                                    <span class="badge 
                                                        @if($besoin->statut == 'résolu') bg-success
                                                        @elseif($besoin->statut == 'en_cours') bg-warning
                                                        @else bg-secondary
                                                        @endif">
                                                        {{ ucfirst($besoin->statut) }}
                                                    </span>
                                                </p>
                                                <p><strong>Description:</strong></p>
                                                <p>{{ $besoin->description }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Mettre à jour
                            </button>
                            <a href="{{ route('etudiants.show', $etudiant->id) }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                        
                        <!-- Bouton pour créer une nouvelle inscription pour cet étudiant -->
                        <a href="{{ route('inscriptions.create') }}?etudiant_id={{ $etudiant->id }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Nouvelle Inscription
                        </a>
                    </div>
                </div>
            </div>
        </form>
        
        <!-- Section de suppression (optionnelle) -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-exclamation-triangle"></i> Zone de Danger
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            <strong>Attention:</strong> La suppression d'un étudiant est irréversible. 
                            Toutes ses inscriptions, paiements et besoins seront également supprimés.
                        </p>
                        <form action="{{ route('etudiants.destroy', $etudiant->id) }}" method="POST" 
                              onsubmit="return confirmerSuppression()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Supprimer cet étudiant
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmerSuppression() {
    return confirm('⚠️ ATTENTION !\n\nÊtes-vous sûr de vouloir supprimer cet étudiant ?\n\nCette action supprimera également :\n• Toutes ses inscriptions\n• Tous ses paiements\n• Tous ses besoins\n\nCette action est irréversible !');
}
</script>
@endpush
