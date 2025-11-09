<?php
class AdminEditModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUserByMail($mail) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE mail = :mail");
        $stmt->execute([":mail" => $mail]);
        return $stmt->fetch();
    }

    public function updateUser($mail, $username, $password = null) {
        if ($password) {
            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $this->db->prepare("UPDATE user SET username = :username, password = :password WHERE mail = :mail");
            return $stmt->execute([
                ":username" => $username,
                ":password" => $hashed,
                ":mail" => $mail
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE user SET username = :username WHERE mail = :mail");
            return $stmt->execute([
                ":username" => $username,
                ":mail" => $mail
            ]);
        }
    }
}
?>