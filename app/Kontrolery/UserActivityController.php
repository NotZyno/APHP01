<?php
require_once("../../Models/UserActivityModel.php");

class UserActivityController {
    private $model;
    public $activities = [];

    public function __construct($db) {
        $this->model = new UserActivityModel($db);
    }
    public function log($mail, $type) {
        $this->model->add($mail, $type);
    }
    public function fetch($mail, $limit = 10) {
        $this->activities = $this->model->getRecent($mail, $limit);
    }
}
?>