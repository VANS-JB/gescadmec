@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <h1>
            <i class="fas fa-money-bill-wave"></i> Nouveau Paiement
        </h1>
        <p class="lead">Enregistrer un nouveau paiement pour un étudiant</p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('paiements.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="inscription_id" class="form-label">Inscription *</label>
                        <select class="form-select @error('inscription_id') is-invalid @enderror" 
                                id="inscription_id" name="inscription_id" required>
                            <option value="">Sélectionnez une inscription</option>
                            @foreach($inscriptions as $inscription)
                                <option value="{{ $inscription->id }}" 
                                    {{ old('inscription_id') == $inscription->id ? 'selected' : '' }}
                                    data-etudiant="{{ $inscription->etudiant->nom }} {{ $inscription->etudiant->prenom }}"
                                    data-niveau="{{ $inscription->niveau->nom }}"
                                    data-montant-total="{{ $inscription->montant_total }}"
                                    data-montant-verse="{{ $inscription->montant_verse }}"
                                    data-reste="{{ $inscription->reste_a_payer }}">
                                    {{ $inscription->etudiant->nom }} {{ $inscription->etudiant->prenom }} - 
                                    {{ $inscription->niveau->nom }} 
                                    (Reste: {{ number_format($inscription->reste_a_payer, 0, ',', ' ') }} FCFA)
                                </option>
                            @endforeach
                        </select>
                        @error('inscription_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="montant" class="form-label">Montant *</label>
                        <input type="number" class="form-control @error('montant') is-invalid @enderror" 
                               id="montant" name="montant" value="{{ old('montant') }}" 
                               min="1" step="1000" required>
                        @error('montant')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted" id="montant_help">
                            Le montant ne peut pas dépasser le reste à payer
                        </small>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-header">
                            <h6 class="mb-0">Informations de l'Inscription</h6>
                        </div>
                        <div class="card-body">
                            <div id="info_etudiant" class="mb-2">
                                <strong>Étudiant:</strong> <span id="etudiant_nom">-</span>
                            </div>
                            <div id="info_niveau" class="mb-2">
                                <strong>Niveau:</strong> <span id="niveau_nom">-</span>
                            </div>
                            <div id="info_montant_total" class="mb-2">
                                <strong>Montant total:</strong> <span id="montant_total">-</span> FCFA
                            </div>
                            <div id="info_montant_verse" class="mb-2">
                                <strong>Déjà versé:</strong> <span id="montant_verse">-</span> FCFA
                            </div>
                            <div id="info_reste" class="mb-2">
                                <strong>Reste à payer:</strong> <span id="reste_a_payer" class="text-danger fw-bold">-</span> FCFA
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_paiement" class="form-label">Date de Paiement *</label>
                        <input type="date" class="form-control @error('date_paiement') is-invalid @enderror" 
                               id="date_paiement" name="date_paiement" value="{{ old('date_paiement', date('Y-m-d')) }}" required>
                        @error('date_paiement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="methode_paiement" class="form-label">Méthode de Paiement *</label>
                        <select class="form-select @error('methode_paiement') is-invalid @enderror" 
                                id="methode_paiement" name="methode_paiement" required>
                            <option value="espèces" {{ old('methode_paiement') == 'espèces' ? 'selected' : '' }}>Espèces</option>
                            <option value="mobile_money" {{ old('methode_paiement') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                            <option value="virement" {{ old('methode_paiement') == 'virement' ? 'selected' : '' }}>Virement Bancaire</option>
                            <option value="chèque" {{ old('methode_paiement') == 'chèque' ? 'selected' : '' }}>Chèque</option>
                            <option value="carte" {{ old('methode_paiement') == 'carte' ? 'selected' : '' }}>Carte Bancaire</option>
                        </select>
                        @error('methode_paiement')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save"></i> Enregistrer le Paiement
                    </button>
                    <a href="{{ route('paiements.index') }}" class="btn btn-secondary">
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
    const inscriptionSelect = document.getElementById('inscription_id');
    const montantInput = document.getElementById('montant');
    const montantHelp = document.getElementById('montant_help');
    
    function mettreAJourInfos() {
        const selectedOption = inscriptionSelect.selectedOptions[0];
        
        if (selectedOption && selectedOption.value) {
            document.getElementById('etudiant_nom').textContent = selectedOption.dataset.etudiant;
            document.getElementById('niveau_nom').textContent = selectedOption.dataset.niveau;
            document.getElementById('montant_total').textContent = parseFloat(selectedOption.dataset.montantTotal).toLocaleString('fr-FR');
            document.getElementById('montant_verse').textContent = parseFloat(selectedOption.dataset.montantVerse).toLocaleString('fr-FR');
            document.getElementById('reste_a_payer').textContent = parseFloat(selectedOption.dataset.reste).toLocaleString('fr-FR');
            
            // Mettre à jour le maximum du montant
            montantInput.max = selectedOption.dataset.reste;
            montantHelp.textContent = `Le montant ne peut pas dépasser le reste à payer: ${parseFloat(selectedOption.dataset.reste).toLocaleString('fr-FR')} FCFA`;
        } else {
            document.getElementById('etudiant_nom').textContent = '-';
            document.getElementById('niveau_nom').textContent = '-';
            document.getElementById('montant_total').textContent = '-';
            document.getElementById('montant_verse').textContent = '-';
            document.getElementById('reste_a_payer').textContent = '-';
        }
    }
    
    inscriptionSelect.addEventListener('change', mettreAJourInfos);
    
    // Initialiser au chargement
    if (inscriptionSelect.value) {
        mettreAJourInfos();
    }
});
</script>
@endpush
