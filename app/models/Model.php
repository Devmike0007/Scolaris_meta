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
    private static function getUsersFilePath() {
        return dirname(__DIR__) . '/data/users.json';
    }

    private static function loadUsers() {
        $file = self::getUsersFilePath();

        if (!file_exists($file)) {
            return [];
        }

        $content = file_get_contents($file);
        $users = json_decode($content, true);

        return is_array($users) ? $users : [];
    }

    private static function saveUsers(array $users) {
        $file = self::getUsersFilePath();
        $dir = dirname($file);

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        return file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT)) !== false;
    }

    public static function login($email, $password) {
        if ($email === ADMIN_EMAIL && $password === ADMIN_PASSWORD) {
            return [
                'id' => 1,
                'name' => 'Admin',
                'is_admin' => true
            ];
        }

        $users = self::loadUsers();

        foreach ($users as $user) {
            if (isset($user['email']) && strtolower($user['email']) === strtolower($email)) {
                if (isset($user['password']) && password_verify($password, $user['password'])) {
                    return [
                        'id' => $user['id'],
                        'name' => trim(($user['nom'] ?? '') . ' ' . ($user['prenom'] ?? '')) ?: $user['email'],
                        'is_admin' => !empty($user['is_admin'])
                    ];
                }
                break;
            }
        }

        return null;
    }

    public static function register($nom, $prenom, $email, $passwordHash, $is_admin = false) {
        $users = self::loadUsers();

        foreach ($users as $user) {
            if (isset($user['email']) && strtolower($user['email']) === strtolower($email)) {
                return false;
            }
        }

        $nextId = 1;
        if (!empty($users)) {
            $ids = array_column($users, 'id');
            $nextId = max($ids) + 1;
        }

        $users[] = [
            'id' => $nextId,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'password' => $passwordHash,
            'is_admin' => !empty($is_admin)
        ];

        return self::saveUsers($users);
    }
}
?>

