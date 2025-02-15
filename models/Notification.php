<?php
class Notification {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($user_id, $message, $type = 'info') {
        $sql = "INSERT INTO notifications (user_id, message, type) VALUES (?, ?, ?)";
        return $this->db->prepare($sql)->execute([$user_id, $message, $type]);
    }

    public function getUnread($user_id) {
        $sql = "SELECT * FROM notifications WHERE user_id = ? AND read_at IS NULL ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll();
    }
} 