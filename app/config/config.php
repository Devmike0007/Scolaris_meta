<?php
// Config ultra-simple
define('APP_NAME', 'Scolaris Meta VR');
define('ADMIN_EMAIL', 'admin@example.com');
define('ADMIN_PASSWORD', 'password123');

// Démarrer la session
session_start();

// Fonction pour vérifier si connecté
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Fonction pour vérifier si admin
function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

// Fonction simple de redirection
function redirect($url) {
    header('Location: ' . $url);
    exit;
}
?>
