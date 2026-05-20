<?php
// Classe de connexion à la base de données
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USER,
                DB_PASS
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            log_error("Erreur de connexion à la base de données: " . $e->getMessage());
            die("Erreur de connexion à la base de données. Veuillez réessayer plus tard.");
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Méthode pour exécuter une requête
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch(PDOException $e) {
            log_error("Erreur de requête SQL: " . $e->getMessage());
            return false;
        }
    }
    
    // Méthode pour récupérer une seule ligne
    public function fetchOne($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetch(PDO::FETCH_ASSOC) : false;
    }
    
    // Méthode pour récupérer plusieurs lignes
    public function fetchAll($sql, $params = []) {
        $stmt = $this->query($sql, $params);
        return $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : false;
    }
    
    // Méthode pour insérer une ligne et retourner l'ID
    public function insert($table, $data) {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        
        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($data);
            return $this->connection->lastInsertId();
        } catch(PDOException $e) {
            log_error("Erreur d'insertion: " . $e->getMessage());
            return false;
        }
    }
}
?>