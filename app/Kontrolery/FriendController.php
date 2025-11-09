<?php
require_once("../../Models/FriendModel.php");

class FriendController {
    private $model;
    public $friends = [];
    public $pending = [];
    public $relationship = null;

    public function __construct($db) {
        $this->model = new FriendModel($db);
    }

    public function handleRequest($userMail) {
        $this->friends = $this->model->getFriends($userMail);
        $this->pending = $this->model->getPendingRequests($userMail);
    }

    public function sendRequest($userMail, $friendMail) {
        return $this->model->sendRequest($userMail, $friendMail);
    }

    public function acceptRequest($relationshipId) {
        return $this->model->acceptRequest($relationshipId);
    }

    public function declineRequest($relationshipId) {
        return $this->model->declineRequest($relationshipId);
    }

    public function removeFriend($relationshipId) {
        return $this->model->removeFriend($relationshipId);
    }

    public function getRelationship($userMail, $friendMail) {
        return $this->model->getRelationship($userMail, $friendMail);
    }
}
?>