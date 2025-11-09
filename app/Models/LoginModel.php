<?php
class LoginModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserByEmail($email) {
        $stmt = $this->db->prepare("SELECT password, username FROM user WHERE mail = :email");
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
}
?>