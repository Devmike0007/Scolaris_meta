<?php
// API endpoints pour Scolaris Meta VR
// Accédez à : http://localhost/Scolaris_vr/public/api.php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Prompt.php';
require_once __DIR__ . '/../app/services/ImageService.php';

header('Content-Type: application/json');

// Fonction pour envoyer une réponse JSON
function json_response($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

// Récupérer la méthode et l'endpoint
$method = $_SERVER['REQUEST_METHOD'];
$endpoint = $_GET['endpoint'] ?? '';

// Routes API
switch ($endpoint) {
    case 'generate':
        if ($method !== 'POST') {
            json_response(['error' => 'Méthode non autorisée'], 405);
        }
        
        // Vérifier l'authentification
        session_start();
        if (!isset($_SESSION['user_id'])) {
            json_response(['error' => 'Non authentifié'], 401);
        }
        
        $data = json_decode(file_get_contents('php://input'), true);
        $prompt = sanitize($data['prompt'] ?? '');
        
        if (empty($prompt)) {
            json_response(['error' => 'Prompt requis'], 400);
        }
        
        // Générer l'image
        $imageService = new ImageService();
        $image_url = $imageService->generateFromPrompt($prompt);
        
        // Sauvegarder en base
        $promptModel = new Prompt();
        $prompt_id = $promptModel->create($prompt, $image_url, $_SESSION['user_id']);
        
        json_response([
            'success' => true,
            'data' => [
                'prompt_id' => $prompt_id,
                'image_url' => $image_url,
                'vr_url' => BASE_URL . '../vr/scene.html?image=' . urlencode($image_url)
            ]
        ]);
        break;
        
    case 'history':
        if ($method !== 'GET') {
            json_response(['error' => 'Méthode non autorisée'], 405);
        }
        
        session_start();
        if (!isset($_SESSION['user_id'])) {
            json_response(['error' => 'Non authentifié'], 401);
        }
        
        $promptModel = new Prompt();
        $prompts = $promptModel->getByUser($_SESSION['user_id']);
        
        json_response([
            'success' => true,
            'data' => $prompts
        ]);
        break;
        
    case 'status':
        json_response([
            'success' => true,
            'api' => 'Scolaris Meta VR API',
            'version' => '1.0.0',
            'endpoints' => [
                'POST /api.php?endpoint=generate' => 'Générer une image',
                'GET /api.php?endpoint=history' => 'Récupérer l\'historique',
                'GET /api.php?endpoint=status' => 'Statut de l\'API'
            ]
        ]);
        break;
        
    default:
        json_response([
            'error' => 'Endpoint non trouvé',
            'available_endpoints' => [
                'generate' => 'POST - Générer une image',
                'history' => 'GET - Historique des prompts',
                'status' => 'GET - Statut de l\'API'
            ]
        ], 404);
        break;
}
?>