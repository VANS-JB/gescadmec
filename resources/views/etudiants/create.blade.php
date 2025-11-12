@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>
            <i class="fas fa-user-plus"></i> Nouvelle Inscription d'Étudiant
        </h1>
        <p class="lead">Remplissez le formulaire pour inscrire un nouvel étudiant</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('etudiants.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">Informations Personnelles</h4>
                    
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom *</label>
                        <input type="text" class="form-control @error('nom') is-invalid @enderror" 
                               id="nom" name="nom" value="{{ old('nom') }}" required>
                        @error('nom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom *</label>
                        <input type="text" class="form-control @error('prenom') is-invalid @enderror" 
                               id="prenom" name="prenom" value="{{ old('prenom') }}" required>
                        @error('prenom')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" class="form-control @error('telephone') is-invalid @enderror" 
                               id="telephone" name="telephone" value="{{ old('telephone') }}">
                        @error('telephone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <textarea class="form-control @error('adresse') is-invalid @enderror" 
                                  id="adresse" name="adresse" rows="3">{{ old('adresse') }}</textarea>
                        @error('adresse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <h4 class="mb-3">Informations de Formation</h4>
                    
                    <div class="mb-3">
                        <label for="niveau_id" class="form-label">Niveau de Langue *</label>
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
                    
                    <h5 class="mt-4">Informations de Paiement</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Prix Total</label>
                        <div class="form-control" id="prix_total_affichage">
                            Sélectionnez un niveau
                        </div>
                        <input type="hidden" id="prix_total" name="prix_total">
                    </div>
                    
                    <div class="mb-3">
                        <label for="montant_verse" class="form-label">Montant Versé *</label>
                        <input type="number" class="form-control @error('montant_verse') is-invalid @enderror" 
                               id="montant_verse" name="montant_verse" value="{{ old('montant_verse', 0) }}" 
                               min="0" step="1000" required>
                        @error('montant_verse')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Enregistrer l'Inscription
                    </button>
                    <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">
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
    
    function calculerReste() {
        const prixTotal = parseFloat(niveauSelect.selectedOptions[0]?.dataset.prix) || 0;
        const montantVerse = parseFloat(montantVerseInput.value) || 0;
        const reste = prixTotal - montantVerse;
        
        resteAffichage.textContent = reste.toLocaleString('fr-FR') + ' FCFA';
        
        // Changer la couleur selon le reste
        if (reste === 0) {
            resteAffichage.className = 'form-control bg-success text-white';
        } else if (reste > 0) {
            resteAffichage.className = 'form-control bg-warning';
        } else {
            resteAffichage.className = 'form-control bg-danger text-white';
        }
    }
    
    niveauSelect.addEventListener('change', function() {
        const prix = this.selectedOptions[0]?.dataset.prix;
        if (prix) {
            prixAffichage.textContent = parseFloat(prix).toLocaleString('fr-FR') + ' FCFA';
            prixAffichage.className = 'form-control bg-light';
        } else {
            prixAffichage.textContent = 'Sélectionnez un niveau';
            prixAffichage.className = 'form-control';
        }
        calculerReste();
    });
    
    montantVerseInput.addEventListener('input', calculerReste);
    
    // Initialiser au chargement
    if (niveauSelect.value) {
        niveauSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
