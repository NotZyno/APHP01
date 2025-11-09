<?php
require_once("../../Models/UserModel.php");

class UserController {
    private $db;
    private $model;
    public $userData = [];

    public function __construct($db) {
        $this->db = $db;
        $this->model = new UserModel($db);
    }

    public function handleRequest($mail) {
        $this->userData = $this->model->getUserData($mail);
    }
}
?>