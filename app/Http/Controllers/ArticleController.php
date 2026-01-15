<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Famille;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        return view('pages.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $familles = Famille::all();
        return view('pages.articles.create', compact('familles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Création de l'article
        $article = new Article();
        $article->code = $request->code;
        $article->designation = $request->designation;
        $article->reference = $request->reference;
        $article->prix_achat = $request->prix_achat;
        $article->prix_vente = $request->prix_vente;
        $article->date_entree = $request->date_entree;
        $article->date_service = $request->date_service;
        $article->famille_id = $request->famille_id;
        $article->statut = $request->statut;

        // Génération automatique du code-barres
        $article->code_barre = Article::generateCodeBarre();

        // Sauvegarde de l'article
        $article->save();

        // Redirection avec un message de succès
        return redirect()
            ->route('gestions_articles.index')
            ->with('success', 'Article ajouté avec succès avec le code-barres: ' . $article->code_barre);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $articleFinds = Article::findOrFail($id);
        $familles = Famille::all();
        return view('pages.articles.edit', compact('articleFinds', 'familles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Récupération de l'article à mettre à jour
        $article = Article::findOrFail($id);

        // Mise à jour des champs
        $article->designation = $request->designation;
        $article->reference = $request->reference;
        $article->prix_achat = $request->prix_achat;
        $article->prix_vente = $request->prix_vente;
        $article->date_entree = $request->date_entree;
        $article->date_service = $request->date_service;

        $article->famille_id = $request->famille_id;
        $article->statut = $request->statut;

        // Sauvegarde des modifications
        $article->save();
        // Redirection avec un message de succès
        return redirect()->route('gestions_articles.index')->with('success', 'Article mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('gestions_articles.index')->with('success', 'Article supprimé avec succès.');
    }

    /**
     * Import articles from CSV/Excel file
     */
    public function import(Request $request)
    {
        try {
            // Validation du fichier
            $request->validate([
                'file' => 'required|file|mimes:csv,txt|max:3048',
            ]);

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

            // Parcourir chaque ligne du fichier
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // Ignorer les lignes complètement vides
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
                    DB::beginTransaction();

                    // Mapper les colonnes du CSV
                    // Format: designation, date_acquisition, date_service, valeur_acquisition, valeur_residuelle, code_famille, libelle_famille
                    $code = trim($row[0]);
                    $designation = trim($row[1]);
                    $date_entree = $this->convertDate($row[2]);
                    $date_service = $this->convertDate($row[3]);
                    $prix_achat = floatval(trim($row[4]));
                    $prix_vente = floatval(trim($row[5]));
                    $famille_id = trim($row[6]);

                    // Générer le numéro d'article unique
                    $lastArticle = Article::latest('id')->first();
                    $nextNumber = $lastArticle ? intval(substr($lastArticle->numero_article, 4)) + 1 : 1;
                    $numeroArticle = 'ART-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

                    // Créer l'article principal
                    $article = Article::create([
                        'code' => $numeroArticle,
                        'designation' => $designation,
                        'date_entree' => $date_entree,
                        'date_service' => $date_service,
                        'prix_achat' => $prix_achat,
                        'prix_vente' => $prix_vente,
                        'famille_id' => $famille_id,
                    ]);

                    DB::commit();
                    $imported++;
                } catch (\Exception $e) {
                    DB::rollBack();
                    $errors[] = 'Ligne ' . ($imported + 2) . ': ' . $e->getMessage() . ' | Données: ' . implode(' | ', $row);
                }
            }

            fclose($handle);

            // Message de succès avec détails
            $message = "$imported article(s) importé(s) avec succès.";

            if (!empty($errors)) {
                $message .= ' ' . count($errors) . ' erreur(s) détectée(s).';
                session()->flash('errors_detail', $errors);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Erreur lors de l\'import: ' . $e->getMessage());
        }
    }

    /**
     * Convertir une date au format d/m/Y en Y-m-d
     */
    private function convertDate($date)
    {
        if (empty($date)) {
            return null;
        }

        try {
            return \Carbon\Carbon::createFromFormat('d/m/Y', trim($date))->toDateString();
        } catch (\Exception $e) {
            \Log::warning('Erreur conversion date', ['date' => $date]);
            return null;
        }
    }

    /**
     * Download template for article import
     */
    public function template()
    {
        $headers = ['Référence immobilisation', 'Désignation', 'Date d\'acquisition', 'Date de mise en service', 'Valeur d\'acquisition', 'Valeur résiduelle', '', 'Groupe immobilisation', 'Libellé groupe immobilisation'];
        $filename = 'template_articles.csv';

        return response()->streamDownload(function () use ($headers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers, ';');
            fclose($handle);
        }, $filename);
    }

    /**
     * Search articles for Select2 AJAX
     */
    public function search(Request $request)
    {
        $search = $request->get('search', '');

        $articles = Article::where(function ($query) use ($search) {
            $query
                ->where('designation', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhere('code_barre', 'like', "%{$search}%")
                ->orWhere('reference', 'like', "%{$search}%");
        })
            ->limit(20)
            ->get()
            ->map(function ($article) {
                return [
                    'id' => $article->id,
                    'designation' => $article->designation,
                    'code' => $article->code,
                    'code_barre' => $article->code_barre,
                    'reference' => $article->reference,
                    'prix_achat' => $article->prix_achat,
                    'prix_vente' => $article->prix_vente,
                ];
            });

        return response()->json($articles);
    }
}
