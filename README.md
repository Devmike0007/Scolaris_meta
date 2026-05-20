# Scolaris Meta VR

Une application web qui permet à un utilisateur de saisir un prompt (texte) et d'afficher une image immersive dans un environnement VR (via A-Frame).

## 📘 Description du projet

Dans le secteur scolaire en République Démocratique du Congo, il existe un problème majeur de visualisation des cours. La majorité des élèves ne comprennent pas bien certaines notions, car ils ne peuvent pas voir concrètement ce qu’ils apprennent.

C’est dans ce contexte que Scolaris Meta intervient.

Notre système propose une solution basée sur la réalité virtuelle (VR) et l’intelligence artificielle (IA). Grâce à cette technologie, l’enseignant peut saisir un prompt décrivant un concept ou une leçon, et l’IA va automatiquement :

- rechercher ou générer une image ou une scène 3D
- transformer le contenu pédagogique en expérience visuelle immersive
- afficher le résultat dans un casque de réalité virtuelle

Ainsi, les élèves peuvent voir, comprendre et interagir avec les notions enseignées, ce qui améliore fortement la compréhension et la mémorisation.

### 🚀 Objectif du projet

Améliorer la qualité de l’éducation en rendant l’apprentissage plus visuel, interactif et immersif grâce à la VR et à l’IA.

### 💡 Exemple

Un professeur de biologie peut entrer un prompt comme :

> "Le système respiratoire humain"

Et le système va générer une représentation visuelle 3D affichée dans un casque VR.

## 🎯 Objectif

Créer une expérience immersive où les utilisateurs peuvent :
1. Saisir une description textuelle (prompt)
2. Générer une image correspondante
3. Visualiser cette image dans un environnement VR 360°
4. Consulter leur historique de prompts

## 🧱 Architecture

```
Scolaris_vr/
├── public/                    # Fichiers accessibles publiquement
│   ├── index.php             # Interface principale
│   ├── admin.php             # Panel d'administration
│   ├── auth.php              # Authentification
│   └── assets/
│       ├── css/style.css     # Styles CSS
│       ├── js/app.js         # JavaScript frontend
│       └── images/           # Images statiques
├── app/                      # Logique métier
│   ├── controllers/          # Contrôleurs MVC
│   │   ├── PromptController.php
│   │   ├── AuthController.php
│   │   └── AdminController.php
│   ├── models/               # Modèles de données
│   │   ├── User.php
│   │   └── Prompt.php
│   └── services/             # Services métier
│       └── ImageService.php
├── vr/                       # Environnement VR
│   └── scene.html            # Scène A-Frame
├── core/                     # Core de l'application
│   └── Database.php          # Connexion base de données
├── config/                   # Configuration
│   └── config.php            # Configuration principale
├── storage/                  # Stockage
│   ├── uploads/              # Images téléchargées
│   └── logs.txt              # Fichier de logs
└── database.sql              # Script SQL
```

## ⚙️ Fonctionnalités

### 1. Interface Utilisateur
- Champ texte pour entrer un prompt
- Bouton "Générer" avec animation
- Affichage de l'image générée
- Lien vers la scène VR
- Historique des prompts

### 2. Authentification
- Inscription (nom, email, mot de passe)
- Connexion avec sessions PHP
- Hash des mots de passe avec `password_hash()`
- Rôles utilisateur (admin/user)

### 3. Génération d'Images
- API qui reçoit un prompt
- Service d'image avec fallback
- Intégration Unsplash API (simulée)
- Stockage des URLs d'images

### 4. Environnement VR
- Utilisation d'A-Frame pour la réalité virtuelle
- Navigation 360° avec l'image générée
- Contrôles de mouvement (ZQSD)
- Mode VR compatible avec les casques

### 5. Administration
- Tableau de bord avec statistiques
- Liste des prompts générés
- Liste des utilisateurs
- Interface réservée aux administrateurs

## 🗄️ Base de Données

### Tables
**users** :
- `id` (INT, clé primaire)
- `name` (VARCHAR)
- `email` (VARCHAR, unique)
- `password` (VARCHAR)
- `role` (ENUM: admin, user)
- `created_at` (TIMESTAMP)

