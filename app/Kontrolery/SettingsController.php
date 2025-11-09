<?php
require_once("../../Models/SettingsModel.php");
require_once("../../Kontrolery/UserActivityController.php");

class SettingsController {
    private $db;
    private $model;
    public $user = [];
    public $success = false;
    public $error = false;

    public function __construct($db) {
        $this->db = $db;
        $this->model = new SettingsModel($db);
        session_start();
    }

    public function handleRequest() {
        $mail = $_SESSION["mail"] ?? null;
        if (!$mail) {
            header("Location: login.php");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST["username"] ?? "";
            $password = $_POST["password"] ?? null;

            if ($username) {
                $result = $this->model->updateUser($mail, $username, $password);
                if ($result) {
                    $_SESSION["username"] = $username;
                    $this->success = true;
                } else {
                    $this->error = true;
                }
            } else {
                $this->error = true;
            }
        }
        $this->user = $this->model->getUser($_SESSION["mail"]);

        $activityController = new UserActivityController($this->db);
        $activityController->log($_SESSION['mail'], 'profile_edit');
    }
}
?>