<?php
// Contrôleur pour l'administration
class AdminController {
    private $userModel;
    private $promptModel;
    
    public function __construct() {
        $this->userModel = new User();
        $this->promptModel = new Prompt();
    }
    
    // Afficher le tableau de bord admin
    public function index() {
        if (!is_logged_in() || !is_admin()) {
            redirect('index.php');
        }
        
        // Récupérer les statistiques
        $GLOBALS['total_prompts'] = $this->promptModel->countAll();
        $GLOBALS['all_prompts'] = $this->promptModel->getAll();
        $GLOBALS['all_users'] = $this->userModel->getAll();
    }

    // Créer un nouvel administrateur
    public function createAdmin() {
        if (!is_logged_in() || !is_admin()) {
            redirect('index.php');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('admin.php');
        }

        $name = sanitize($_POST['name'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        $errors = [];

        if (empty($name)) {
            $errors[] = 'Le nom est requis.';
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email invalide.';
        }

        if (empty($password)) {
            $errors[] = 'Le mot de passe est requis.';
        }

        if ($password !== $confirm_password) {
            $errors[] = 'Les mots de passe ne correspondent pas.';
        }

        if ($this->userModel->findByEmail($email)) {
            $errors[] = 'Cet email est déjà utilisé.';
        }

        if (!empty($errors)) {
            $_SESSION['admin_errors'] = $errors;
            redirect('admin.php');
        }

        $this->userModel->create($name, $email, $password, 'admin');
        $_SESSION['admin_success'] = 'Le compte administrateur a bien été créé.';
        redirect('admin.php');
    }
}
?>