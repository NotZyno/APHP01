<?php
require_once("../../../Utility/db.php");
require_once("../../Kontrolery/LoginController.php");

$controller = new Auth($db);
$controller->handleRequest();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ced4da;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .login-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Logowanie</h1>
        <?php if ($controller->hasError()): ?>
            <p style="color: red;">Błąd logowania</p>
        <?php endif; ?>
        <form action="" method="POST">
            <input type="text" name="login" placeholder="Wpisz login (pocztę)" required>
            <input type="password" name="password" placeholder="Wpisz hasło" required>
            <button type="submit">Zaloguj</button>
            <p><a href="Registration.php">Załóż konto</a></p>
        </form>
    </div>
</body>
</html>
