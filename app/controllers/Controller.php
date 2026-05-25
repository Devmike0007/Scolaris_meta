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
?>
