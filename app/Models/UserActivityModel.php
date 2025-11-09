<?php
class UserActivityModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function add($mail, $type) {
        $stmt = $this->db->prepare("INSERT INTO user_activity (mail, activity_type) VALUES (:mail, :type)");
        return $stmt->execute([
            ":mail" => $mail,
            ":type" => $type
        ]);
    }

    public function getRecent($mail, $limit = 10) {
        $stmt = $this->db->prepare("SELECT * FROM user_activity WHERE mail = :mail ORDER BY activity_timestamp DESC LIMIT $limit");
        $stmt->execute([':mail' => $mail]);
        return $stmt->fetchAll();
    }
}
?>