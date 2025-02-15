-- Création de la base de données
CREATE DATABASE IF NOT EXISTS projetb2;

-- Création de l'utilisateur
CREATE USER IF NOT EXISTS 'projetb2'@'localhost' IDENTIFIED BY 'password';

-- Attribution des privilèges
GRANT ALL PRIVILEGES ON projetb2.* TO 'projetb2'@'localhost';
FLUSH PRIVILEGES;

USE projetb2;

-- Structure des tables
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE skills (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE user_skills (
    user_id INT,
    skill_id INT,
    level ENUM('débutant', 'intermédiaire', 'expert'),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES skills(id) ON DELETE CASCADE,
    PRIMARY KEY (user_id, skill_id)
);

CREATE TABLE projects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_path VARCHAR(255),
    external_link VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Insertion des données de test
INSERT INTO users (email, password, is_admin) VALUES
('admin@example.com', '$2y$10$1CAQa77QW8Qv6y7yImdkZuOxPFkQyifoWJ38vDNpcmkZkf9R8tTFW', TRUE),  -- mot de passe réel
('user@example.com', '$2y$10$FUjrFcJ/dfsNsNYOn1yUeOhvGWHZMyxwnaiB1EW9oeqaTjM3Z5dR.', FALSE);  -- mot de passe réel

-- Insertion de quelques compétences
INSERT INTO skills (name, description) VALUES
('PHP', 'Langage de programmation côté serveur'),
('MySQL', 'Système de gestion de base de données'),
('HTML/CSS', 'Langages de balisage et de style'),
('JavaScript', 'Langage de programmation côté client');
