<?php
require_once("../../Models/AdminEditModel.php");

class AdminEditController {
    private $db;
    private $model;
    public $user = [];
    public $success = false;
    public $error = false;

    public function __construct($db) {
        $this->db = $db;
        $this->model = new AdminEditModel($db);
    }

    public function handleRequest() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $mail = $_POST["edit_mail"];
            $username = $_POST["edit_username"];
            $password = $_POST["edit_password"] ?? null;

            $result = $this->model->updateUser($mail, $username, $password);
            $this->success = $result;
            $this->error = !$result;
            $this->user = $this->model->getUserByMail($mail);
        } elseif (isset($_GET["mail"])) {
            $this->user = $this->model->getUserByMail($_GET["mail"]);
        }
    }
}
?>