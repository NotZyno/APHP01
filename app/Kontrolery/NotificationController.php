<?php
require_once("../../Models/NotificationModel.php");

class NotificationController {
    private $model;
    public $notifications = [];

    public function __construct($db) {
        $this->model = new NotificationModel($db);
    }
    public function fetch($mail) {
        $this->notifications = $this->model->getUnread($mail);
    }
    public function read($notificationId) {
        $this->model->markAsRead($notificationId);
    }
    public function notify($mail, $type, $content) {
        $this->model->add($mail, $type, $content);
    }
}
?>