**prompts** :
- `id` (INT, clé primaire)
- `prompt` (TEXT)
- `image_url` (TEXT)
- `user_id` (INT, clé étrangère)
- `created_at` (TIMESTAMP)

### Installation
1. Exécuter le script `database.sql` dans phpMyAdmin ou MySQL
2. Les identifiants par défaut sont :
   - Admin: `admin@scolaris.com` / `admin123`
   - User: `user@test.com` / `user123`

## 🚀 Installation

### Prérequis
- Serveur web (Apache avec XAMPP/WAMP/MAMP)
- PHP 7.4+
- MySQL 5.7+
- Navigateur web moderne

### Étapes d'installation
1. Cloner le projet dans le dossier `htdocs` de XAMPP
2. Importer la base de données avec `database.sql`
3. Configurer les paramètres dans `config/config.php`
4. Accéder à l'application via `http://localhost/Scolaris_vr/public/`

### Configuration
Modifier `config/config.php` :
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'scolaris_meta_vr');
define('DB_USER', 'root');
define('DB_PASS', '');

// Optionnel : clé API Unsplash
define('UNSPLASH_ACCESS_KEY', 'votre_clé_api');
```

## 🎨 Technologies Utilisées

### Backend
- **PHP** : Langage serveur
- **MySQL** : Base de données
- **PDO** : Connexion sécurisée à la base
- **Sessions PHP** : Gestion d'authentification

### Frontend
- **HTML5/CSS3** : Structure et style
- **JavaScript (ES6)** : Interactivité
- **Fetch API** : Communication avec le backend
- **A-Frame** : Framework VR Web

### Sécurité
- `password_hash()` pour les mots de passe
- `htmlspecialchars()` pour éviter les XSS
- Sessions PHP sécurisées
- Validation des données côté serveur

## 📦 Fonctionnalités Bonus

### ✅ Implémentées
- Image fallback si l'API échoue
- Stockage des prompts en base de données
- Historique personnel pour chaque utilisateur
- Interface responsive
- Animations et feedback utilisateur

### 🔮 Améliorations Possibles
- Intégration d'API d'IA (DALL-E, Stable Diffusion)
- Éditeur d'images intégré
- Partage sur les réseaux sociaux
- Mode multi-utilisateur en temps réel
- Export d'images en haute résolution

## ⚠️ Sécurité

### Mesures implémentées
1. **Hash des mots de passe** : Utilisation de `password_hash()`
2. **Protection XSS** : `htmlspecialchars()` sur toutes les sorties
3. **Validation des données** : Côté serveur et client
4. **Sessions sécurisées** : Gestion PHP des sessions
5. **Requêtes préparées** : Protection contre les injections SQL

### Recommandations pour la production
1. Utiliser HTTPS
2. Configurer un `.htaccess` pour la sécurité
3. Limiter les tentatives de connexion
4. Mettre à jour régulièrement les dépendances
5. Sauvegarder régulièrement la base de données

## 👥 Utilisateurs par Défaut

### Administrateur
- Email: `admin@scolaris.com`
- Mot de passe: `admin123`
- Rôle: Admin (accès au panel d'administration)

### Utilisateur Test
- Email: `user@test.com`
- Mot de passe: `user123`
- Rôle: User (interface standard)

## 📝 Journal des Modifications

### Version 1.0.0
- Architecture MVC légère
- Authentification complète
- Génération d'images avec fallback
- Environnement VR avec A-Frame
- Panel d'administration
- Base de données MySQL
- Interface responsive

## 🆘 Support

### Problèmes courants
1. **Connexion base de données** : Vérifier les identifiants dans `config.php`
2. **Permissions** : S'assurer que le serveur peut écrire dans `storage/uploads/`
3. **VR non fonctionnel** : Vérifier que JavaScript est activé

### Débogage
- Consulter `storage/logs.txt` pour les erreurs
- Vérifier la console du navigateur (F12)
- S'assurer que les extensions PHP nécessaires sont activées

## 📄 Licence

Projet éducatif - Scolaris Meta VR
© 2024 - Tous droits réservés

---

**Note** : Ce projet est conçu à des fins éducatives. Pour une utilisation en production, des mesures de sécurité supplémentaires sont recommandées.