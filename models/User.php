<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function register($email, $password, $isAdmin = false) {
        // Vérifier si l'email existe déjà
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            return false;
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // S'assurer que $isAdmin est un booléen
        $isAdmin = (bool)$isAdmin;

        // Insertion du nouvel utilisateur
        $stmt = $this->db->prepare("
            INSERT INTO users (email, password, is_admin) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$email, $hashedPassword, $isAdmin]);
    }

    public function login($email, $password) {
        $stmt = $this->db->prepare("
            SELECT id, email, password, is_admin 
            FROM users 
            WHERE email = ?
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Ne pas retourner le mot de passe
            unset($user['password']);
            return $user;
        }
        return false;
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT id, email, is_admin, created_at 
            FROM users 
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getUserByRememberToken($token) {
        $stmt = $this->db->prepare("
            SELECT id, email, is_admin 
            FROM users 
            WHERE remember_token = ?
        ");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    public function getAllUsers() {
        $stmt = $this->db->query("
            SELECT id, email, is_admin, created_at 
            FROM users 
            ORDER BY created_at DESC
        ");
        return $stmt->fetchAll();
    }
}
