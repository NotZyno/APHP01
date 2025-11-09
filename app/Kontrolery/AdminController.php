<?php
require_once("../../Models/AdminModel.php");

class AdminController {
    private $db;
    private $model;
    public $users = [];
    public $totalUsers = 0;

    public function __construct($db) {
        $this->db = $db;
        $this->model = new AdminModel($db);
    }

    public function handleRequest() {
        if (!isset($_SESSION["isLogged"]) || $_SESSION["permission"] !== "admin") {
            header("Location: login.php");
            exit;
        }
        $search = $_POST["search"] ?? null;
        if ($search && $search !== "") {
            $this->users = $this->model->getUsers($search);
            $this->totalUsers = $this->model->countAllUsers($search);
        } else {
            $this->users = $this->model->getAllUsers();
            $this->totalUsers = $this->model->countAllUsers();
        }
    }
}
?>