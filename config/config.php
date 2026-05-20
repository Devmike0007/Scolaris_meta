<?php
// Configuration de l'application Scolaris Meta VR

// Activer l'affichage des erreurs pour le débogage
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'scolaris_meta_vr');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuration de l'application
define('APP_NAME', 'Scolaris Meta VR');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/Scolaris_vr/public/');

// Identifiants admin par défaut
define('DEFAULT_ADMIN_NAME', 'Dev Mike');
define('DEFAULT_ADMIN_EMAIL', 'devmike@gmail.com');
define('DEFAULT_ADMIN_PASSWORD', '87654321');

// Configuration de l'API Unsplash (simulée si non configurée)
define('UNSPLASH_ACCESS_KEY', '');
define('UNSPLASH_API_URL', 'https://api.unsplash.com/photos/random');

// Dossiers
define('UPLOAD_DIR', __DIR__ . '/../storage/uploads/');
define('LOG_FILE', __DIR__ . '/../storage/logs.txt');

// Démarrer la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Créer un admin par défaut si le compte n'existe pas encore
function ensure_default_admin_exists() {
    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER,
            DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        $stmt = $pdo->prepare('SELECT id, password FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => DEFAULT_ADMIN_EMAIL]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $hashedPassword = password_hash(DEFAULT_ADMIN_PASSWORD, PASSWORD_DEFAULT);
            $insert = $pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)');
            $insert->execute([
                'name' => DEFAULT_ADMIN_NAME,
                'email' => DEFAULT_ADMIN_EMAIL,
                'password' => $hashedPassword,
                'role' => 'admin'
            ]);
        } else {
            if (!password_verify(DEFAULT_ADMIN_PASSWORD, $user['password'])) {
                $hashedPassword = password_hash(DEFAULT_ADMIN_PASSWORD, PASSWORD_DEFAULT);
                $update = $pdo->prepare('UPDATE users SET password = :password WHERE id = :id');
                $update->execute([
                    'password' => $hashedPassword,
                    'id' => $user['id']
                ]);
            }
        }
    } catch (PDOException $e) {
        // Ignorer si la base n'existe pas encore ou si la connexion échoue
    }
}

ensure_default_admin_exists();

// Fonction pour logger les erreurs
function log_error($message) {
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] $message\n";
    @file_put_contents(LOG_FILE, $log_message, FILE_APPEND);
}

// Fonction pour rediriger
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

// Fonction pour vérifier si l'utilisateur est connecté
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Fonction pour vérifier si l'utilisateur est admin
function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

// Fonction pour sécuriser les données
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Fonction pour obtenir l'URL de base
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\'));
?>