<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$controller = new AuthController();

// Router simple
$action = $_GET['action'] ?? 'login';

switch ($action) {
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->register();
        } else {
            $controller->showRegister();
        }
        break;
    case 'logout':
        $controller->logout();
        break;
    case 'login':
    default:
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->login();
        } else {
            $controller->showLogin();
        }
        break;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?> - Authentification</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-header">
            <h1><i class="fas fa-vr-cardboard"></i> <?php echo APP_NAME; ?></h1>
            <p>Plongez dans l'immersion virtuelle</p>
        </div>
        
        <div class="auth-tabs">
            <a href="?action=login" class="tab <?php echo $action === 'login' ? 'active' : ''; ?>">
                <i class="fas fa-sign-in-alt"></i> Connexion
            </a>
            <a href="?action=register" class="tab <?php echo $action === 'register' ? 'active' : ''; ?>">
                <i class="fas fa-user-plus"></i> Inscription
            </a>
        </div>
        
        <div class="auth-form">
            <?php if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])): ?>
                <div class="error-messages">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <p><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></p>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['errors']); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($action === 'register'): ?>
                <form method="POST" action="?action=register">
                    <div class="form-group">
                        <label for="name"><i class="fas fa-user"></i> Nom complet</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password"><i class="fas fa-lock"></i> Confirmer le mot de passe</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> S'inscrire
                    </button>
                </form>
            <?php else: ?>
                <form method="POST" action="?action=login">
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i> Se connecter
                    </button>
                </form>
            <?php endif; ?>
        </div>
        
        <div class="auth-footer">
            <p>Projet éducatif - Scolaris Meta VR</p>
        </div>
    </div>
</body>
</html>