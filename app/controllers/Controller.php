<?php
// Controller - Logique de contrôle
class AuthController {
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = UserModel::login($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['is_admin'] = $user['is_admin'];
                redirect('../../public/index.php');
            } else {
                redirect('auth.php?action=login&error=1');
            }
        }
    }
    
    public function logout() {
        session_destroy();
        redirect('auth.php?action=login');
    }
    public function register() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        $type = $_POST['type'] ?? 'user';

        // Vérification mot de passe
        if ($password !== $confirm) {
            redirect('auth.php?action=register&error=password');
            return;
        }

        // Hash du mot de passe (important 🔐)
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Vérifier si admin
        $is_admin = 0;
        if ($type === 'admin') {
            $code_admin = $_POST['code_admin'] ?? '';

            if ($code_admin !== "123456") { // ton code secret
                redirect('auth.php?action=register&error=admin');
                return;
            }

            $is_admin = 1;
        }

        // Enregistrer utilisateur
        $result = UserModel::register($nom, $prenom, $email, $passwordHash, $is_admin);

        if ($result) {
            redirect('auth.php?action=login&success=1');
        } else {
            redirect('auth.php?action=register&error=1');
        }
    }
}
}

class ImageController {
    public function generate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return null;
        }
        
        if (!is_logged_in()) {
            redirect('../../app/auth/auth.php?action=login');
        }
        
        $prompt = trim($_POST['prompt'] ?? '');
        
        if (!empty($prompt)) {
            $image = ImageModel::generate($prompt);
            return [
                'image' => $image,
                'prompt' => $prompt
            ];
        }
        
        return null;
    }
}



