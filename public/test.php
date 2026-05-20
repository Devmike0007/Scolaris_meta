<?php
echo "Test PHP fonctionnel !<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";

// Test de connexion à la base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=scolaris_meta_vr", "root", "");
    echo "Connexion MySQL: OK<br>";
} catch (PDOException $e) {
    echo "Connexion MySQL: ÉCHEC - " . $e->getMessage() . "<br>";
}

// Test des permissions
echo "Permissions du dossier: ";
if (is_writable(__DIR__)) {
    echo "Écriture OK<br>";
} else {
    echo "Écriture ÉCHEC<br>";
}

// Test des sessions
session_start();
$_SESSION['test'] = 'test_value';
echo "Sessions: " . (isset($_SESSION['test']) ? 'OK' : 'ÉCHEC') . "<br>";

// Test de l'URL de base
echo "URL actuelle: " . $_SERVER['REQUEST_URI'] . "<br>";
?>