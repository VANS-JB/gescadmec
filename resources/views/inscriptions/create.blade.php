@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>
            <i class="fas fa-user-plus"></i> Nouvelle Inscription
        </h1>
        <p class="lead">Inscrire un étudiant à un niveau de formation</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('inscriptions.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">Sélection de l'Étudiant</h4>
                    
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
                        <div class="mt-2">
                            <a href="{{ route('etudiants.create') }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-plus"></i> Créer un nouvel étudiant
                            </a>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="niveau_id" class="form-label">Niveau de Formation *</label>
                        <select class="form-select @error('niveau_id') is-invalid @enderror" 
                                id="niveau_id" name="niveau_id" required>
                            <option value="">Sélectionnez un niveau</option>
                            @foreach($niveaux as $niveau)
                                <option value="{{ $niveau->id }}" 
                                    {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}
                                    data-prix="{{ $niveau->prix_total }}">
                                    {{ $niveau->nom }} - {{ number_format($niveau->prix_total, 0, ',', ' ') }} FCFA
                                </option>
                            @endforeach
                        </select>
                        @error('niveau_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h4 class="mb-3">Période de Formation</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_debut" class="form-label">Date de Début *</label>
                                <input type="date" class="form-control @error('date_debut') is-invalid @enderror" 
                                       id="date_debut" name="date_debut" value="{{ old('date_debut') }}" required>
                                @error('date_debut')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="date_fin" class="form-label">Date de Fin *</label>
                                <input type="date" class="form-control @error('date_fin') is-invalid @enderror" 
                                       id="date_fin" name="date_fin" value="{{ old('date_fin') }}" required>
                                @error('date_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Information:</strong> La durée de formation sera calculée automatiquement.
                    </div>
                    
                    <h5 class="mt-4">Informations de Paiement</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Prix Total de la Formation</label>
                        <div class="form-control bg-light" id="prix_total_affichage">
                            Sélectionnez un niveau
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="montant_verse" class="form-label">Montant Versé *</label>
                        <input type="number" class="form-control @error('montant_verse') is-invalid @enderror" 
                               id="montant_verse" name="montant_verse" value="{{ old('montant_verse', 0) }}" 
                               min="0" step="1000" required>
                        @error('montant_verse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Entrez 0 si l'étudiant ne paie pas maintenant.
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="methode_paiement" class="form-label">Méthode de Paiement</label>
                        <select class="form-select" id="methode_paiement" name="methode_paiement">
                            <option value="espèces" {{ old('methode_paiement') == 'espèces' ? 'selected' : '' }}>Espèces</option>
                            <option value="mobile_money" {{ old('methode_paiement') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                            <option value="virement" {{ old('methode_paiement') == 'virement' ? 'selected' : '' }}>Virement Bancaire</option>
                            <option value="chèque" {{ old('methode_paiement') == 'chèque' ? 'selected' : '' }}>Chèque</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Reste à Payer</label>
                        <div class="form-control" id="reste_a_payer_affichage">
                            0 FCFA
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Statut du Paiement</label>
                        <div class="form-control" id="statut_paiement_affichage">
                            Non payé
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Enregistrer l'Inscription
                    </button>
                    <a href="{{ route('inscriptions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const niveauSelect = document.getElementById('niveau_id');
    const prixAffichage = document.getElementById('prix_total_affichage');
    const montantVerseInput = document.getElementById('montant_verse');
    const resteAffichage = document.getElementById('reste_a_payer_affichage');
    const statutAffichage = document.getElementById('statut_paiement_affichage');
    
    function calculerInfosPaiement() {
        const prixTotal = parseFloat(niveauSelect.selectedOptions[0]?.dataset.prix) || 0;
        const montantVerse = parseFloat(montantVerseInput.value) || 0;
        const reste = prixTotal - montantVerse;
        
        // Mettre à jour l'affichage du prix total
        if (prixTotal > 0) {
            prixAffichage.textContent = prixTotal.toLocaleString('fr-FR') + ' FCFA';
            prixAffichage.className = 'form-control bg-light';
        } else {
            prixAffichage.textContent = 'Sélectionnez un niveau';
            prixAffichage.className = 'form-control bg-light';
        }
        
        // Mettre à jour le reste à payer
        resteAffichage.textContent = reste.toLocaleString('fr-FR') + ' FCFA';
        
        // Déterminer et afficher le statut
        let statut = 'Non payé';
        let statutClasse = 'bg-danger text-white';
        
        if (reste === 0 && prixTotal > 0) {
            statut = 'Soldé';
            statutClasse = 'bg-success text-white';
            resteAffichage.className = 'form-control bg-success text-white';
        } else if (montantVerse > 0 && reste > 0) {
            statut = 'Partiel';
            statutClasse = 'bg-warning';
            resteAffichage.className = 'form-control bg-warning';
        } else if (montantVerse === 0 && prixTotal > 0) {
            statut = 'Non payé';
            statutClasse = 'bg-danger text-white';
            resteAffichage.className = 'form-control bg-danger text-white';
        } else {
            resteAffichage.className = 'form-control';
        }
        
        statutAffichage.textContent = statut;
        statutAffichage.className = 'form-control ' + statutClasse;
    }
    
    niveauSelect.addEventListener('change', calculerInfosPaiement);
    montantVerseInput.addEventListener('input', calculerInfosPaiement);
    
    // Initialiser au chargement
    if (niveauSelect.value) {
        niveauSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush