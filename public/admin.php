<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Prompt.php';
require_once __DIR__ . '/../app/controllers/AdminController.php';

$controller = new AdminController();
$action = $_GET['action'] ?? 'index';

switch ($action) {
    case 'create_admin':
        $controller->createAdmin();
        break;
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
    <title><?php echo APP_NAME; ?> - Administration</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="admin-container">
        <header class="admin-header">
            <h1><i class="fas fa-cog"></i> <?php echo APP_NAME; ?> - Administration</h1>
            <div class="admin-nav">
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-home"></i> Retour à l'accueil
                </a>
                <a href="auth.php?action=logout" class="btn btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </header>
        
        <main class="admin-main">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Utilisateurs</h3>
                        <p class="stat-number"><?php echo count($all_users ?? []); ?></p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-image"></i>
                    </div>
                    <div class="stat-content">
                        <h3>Prompts générés</h3>
                        <p class="stat-number"><?php echo $total_prompts ?? 0; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="admin-sections">
                <?php if (!empty($_SESSION['admin_errors']) || !empty($_SESSION['admin_success'])): ?>
                    <div class="admin-notice">
                        <?php if (!empty($_SESSION['admin_errors'])): ?>
                            <div class="error-messages">
                                <?php foreach ($_SESSION['admin_errors'] as $error): ?>
                                    <p><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></p>
                                <?php endforeach; ?>
                            </div>
                            <?php unset($_SESSION['admin_errors']); ?>
                        <?php endif; ?>
                        <?php if (!empty($_SESSION['admin_success'])): ?>
                            <div class="success-message">
                                <p><i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_SESSION['admin_success']); ?></p>
                            </div>
                            <?php unset($_SESSION['admin_success']); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <section class="admin-section">
                    <h2><i class="fas fa-user-shield"></i> Créer un administrateur</h2>
                    <p>Ajoutez un compte admin sans modifier manuellement la base de données.</p>
                    <form method="POST" action="?action=create_admin" class="admin-form">
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
                            <i class="fas fa-plus-circle"></i> Créer un admin
                        </button>
                    </form>
                </section>

                <section class="admin-section">
                    <h2><i class="fas fa-list"></i> Liste des prompts</h2>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Prompt</th>
                                    <th>Utilisateur</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($all_prompts)): ?>
                                    <?php foreach ($all_prompts as $prompt): ?>
                                        <tr>
                                            <td><?php echo $prompt['id']; ?></td>
                                            <td class="prompt-cell"><?php echo htmlspecialchars(substr($prompt['prompt'], 0, 100)); ?><?php echo strlen($prompt['prompt']) > 100 ? '...' : ''; ?></td>
                                            <td><?php echo htmlspecialchars($prompt['user_name'] ?? 'Utilisateur inconnu'); ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($prompt['created_at'])); ?></td>
                                            <td>
                                                <a href="../vr/scene.html?image=<?php echo urlencode($prompt['image_url']); ?>" target="_blank" class="btn-small">
                                                    <i class="fas fa-eye"></i> Voir
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="empty-table">Aucun prompt généré</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
                
                <section class="admin-section">
                    <h2><i class="fas fa-users"></i> Liste des utilisateurs</h2>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Date d'inscription</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($all_users)): ?>
                                    <?php foreach ($all_users as $user): ?>
                                        <tr>
                                            <td><?php echo $user['id']; ?></td>
                                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td>
                                                <span class="role-badge role-<?php echo $user['role']; ?>">
                                                    <?php echo $user['role']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="empty-table">Aucun utilisateur</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
        
        <footer class="admin-footer">
            <p>Panel d'administration - Scolaris Meta VR &copy; <?php echo date('Y'); ?></p>
        </footer>
    </div>
</body>
</html>