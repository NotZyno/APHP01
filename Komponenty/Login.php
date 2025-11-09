<?php

class Auth {
    private $db;
    private $error = false;

    public function __construct($db) {
        $this->db = $db;
        session_start();
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $mail = $_POST["login"] ?? null;
            $password = $_POST["password"] ?? null;

            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $this->error = true;
                return;
            }

            if ($mail && $password) {
                $stmt = $this->db->prepare("SELECT password FROM user WHERE mail = :userMail");
                $stmt->execute([":userMail" => $mail]);
                $result = $stmt->fetch();

                if ($result){
                    if(password_verify($password, $result["password"])) {
                        $_SESSION["isLogged"] = true;
                        $_SESSION["mail"] = $mail;
                        
                        // Pobranie uprawnień użytkownika
                        $stmt = $this->db->prepare("
                            SELECT r.permission_name 
                            FROM user u 
                            INNER JOIN permission r ON u.permission = r.permission_id 
                            WHERE u.mail = :userMail
                        ");
                        $stmt->execute([":userMail" => $mail]);
                        $permissionResult = $stmt->fetch();

                        if ($permissionResult) {
                            $_SESSION["permission"] = $permissionResult["permission_name"];

                            if ($_SESSION["permission"] === "admin") {
                                header("Location: Admin.php");
                                exit;
                            } else if ($_SESSION["permission"] === "user") {
                                header("Location: user.php");
                                exit;
                            } else {
                                header("Location: welcome.php");
                                exit;
                            }
                        } else {
                            header("Location: welcome.php");
                        }
                    } else {
                        $this->error = true;
                    }
                } else {
                    $this->error = true;
                }
            } else {
                $this->error = true;
            }
        }
    }

    public function hasError() {
        return $this->error;
    }
}
?>