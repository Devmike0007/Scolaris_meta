<?php
// Fichier de démarrage simple pour Scolaris Meta VR
// Accédez à : http://localhost/Scolaris_vr/start.php

echo "<h1>Scolaris Meta VR - Page de démarrage</h1>";

// Vérifier les prérequis
echo "<h2>Vérification des prérequis :</h2>";
echo "<ul>";

// PHP version
echo "<li>PHP Version: " . phpversion() . " - " . (version_compare(phpversion(), '7.4.0', '>=') ? "✅ OK" : "❌ Trop ancien") . "</li>";

// Extensions PHP
$extensions = ['pdo_mysql', 'session', 'json', 'curl'];
foreach ($extensions as $ext) {
    echo "<li>Extension $ext: " . (extension_loaded($ext) ? "✅ OK" : "❌ Manquante") . "</li>";
}

// Permissions
echo "<li>Dossier storage/uploads: " . (is_writable(__DIR__ . '/storage/uploads') ? "✅ Écriture OK" : "❌ Pas d'écriture") . "</li>";

echo "</ul>";

// Test de connexion à la base de données
echo "<h2>Test de connexion MySQL :</h2>";
try {
    $pdo = new PDO("mysql:host=localhost", "root", "");
    echo "<p style='color:green'>✅ Connexion MySQL: OK</p>";
    
    // Vérifier si la base existe
    $stmt = $pdo->query("SHOW DATABASES LIKE 'scolaris_meta_vr'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color:green'>✅ Base de données 'scolaris_meta_vr': Existe</p>";
    } else {
        echo "<p style='color:orange'>⚠️ Base de données 'scolaris_meta_vr': Non trouvée</p>";
        echo "<p>Exécutez le fichier database.sql dans phpMyAdmin</p>";
    }
} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Connexion MySQL: ÉCHEC - " . $e->getMessage() . "</p>";
}

// Liens vers l'application
echo "<h2>Accès à l'application :</h2>";
echo "<ul>";
echo "<li><a href='public/'>Interface principale (index.php)</a></li>";
echo "<li><a href='public/auth.php'>Authentification</a></li>";
echo "<li><a href='public/admin.php'>Administration (admin requis)</a></li>";
echo "<li><a href='public/test.php'>Test PHP</a></li>";
echo "<li><a href='vr/scene.html'>Scène VR (nécessite une image)</a></li>";
echo "</ul>";

// Instructions
echo "<h2>Instructions d'installation :</h2>";
echo "<ol>";
echo "<li>Importer database.sql dans phpMyAdmin</li>";
echo "<li>Accéder à <a href='public/'>http://localhost/Scolaris_vr/public/</a></li>";
echo "<li>Se connecter avec : admin@scolaris.com / admin123</li>";
echo "<li>Ou créer un nouveau compte</li>";
echo "</ol>";

// Dépannage
echo "<h2>Dépannage :</h2>";
echo "<p>Si vous avez une erreur 403 :</p>";
echo "<ol>";
echo "<li>Vérifiez que mod_rewrite est activé dans Apache</li>";
echo "<li>Renommez public/.htaccess en public/.htaccess.bak</li>";
echo "<li>Redémarrez Apache depuis le panneau XAMPP</li>";
echo "</ol>";

echo "<hr>";
echo "<p><small>Scolaris Meta VR - " . date('Y') . "</small></p>";
?>