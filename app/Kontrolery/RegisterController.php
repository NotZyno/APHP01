<?php
require_once("../../Models/RegisterModel.php");

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

            if ($mail === null || $username === null || $password === null || $confirmPassword === null) {
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

            $registerModel = new RegisterModel($this->db);

            if ($registerModel->emailExists($mail)) {
                $this->duplicateEmail = true;
                return;
            }

            if ($registerModel->createUser($mail, $username, $password)) {
                $_SESSION["isLogged"] = true;
                $_SESSION["permission"] = null;
                $_SESSION["username"] = $username;
                $_SESSION["mail"] = $mail;
                header("Location: welcome.php");
                exit;
            } else {
                $this->error = true;
            }
        }
    }

    public function hasError() {
        return $this->error;
    }

    public function hasEmailError() {
        return $this->errorPoczta;
    }

    public function hasDuplicateEmail() {
        return $this->duplicateEmail;
    }
}
?>