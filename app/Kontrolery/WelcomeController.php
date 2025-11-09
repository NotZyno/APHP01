<?php
require_once("../../Models/WelcomeModel.php");

class WelcomeController {
    private $db;
    private $model;
    public $success = true;

    public function __construct($db) {
        $this->db = $db;
        $this->model = new WelcomeModel($db);
        session_start();
    }

    public function handleRequest() {
        if ($_SESSION["isLogged"] === null || $_SESSION["isLogged"] === false) {
            header("Location: login.php");
            exit;
        }
        if ($_SESSION["permission"] !== null) {
            header("Location: ../index.php");
            exit;
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $username = $_POST["username"] ?? "";
            $firstname = $_POST["firstname"] ?? "";
            $lastname = $_POST["lastname"] ?? "";
            $bio = $_POST["bio"] ?? "";
            $file = $_FILES["photo"] ?? null;
            $photoFileName = "profile_picture";

            if ($file && $file["error"] === UPLOAD_ERR_OK) {
                $baseDir = "../../public/uploads/";
                $userDir = $baseDir . $_SESSION["mail"] . "/";
                if (!is_dir($userDir)) {
                    mkdir($userDir, 0755, true);
                }
                
                $ext = strtolower(pathinfo($file["name"], PATHINFO_EXTENSION));
                $dest_path = $userDir . $photoFileName . "." . $ext;
                move_uploaded_file($file["tmp_name"], $dest_path);
                $photoFileName = $photoFileName . "." . $ext;
            }

            $result = $this->model->updateUserProfile(
                $_SESSION["mail"],
                $username,
                $firstname,
                $lastname,
                $bio,
                $photoFileName
            );

            if ($result) {
                $_SESSION["permission"] = "user";
                echo "<h1>Zostałeś poprawnie zarejestrowany!</h1>";
                echo '<script>setTimeout(function(){ window.location.href = "user.php"; }, 5000);</script>';
                exit;
            } else {
                $this->success = false;
            }
        }
    }
}
?>