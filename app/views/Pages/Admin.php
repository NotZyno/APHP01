<?php
require_once("../../../Utility/db.php");
require_once("../Komponenty/HeaderAdmin.php");
require_once("../../Kontrolery/AdminController.php");
require_once("../../Kontrolery/UserActivityController.php");

if(session_status() === PHP_SESSION_NONE)
{
    session_start();
}

$header = new HeaderAdmin($_SESSION["username"]);
$header->render();

$controller = new AdminController($db);
$controller->handleRequest();

$result = $controller->users;


// --- WYSZUKIWANIE LOGÓW---
$activitySearch = $_POST['activity_search'] ?? '';
$params = [];
$sql = null;
if ($activitySearch !== '') {
    $sql = "WHERE mail LIKE :search OR activity_type LIKE :search";
    $params[':search'] = "%$activitySearch%";
}
$stmt = $db->prepare("SELECT * FROM user_activity $sql ORDER BY activity_timestamp DESC");
if ($sql) {
    $stmt->execute($params);
} else {
    $stmt->execute();
}
$allActivities = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
<style>
    body {
        background: #f0f2f5;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }
    .table-container {
        max-width: 900px;
        margin: 40px auto 0 auto;
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 4px 24px rgba(24,119,242,0.08), 0 1.5px 6px rgba(0,0,0,0.04);
        padding: 32px 24px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        font-family: inherit;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(24,119,242,0.05);
    }
    th, td {
        border: none;
        text-align: left;
        padding: 14px 16px;
    }
    th {
        background-color: #1877f2;
        color: #fff;
        font-weight: bold;
        font-size: 1.1rem;
        letter-spacing: 1px;
    }
    tr:nth-child(even) {
        background-color: #f6f8fa;
    }
    tr:nth-child(odd) {
        background-color: #eaf1fb;
    }
    tr:hover {
        background-color: #dbeafe;
        transition: background 0.2s;
    }
    td p {
        margin: 0;
        font-size: 1rem;
        color: #222;
    }
    @media (max-width: 700px) {
        .table-container {
            padding: 10px 2px;
        }
        th, td {
            padding: 8px 4px;
            font-size: 0.95rem;
        }
    }
    button form {
        margin: 0;
    }
    /* ...istniejący CSS... */
    .activity-table {
        width: 100%;
        border-collapse: collapse;
        margin: 40px 0 0 0;
    }
    .activity-table th, .activity-table td {
        border: none;
        text-align: left;
        padding: 10px 14px;
    }
    .activity-table th {
        background-color: #1877f2;
        color: #fff;
        font-weight: bold;
        font-size: 1.05rem;
    }
    .activity-table tr:nth-child(even) {
        background-color: #f6f8fa;
    }
    .activity-table tr:nth-child(odd) {
        background-color: #eaf1fb;
    }
</style>

<div class="table-container">
 <form method="POST" style="margin-bottom: 24px; text-align: right;">
    <input type="text" name="search" placeholder="Szukaj użytkownika..." value="<?= isset($_POST['search']) ? htmlspecialchars($_POST['search']) : '' ?>" style="padding: 8px; border-radius: 6px; border: 1px solid #ccc;">
    <button type="submit" style="padding: 8px 16px; border-radius: 6px; background: #1877f2; color: #fff; border: none;">Szukaj</button>
</form>
 <table id="userTable">
    <tr>
        <th>Email</th>
        <th>Username</th>
        <th>Name</th>
        <th>Edytuj</th>
    </tr>
    <?php foreach($result as $index => $res): ?>
        <tr>
            <td><p><?= htmlspecialchars($res["mail"]) ?></p></td>
            <td><p><?= htmlspecialchars($res["username"]) ?></p></td>
            <td><p><?= htmlspecialchars($res["name"]) ?></p></td> 
            <td>
                <form action="AdminEdit.php" method="GET" style="margin:0;">
                    <input type="hidden" name="mail" value="<?= htmlspecialchars($res["mail"]) ?>">
                    <button type="submit">
                        <p>Edytuj</p>
                    </button>
                </form>
            </td> 
        </tr>
    <?php endforeach; ?>
 </table>

 

 <!-- WYSZUKIWANIE LOGÓW -->
 <form method="POST" style="margin-bottom: 24px; text-align: right;">
    <input type="text" name="activity_search" placeholder="Szukaj w logach (email, typ)..." value="<?= htmlspecialchars($activitySearch) ?>" style="padding: 8px; border-radius: 6px; border: 1px solid #ccc;">
    <button type="submit" style="padding: 8px 16px; border-radius: 6px; background: #1877f2; color: #fff; border: none;">Szukaj</button>
 </form>

 <!-- TABELA LOGÓW -->
 <h2 style="margin-top:40px; color:#1877f2;">Logi aktywności użytkowników</h2>
 <table class="activity-table">
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Typ aktywności</th>
        <th>Czas</th>
    </tr>
    <?php foreach($allActivities as $activities): ?>
        <tr>
            <td><?= htmlspecialchars($activities['activity_id']) ?></td>
            <td><?= htmlspecialchars($activities['mail']) ?></td>
            <td><?= htmlspecialchars($activities['activity_type']) ?></td>
            <td><?= htmlspecialchars($activities['activity_timestamp']) ?></td>
        </tr>
    <?php endforeach; ?>
 </table>
</div>

</body>
</html>