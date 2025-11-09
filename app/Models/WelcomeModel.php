<?php

class WelcomeModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function updateUserProfile($mail, $username, $firstname, $lastname, $bio, $photoFileName) {
        $stmt = $this->db->prepare("
            UPDATE user 
            SET 
                username = :username,
                name = :firstname,
                second_name = :lastname,
                biography = :bio,
                profile_picture = :photo,
                permission = 2
            WHERE mail = :mail
        ");
        return $stmt->execute([
            ':username' => $username,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':bio' => $bio,
            ':photo' => $photoFileName,
            ':mail' => $mail
        ]);
    }
}
?>