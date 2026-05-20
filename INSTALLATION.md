# Guide d'Installation - Scolaris Meta VR

## 📋 Prérequis

### Logiciels nécessaires
1. **XAMPP** (Windows) ou **MAMP** (Mac) ou **LAMP** (Linux)
2. **Navigateur web moderne** (Chrome, Firefox, Edge)
3. **Éditeur de code** (VS Code, PHPStorm, Sublime Text)

### Versions minimales
- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur
- Apache 2.4 ou supérieur

## 🚀 Installation Rapide

### Étape 1 : Installer XAMPP
1. Télécharger XAMPP depuis https://www.apachefriends.org/
2. Installer XAMPP dans `C:\xampp\` (par défaut)
3. Démarrer Apache et MySQL depuis le panneau de contrôle XAMPP

### Étape 2 : Déployer le projet
1. Copier le dossier `Scolaris_vr` dans `C:\xampp\htdocs\`
2. Structure finale : `C:\xampp\htdocs\Scolaris_vr\`

### Étape 3 : Configurer la base de données
1. Ouvrir phpMyAdmin : http://localhost/phpmyadmin
2. Créer une nouvelle base de données : `scolaris_meta_vr`
3. Importer le fichier `database.sql` depuis le dossier du projet
4. Vérifier que les tables `users` et `prompts` sont créées

### Étape 4 : Configurer l'application
1. Ouvrir `config/config.php`
2. Vérifier les paramètres de connexion à la base de données :
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'scolaris_meta_vr');
define('DB_USER', 'root');
define('DB_PASS', ''); // Mot de passe vide par défaut avec XAMPP
```

### Étape 5 : Tester l'installation
1. Ouvrir http://localhost/Scolaris_vr/public/
2. Se connecter avec :
   - Email: `user@test.com`
   - Mot de passe: `user123`
3. Tester la génération d'image avec un prompt

## 🔧 Configuration Avancée

### Configuration de la base de données
Si vous avez modifié le mot de passe MySQL :
```php
// Dans config/config.php
define('DB_PASS', 'votre_mot_de_passe');
```

### Configuration Unsplash API (optionnel)
1. Créer un compte sur https://unsplash.com/developers
2. Créer une nouvelle application
3. Copier la clé d'accès
4. Ajouter dans `config/config.php` :
```php
define('UNSPLASH_ACCESS_KEY', 'votre_clé_api_ici');
```

### Configuration des permissions
Assurez-vous que les dossiers ont les bonnes permissions :
```bash
# Sous Linux/Mac
chmod 755 storage/
chmod 777 storage/uploads/
chmod 666 storage/logs.txt
```

## 🐛 Dépannage

### Problème 1 : Erreur de connexion à la base de données
**Symptôme** : "Erreur de connexion à la base de données"
**Solution** :
1. Vérifier que MySQL est démarré dans XAMPP
2. Vérifier les identifiants dans `config/config.php`
3. Vérifier que la base `scolaris_meta_vr` existe

### Problème 2 : Pages blanches
**Symptôme** : Page blanche sans erreur
**Solution** :
1. Activer l'affichage des erreurs dans `config/config.php` :
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```
2. Vérifier les logs Apache dans `C:\xampp\apache\logs\`
3. Vérifier les logs PHP dans `C:\xampp\php\logs\`

### Problème 3 : Images non générées
**Symptôme** : L'image ne s'affiche pas après génération
**Solution** :
1. Vérifier la connexion internet
2. Vérifier la console du navigateur (F12 > Console)
3. Vérifier que JavaScript est activé

### Problème 4 : VR non fonctionnel
**Symptôme** : La scène VR ne se charge pas
**Solution** :
1. Vérifier que A-Frame est accessible (connexion internet)
2. Vérifier la console du navigateur pour les erreurs CORS
3. Essayer avec un autre navigateur

## 📊 Comptes par Défaut

### Administrateur
- **Email** : `admin@scolaris.com`
- **Mot de passe** : `admin123`
- **URL admin** : http://localhost/Scolaris_vr/public/admin.php

### Utilisateur Test
- **Email** : `user@test.com`
- **Mot de passe** : `user123`
- **URL principale** : http://localhost/Scolaris_vr/public/

## 🔒 Sécurité en Production

### Changer les mots de passe par défaut
1. Se connecter à phpMyAdmin
2. Exécuter cette requête pour changer le mot de passe admin :
```sql
UPDATE users SET password = '$2y$10$votre_nouveau_hash' WHERE email = 'admin@scolaris.com';
```
3. Générer un nouveau hash avec :
```php
echo password_hash('nouveau_mot_de_passe', PASSWORD_DEFAULT);
```

### Activer HTTPS
1. Générer un certificat SSL
2. Configurer Apache pour utiliser HTTPS
3. Modifier `config/config.php` :
```php
define('BASE_URL', 'https://votre-domaine.com/Scolaris_vr/public/');
```

### Sauvegardes régulières
1. Exporter régulièrement la base de données
2. Sauvegarder le dossier `storage/uploads/`
3. Conserver une copie des fichiers de configuration

## 🎯 Tests de Fonctionnalité

### Test 1 : Authentification
1. Accéder à http://localhost/Scolaris_vr/public/auth.php
2. S'inscrire avec un nouvel email
3. Se connecter avec le nouveau compte
4. Se déconnecter et se reconnecter

### Test 2 : Génération d'image
1. Se connecter
2. Entrer un prompt : "Une forêt enchantée"
3. Cliquer sur "Générer l'image"
4. Vérifier que l'image s'affiche
5. Cliquer sur "Voir en VR"

### Test 3 : Administration
1. Se connecter avec `admin@scolaris.com`
2. Accéder à http://localhost/Scolaris_vr/public/admin.php
3. Vérifier les statistiques
4. Consulter la liste des prompts et utilisateurs

### Test 4 : VR
1. Générer une image
2. Cliquer sur "Voir en VR"
3. Tester la navigation avec ZQSD
4. Tester le mode VR (si casque disponible)

## 📞 Support

### Ressources utiles
- Documentation PHP : https://www.php.net/docs.php
- Documentation MySQL : https://dev.mysql.com/doc/
- Documentation A-Frame : https://aframe.io/docs/
- Forum XAMPP : https://community.apachefriends.org/

### Fichiers de logs
- Logs Apache : `C:\xampp\apache\logs\error.log`
- Logs PHP : `C:\xampp\php\logs\php_error_log`
- Logs application : `storage/logs.txt`

### Contact
Pour toute question ou problème, consultez la documentation ou les forums en ligne.

---

**Note** : Ce guide est spécifique à l'installation sous Windows avec XAMPP. Pour d'autres environnements, adaptez les chemins et commandes en conséquence.