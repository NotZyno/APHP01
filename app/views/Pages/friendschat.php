<?php
require_once("../../../Utility/db.php");
require_once("../../Kontrolery/FriendController.php");
require_once("../../Kontrolery/ChatController.php");
session_start();

if($_SESSION["permission"] === "user"): require_once("../Komponenty/HeaderUser.php"); $header = new HeaderUser($_SESSION["username"], $_SESSION["mail"] ?? null); $header->render();
            else: require_once("../Komponenty/HeaderAdmin.php"); $header = new HeaderAdmin($_SESSION["username"]);$header->render();
        endif;
        
if (!isset($_SESSION["isLogged"]) || $_SESSION["isLogged"] === false) {
    header("Location: login.php");
    exit;
}

$userMail = $_SESSION["mail"] ?? null;

// Pobierz znajomych
$friendController = new FriendController($db);
$friendController->handleRequest($userMail);
$friends = $friendController->friends;

// Zbierz maile znajomych
$friendMails = [];
foreach ($friends as $friend) {
    $friendMails[] = ($friend['friend_mail'] === $userMail) ? $friend['mail'] : $friend['friend_mail'];
}

// Pobierz posty tylko od znajomych
$posts = [];
if (($friendMails) !== null) {
    $placeholders = implode(',', array_fill(0, count($friendMails), '?'));
    $stmt = $db->prepare("SELECT p.*, u.username FROM posts p JOIN user u ON p.mail = u.mail WHERE p.mail IN ($placeholders) ORDER BY p.creation_date DESC");
    $stmt->execute($friendMails);
    $posts = $stmt->fetchAll();
}


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Posty znajomych</title>
    <style>
        body {
            background: #f0f2f5;
            font-family: Arial, sans-serif;
            margin: 0;
        }
        #content {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
        }
        .post {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            margin-bottom: 18px;
            padding: 16px;
        }
        .post .author {
            font-weight: bold;
            color: #1877f2;
        }
        .post .date {
            color: #888;
            font-size: 12px;
            margin-left: 8px;
        }
        .post .content {
            margin-top: 8px;
            font-size: 15px;
        }
        .ping-highlight {
            text-decoration: underline;
            color: #1877f2;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="content">
        <h2>Posty znajomych</h2>
        <?php if (($posts) === null): ?>
            <p>Brak postów od znajomych.</p>
        <?php else: ?>
            <?php foreach ($posts as $post): ?>
                <div class="post">
                    <span class="author"><?= htmlspecialchars($post["username"]) ?></span>
                    <span class="date"><?= htmlspecialchars($post["creation_date"]) ?></span>
                    <div class="content"><?= nl2br(($post["content"])) ?></div>
                    <?php if (($post["image"] !== null) || ($post["image_path"] !== null)): ?>
                        <div style="margin-top:10px;">
                            <img src="/APHP01/app/<?= htmlspecialchars(!empty($post["image_path"]) ? $post["image_path"] : $post["image"]) ?>" alt="Zdjęcie do posta" style="max-width:100px; max-height:1000px;border-radius:8px;">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>