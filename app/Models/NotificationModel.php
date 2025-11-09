<?php
class NotificationModel {
    private $db;
    public function __construct($db) {
        $this->db = $db;
    }

    public function add($mail, $type, $content) {
        $stmt = $this->db->prepare("INSERT INTO notifications (mail, type, content) VALUES (:mail, :type, :content)");
        return $stmt->execute([
            ":mail" => $mail,
            ":type" => $type,
            ":content" => $content
        ]);
    }
    public function getUnread($mail) {
        $stmt = $this->db->prepare("SELECT * FROM notifications WHERE mail = :mail AND status = 'unread' ORDER BY creation_date DESC");
        $stmt->execute([":mail" => $mail]);
        return $stmt->fetchAll();
    }
    public function markAsRead($notificationId) {
        $stmt = $this->db->prepare("UPDATE notifications SET status = 'read' WHERE notification_id = :id");
        return $stmt->execute([":id" => $notificationId]);
    }
}
?>