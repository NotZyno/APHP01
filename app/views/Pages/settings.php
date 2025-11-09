<?php
require_once("../../../Utility/db.php");
require_once("../../Kontrolery/SettingsController.php");

$controller = new SettingsController($db);
$controller->handleRequest();
$user = $controller->user;
$success = $controller->success;
$error = $controller->error;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Ustawienia konta</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e0e7ff 0%, #f0f2f5 100%);
            margin: 0;
            min-height: 100vh;
        }
        .settings-container {
            background: #fff;
            max-width: 420px;
            margin: 60px auto 0 auto;
            padding: 32px 32px 24px 32px;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(24, 119, 242, 0.10), 0 1.5px 6px rgba(0,0,0,0.04);
            position: relative;
        }
        .settings-container h2 {
            text-align: center;
            color: #1877f2;
            margin-bottom: 18px;
            letter-spacing: 1px;
        }
        .settings-container label {
            display: block;
            margin-top: 18px;
            font-weight: 600;
            color: #333;
        }
        .settings-container input[type="text"],
        .settings-container input[type="email"],
        .settings-container input[type="password"] {
            width: 400px;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin-top: 6px;
            font-size: 16px;
            background: #f9fafb;
            transition: border-color 0.2s;
        }
        .settings-container input:focus {
            border-color: #1877f2;
            outline: none;
            background: #fff;
        }
        .settings-container input[disabled] {
            background: #e5e7eb;
            color: #888;
        }
        .settings-container button {
            margin-top: 28px;
            width: 100%;
            background: linear-gradient(90deg, #1877f2 60%, #4f8cff 100%);
            color: #fff;
            border: none;
            padding: 12px 0;
            border-radius: 6px;
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 1px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(24,119,242,0.08);
            transition: background 0.2s;
        }
        .settings-container button:hover {
            background: linear-gradient(90deg, #165ecb 60%, #3576e0 100%);
        }
        .msg {
            text-align: center;
            margin-top: 10px;
            margin-bottom: 0;
            font-size: 15px;
        }
        .msg.success { color: #22c55e; }
        .msg.error { color: #ef4444; }
        .avatar-preview {
            display: flex;
            justify-content: center;
            margin-bottom: 18px;
        }
        .avatar-preview img {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #1877f2;
            background: #e5e7eb;
            box-shadow: 0 2px 8px rgba(24,119,242,0.08);
        }
        .back-link {
            display: block;
            margin: 22px auto 0 auto;
            text-align: center;
            color: #1877f2;
            text-decoration: none;
            font-weight: 500;
            font-size: 15px;
            transition: color 0.2s;
        }
        .back-link:hover {
            color: #165ecb;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="settings-container">
        <h2>Ustawienia konta</h2>
        <div class="avatar-preview">
            <img src="/APHP01/app/public/uploads/<?= htmlspecialchars($user["mail"] ?? "default") ?>/profile_picture.png"
                 alt="avatar"
                 onerror="this.onerror=null;this.src='/APHP01/public/Assets/img/default.png';">
        </div>
        <?php if ($success): ?>
            <div class="msg success">Zapisano zmiany!</div>
        <?php elseif ($error): ?>
            <div class="msg error">Błąd podczas zapisu zmian.</div>
        <?php endif; ?>
        <form method="post" action="">
            <label for="username">Nazwa użytkownika</label>
            <input type="text" name="username" id="username" value="<?= htmlspecialchars($user["username"] ?? "") ?>" required>

            <label for="mail">E-mail</label>
            <input type="text" id="mail" value="<?= htmlspecialchars($user["mail"] ?? "") ?>" disabled>

            <label for="password">Nowe hasło (opcjonalnie)</label>
            <input type="password" name="password" id="password">

            <button type="submit">Zapisz zmiany</button>
        </form>
        <a href="user.php" class="back-link">← Powróć do profilu</a>
    </div>
</body>
</html>