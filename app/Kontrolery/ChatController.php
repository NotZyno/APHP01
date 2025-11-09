<?php
require_once("../../Models/ChatModel.php");

class ChatController {
    private $db;
    private $model;
    public $posts = [];
    public $comments = [];
    public $error = false;

    public function __construct($db) {
        $this->db = $db;
        $this->model = new ChatModel($db);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function handleRequest() {
        if (!isset($_SESSION["isLogged"]) || $_SESSION["isLogged"] === false) {
            header("Location: login.php");
            exit;
        }

        // Dodawanie posta
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["post_content"]) && !empty($_POST["post_content"])) {
                $mail = $_SESSION["mail"] ?? null;
                $content = trim($_POST["post_content"]);
                $imagePath = null;

                // Obsługa uploadu zdjęcia
                if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] === UPLOAD_ERR_OK) {
                    $baseDir = "../../public/uploads/";
                    $userDir = $baseDir . $_SESSION["mail"] . "/";
                    if (!is_dir($userDir)) {
                        mkdir($userDir, 0755, true);
                    }
                    $ext = strtolower(pathinfo($_FILES['post_image']['name'], PATHINFO_EXTENSION));
                    $filename = uniqid('post_', true) . '.' . $ext;
                    $targetPath = $userDir . $filename;
                    if (move_uploaded_file($_FILES['post_image']['tmp_name'], $targetPath)) {
                        $imagePath = "public/uploads/" . $_SESSION["mail"] . "/" . $filename;
                    }
                }

                if ($mail && $content) {
                    $this->model->addPost($mail, $content, $imagePath);
                } else {
                    $this->error = true;
                }
            }
            // Dodawanie komentarza
            if (isset($_POST["comment_content"], $_POST["post_id"]) && !empty($_POST["comment_content"])) {
                $mail = $_SESSION["mail"] ?? null;
                $content = trim($_POST["comment_content"]);
                $postId = (int)$_POST["post_id"];
                if ($mail && $content && $postId) {
                    $this->model->addComment($postId, $mail, $content);

                    // --- POWIADOMIENIE DLA WŁAŚCICIELA POSTA ---
                    $stmt = $this->db->prepare("SELECT mail FROM posts WHERE post_id = :post_id");
                    $stmt->execute([":post_id" => $postId]);
                    $postOwner = $stmt->fetchColumn();

                    if ($postOwner && $postOwner !== $mail) {
                        require_once("../../Kontrolery/NotificationController.php");
                        $notifController = new NotificationController($this->db);
                        $notifController->notify(
                            $postOwner,
                            'comment',
                            "Użytkownik " . htmlspecialchars($_SESSION['username']) . " skomentował(a) Twój post:<br><em>" . htmlspecialchars($content) . "</em>"
                        );
                    }
                    // --- KONIEC POWIADOMIENIA ---
                }
            }
        }
        // Pobieranie postów
        $this->posts = $this->model->getAllPosts();
        // Pobieranie komentarzy do każdego posta
        $this->comments = [];
        foreach ($this->posts as $post) {
            $this->comments[$post["post_id"]] = $this->model->getCommentsForPost($post["post_id"]);
        }
    }
}
?>