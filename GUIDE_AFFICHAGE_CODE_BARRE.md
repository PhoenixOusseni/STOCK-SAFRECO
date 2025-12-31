# Guide d'utilisation - Affichage des codes-barres

## Vue d'ensemble

Le système affiche graphiquement les codes-barres des articles de manière **scannable** avec des fonctionnalités d'impression et de téléchargement.

---

## 📍 Où voir les codes-barres ?

### 1️⃣ Page de modification d'article

**Chemin :** `Gestion des articles` → Cliquer sur 👁️ (œil) → **Code-barres visible en haut**

**Fonctionnalités :**
- ✅ Affichage graphique du code-barres
- 🖨️ Bouton "Imprimer"
- 💾 Bouton "Télécharger" (format PNG)

**Exemple de ce que vous verrez :**
```
┌─────────────────────────────────────────┐
│  Code-barres de l'article               │
├─────────────────────────────────────────┤
│  ████ ██ ███ █ ██ ███ ██ █ ████        │
│                                         │
│  CB2025000001                           │
│  Samsung Galaxy A54                     │
│                                         │
│  [🖨️ Imprimer]  [💾 Télécharger]       │
└─────────────────────────────────────────┘
```

---

### 2️⃣ Page liste des articles

**Chemin :** `Gestion des articles` → **Tableau avec colonne "Code-barres"**

**Fonctionnalités :**
- 📋 Affichage du numéro du code-barres dans le tableau
- 🔍 Bouton avec icône scanner pour ouvrir une modale
- 📱 Modale avec code-barres graphique + options

**Dans le tableau :**
```
┌────┬─────────────┬───────────┬─────────────┬────────┐
│ #  │ Nom         │ Référence │ Code-barres │ Actions│
├────┼─────────────┼───────────┼─────────────┼────────┤
│ 01 │ Galaxy A54  │ GA54-BK   │ CB2025000001│ 🔍 👁️ │
└────┴─────────────┴───────────┴─────────────┴────────┘
```

**Cliquez sur 🔍 pour ouvrir la modale :**
```
╔═══════════════════════════════════════╗
║  Code-barres de l'article         [X] ║
╠═══════════════════════════════════════╣
║                                       ║
║  ████ ██ ███ █ ██ ███ ██ █ ████     ║
║                                       ║
║  CB2025000001                         ║
║  Samsung Galaxy A54                   ║
║  250 000 FCFA                         ║
║                                       ║
╠═══════════════════════════════════════╣
║  [Fermer] [🖨️ Imprimer] [💾 Télécharger]║
╚═══════════════════════════════════════╝
```

---

## 🖨️ Comment imprimer un code-barres ?

### Méthode 1 : Depuis la page d'édition
1. Aller sur la page de modification de l'article
2. Cliquer sur le bouton **"🖨️ Imprimer"**
3. Une nouvelle fenêtre s'ouvre avec le code-barres
4. L'impression démarre automatiquement
5. La fenêtre se ferme après impression

### Méthode 2 : Depuis le tableau
1. Dans la liste des articles, cliquer sur **🔍**
2. La modale s'ouvre avec le code-barres
3. Cliquer sur **"🖨️ Imprimer"**
4. L'impression démarre automatiquement

**Ce qui est imprimé :**
- Code-barres graphique (scannable)
- Numéro du code-barres (CB2025000001)
- Désignation de l'article
- Prix de vente

---

## 💾 Comment télécharger un code-barres ?

### Depuis n'importe quelle page avec le code-barres :
1. Cliquer sur le bouton **"💾 Télécharger"**
2. Un fichier PNG est généré et téléchargé automatiquement
3. Nom du fichier : `code-barre-CB2025000001.png`

**Format du fichier :**
- Type : PNG (image)
- Fond : Blanc
- Qualité : Haute résolution
- Utilisable dans : Documents, étiquettes, etc.

---

## 📊 Utilisation du composant réutilisable

Si vous développez de nouvelles pages et souhaitez afficher un code-barres, utilisez le composant :

```blade
<x-barcode 
    :codeBarre="$article->code_barre" 
    :designation="$article->designation"
    :prix="$article->prix_vente"
    :showButtons="true"
/>
```

**Paramètres :**
- `codeBarre` : Le code-barres à afficher (obligatoire)
- `designation` : Nom de l'article (optionnel)
- `prix` : Prix de l'article (optionnel)
- `showButtons` : Afficher les boutons Imprimer/Télécharger (true/false)

---

## 🔧 Personnalisation

### Modifier l'apparence du code-barres

Dans vos scripts, vous pouvez ajuster les paramètres :

```javascript
JsBarcode("#barcode", "CB2025000001", {
    format: "CODE128",      // Format du code-barres
    width: 2,               // Largeur des barres (1-4)
    height: 80,             // Hauteur du code-barres
    displayValue: false,    // Afficher le texte sous le code
    margin: 10              // Marge autour du code
});
```

### Formats de code-barres supportés

JsBarcode supporte plusieurs formats :
- **CODE128** (recommandé) - Utilisé actuellement
- CODE39
- EAN13
- UPC
- ITF14
- MSI
- Pharmacode
- Codabar

---

## ❓ Foire aux questions

### Q : Le code-barres ne s'affiche pas ?
**R :** Vérifiez que :
1. L'article possède bien un code-barres (champ `code_barre` non vide)
2. Le script JsBarcode est bien chargé
3. Il n'y a pas d'erreur JavaScript dans la console

### Q : Puis-je scanner le code-barres avec mon téléphone ?
**R :** Oui ! Les codes-barres générés sont au format CODE128 et sont scannables avec :
- Applications de scan de codes-barres
- Douchettes de caisse
- Lecteurs de codes-barres professionnels

### Q : Comment générer des codes-barres pour les anciens articles ?
**R :** Exécutez la commande :
```bash
php artisan db:seed --class=GenerateCodeBarreSeeder
```

### Q : Puis-je imprimer plusieurs codes-barres en même temps ?
**R :** Actuellement, l'impression se fait article par article. Pour une impression en masse, vous pouvez créer une page dédiée qui affiche plusieurs codes-barres.

### Q : Le code-barres est-il unique ?
**R :** Oui ! Chaque code-barres est **garanti unique** grâce à :
- Index unique dans la base de données
- Vérification lors de la génération
- Format avec année + numéro séquentiel

---

## 📚 Ressources

- **Bibliothèque utilisée :** [JsBarcode](https://github.com/lindell/JsBarcode)
- **Format :** CODE128
- **Documentation complète :** Voir `DOCUMENTATION_CODE_BARRE.md`

---

## ✨ Prochaines améliorations possibles

- [ ] Impression en masse de codes-barres
- [ ] Export PDF avec plusieurs codes-barres
- [ ] Étiquettes personnalisables
- [ ] Scanner intégré pour vérifier les articles
- [ ] Historique des scans
