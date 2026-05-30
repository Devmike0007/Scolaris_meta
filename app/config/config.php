<?php

// Empêche le chargement multiple du fichier
if (defined('CONFIG_LOADED')) {
    return;
}
define('CONFIG_LOADED', true);

// Config
define('APP_NAME', 'Scolaris Meta VR');
define('ADMIN_EMAIL', 'admin@example.com');
define('ADMIN_PASSWORD', 'password123');

define('CSS', '../assets/css/');
define('IMG', '../assets/img/');

// Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ PROTECTION DES FONCTIONS

if (!function_exists('is_logged_in')) {
    function is_logged_in() {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('is_admin')) {
    function is_admin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
    }
}

if (!function_exists('redirect')) {
    function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
}
?>