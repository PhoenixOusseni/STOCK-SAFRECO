<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Article;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;

class PageController extends Controller
{
    public function auth()
    {
        return view('login-admin');
    }

    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function parametres()
    {
        return view('pages.parametres.index');
    }

    /**
     * Effacer le cache de l'application
     */
    public function clearCache()
    {
        \Artisan::call('cache:clear');
        return redirect()->back()->with('success', 'Le cache a été vidé avec succès.');
    }

    /**
     * Effacer les logs
     */
    public function clearLogs()
    {
        try {
            $logFiles = glob(storage_path('logs/*.log'));
            foreach ($logFiles as $logFile) {
                unlink($logFile);
            }
            return redirect()->back()->with('success', 'Les logs ont été réinitialisés avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la réinitialisation des logs.');
        }
    }

    /**
     * Exécuter les migrations
     */
    public function migrate()
    {
        try {
            \Artisan::call('migrate', ['--force' => true]);
            return redirect()->back()->with('success', 'Les migrations ont été exécutées avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'exécution des migrations.');
        }
    }

    /**
     * help method
     */
    public function help()
    {
        return view('pages.help');
    }

    /**
     * Taux d'amortissement fiscal
     */
    public function tauxAmortissement()
    {
        // Récupérer tous les articles avec leurs familles
        $articlesData = Article::with(['famille'])
            ->where('statut', 'amortissable')
            ->whereHas('famille', function($query) {
                $query->whereNotNull('taux_amortissement');
            })
            ->get()
            ->map(function($article) {
                // Récupérer la date d'entrée et le prix d'achat directement depuis l'article
                $dateMiseService = $article->date_entree;
                $valeurAcquisition = $article->prix_achat ?? 0;

                // Calculer les amortissements
                $tauxAmortissement = $article->famille ? $article->famille->taux_amortissement : 0;
                $anneeActuelle = date('Y');
                $anneeMiseService = $dateMiseService ? date('Y', strtotime($dateMiseService)) : $anneeActuelle;

                // Calcul de l'amortissement annuel
                $amortissementAnnuel = ($valeurAcquisition * $tauxAmortissement) / 100;

                // Amortissements antérieurs (années précédentes)
                $nbreAnneesAnterieures = max(0, $anneeActuelle - $anneeMiseService - 1);
                $amortissementsAnterieurs = $amortissementAnnuel * $nbreAnneesAnterieures;

                // Amortissement de l'exercice en cours
                $amortissementExercice = $amortissementAnnuel;

                // Total des amortissements
                $totalAmortissements = $amortissementsAnterieurs + $amortissementExercice;

                // Valeur résiduelle
                $valeurResiduelle = max(0, $valeurAcquisition - $totalAmortissements);

                return [
                    'numero_compte' => $article->code,
                    'designation' => $article->designation,
                    'taux_amortissement' => $tauxAmortissement,
                    'date_mise_service' => $dateMiseService,
                    'valeur_acquisition' => $valeurAcquisition,
                    'amortissements_anterieurs' => $amortissementsAnterieurs,
                    'amortissement_exercice' => $amortissementExercice,
                    'total_amortissements' => $totalAmortissements,
                    'valeur_residuelle' => $valeurResiduelle,
                    'famille' => $article->famille ? $article->famille->designation : 'Non classé',
                ];
            })
            ->groupBy('famille');

        return view('pages.amortissements.tableau_amortissement', compact('articlesData'));
    }

    // Article with code-barre generation logic moved to Article model
    public function codeBarArticle()
    {
        $articles = Article::all();
        return view('pages.articles.view_codeBar_article', compact('articles'));
    }

    // Print code-barres for a specific article
    public function printCodeBarArticle()
    {
        $articles = Article::all();
        return view('pages.articles.print_codeBar_article', compact('articles'));
    }

    /**
     * Imprimer le tableau d'amortissement
     */
    public function printTableauAmortissement()
    {
        // Récupérer tous les articles avec leurs familles
        $articlesData = Article::with(['famille'])
            ->where('statut', 'amortissable')
            ->whereHas('famille', function($query) {
                $query->whereNotNull('taux_amortissement');
            })
            ->get()
            ->map(function($article) {
                // Récupérer la date d'entrée et le prix d'achat directement depuis l'article
                $dateMiseService = $article->date_entree;
                $valeurAcquisition = $article->prix_achat ?? 0;

                // Calculer les amortissements
                $tauxAmortissement = $article->famille ? $article->famille->taux_amortissement : 0;
                $anneeActuelle = date('Y');
                $anneeMiseService = $dateMiseService ? date('Y', strtotime($dateMiseService)) : $anneeActuelle;

                // Calcul de l'amortissement annuel
                $amortissementAnnuel = ($valeurAcquisition * $tauxAmortissement) / 100;

                // Amortissements antérieurs (années précédentes)
                $nbreAnneesAnterieures = max(0, $anneeActuelle - $anneeMiseService - 1);
                $amortissementsAnterieurs = $amortissementAnnuel * $nbreAnneesAnterieures;

                // Amortissement de l'exercice en cours
                $amortissementExercice = $amortissementAnnuel;

                // Total des amortissements
                $totalAmortissements = $amortissementsAnterieurs + $amortissementExercice;

                // Valeur résiduelle
                $valeurResiduelle = max(0, $valeurAcquisition - $totalAmortissements);

                return [
                    'numero_compte' => $article->code,
                    'designation' => $article->designation,
                    'taux_amortissement' => $tauxAmortissement,
                    'date_mise_service' => $dateMiseService,
                    'valeur_acquisition' => $valeurAcquisition,
                    'amortissements_anterieurs' => $amortissementsAnterieurs,
                    'amortissement_exercice' => $amortissementExercice,
                    'total_amortissements' => $totalAmortissements,
                    'valeur_residuelle' => $valeurResiduelle,
                    'famille' => $article->famille ? $article->famille->designation : 'Non classé',
                ];
            })
            ->groupBy('famille');

        return view('pages.amortissements.print_tableau_amortissement', compact('articlesData'));
    }
}

