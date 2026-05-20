<?php
// Fichier de test très simple
echo "<!DOCTYPE html>";
echo "<html><head><title>Test Simple</title></head>";
echo "<body>";
echo "<h1>Test d'accès Apache/PHP</h1>";
echo "<p>Si vous voyez cette page, Apache et PHP fonctionnent.</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<hr>";
echo "<h2>Liens de test :</h2>";
echo "<ul>";
echo "<li><a href='index.php'>Application principale</a></li>";
echo "<li><a href='auth.php'>Authentification</a></li>";
echo "<li><a href='test.php'>Test PHP complet</a></li>";
echo "</ul>";
echo "</body></html>";
?>