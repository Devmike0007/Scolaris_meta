<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Prompt.php';
require_once __DIR__ . '/../app/services/ImageService.php';
require_once __DIR__ . '/../app/controllers/PromptController.php';

$controller = new PromptController();

// Router simple
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'generate':
        $controller->generate();
        exit;
    case 'history':
        $controller->getHistory();
        exit;
    default:
        $controller->index();
        break;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-vr-cardboard"></i> <?php echo APP_NAME; ?></h1>
            <div class="user-info">
                <span>Bonjour, <?php echo $_SESSION['user_name']; ?>!</span>
                <div class="user-actions">
                    <?php if (is_admin()): ?>
                        <a href="admin.php" class="btn btn-admin"><i class="fas fa-cog"></i> Admin</a>
                    <?php endif; ?>
                    <a href="auth.php?action=logout" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                </div>
            </div>
        </header>

        <main>
            <div class="generator-section">
                <h2><i class="fas fa-magic"></i> Générateur d'images VR</h2>
                <p class="subtitle">Décrivez votre scène et plongez dans l'immersion virtuelle</p>
                
                <div class="prompt-form">
                    <textarea id="prompt-input" placeholder="Ex: Une forêt enchantée au coucher du soleil avec des lucioles..." rows="4"></textarea>
                    <button id="generate-btn" class="btn btn-primary">
                        <i class="fas fa-bolt"></i> Générer l'image
                    </button>
                </div>
                
                <div class="loader" id="loader" style="display: none;">
                    <div class="spinner"></div>
                    <p>Génération de votre image en cours...</p>
                </div>
                
                <div class="result-section" id="result-section" style="display: none;">
                    <h3><i class="fas fa-image"></i> Votre image générée</h3>
                    <div class="image-preview">
                        <img id="generated-image" src="" alt="Image générée">
                    </div>
                    <div class="actions">
                        <a id="vr-link" href="#" class="btn btn-vr" target="_blank">
                            <i class="fas fa-vr-cardboard"></i> Voir en VR
                        </a>
                        <button id="new-prompt" class="btn btn-secondary">
                            <i class="fas fa-redo"></i> Nouveau prompt
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="history-section">
                <h3><i class="fas fa-history"></i> Votre historique</h3>
                <div class="history-list" id="history-list">
                    <?php if (!empty($user_prompts)): ?>
                        <?php foreach ($user_prompts as $prompt): ?>
                            <div class="history-item">
                                <div class="prompt-text"><?php echo htmlspecialchars($prompt['prompt']); ?></div>
                                <div class="prompt-meta">
                                    <span class="date"><?php echo date('d/m/Y H:i', strtotime($prompt['created_at'])); ?></span>
                                    <a href="../vr/scene.html?image=<?php echo urlencode($prompt['image_url']); ?>" target="_blank" class="btn-small">
                                        <i class="fas fa-eye"></i> Voir en VR
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="empty-history">Aucun prompt généré pour le moment.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
        
        <footer>
            <p>Scolaris Meta VR &copy; <?php echo date('Y'); ?> - Projet éducatif</p>
        </footer>
    </div>

    <script src="assets/js/app.js"></script>
</body>
</html>