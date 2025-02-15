<?php

class SearchController {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function search() {
        if (!isset($_GET['q']) || strlen($_GET['q']) < 2) {
            return ['error' => 'Veuillez entrer au moins 2 caractères'];
        }

        $query = '%' . $_GET['q'] . '%';
        $results = [
            'projects' => $this->searchProjects($query),
            'skills' => $this->searchSkills($query)
        ];

        return $results;
    }

    private function searchProjects($query) {
        $sql = "SELECT * FROM projects 
                WHERE title LIKE ? 
                OR description LIKE ? 
                ORDER BY created_at DESC 
                LIMIT 10";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$query, $query]);
        return $stmt->fetchAll();
    }

    private function searchSkills($query) {
        $sql = "SELECT * FROM skills 
                WHERE name LIKE ? 
                OR description LIKE ? 
                ORDER BY name ASC 
                LIMIT 10";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$query, $query]);
        return $stmt->fetchAll();
    }
} 