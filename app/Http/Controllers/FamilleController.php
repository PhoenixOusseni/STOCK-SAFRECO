<?php

namespace App\Http\Controllers;

use App\Models\Famille;
use Illuminate\Http\Request;

class FamilleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $familles = Famille::all();
        return view('pages.familles.index', compact('familles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Création de la famille
        $famille = new Famille();
        $code = 'FAM-' . str_pad(Famille::max('id') + 1, 5, '0', STR_PAD_LEFT);
        $famille->code = $code;
        $famille->designation = $request->designation;
        $famille->taux_amortissement = $request->taux_amortissement;

        $famille->save();

        return redirect()->route('gestions_familles.index')->with('success', 'Famille créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $id)
    {
        $findFamille = Famille::find($id);
        return view('pages.familles.show', compact('findFamille'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Famille $famille)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Famille $famille)
    {
        //
    }
}
