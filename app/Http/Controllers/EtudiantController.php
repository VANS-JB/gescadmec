<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Niveau;
use App\Models\Inscription;


class EtudiantController extends Controller
{
     /**
     * Afficher la liste des étudiants
     */
    public function index()
    {
        $etudiants = Etudiant::with('inscriptions.niveau')->get();
        return view('etudiants.index', compact('etudiants'));
    }

    /**
     * Afficher le formulaire d'inscription
     */
    public function create()
    {
        $niveaux = Niveau::all();
        return view('etudiants.create', compact('niveaux'));
    }

    /**
     * Enregistrer un nouvel étudiant avec son inscription
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants',
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
            'niveau_id' => 'required|exists:niveaux,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'montant_verse' => 'required|numeric|min:0',
        ]);

        // Créer l'étudiant
        $etudiant = Etudiant::create($request->all());

        // Récupérer le niveau choisi
        $niveau = Niveau::find($request->niveau_id);

        // Calculer le reste à payer
        $reste_a_payer = $niveau->prix_total - $request->montant_verse;

        // Déterminer le statut de paiement
        $statut_paiement = $reste_a_payer == 0 ? 'soldé' : ($request->montant_verse > 0 ? 'partiel' : 'non_payé');

        // Créer l'inscription
        $inscription = Inscription::create([
            'etudiant_id' => $etudiant->id,
            'niveau_id' => $request->niveau_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'montant_total' => $niveau->prix_total,
            'montant_verse' => $request->montant_verse,
            'reste_a_payer' => $reste_a_payer,
            'statut_paiement' => $statut_paiement,
        ]);

        // Si un paiement a été fait, l'enregistrer
        if ($request->montant_verse > 0) {
            $inscription->paiements()->create([
                'montant' => $request->montant_verse,
                'date_paiement' => now(),
                'methode_paiement' => $request->methode_paiement ?? 'espèces',
            ]);
        }

        return redirect()->route('etudiants.show', $etudiant->id)
            ->with('success', 'Étudiant inscrit avec succès!');
    }

    /**
     * Afficher les détails d'un étudiant
     */
    public function show(Etudiant $etudiant)
    {
        $etudiant->load('inscriptions.niveau', 'besoins');
        return view('etudiants.show', compact('etudiant'));
    }

    /**
 * Afficher le formulaire de modification
 */
public function edit(Etudiant $etudiant)
{
    $etudiant->load(['inscriptions.niveau', 'besoins']);
    return view('etudiants.edit', compact('etudiant'));
}
    /**
     * Mettre à jour les informations d'un étudiant
     */
    public function update(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:etudiants,email,' . $etudiant->id,
            'telephone' => 'nullable|string|max:20',
            'adresse' => 'nullable|string',
        ]);

        $etudiant->update($request->all());

        return redirect()->route('etudiants.show', $etudiant->id)
            ->with('success', 'Étudiant modifié avec succès!');
    }

    
      /**
 * Supprimer un étudiant
 */
public function destroy(Etudiant $etudiant)
{
    try {
        // OPTION 1 : Suppression simple (recommandée)
        // La base de données gère automatiquement la suppression en cascade
        $etudiant->delete();

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès!');

    } catch (\Exception $e) {
        return redirect()->route('etudiants.show', $etudiant->id)
            ->with('error', 'Une erreur est survenue lors de la suppression: ' . $e->getMessage());
    }
}
}
