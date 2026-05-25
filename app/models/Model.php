<?php
// Model - Logique métier
class ImageModel {
    public static function generate($prompt) {
        $images = [
            'forêt' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600',
            'montagne' => 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600',
            'plage' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=600',
            'ville' => 'https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?w=600',
            'espace' => 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?w=600',
            'default' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?w=600'
        ];
        
        $prompt_lower = strtolower($prompt);
        
        foreach ($images as $key => $url) {
            if ($key !== 'default' && strpos($prompt_lower, $key) !== false) {
                return $url;
            }
        }
        
        return $images['default'];
    }
}

class UserModel {
    public static function login($email, $password) {
        if ($email === ADMIN_EMAIL && $password === ADMIN_PASSWORD) {
            return [
                'id' => 1,
                'name' => 'Admin',
                'is_admin' => true
            ];
        }
        return null;
    }
}
?>
