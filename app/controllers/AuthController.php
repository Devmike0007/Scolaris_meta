<?php
// Contrôleur pour l'authentification
class AuthController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    // Afficher le formulaire d'inscription
    public function showRegister() {
        if (is_logged_in()) {
            redirect('index.php');
        }
        require_once __DIR__ . '/../../public/auth.php';
    }
    
    // Traiter l'inscription
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('auth.php?action=register');
        }
        
        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Validation
        $errors = [];
        
        if (empty($name)) {
            $errors[] = "Le nom est requis";
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email invalide";
        }
        
        if (empty($password)) {
            $errors[] = "Le mot de passe est requis";
        }
        
        if ($password !== $confirm_password) {
            $errors[] = "Les mots de passe ne correspondent pas";
        }
        
        // Vérifier si l'email existe déjà
        if ($this->userModel->findByEmail($email)) {
            $errors[] = "Cet email est déjà utilisé";
        }
        
        if (empty($errors)) {
            $user_id = $this->userModel->create($name, $email, $password);
            
            if ($user_id) {
                // Connecter automatiquement l'utilisateur
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $name;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_role'] = 'user';
                
                redirect('index.php');
            } else {
                $errors[] = "Erreur lors de l'inscription";
            }
        }
        
        // Afficher les erreurs
        $_SESSION['errors'] = $errors;
        redirect('auth.php?action=register');
    }
    
    // Afficher le formulaire de connexion
    public function showLogin() {
        if (is_logged_in()) {
            redirect('index.php');
        }
        require_once __DIR__ . '/../../public/auth.php';
    }
    
    // Traiter la connexion
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('auth.php?action=login');
        }
        
        $email = sanitize($_POST['email']);
        $password = $_POST['password'];
        
        $user = $this->userModel->verify($email, $password);
        
        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role'];
            
            redirect('index.php');
        } else {
            $_SESSION['errors'] = ["Email ou mot de passe incorrect"];
            redirect('auth.php?action=login');
        }
    }
    
    // Déconnexion
    public function logout() {
        session_destroy();
        redirect('auth.php?action=login');
    }
}
?>