<?php

class RegisterModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT mail FROM user WHERE mail = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }

    public function createUser($email, $username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("
            INSERT INTO user (mail, password, username) 
            VALUES (:email, :password, :username)
        ");
        return $stmt->execute([
            ':email' => $email,
            ':password' => $hashedPassword,
            ':username' => $username
        ]);
    }
}
?>