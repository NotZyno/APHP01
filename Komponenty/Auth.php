<?php
session_start(); // Tylko raz, na początku

class Auth {
    private $db;
    private $error = false;

    public function __construct($database) {
        $this->db = $database;
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $login = $_POST["login"] ?? null;
            $password = $_POST["password"] ?? null;

            if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
                $this->error = true;
                return;
            }

            if ($login && $password) {
                $stmt = $this->db->prepare("SELECT password FROM user WHERE mail = :userMail");
                $stmt->execute([":userMail" => $login]);
                $result = $stmt->fetch();

                if ($result && password_verify($password, $result["password"])) {
                    $_SESSION["isLogged"] = true;
                    $_SESSION["username"] = $login;

                    // Pobranie uprawnień użytkownika
                    $stmt = $this->db->prepare("
                        SELECT r.permission_name 
                        FROM user u 
                        INNER JOIN permissions r ON u.permission = r.permission_id 
                        WHERE u.mail = :userMail
                    ");
                    $stmt->execute([":userMail" => $login]);
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
                            header("Location: Welcome.php");
                            exit;
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

class Register {
    private $db;
    private $error = false;
    private $errorPoczta = false;

    public function __construct($db) {
        $this->db = $db;
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $login = $_POST["login"] ?? null;
            $username = $_POST["username"] ?? null;
            $password = $_POST["password"] ?? null;
            $confirmPassword = $_POST["confirmPassword"] ?? null;
            $permission = "user";

            if (!$login || !$username || !$password || !$confirmPassword) {
                $this->error = true;
                return;
            }

            if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
                $this->errorPoczta = true;
                return;
            }

            if ($password !== $confirmPassword) {
                $this->error = true;
                return;
            }

            $stmt = $this->db->prepare("SELECT mail FROM user WHERE mail = :userMail");
            $stmt->execute([":userMail" => $login]);
            $result = $stmt->fetch();

            if ($result) {
                $this->error = true;
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $this->db->prepare("
                INSERT INTO user (mail, password, username, permission) 
                VALUES (:userMail, :userPassword, :username, 
                (SELECT permission_id FROM roles WHERE permission_name = :permissionName))
            ");

            $stmt->execute([
                ":userMail" => $login,
                ":userPassword" => $hashedPassword,
                ":username" => $username,
                ":permissionName" => $permission
            ]);

            $_SESSION["isLogged"] = true;
            $_SESSION["permission"] = $permission;

            header("Location: Welcome.php");
            exit;
        }
    }

    public function hasError(): bool {
        return $this->error;
    }

    public function hasEmailError(): bool {
        return $this->errorPoczta;
    }
}
?>
