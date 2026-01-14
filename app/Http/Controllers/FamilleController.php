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

    // import method to handle CSV import of familles
    public function import(Request $request)
    {
        try {
            $file = $request->file('file');

            // Ouvrir le fichier CSV
            $handle = fopen($file->getRealPath(), 'r');

            // Détecter le séparateur (virgule ou point-virgule)
            $firstLine = fgets($handle);
            rewind($handle);

            $delimiter = ',';
            if (substr_count($firstLine, ';') > substr_count($firstLine, ',')) {
                $delimiter = ';';
            }

            // Ignorer la première ligne (en-têtes)
            $header = fgetcsv($handle, 1000, $delimiter);

            $imported = 0;
            $errors = [];

            // Obtenir le dernier ID pour la génération des codes
            $lastId = Famille::max('id') ?? 0;

            // Parcourir chaque ligne du fichier
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // Ignorer les lignes complètement vides (toutes les colonnes vides)
                $hasData = false;
                foreach ($row as $cell) {
                    if (!empty(trim($cell))) {
                        $hasData = true;
                        break;
                    }
                }

                if (!$hasData) {
                    continue;
                }

                try {
                    // Mapper les colonnes du CSV
                    // Format attendu: code, designation, taux_amortissement
                    $code = trim($row[0] ?? '');
                    $designation = trim($row[1] ?? '');
                    $taux_amortissement = trim($row[2] ?? '');

                    // Debug: Log des données lues (à retirer en production)
                    \Log::info('Import ligne', [
                        'row' => $row,
                        'code' => $code,
                        'designation' => $designation,
                        'taux_amortissement' => $taux_amortissement,
                    ]);

                    // Vérifier si le code existe déjà (sécurité)
                    while (Famille::where('code', $code)->exists()) {
                        $lastId++;
                        $code = str_pad($lastId, 5, '0', STR_PAD_LEFT);
                    }

                    // Créer un nouveau fournisseur
                    Famille::create([
                        'code' => $code,
                        'designation' => $designation,
                        'taux_amortissement' => $taux_amortissement,
                    ]);

                    $imported++;

                } catch (\Exception $e) {
                    $errors[] = "Ligne " . ($imported + 2) . ": " . $e->getMessage() . " | Données: " . implode(' | ', $row);
                }
            }

            fclose($handle);

            // Message de succès avec détails
            $message = "$imported groupe(s) immobilisation(s) importé(s) avec succès.";

            if (!empty($errors)) {
                $message .= " " . count($errors) . " erreur(s) détectée(s).";
                // Afficher les erreurs dans la session
                session()->flash('errors_detail', $errors);
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'import: ' . $e->getMessage());
        }
    }

    // template method to download CSV template for familles
    public function template()
    {
        $headers = ['code', 'designation', 'taux_amortissement'];
        $filename = 'template_familles.csv';

        return response()->streamDownload(function() use ($headers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            fclose($handle);
        }, $filename);
    }
}
