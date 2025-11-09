<?php 
class Register {
    private $db;
    private $error = false;
    private $errorPoczta = false;
    private $duplicateEmail = false;

    public function __construct($db) {
        $this->db = $db;
        session_start();
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $mail = $_POST["login"] ?? null;
            $username = $_POST["username"] ?? null;
            $password = $_POST["password"] ?? null;
            $confirmPassword = $_POST["confirmPassword"] ?? null;
            $permission = "user";

            if ($mail === null|| $username === null|| $password === null || $confirmPassword === null) {
                $this->error = true;
                return;
            }

            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $this->errorPoczta = true;
                return;
            }

            if ($password !== $confirmPassword) {
                $this->error = true;
                return;
            }

            $stmt = $this->db->prepare("SELECT mail FROM user WHERE mail = :userMail");
            $stmt->execute([":userMail" => $mail]);
            $result = $stmt->fetch();

            if ($result) {
                $this->duplicateEmail = true;
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $this->db->prepare("
                INSERT INTO user (mail, password, username) 
                VALUES (:userMail, :userPassword, :username)
            ");

            $stmt->execute([
                ":userMail" => $mail,
                ":userPassword" => $hashedPassword,
                ":username" => $username,
            ]);

            $_SESSION["isLogged"] = true;
            $_SESSION["permission"] = null;
            $_SESSION["username"] = $username;
            $_SESSION["mail"] = $mail;
            header("Location: welcome.php");
            exit;
        }
    }

    public function hasError(): bool {
        return $this->error;
    }

    public function hasEmailError(): bool {
        return $this->errorPoczta;
    }

    public function hasDuplicateEmail(): bool {
        return $this->duplicateEmail;
    }
}
?>