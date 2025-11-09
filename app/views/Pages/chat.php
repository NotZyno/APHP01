<?php
session_start();
require_once("../../../Utility/db.php");
require_once("../../Kontrolery/ChatController.php");

$controller = new ChatController($db);
$controller->handleRequest();
$posts = $controller->posts;

$a = 4;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablica postów</title>
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
            .post-form {
                background: #fff;
                padding: 16px;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);
                margin-bottom: 24px;
            }
            .post-form textarea {
                width: 100%;
                border: 1px solid #ccc;
                border-radius: 6px;
                padding: 10px;
                font-size: 16px;
                resize: vertical;
                min-height: 60px;
            }
            .post-form button {
                margin-top: 10px;
                background: #1877f2;
                color: #fff;
                border: none;
                padding: 10px 18px;
                border-radius: 6px;
                cursor: pointer;
                font-size: 16px;
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
    </style>
</head>
<body>
    <?php if($_SESSION["permission"] === "user"): require_once("../Komponenty/HeaderUser.php"); $header = new HeaderUser($_SESSION["username"], $_SESSION["mail"] ?? null); $header->render();
            else: require_once("../Komponenty/HeaderAdmin.php"); $header = new HeaderAdmin($_SESSION["username"]);$header->render();
        endif;
    ?>
    <div id="content">
        <form class="post-form" method="post" action="" enctype="multipart/form-data">
            <textarea name="post_content" placeholder="Co słychać?" required></textarea>
            <input type="file" name="post_image" accept="image/*" style="margin-top:8px;">
            <button type="submit">Opublikuj</button>
        </form>

        <?php foreach ($posts as $post): ?>
            <div class="post">
                <span class="author"><?= htmlspecialchars($post["username"]) ?></span>
                <span class="date"><?= htmlspecialchars($post["creation_date"]) ?></span>
                <div class="content"><?= nl2br($post["content"]) ?></div>

                <?php if (!empty($post["image"]) || !empty($post["image_path"])): ?>
                    <div style="margin-top:10px;">
                        <img src="/APHP01/app/<?= htmlspecialchars(!empty($post["image_path"]) ? $post["image_path"] : $post["image"]) ?>" alt="Zdjęcie do posta" style="max-width:100px; max-height:1000px;border-radius:8px;">
                    </div>
                <?php endif; ?>

                <!-- Komentarze -->
                <div style="margin-top:16px; margin-left:20px;">
                    <strong>Komentarze:</strong>
                    <?php foreach ($controller->comments[$post["post_id"]] as $comment): ?>
                        <div style="background:#f3f4f6; border-radius:6px; margin:8px 0; padding:8px 12px;">
                            <span style="font-weight:bold; color:#1877f2;"><?= htmlspecialchars($comment["username"]) ?></span>
                            <span style="color:#888; font-size:12px; margin-left:8px;"><?= htmlspecialchars($comment["creation_date"]) ?></span>
                            <div><?= htmlspecialchars(nl2br($comment["content"]))?></div>
                        </div>
                    <?php endforeach; ?>
                    <!-- Formularz dodawania komentarza -->
                    <form method="post" action="" style="margin-top:8px;">
                        <input type="hidden" name="post_id" value="<?= $post["post_id"] ?>">
                        <textarea name="comment_content" placeholder="Dodaj komentarz..." required style="width:100%; min-height:40px; border-radius:4px; border:1px solid #ccc; margin-bottom:4px;"></textarea>
                        <button type="submit" style="background:#1877f2; color:#fff; border:none; border-radius:4px; padding:6px 14px; cursor:pointer;">Dodaj komentarz</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>