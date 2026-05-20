-- Script SQL pour Scolaris Meta VR
-- Création de la base de données et des tables

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS scolaris_meta_vr;
USE scolaris_meta_vr;

-- Table des utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table des prompts
CREATE TABLE prompts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prompt TEXT NOT NULL,
    image_url TEXT NOT NULL,
    user_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insérer un utilisateur admin par défaut (mot de passe: admin123)
INSERT INTO users (name, email, password, role) VALUES
('Administrateur', 'admin@scolaris.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insérer un utilisateur test (mot de passe: user123)
INSERT INTO users (name, email, password, role) VALUES
('Utilisateur Test', 'user@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

-- Insérer des données de test pour les prompts
INSERT INTO prompts (prompt, image_url, user_id) VALUES
('Une forêt enchantée au coucher du soleil', 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=1200', 2),
('Une ville futuriste la nuit', 'https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?w=1200', 2),
('Une galaxie lointaine avec des nébuleuses colorées', 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?w=1200', 2),
('Un paysage de montagne enneigé', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200', 2),
('Une plage tropicale avec des palmiers', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200', 2);

-- Créer des index pour améliorer les performances
CREATE INDEX idx_user_id ON prompts(user_id);
CREATE INDEX idx_created_at ON prompts(created_at);
CREATE INDEX idx_user_email ON users(email);

-- Afficher les informations de la base de données
SELECT 'Base de données créée avec succès!' as message;
SELECT COUNT(*) as total_users FROM users;
SELECT COUNT(*) as total_prompts FROM prompts;

-- Note: Les mots de passe hashés sont générés avec password_hash('admin123', PASSWORD_DEFAULT)
-- et password_hash('user123', PASSWORD_DEFAULT)