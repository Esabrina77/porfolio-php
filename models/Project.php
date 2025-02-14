<?php
require_once __DIR__ . '/../config/database.php';

class Project {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $stmt = $this->db->getConnection()->query("SELECT * FROM projects ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getUserProjects($userId) {
        $sql = "SELECT * FROM projects WHERE user_id = ? ORDER BY created_at DESC";
        return $this->db->query($sql, [$userId])->fetchAll();
    }

    public function addProject($userId, $title, $description, $imageUrl = null, $externalLink = null) {
        $sql = "INSERT INTO projects (user_id, title, description, image_url, external_link) 
                VALUES (?, ?, ?, ?, ?)";
        return $this->db->query($sql, [$userId, $title, $description, $imageUrl, $externalLink]);
    }

    public function updateProject($id, $title, $description, $imageUrl = null, $externalLink = null) {
        $sql = "UPDATE projects 
                SET title = ?, description = ?, image_url = ?, external_link = ? 
                WHERE id = ?";
        return $this->db->query($sql, [$title, $description, $imageUrl, $externalLink, $id]);
    }

    public function deleteProject($id, $userId) {
        $sql = "DELETE FROM projects WHERE id = ? AND user_id = ?";
        return $this->db->query($sql, [$id, $userId]);
    }

    public function getProject($id) {
        $sql = "SELECT * FROM projects WHERE id = ?";
        return $this->db->query($sql, [$id])->fetch();
    }

    public function getAllProjects() {
        $sql = "SELECT p.*, u.email as user_email 
                FROM projects p 
                JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function create($userId, $title, $description, $imagePath = null, $externalLink = null) {
        $sql = "INSERT INTO projects (user_id, title, description, image_path, external_link) 
                VALUES (?, ?, ?, ?, ?)";
        
        return $this->db->query($sql, [
            $userId,
            $title,
            $description,
            $imagePath,
            $externalLink
        ]);
    }

    public function update($id, $title, $description, $imagePath = null, $externalLink = null) {
        $sql = "UPDATE projects 
                SET title = ?, description = ?, image_path = ?, external_link = ? 
                WHERE id = ?";
        
        return $this->db->query($sql, [
            $title,
            $description,
            $imagePath,
            $externalLink,
            $id
        ]);
    }
}
