<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paiement;
use App\Models\Inscription;

class PaiementController extends Controller
{
    /**
     * Afficher tous les paiements
     */
    public function index()
    {
        $paiements = Paiement::with('inscription.etudiant', 'inscription.niveau')->get();
        return view('paiements.index', compact('paiements'));
    }

    /**
     * Afficher le formulaire pour un nouveau paiement
     */
    public function create()
    {
        $inscriptions = Inscription::with('etudiant')->where('reste_a_payer', '>', 0)->get();
        return view('paiements.create', compact('inscriptions'));
    }

    /**
     * Enregistrer un nouveau paiement
     */
    public function store(Request $request)
    {
        $request->validate([
        'inscription_id' => 'required|exists:inscriptions,id',
        'montant' => 'required|numeric|min:1',
        'date_paiement' => 'required|date',
        'methode_paiement' => 'required|string',
    ]);

    $inscription = Inscription::find($request->inscription_id);

    // Vérifier que le montant ne dépasse pas le reste à payer
    if ($request->montant > $inscription->reste_a_payer) {
        return back()->withErrors(['montant' => 'Le montant ne peut pas dépasser le reste à payer: ' . $inscription->reste_a_payer . ' FCFA']);
    }

    // Créer le paiement
    Paiement::create([
        'inscription_id' => $request->inscription_id,
        'montant' => $request->montant,
        'date_paiement' => $request->date_paiement,
        'methode_paiement' => $request->methode_paiement,
    ]);

    // Mettre à jour l'inscription
    $inscription->montant_verse += $request->montant;
    $inscription->reste_a_payer -= $request->montant;
    $inscription->statut_paiement = $inscription->reste_a_payer == 0 ? 'soldé' : 'partiel';
    $inscription->save();

    return redirect()->route('paiements.index')
        ->with('success', 'Paiement enregistré avec succès!');
    }

    /**
     * Afficher les statistiques par niveau
     */
    public function statistiques()
    {
        $statistiques = Inscription::with('niveau')
            ->selectRaw('niveau_id, 
                        SUM(montant_verse) as total_verse, 
                        SUM(reste_a_payer) as total_reste,
                        COUNT(*) as nombre_inscriptions')
            ->groupBy('niveau_id')
            ->get();

        return view('paiements.statistiques', compact('statistiques'));
    }
}
