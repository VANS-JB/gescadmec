<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Besoin;
use App\Models\Etudiant;

class BesoinController extends Controller
{
    /**
     * Afficher tous les besoins
     */
    public function index()
    {
        $besoins = Besoin::with('etudiant')->get();
        return view('besoins.index', compact('besoins'));
    }

    /**
     * Afficher le formulaire pour un nouveau besoin
     */
    public function create()
    {
        $etudiants = Etudiant::all();
        return view('besoins.create', compact('etudiants'));
    }

    /**
     * Enregistrer un nouveau besoin
     */
    public function store(Request $request)
    {
        $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
            'description' => 'required|string',
            'date_soumission' => 'required|date',
        ]);

        Besoin::create($request->all());

        return redirect()->route('besoins.index')
            ->with('success', 'Besoin enregistré avec succès!');
    }

    /**
     * Mettre à jour le statut d'un besoin
     */
    public function updateStatut(Request $request, Besoin $besoin)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,en_cours,résolu',
        ]);

        $besoin->update(['statut' => $request->statut]);

        return back()->with('success', 'Statut mis à jour avec succès!');
    }

    /**
 * Supprimer un besoin
 */
public function destroy(Besoin $besoin)
{
    $besoin->delete();
    return response()->json(['success' => true]);
}
}
