<?php
// Version simplifiée de Scolaris Meta VR
// Accédez à : http://localhost/Scolaris_vr/index_simple.php

// Configuration simple
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion base de données
try {
    $pdo = new PDO("mysql:host=localhost;dbname=scolaris_meta_vr;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur base de données: " . $e->getMessage());
}

// Fonctions utilitaires
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Images de fallback
$fallback_images = [
    'nature' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=1200',
    'city' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=1200',
    'space' => 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?w=1200',
    'default' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1200'
];

// Traitement des actions
$action = $_GET['action'] ?? '';

if ($action === 'generate' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Générer une image
    $prompt = sanitize($_POST['prompt'] ?? '');
    
    // Simuler une image basée sur le prompt
    $prompt_lower = strtolower($prompt);
    if (strpos($prompt_lower, 'forêt') !== false || strpos($prompt_lower, 'nature') !== false) {
        $image_url = $fallback_images['nature'];
    } elseif (strpos($prompt_lower, 'ville') !== false || strpos($prompt_lower, 'city') !== false) {
        $image_url = $fallback_images['city'];
    } elseif (strpos($prompt_lower, 'espace') !== false || strpos($prompt_lower, 'space') !== false) {
        $image_url = $fallback_images['space'];
    } else {
        $image_url = $fallback_images['default'];
    }
    
    // Sauvegarder en base (simplifié)
    $stmt = $pdo->prepare("INSERT INTO prompts (prompt, image_url, user_id) VALUES (?, ?, 2)");
    $stmt->execute([$prompt, $image_url]);
    
    // Retourner JSON
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'image_url' => $image_url,
        'vr_url' => 'vr/scene.html?image=' . urlencode($image_url)
    ]);
    exit;
}

// Interface HTML
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scolaris Meta VR - Version Simplifiée</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #667eea; color: white; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; color: #333; border-radius: 10px; padding: 30px; }
        h1 { color: #4a5568; margin-bottom: 20px; }
        textarea { width: 100%; padding: 15px; border: 2px solid #e2e8f0; border-radius: 8px; margin: 20px 0; }
        button { background: #48bb78; color: white; border: none; padding: 15px 30px; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #38a169; }
        .result { margin-top: 30px; padding: 20px; background: #f7fafc; border-radius: 8px; }
        .result img { max-width: 100%; height: 300px; object-fit: cover; border-radius: 8px; }
        .links { margin-top: 20px; }
        .links a { display: inline-block; margin-right: 10px; padding: 10px 20px; background: #667eea; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎮 Scolaris Meta VR - Version Simplifiée</h1>
        <p>Cette version contourne les problèmes de configuration Apache.</p>
        
        <div class="generator">
            <h2>Générateur d'images VR</h2>
            <textarea id="prompt" placeholder="Décrivez votre scène (ex: Une forêt enchantée au coucher du soleil)" rows="4"></textarea>
            <button onclick="generateImage()">✨ Générer l'image</button>
        </div>
        
        <div class="result" id="result" style="display: none;">
            <h3>Votre image générée :</h3>
            <img id="generated-image" src="" alt="Image générée">
            <div class="links">
                <a id="vr-link" href="#" target="_blank">👓 Voir en VR</a>
                <a href="vr/scene.html" target="_blank">🌐 Scène VR vide</a>
            </div>
        </div>
        
        <div class="instructions" style="margin-top: 30px; padding: 20px; background: #edf2f7; border-radius: 8px;">
            <h3>Instructions :</h3>
            <ol>
                <li>Entrez une description dans le champ texte</li>
                <li>Cliquez sur "Générer l'image"</li>
                <li>Cliquez sur "Voir en VR" pour l'expérience immersive</li>
                <li>Utilisez ZQSD pour vous déplacer dans la scène VR</li>
            </ol>
        </div>
    </div>
    
    <script>
        async function generateImage() {
            const prompt = document.getElementById('prompt').value.trim();
            if (!prompt) {
                alert('Veuillez entrer une description');
                return;
            }
            
            const formData = new FormData();
            formData.append('prompt', prompt);
            
            try {
                const response = await fetch('?action=generate', {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    document.getElementById('generated-image').src = data.image_url;
                    document.getElementById('vr-link').href = data.vr_url;
                    document.getElementById('result').style.display = 'block';
                }
            } catch (error) {
                alert('Erreur: ' + error.message);
            }
        }
    </script>
</body>
</html>