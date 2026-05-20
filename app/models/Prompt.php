<?php
// Modèle Prompt pour gérer les prompts et images
class Prompt {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Créer un nouveau prompt
    public function create($prompt, $image_url, $user_id) {
        $data = [
            'prompt' => $prompt,
            'image_url' => $image_url,
            'user_id' => $user_id,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('prompts', $data);
    }
    
    // Récupérer tous les prompts (pour admin)
    public function getAll() {
        $sql = "SELECT p.*, u.name as user_name, u.email as user_email 
                FROM prompts p 
                LEFT JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC";
        return $this->db->fetchAll($sql);
    }
    
    // Récupérer les prompts d'un utilisateur
    public function getByUser($user_id) {
        $sql = "SELECT * FROM prompts WHERE user_id = :user_id ORDER BY created_at DESC";
        return $this->db->fetchAll($sql, ['user_id' => $user_id]);
    }
    
    // Récupérer un prompt par ID
    public function findById($id) {
        $sql = "SELECT p.*, u.name as user_name 
                FROM prompts p 
                LEFT JOIN users u ON p.user_id = u.id 
                WHERE p.id = :id";
        return $this->db->fetchOne($sql, ['id' => $id]);
    }
    
    // Compter le nombre total de prompts
    public function countAll() {
        $sql = "SELECT COUNT(*) as total FROM prompts";
        $result = $this->db->fetchOne($sql);
        return $result ? $result['total'] : 0;
    }
}
?>