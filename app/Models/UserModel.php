<?php

class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE mail = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function getPermission($email) {
        $stmt = $this->db->prepare("
            SELECT r.permission_name 
            FROM user u 
            INNER JOIN permission r ON u.permission = r.permission_id 
            WHERE u.mail = :email
        ");
        $stmt->execute([':email' => $email]);
        $result = $stmt->fetch();
        return $result['permission_name'] ?? 'user';
    }

    public function getUserData($mail) {
        $stmt = $this->db->prepare("SELECT username, mail, name, second_name, biography FROM user WHERE mail = :mail");
        $stmt->execute([':mail' => $mail]);
        return $stmt->fetch();
    }
}
?>