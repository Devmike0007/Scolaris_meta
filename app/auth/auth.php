<?php
require '../config/config.php';
require '../models/Model.php';
require '../controllers/Controller.php';
require '../views/View.php';

// Router Auth
$action = $_GET['action'] ?? 'login';
$controller = new AuthController();

if ($action === 'login') {
    view_login();
} elseif ($action === 'process' || $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
} elseif ($action === 'logout') {
    $controller->logout();
}
?>
