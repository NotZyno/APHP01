<?php

class SettingsModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getUser($mail) {
        $stmt = $this->db->prepare("SELECT username, mail FROM user WHERE mail = :mail");
        $stmt->execute([":mail" => $mail]);
        return $stmt->fetch();
    }

    public function updateUser($mail, $username = null,  $password = null) {

        switch(true)
        {
            case $username !== null && $password !== null:
                    $hashed = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $this->db->prepare("UPDATE user SET username = :username, password = :password WHERE mail = :mail");
                    return $stmt->execute([
                    ":username" => $username,
                    ":mail" => $mail,
                    ":password" => $hashed
                    ]);
                break;
            case $username !== null:
                    $stmt = $this->db->prepare("UPDATE user SET username = :username WHERE mail = :mail");
                    return $stmt->execute([
                    ":username" => $username,
                    ":mail" => $mail
                    ]);
                break;
            case $password !== null:
                    $hashed = password_hash($password, PASSWORD_BCRYPT);
                    $stmt = $this->db->prepare("UPDATE user SET password = :password WHERE mail = :mail");
                    return $stmt->execute([
                    ":mail" => $mail,
                    ":password" => $hashed
                     ]);
                break;
            default:
            return false;
        }
    }
}
?>