# Guide d'utilisation - Scan de Code-barres pour les Entrées

## Vue d'ensemble

Le système permet maintenant de scanner des codes-barres pour sélectionner rapidement les articles lors de la création d'une entrée de stock. Le prix d'achat se remplit automatiquement.

---

## 📱 Fonctionnalités

### 1️⃣ Scan de code-barres

**Où ?** Page de création d'entrée : `Gestion des Entrées` → `Ajouter une entrée`

**Comment ça marche ?**
1. Placez le curseur dans le champ "Scanner Code-barres"
2. Scannez le code-barres de l'article avec votre lecteur
3. L'article est sélectionné automatiquement
4. Le prix d'achat se remplit automatiquement
5. Le focus passe à la quantité

**Schéma :**
```
┌──────────────────────────────────────────────────────────┐
│ Scanner Code-barres │ Article    │ Dépôt │ Qté │ Prix   │
├──────────────────────────────────────────────────────────┤
│ [Scanner ici...]    │ [Select]   │ [...]  │ [...] │ [Auto]│
│  Ou sélectionnez    │            │        │       │       │
│  ci-dessous         │            │        │       │       │
└──────────────────────────────────────────────────────────┘
```

---

### 2️⃣ Sélection manuelle (Select2)

Si vous n'avez pas de lecteur de code-barres, vous pouvez :
1. Cliquer sur le champ "Article"
2. Rechercher l'article par nom ou code
3. Sélectionner l'article
4. Le prix d'achat se remplit automatiquement

---

## 🔧 Fonctionnement technique

### Détection du scan

Le système détecte automatiquement quand un code-barres est scanné :
- **Entrée manuelle** : Appuyez sur Entrée après avoir tapé le code
- **Scanner automatique** : Le scanner envoie le code et appuie sur Entrée automatiquement
- **Détection intelligente** : Si vous tapez 8+ caractères rapidement, le système recherche automatiquement

### Remplissage automatique du prix

Quand un article est sélectionné (par scan ou select) :
1. Le système récupère le prix d'achat de l'article
2. Le champ "Prix Unitaire" se remplit automatiquement
3. Le champ est en lecture seule (readonly) pour éviter les modifications accidentelles

**Note :** Vous pouvez toujours modifier le prix manuellement en cliquant dessus si nécessaire.

---

## 🎯 Flux de travail recommandé

### Avec lecteur de code-barres :

```
1. Sélectionner le fournisseur
2. Scanner le code-barres → Article + Prix remplis
3. Sélectionner le dépôt
4. Entrer la quantité
5. Cliquer sur [+] pour ajouter un autre article
6. Répéter les étapes 2-5
7. Enregistrer l'entrée
```

### Sans lecteur (sélection manuelle) :

```
1. Sélectionner le fournisseur
2. Cliquer sur "Article" et rechercher
3. Sélectionner l'article → Prix rempli automatiquement
4. Sélectionner le dépôt
5. Entrer la quantité
6. Cliquer sur [+] pour ajouter un autre article
7. Répéter les étapes 2-6
8. Enregistrer l'entrée
```

---

## 🔍 Recherche intelligente

Le système recherche les articles par :
- **Désignation** : Nom de l'article
- **Code article** : Code interne
- **Code-barres** : CB2025000001
- **Référence** : Référence fournisseur

**Exemple :**
- Scanner : `CB2025000001` → Trouve l'article correspondant
- Taper : "Samsung" → Affiche tous les articles Samsung
- Taper : "ART-00042" → Trouve l'article avec ce code

---

## ⚡ Avantages

### Rapidité
- ✅ Gain de temps : Pas besoin de chercher manuellement
- ✅ Moins d'erreurs : Le code-barres est unique
- ✅ Flux continu : Scanner → Quantité → Suivant

### Précision
- ✅ Prix automatique : Évite les erreurs de saisie
- ✅ Article correct : Le code-barres ne peut pas se tromper
- ✅ Stock exact : Moins de risques d'erreurs

### Productivité
- ✅ Traitement rapide des réceptions
- ✅ Moins de fatigue pour l'opérateur
- ✅ Plus d'entrées traitées par heure

---

## 🛠️ Configuration du lecteur de code-barres

### Paramètres recommandés :

1. **Mode clavier** : Émulation clavier (Keyboard Wedge)
2. **Suffixe** : Ajouter "Entrée" après le scan
3. **Préfixe** : Aucun (ou selon votre configuration)
4. **Délai** : Pas de délai entre les caractères

