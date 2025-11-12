<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Niveau;
use App\Models\Inscription;

class InscriptionController extends Controller
{
     /**
     * Afficher toutes les inscriptions
     */
    public function index()
    {
        $inscriptions = Inscription::with(['etudiant', 'niveau'])->get();
        return view('inscriptions.index', compact('inscriptions'));
    }

    /**
     * Afficher le formulaire pour une nouvelle inscription
     */
    public function create()
    {
        $etudiants = Etudiant::all();
        $niveaux = Niveau::all();
        return view('inscriptions.create', compact('etudiants', 'niveaux'));
    }

    /**
     * Enregistrer une nouvelle inscription
     */
    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'niveau_id' => 'required|exists:niveaux,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'montant_verse' => 'required|numeric|min:0',
        ]);

        $niveau = Niveau::find($request->niveau_id);
        $reste_a_payer = $niveau->prix_total - $request->montant_verse;
        $statut_paiement = $reste_a_payer == 0 ? 'soldé' : ($request->montant_verse > 0 ? 'partiel' : 'non_payé');

        $inscription = Inscription::create([
            'etudiant_id' => $request->etudiant_id,
            'niveau_id' => $request->niveau_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'montant_total' => $niveau->prix_total,
            'montant_verse' => $request->montant_verse,
            'reste_a_payer' => $reste_a_payer,
            'statut_paiement' => $statut_paiement,
        ]);

        if ($request->montant_verse > 0) {
            $inscription->paiements()->create([
                'montant' => $request->montant_verse,
                'date_paiement' => now(),
                'methode_paiement' => $request->methode_paiement ?? 'espèces',
            ]);
        }

        return redirect()->route('inscriptions.show', $inscription->id)
            ->with('success', 'Inscription créée avec succès!');
    }

    /**
     * Afficher les détails d'une inscription
     */
    public function show(Inscription $inscription)
    {
        $inscription->load(['etudiant', 'niveau', 'paiements']);
        return view('inscriptions.show', compact('inscription'));
    }
}
