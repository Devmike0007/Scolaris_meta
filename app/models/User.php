<?php
// Modèle User pour gérer les utilisateurs
class User {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    // Créer un nouvel utilisateur
    public function create($name, $email, $password, $role = 'user') {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password,
            'role' => $role,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('users', $data);
    }
    
    // Trouver un utilisateur par email
    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = :email";
        return $this->db->fetchOne($sql, ['email' => $email]);
    }
    
    // Trouver un utilisateur par ID
    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        return $this->db->fetchOne($sql, ['id' => $id]);
    }
    
    // Vérifier les identifiants
    public function verify($email, $password) {
        $user = $this->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    // Récupérer tous les utilisateurs (pour admin)
    public function getAll() {
        $sql = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
        return $this->db->fetchAll($sql);
    }
}
?>