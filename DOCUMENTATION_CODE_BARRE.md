# Génération automatique de codes-barres pour les articles

## Vue d'ensemble

Le système génère automatiquement un **code-barres unique** pour chaque article lors de sa création. 

## Format du code-barres

**Format:** `CBAAAA999999`

Où :
- `CB` = Préfixe fixe (Code-Barres)
- `AAAA` = Année en cours (ex: 2025)
- `999999` = Numéro séquentiel sur 6 chiffres (de 000001 à 999999)

**Exemples:**
- `CB2025000001` - Premier article de 2025
- `CB2025000042` - 42ème article de 2025
- `CB2026000001` - Premier article de 2026

## Fonctionnement

### 1. Création manuelle d'un article

Lors de l'enregistrement d'un nouvel article via le formulaire, le code-barres est **généré automatiquement** dans le contrôleur `ArticleController@store`.

```php
// Le code-barres est généré automatiquement
$article->code_barre = Article::generateCodeBarre();
```

### 2. Importation en masse (CSV)

Lors de l'importation d'articles via fichier CSV, chaque article reçoit également un code-barres unique automatiquement.

### 3. Articles existants

Pour générer des codes-barres pour les articles qui n'en ont pas encore, utilisez la commande :

```bash
php artisan db:seed --class=GenerateCodeBarreSeeder
```

## Garantie d'unicité

Le système garantit l'unicité de chaque code-barres grâce à :

1. **Index unique** dans la base de données (champ `code_barre`)
2. **Vérification en boucle** : si un code existe déjà, on incrémente jusqu'à trouver un code libre
3. **Séquence par année** : le compteur redémarre à 1 chaque nouvelle année

## Fichiers modifiés

### Migration
- `database/migrations/2025_12_30_123356_add_code_barre_to_articles_table.php`
  - Ajoute le champ `code_barre` (string, unique, nullable)

### Modèle
- `app/Models/Article.php`
  - Méthode `generateCodeBarre()` : génère un code-barres unique

### Contrôleur
- `app/Http/Controllers/ArticleController.php`
  - Méthode `store()` : génère le code-barres à la création
  - Méthode `import()` : génère le code-barres lors de l'importation

### Seeder
- `database/seeders/GenerateCodeBarreSeeder.php`
  - Génère des codes-barres pour les articles existants

## Utilisation dans les vues

Pour afficher le code-barres d'un article dans vos vues Blade :

```blade
<p>Code-barres : {{ $article->code_barre }}</p>
```

## Affichage graphique du code-barres

Le système utilise **JsBarcode** (bibliothèque JavaScript) pour afficher les codes-barres de manière graphique et scannable.

### Méthode 1 : Affichage direct dans les vues

Pour afficher un code-barres dans une vue Blade, ajoutez :

```blade
<!-- Inclure la bibliothèque JsBarcode -->
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

<!-- Élément SVG pour le code-barres -->
<svg id="barcode"></svg>

<!-- Script pour générer le code-barres -->
<script>
    JsBarcode("#barcode", "{{ $article->code_barre }}", {
        format: "CODE128",
        width: 2,
        height: 80,
        displayValue: false,
        margin: 10
    });
</script>
```

### Méthode 2 : Utiliser le composant Blade

Un composant réutilisable a été créé dans `resources/views/components/barcode.blade.php` :

```blade
<x-barcode 
    :codeBarre="$article->code_barre" 
    :designation="$article->designation"
    :prix="$article->prix_vente"
    :showButtons="true"
/>
```

### Fonctionnalités disponibles

#### 1. Page d'édition (edit.blade.php)
- Affichage du code-barres en haut de la page
- Bouton pour **imprimer** le code-barres
- Bouton pour **télécharger** le code-barres en PNG

#### 2. Page de liste (index.blade.php)
- Colonne "Code-barres" affichant le numéro
- Bouton avec icône 🔍 pour visualiser le code-barres dans une modale
- Modale avec options d'impression et téléchargement

### Impression du code-barres

Le système génère automatiquement une page imprimable contenant :
- Le code-barres graphique
- Le numéro du code-barres
- La désignation de l'article
- Le prix de vente

```javascript
function printBarcode() {
    // Ouvre une nouvelle fenêtre avec le code-barres
    // Lance automatiquement l'impression
}
```

### Téléchargement du code-barres

Le code-barres peut être téléchargé au format PNG :
- Conversion SVG → Canvas → PNG
- Fond blanc automatique
- Nom du fichier : `code-barre-CB2025000001.png`

### Alternative PHP (si nécessaire)

Si vous préférez générer les codes-barres côté serveur, vous pouvez installer :

```bash
composer require picqer/php-barcode-generator
```

Puis l'utiliser dans vos vues :

```php
use Picqer\Barcode\BarcodeGeneratorHTML;

$generator = new BarcodeGeneratorHTML();
echo $generator->getBarcode($article->code_barre, $generator::TYPE_CODE_128);
```

**Recommandation :** Utilisez JsBarcode (méthode JavaScript) car elle est plus légère et ne nécessite pas de dépendance PHP supplémentaire.

## Capacité maximale

Avec 6 chiffres, le système peut gérer **jusqu'à 999,999 articles par an** avant de redémarrer la séquence l'année suivante.

## Modifications futures possibles

Si vous souhaitez :
- **Changer le préfixe** : modifiez `CB` dans la méthode `generateCodeBarre()`
- **Augmenter la capacité** : changez le `6` dans `str_pad($newNumber, 6, ...)`
- **Format différent** : adaptez la logique de génération selon vos besoins
