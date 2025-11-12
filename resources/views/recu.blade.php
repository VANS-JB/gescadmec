<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu de Paiement - Académie de Langue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none !important; }
            body { padding: 20px; }
            .card { border: none !important; }
            .border { border: 1px solid #dee2e6 !important; }
        }
        .receipt-header {
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .watermark {
            position: absolute;
            opacity: 0.1;
            font-size: 120px;
            transform: rotate(-45deg);
            top: 30%;
            left: 10%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="text-center no-print mb-4">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Imprimer le Reçu
            </button>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="fas fa-times"></i> Fermer
            </button>
        </div>

        <div class="card border">
            <div class="card-body">
                <!-- Filigrane -->
                <div class="watermark">GESCADMEC</div>
                
                <!-- En-tête du reçu -->
                <div class="row receipt-header">
                    <div class="col-6">
                        <h2 class="mb-0">GESCADMEC</h2>
                        <p class="mb-0">Centre de Formation Linguistique</p>
                        <p class="mb-0">Email: contact@academie-langue.com</p>
                        <p class="mb-0">Tél: +225 01 23 45 67 89</p>
                    </div>
                    <div class="col-6 text-end">
                        <h3 class="text-primary">REÇU DE PAIEMENT</h3>
                        <p class="mb-0"><strong>N°:</strong> REC-{{ str_pad($paiement->id, 6, '0', STR_PAD_LEFT) }}</p>
                        <p class="mb-0"><strong>Date:</strong> {{ $paiement->date_paiement_formatee }}</p>
                    </div>
                </div>

                <!-- Informations de l'étudiant -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5>Informations de l'Étudiant</h5>
                        <table class="table table-bordered">
                            <tr>
                                <td width="30%"><strong>Nom & Prénom:</strong></td>
                                <td>{{ $paiement->inscription->etudiant->nom }} {{ $paiement->inscription->etudiant->prenom }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $paiement->inscription->etudiant->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Téléphone:</strong></td>
                                <td>{{ $paiement->inscription->etudiant->telephone ?? 'Non renseigné' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Détails du paiement -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h5>Détails du Paiement</h5>
                        <table class="table table-bordered">
                            <tr>
                                <td width="30%"><strong>Niveau de Formation:</strong></td>
                                <td>{{ $paiement->inscription->niveau->nom }}</td>
                            </tr>
                            <tr>
                                <td><strong>Montant Total:</strong></td>
                                <td>{{ number_format($paiement->inscription->montant_total, 0, ',', ' ') }} FCFA</td>
                            </tr>
                            <tr>
                                <td><strong>Montant déjà versé:</strong></td>
                                <td>{{ number_format($paiement->inscription->montant_verse - $paiement->montant, 0, ',', ' ') }} FCFA</td>
                            </tr>
                            <tr class="table-success">
                                <td><strong>Montant de ce paiement:</strong></td>
                                <td><strong>{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Nouveau total versé:</strong></td>
                                <td>{{ number_format($paiement->inscription->montant_verse, 0, ',', ' ') }} FCFA</td>
                            </tr>
                            <tr class="table-warning">
                                <td><strong>Reste à payer:</strong></td>
                                <td><strong>{{ number_format($paiement->inscription->reste_a_payer, 0, ',', ' ') }} FCFA</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Méthode de Paiement:</strong></td>
                                <td>{{ ucfirst($paiement->methode_paiement) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Période de formation:</strong></td>
                                <td>
                                    {{ \Carbon\Carbon::parse($paiement->inscription->date_debut)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse($paiement->inscription->date_fin)->format('d/m/Y') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Signature -->
                <div class="row mt-5">
                    <div class="col-6">
                        <p>Signature de l'étudiant:</p>
                        <div style="border-bottom: 1px solid #333; height: 50px; margin-top: 40px;"></div>
                    </div>
                    <div class="col-6 text-end">
                        <p>Signature du responsable:</p>
                        <div style="border-bottom: 1px solid #333; height: 50px; margin-top: 40px;"></div>
                        <p class="mt-2">Le Responsable de l'Académie</p>
                    </div>
                </div>

                <!-- Pied de page -->
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <p class="text-muted mb-0">
                            <small>
                                Ce reçu est généré automatiquement par le système de gestion de l'Académie de Langue.<br>
                                Pour toute réclamation, merci de présenter ce reçu dans un délai de 30 jours.
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Impression automatique optionnelle
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
