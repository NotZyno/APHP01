<?php
require_once("../../Models/LoginModel.php");
require_once("../../Kontrolery/UserActivityController.php");

class Auth {
    private $db;
    private $error = false;
    public $username;

    public function __construct($db) {
        $this->db = $db;
        session_start();
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $mail = $_POST["login"] ?? null;
            $password = $_POST["password"] ?? null;

            if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $this->error = true;
                return;
            }

            $loginModel = new LoginModel($this->db);

            $result = $loginModel->getUserByEmail($mail);

            if ($result && password_verify($password, $result["password"])) {
                $_SESSION["isLogged"] = true;
                $_SESSION["mail"] = $mail;
                $_SESSION["username"] = $result["username"];

                $permission = $loginModel->getPermission($mail);
                $_SESSION["permission"] = $permission;

                // Log user activity
                $activityController = new UserActivityController($this->db);
                $activityController->log($mail, 'login');

                if ($permission === "admin") {
                    header("Location: Admin.php");
                    exit;
                } else if ($permission === "user") {
                    header("Location: user.php");
                    exit;
                } else {
                    header("Location: welcome.php");
                    exit;
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