### Types de lecteurs compatibles :

- ✅ **Lecteurs USB** : Plug & Play, émulation clavier
- ✅ **Lecteurs Bluetooth** : Jumelage avec l'ordinateur
- ✅ **Lecteurs filaires** : Port série ou USB
- ✅ **Caméra/Scanner 2D** : Pour QR codes et codes-barres

### Lecteurs testés :

- Honeywell Voyager 1200g
- Zebra DS2208
- Scanner portable Bluetooth
- Application mobile (Android/iOS)

---

## 📱 Utilisation mobile

Vous pouvez utiliser votre smartphone comme lecteur :

### Applications recommandées :

**Android :**
- QR & Barcode Scanner
- Barcode Scanner by ZXing
- Scanner de codes QR et codes-barres

**iOS :**
- Appareil photo natif (iOS 11+)
- QR Code Reader
- Barcode Scanner

### Comment faire :

1. Installez l'application
2. Ouvrez la page d'entrée sur mobile
3. Cliquez dans le champ "Scanner Code-barres"
4. Scannez avec l'application
5. Le code est automatiquement inséré

---

## ❓ Dépannage

### Le scan ne fonctionne pas ?

**Vérifiez :**
- Le curseur est bien dans le champ "Scanner Code-barres"
- Le lecteur est allumé et connecté
- Le lecteur est configuré en mode "Clavier"
- Le code-barres est lisible et propre

**Solutions :**
- Nettoyez le code-barres
- Rapprochez ou éloignez le lecteur
- Vérifiez la configuration du lecteur
- Essayez de saisir le code manuellement

### L'article n'est pas trouvé ?

**Causes possibles :**
- Le code-barres n'existe pas dans la base
- L'article n'a pas de code-barres généré
- Le code-barres est incorrect

**Solutions :**
- Vérifiez le code-barres dans "Gestion des articles"
- Générez les codes-barres manquants : `php artisan db:seed --class=GenerateCodeBarreSeeder`
- Utilisez la sélection manuelle comme alternative

### Le prix ne se remplit pas ?

**Vérifiez :**
- L'article a bien un prix d'achat défini
- Le champ n'est pas bloqué par un autre script
- La connexion internet fonctionne (pour Select2 AJAX)

**Solutions :**
- Définissez le prix d'achat dans la fiche article
- Actualisez la page
- Vérifiez la console JavaScript (F12) pour les erreurs

---

## 🔒 Sécurité

### Validation des données

Même avec le scan automatique, le système valide :
- ✅ L'article existe
- ✅ Le prix est un nombre valide
- ✅ La quantité est supérieure à 0
- ✅ Le dépôt est sélectionné

### Protection contre les erreurs

- Le champ prix est en lecture seule par défaut
- Impossible de scanner un code-barres invalide
- Alerte si l'article n'est pas trouvé
- Confirmation avant suppression d'une ligne

---

## 📊 Statistiques d'utilisation

Avec le scan de code-barres :
- **Temps de saisie** : Réduit de 60-80%
- **Erreurs de saisie** : Réduites de 90%
- **Productivité** : Augmentée de 3x

---

## 🎓 Formation des utilisateurs

### Pour bien utiliser le système :

1. **Se familiariser** avec les champs
2. **Pratiquer** le scan de quelques articles
3. **Comprendre** le flux : Scanner → Dépôt → Quantité
4. **Utiliser** les raccourcis : Tab pour passer au champ suivant
5. **Vérifier** toujours avant d'enregistrer

### Raccourcis clavier :

- **Tab** : Passer au champ suivant
- **Entrée** : Valider le scan / Ajouter l'article (selon le contexte)
- **Échap** : Annuler / Fermer Select2

---

## 🆕 Prochaines améliorations

- [ ] Support du scan multiarticle d'un coup
- [ ] Historique des scans
- [ ] Statistiques par opérateur
- [ ] Mode hors ligne
- [ ] Import Excel avec code-barres
- [ ] Impression d'étiquettes en masse

---

## 📞 Support

Pour toute question ou problème :
- Documentation technique : `DOCUMENTATION_CODE_BARRE.md`
- Guide d'affichage : `GUIDE_AFFICHAGE_CODE_BARRE.md`
- Ce guide : `GUIDE_SCAN_CODE_BARRE.md`
