<?php
require_once __DIR__ . '/../config/database.php';

class Skill {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllSkills() {
        $sql = "SELECT * FROM skills ORDER BY name";
        return $this->db->query($sql)->fetchAll();
    }

    public function getUserSkills($userId) {
        $sql = "SELECT s.*, us.level 
                FROM skills s 
                JOIN user_skills us ON s.id = us.skill_id 
                WHERE us.user_id = ?";
        return $this->db->query($sql, [$userId])->fetchAll();
    }

    public function addSkill($name) {
        $sql = "INSERT INTO skills (name) VALUES (?)";
        return $this->db->query($sql, [$name]);
    }

    public function addUserSkill($userId, $skillId, $level) {
        $sql = "INSERT INTO user_skills (user_id, skill_id, level) 
                VALUES (?, ?, ?)";
        return $this->db->query($sql, [$userId, $skillId, $level]);
    }

    public function updateUserSkill($userId, $skillId, $level) {
        $sql = "UPDATE user_skills 
                SET level = ? 
                WHERE user_id = ? AND skill_id = ?";
        return $this->db->query($sql, [$level, $userId, $skillId]);
    }

    public function removeUserSkill($userId, $skillId) {
        $sql = "DELETE FROM user_skills 
                WHERE user_id = ? AND skill_id = ?";
        return $this->db->query($sql, [$userId, $skillId]);
    }

    public function deleteSkill($id) {
        $sql = "DELETE FROM skills WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function updateSkill($id, $name, $description) {
        $sql = "UPDATE skills SET name = ?, description = ? WHERE id = ?";
        return $this->db->query($sql, [$name, $description, $id]);
    }

    public function getSkillById($id) {
        $sql = "SELECT * FROM skills WHERE id = ?";
        return $this->db->query($sql, [$id])->fetch();
    }

    public function getSkillUsers($skillId) {
        $sql = "SELECT u.id, u.email, us.level 
                FROM users u 
                JOIN user_skills us ON u.id = us.user_id 
                WHERE us.skill_id = ?
                ORDER BY u.email";
        return $this->db->query($sql, [$skillId])->fetchAll();
    }
}
