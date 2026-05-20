<?php
// Contrôleur pour gérer les prompts
class PromptController {
    private $promptModel;
    private $imageService;
    
    public function __construct() {
        $this->promptModel = new Prompt();
        $this->imageService = new ImageService();
    }
    
    // Afficher l'interface principale
    public function index() {
        if (!is_logged_in()) {
            redirect('auth.php?action=login');
        }
        
        // Récupérer l'historique de l'utilisateur
        $user_prompts = $this->promptModel->getByUser($_SESSION['user_id']);
        
        require_once __DIR__ . '/../../public/index.php';
    }
    
    // Traiter la génération d'image
    public function generate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('index.php');
        }
        
        if (!is_logged_in()) {
            http_response_code(401);
            echo json_encode(['error' => 'Non authentifié']);
            exit();
        }
        
        $prompt = sanitize($_POST['prompt']);
        
        if (empty($prompt)) {
            http_response_code(400);
            echo json_encode(['error' => 'Le prompt est requis']);
            exit();
        }
        
        // Générer l'image
        $image_url = $this->imageService->generateFromPrompt($prompt);
        
        // Sauvegarder en base de données
        $prompt_id = $this->promptModel->create($prompt, $image_url, $_SESSION['user_id']);
        
        // Retourner la réponse JSON
        echo json_encode([
            'success' => true,
            'image_url' => $image_url,
            'prompt_id' => $prompt_id,
            'vr_url' => BASE_URL . '../vr/scene.html?image=' . urlencode($image_url)
        ]);
    }
    
    // API pour récupérer l'historique
    public function getHistory() {
        if (!is_logged_in()) {
            http_response_code(401);
            echo json_encode(['error' => 'Non authentifié']);
            exit();
        }
        
        $user_prompts = $this->promptModel->getByUser($_SESSION['user_id']);
        
        echo json_encode([
            'success' => true,
            'prompts' => $user_prompts
        ]);
    }
}
?>