<?php
require_once("../../../Utility/db.php");
require_once("../../Kontrolery/AdminEditController.php");

require_once("../Komponenty/HeaderAdmin.php");

session_start();
$header = new HeaderAdmin($_SESSION["username"]);
$header->render();

$controller = new AdminEditController($db);
$controller->handleRequest();
$user = $controller->user;
$returnUrl = $_SERVER['HTTP_REFERER'] ?? 'Admin.php';
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Edycja użytkownika</title>
    <link rel="stylesheet" href="../../public/Assets/css/adminEdit.css">
</head>
<body>
    <div class="edit-container">
        <h2>Edycja użytkownika</h2>
        <form method="POST" action="">
            <input type="hidden" name="edit_mail" value="<?= htmlspecialchars($user['mail']) ?>">
            <label>Nowy e-mail: <input type="email" name="edit_newmail" value="<?= htmlspecialchars($user['mail']) ?>" disabled></label>
            <label>Nazwa użytkownika: <input type="text" name="edit_username" value="<?= htmlspecialchars($user['username']) ?>" required></label>
            <label>Nowe hasło (opcjonalnie): <input type="password" name="edit_password"></label>
            <button type="submit">Zapisz zmiany</button>
            <p><a href="<?= htmlspecialchars($returnUrl) ?>">Powrót</a></p>
            <?php echo "$returnUrl"?>
            
        </form>
    </div>
</body>
</html>
