<?php

class AdminModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getAllUsers() {
        $stmt = $this->db->prepare("SELECT * FROM user");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getUsers($search) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE username LIKE :search");
        $stmt->execute([':search' => "%$search%"]);
        return $stmt->fetchAll();
    }

    public function countAllUsers($search = null) {
        if ($search) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM user WHERE username LIKE :search");
            $stmt->execute([':search' => "%$search%"]);
        } else {
            $stmt = $this->db->query("SELECT COUNT(*) FROM user");
        }
        return $stmt->fetchColumn();
    }
}
?>