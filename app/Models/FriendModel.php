<?php
class FriendModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }
    public function sendRequest($userMail, $friendMail) {
        $stmt = $this->db->prepare("INSERT INTO relationships (mail, friend_mail, status) VALUES (:user, :friend, 'pending')");
        return $stmt->execute([
            ':user' => $userMail,
            ':friend' => $friendMail
        ]);
    }
    public function acceptRequest($relationshipId) {
        $stmt = $this->db->prepare("UPDATE relationships SET status = 'accepted' WHERE relationship_id = :id");
        return $stmt->execute([':id' => $relationshipId]);
    }
    public function declineRequest($relationshipId) {
        $stmt = $this->db->prepare("UPDATE relationships SET status = 'declined' WHERE relationship_id = :id");
        return $stmt->execute([':id' => $relationshipId]);
    }
    public function removeFriend($relationshipId) {
        $stmt = $this->db->prepare("DELETE FROM relationships WHERE relationship_id = :id");
        return $stmt->execute([':id' => $relationshipId]);
    }
    public function getFriends($userMail) {
        $stmt = $this->db->prepare("
            SELECT * FROM relationships 
            WHERE (mail = :mail OR friend_mail = :mail) AND status = 'accepted'
        ");
        $stmt->execute([':mail' => $userMail]);
        return $stmt->fetchAll();
    }

    public function getPendingRequests($userMail) {
        $stmt = $this->db->prepare("
            SELECT * FROM relationships 
            WHERE friend_mail = :mail AND status = 'pending'
        ");
        $stmt->execute([':mail' => $userMail]);
        return $stmt->fetchAll();
    }

    public function getRelationship($userMail, $friendMail) {
        $stmt = $this->db->prepare("
            SELECT * FROM relationships 
            WHERE (mail = :user AND friend_mail = :friend) 
               OR (mail = :friend AND friend_mail = :user)
            LIMIT 1
        ");
        $stmt->execute([':user' => $userMail, ':friend' => $friendMail]);
        return $stmt->fetch();
    }
}
?>