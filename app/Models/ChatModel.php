<?php

class ChatModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllPosts() {
        $stmt = $this->db->query("SELECT p.*, u.username FROM posts p JOIN user u ON p.mail = u.mail ORDER BY p.creation_date DESC");
        return $stmt->fetchAll();
    }

    public function addPost($mail, $content, $imagePath = null) {
        $stmt = $this->db->prepare("INSERT INTO posts (mail, content, image, creation_date) VALUES (:mail, :content, :image_path, NOW())");
        return $stmt->execute([
            ":mail" => $mail,
            ":content" => $content,
            ":image_path" => $imagePath
        ]);
    }
    public function getCommentsForPost($postId) {
        $stmt = $this->db->prepare("SELECT c.*, u.username FROM comments c JOIN user u ON c.mail = u.mail WHERE c.post_id = :post_id ORDER BY c.creation_date ASC");
        $stmt->execute([":post_id" => $postId]);
        return $stmt->fetchAll();
    }

    public function addComment($postId, $mail, $content) {
        $stmt = $this->db->prepare("INSERT INTO comments (comment_id, post_id, mail, content, creation_date) VALUES ('', :post_id, :mail, :content, NOW())");
        return $stmt->execute([
            ":post_id" => $postId,
            ":mail" => $mail,
            ":content" => $content
        ]);
    }
}
?>