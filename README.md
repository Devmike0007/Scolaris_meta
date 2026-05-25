# Scolaris Meta VR

## 📘 Mission éducative

Dans le secteur scolaire en République Démocratique du Congo, il existe un problème majeur de visualisation des cours. La majorité des élèves ne comprennent pas bien certaines notions, car ils ne peuvent pas voir concrètement ce qu'ils apprennent.

C'est dans ce contexte que Scolaris Meta intervient avec une solution basée sur la réalité virtuelle (VR) et l'intelligence artificielle (IA).

## 🚀 Objectif pédagogique

Améliorer la qualité de l'éducation en rendant l'apprentissage plus visuel, interactif et immersif grâce à la VR et à l'IA.

## 💡 Exemple d'utilisation

Un professeur de biologie peut entrer : "Le système respiratoire humain"
Le système génère une représentation 3D affichée dans un casque VR, permettant aux élèves d'explorer les poumons de manière immersive.

## 🎯 Version Simplifiée - Structure ultra-simple

```
config.php          ← Configuration + fonctions basiques
auth.php            ← Login / Logout
index.php           ← Accueil + Générateur d'images
vr.php              ← Affichage VR (Three.js)
```

**C'est tout!** Plus de dossiers app/, core/, config/, etc.

## 🚀 Comment ça marche

### 1. **config.php** - Tout ce qu'il faut
```php
- Variables de config
- Session management
- Fonctions is_logged_in(), is_admin()
```

### 2. **auth.php** - Authentification simple
```php
- Formulaire de login
- Traitement du login
- Logout
```

### 3. **index.php** - Page principale
```php
- Vérifier login
- Formulaire textarea
- Générer image basique
- Afficher résultat
```

### 4. **vr.php** - Affichage VR
```php
- Charger image avec Three.js
- Afficher en 360°
- Contrôles souris
```

## 🔐 Login

- **Email**: admin@example.com
- **Mot de passe**: password123

## 📝 Architecture ultra-simple

- ❌ Pas de base de données
- ❌ Pas de contrôleurs
- ❌ Pas de modèles
- ❌ Pas de services
- ❌ Pas de routeur compliqué
- ✅ Juste du PHP basique
- ✅ Juste du HTML/CSS simple
- ✅ Un peu de JavaScript (Three.js)

## 🎓 Impact éducatif

Cette version simplifiée permet aux enseignants et élèves de :
1. Visualiser des concepts complexes en 3D
2. Interagir avec le contenu pédagogique
3. Améliorer la compréhension et mémorisation
4. Rendre l'apprentissage plus engageant

## 🎓 Parfait pour apprendre

Maintenant tu peux:
1. Lire `config.php` en 5 minutes
2. Comprendre `auth.php` en 5 minutes
3. Maîtriser `index.php` en 10 minutes
4. Explorer `vr.php` (Three.js) en 20 minutes

**Total: 40 minutes pour comprendre tout le projet!** 🚀
