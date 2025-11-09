<?php
require_once("../../../Utility/db.php");
require_once("../Komponenty/HeaderUser.php");
require_once("../Komponenty/HeaderAdmin.php");
require_once("../../Kontrolery/UserController.php");
require_once("../../Kontrolery/NotificationController.php");
require_once("../../Kontrolery/FriendController.php");

session_start();

if (!isset($_SESSION["isLogged"]) || $_SESSION["isLogged"] === false) {
    header("Location: login.php");
    exit;
}

// SYSTEM POWIADOMIEŃ
$notification = $_SESSION['notification'] ?? null;
if ($notification) unset($_SESSION['notification']);

if($_SESSION["permission"] === "user"): require_once("../Komponenty/HeaderUser.php"); $header = new HeaderUser($_SESSION["username"], $_SESSION["mail"] ?? null); $header->render();
            else: require_once("../Komponenty/HeaderAdmin.php"); $header = new HeaderAdmin($_SESSION["username"]);$header->render();
        endif;

$controller = new UserController($db);
$controller->handleRequest($_SESSION["mail"]);
$user = $controller->userData;

$notifController = new NotificationController($db);
$notifController->fetch($_SESSION["mail"]);

// --- SYSTEM ZNAJOMYCH ---
require_once("../../Kontrolery/FriendController.php");
$friendController = new FriendController($db);
$userMail = $_SESSION["mail"] ?? null;

// Obsługa akcji znajomych
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["accept"])) {
        $friendController->acceptRequest((int)$_POST["accept"]);
        $_SESSION['notification'] = "Zaproszenie zaakceptowane.";
        header("Location: user.php");
        exit;
    }
    if (isset($_POST["decline"])) {
        $friendController->declineRequest((int)$_POST["decline"]);
        $_SESSION['notification'] = "Zaproszenie odrzucone.";
        header("Location: user.php");
        exit;
    }
    if (isset($_POST["remove"])) {
        $friendController->removeFriend((int)$_POST["remove"]);
        $_SESSION['notification'] = "Znajomy usunięty.";
        header("Location: user.php");
        exit;
    }
    if (isset($_POST["invite"]) && isset($_POST["friend_mail"])) {
        $friendController->sendRequest($userMail, $_POST["friend_mail"]);
        $_SESSION['notification'] = "Zaproszenie wysłane.";
        header("Location: user.php");
        exit;
    }
    // Obsługa oznaczania powiadomień jako przeczytane
    if (isset($_POST["read_notification"])) {
        $notifController->read((int)$_POST["read_notification"]);
        header("Location: user.php");
        exit;
    }
}

$friendController->handleRequest($userMail);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Twój panel</title>
    <style>
        .dashboard-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 24px rgba(24,119,242,0.08), 0 1.5px 6px rgba(0,0,0,0.04);
            padding: 32px 24px;
            font-family: Arial, sans-serif;
        }
        .dashboard-container h2 {
            color: #1877f2;
            margin-bottom: 18px;
        }
        .dashboard-container p {
            margin: 8px 0;
            color: #222;
        }
        .notification {
            background: #e0f3ff;
            color: #1877f2;
            border: 1px solid #b6e0fe;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 18px;
            font-weight: 600;
            text-align: center;
        }
        .notification-list {
            margin-bottom: 18px;
        }
        .notification-list h3 {
            color: #1877f2;
            font-size: 1.1rem;
        }
        .notification-list ul {
            padding-left: 18px;
        }
        .notification-list li {
            margin-bottom: 8px;
        }
        .friends-section {
            margin-top: 32px;
            background: #f6f8fa;
            border-radius: 10px;
            padding: 18px 16px;
        }
        .friends-section h3 {
            color: #1877f2;
            margin-bottom: 10px;
        }
        .friends-section ul {
            padding-left: 18px;
        }
        .friends-section li {
            margin-bottom: 8px;
        }
        .friend-actions form {
            display: inline;
        }
        .friend-invite-form {
            margin-top: 16px;
            text-align: center;
        }
        .friend-invite-form input[type="email"] {
            padding: 7px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            margin-right: 8px;
        }
        .friend-invite-form button {
            padding: 7px 18px;
            border-radius: 6px;
            background: #1877f2;
            color: #fff;
            border: none;
            font-weight: 600;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <?php if ($notification): ?>
            <div class="notification"><?= htmlspecialchars($notification) ?></div>
        <?php endif; ?>
        <div style="display: block; text-align: center;">
            <h2>Witaj, <?= htmlspecialchars($user['username']) ?>!</h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($user['mail']) ?></p>
            <p><strong>Imię:</strong> <?= htmlspecialchars($user['name']) ?></p>
            <p><strong>Nazwisko:</strong> <?= htmlspecialchars($user['second_name']) ?></p>
            <p><strong>O mnie:</strong> <?= nl2br(htmlspecialchars($user['biography'])) ?></p>
        </div>
        
        <a href="settings.php" style="
            display: block;
            text-align: center;
            margin-top:22px;
            padding:10px 28px;
            background:#1877f2;
            color:#fff;
            border-radius:6px;
            text-decoration:none;
            font-weight:600;
            font-size:16px;
            transition:background 0.2s;
            box-shadow:0 2px 8px rgba(24,119,242,0.08);
        ">Ustawienia konta</a>

        <?php if (!empty($notifController->notifications)): ?>
            <div class="notification-list">
                <h3>Powiadomienia:</h3>
                <ul>
                    <?php foreach ($notifController->notifications as $notif): ?>
                        <li>
                            <?= nl2br($notif["content"]) ?>
                            <form method="post" action="" style="display:inline;">
                                <input type="hidden" name="read_notification" value="<?= $notif["notification_id"] ?>">
                                <button type="submit" style="
                                    background:none;
                                    border:none;
                                    color:#1877f2;
                                    cursor:pointer;
                                    padding:0;
                                    font-size:inherit;
                                    font-family:inherit;
                                ">Oznacz jako przeczytane</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- SYSTEM ZNAJOMYCH -->
        <div class="friends-section">
            <h3>Twoi znajomi</h3>
            <ul>
                <?php foreach ($friendController->friends as $friend): ?>
                    <li>
                        <?= htmlspecialchars($friend['friend_mail'] === $userMail ? $friend['friend_mail'] : $friend['user_mail']) ?>
                        <span class="friend-actions">
                            <form method="post" style="display:inline;">
                                <button type="submit" name="remove" value="<?= $friend['relationship_id'] ?>">Usuń</button>
                            </form>
                        </span>
                    </li>
                <?php endforeach; ?>
                <?php if ($friendController->friends === null): ?>
                    <li>Brak znajomych.</li>
                <?php endif; ?>
            </ul>

            <h3>Zaproszenia do zaakceptowania</h3>
            <ul>
                <?php foreach ($friendController->pending as $req): ?>
                    <li>
                        <?= htmlspecialchars($req['friend_mail']) ?>
                        <span class="friend-actions">
                            <form method="post" style="display:inline;">
                                <button type="submit" name="accept" value="<?= $req['relationship_id'] ?>">Akceptuj</button>
                                <button type="submit" name="decline" value="<?= $req['relationship_id'] ?>">Odrzuć</button>
                            </form>
                        </span>
                    </li>
                <?php endforeach; ?>
                <?php if (empty($friendController->pending)): ?>
                    <li>Brak zaproszeń.</li>
                <?php endif; ?>
            </ul>

            <div class="friend-invite-form">
                <form method="post">
                    <input type="email" name="friend_mail" placeholder="Email znajomego" required>
                    <button type="submit" name="invite">Wyślij zaproszenie</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>