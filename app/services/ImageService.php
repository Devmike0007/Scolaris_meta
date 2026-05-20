<?php
// Service pour générer des images à partir de prompts
class ImageService {
    
    // Générer une image à partir d'un prompt
    public function generateFromPrompt($prompt) {
        // Si une clé Unsplash est configurée, utiliser l'API réelle
        if (!empty(UNSPLASH_ACCESS_KEY)) {
            return $this->getFromUnsplashAPI($prompt);
        }
        
        // Sinon, utiliser une image simulée basée sur le prompt
        return $this->getSimulatedImage($prompt);
    }
    
    // Récupérer une image depuis l'API Unsplash
    private function getFromUnsplashAPI($prompt) {
        $url = UNSPLASH_API_URL . "?query=" . urlencode($prompt) . "&client_id=" . UNSPLASH_ACCESS_KEY;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        
        if (isset($data['urls']['regular'])) {
            return $data['urls']['regular'];
        }
        
        // Fallback si l'API échoue
        return $this->getSimulatedImage($prompt);
    }
    
    // Générer une image simulée basée sur le prompt
    private function getSimulatedImage($prompt) {
        // Mots-clés communs pour déterminer le type d'image
        $keywords = [
            'nature' => ['forêt', 'montagne', 'rivière', 'océan', 'plage', 'arbre', 'fleur'],
            'city' => ['ville', 'bâtiment', 'immeuble', 'rue', 'architecture', 'urban'],
            'space' => ['espace', 'galaxie', 'étoile', 'planète', 'cosmos', 'univers'],
            'abstract' => ['abstrait', 'couleur', 'forme', 'géométrique', 'art']
        ];
        
        // Images de fallback par catégorie
        $fallback_images = [
            'nature' => 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=1200',
            'city' => 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=1200',
            'space' => 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?w-1200',
            'abstract' => 'https://images.unsplash.com/photo-1543857778-c4a1a569e388?w=1200',
            'default' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=1200'
        ];
        
        $prompt_lower = strtolower($prompt);
        
        // Déterminer la catégorie basée sur les mots-clés
        foreach ($keywords as $category => $words) {
            foreach ($words as $word) {
                if (strpos($prompt_lower, $word) !== false) {
                    return $fallback_images[$category];
                }
            }
        }
        
        // Retourner l'image par défaut
        return $fallback_images['default'];
    }
    
    // Sauvegarder une image localement (optionnel)
    public function saveImageLocally($image_url, $prompt) {
        $filename = md5($prompt . time()) . '.jpg';
        $filepath = UPLOAD_DIR . $filename;
        
        $image_data = @file_get_contents($image_url);
        
        if ($image_data !== false) {
            file_put_contents($filepath, $image_data);
            return BASE_URL . 'assets/images/' . $filename;
        }
        
        return $image_url; // Retourner l'URL originale si l'enregistrement échoue
    }
}
?>