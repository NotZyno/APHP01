<?php
require_once("../../../Utility/db.php");
require_once("../../Kontrolery/RegisterController.php");

$registerHandler = new Register($db);
$error = false;
$errorPoczta = false;
$duplicateEmail = false;

try {
    $registerHandler->handleRequest();
    $errorPoczta = $registerHandler->hasEmailError() ?? false;
    $error = $registerHandler->hasError() ?? false;
    $duplicateEmail = $registerHandler->hasDuplicateEmail() ?? false;
} catch (PDOException $e) {
    $error = true;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejestracja</title>
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
        .register-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        .register-container h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }
        .register-container input[type="text"],
        .register-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ced4da;
            border-radius: 3px;
            box-sizing: border-box;
        }
        .register-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .register-container button:hover {
            background-color: #0056b3;
        }
        .register-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .register-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Rejestracja</h1>
        <?php if ($duplicateEmail): ?>
            <p style="color: red; text-align: center;">Już ktoś używa tego adresu poczty.</p>
        <?php endif; ?>
        <?php if ($error): ?>
            <p style="color: red; text-align: center;">Błąd rejestracji. Sprawdź dane.</p>
        <?php endif; ?>
        <?php if ($errorPoczta): ?>
            <p style="color: red; text-align: center;">Podaj poprawny adres poczty.</p>
        <?php endif; ?>
        <form action="" method="POST">
            <input type="text" name="login" placeholder="Wpisz e-mail" required>
            <input type="text" name="username" placeholder="Nazwę użytkownika" required>
            <input type="password" name="password" placeholder="Wpisz hasło" required>
            <input type="password" name="confirmPassword" placeholder="Potwierdź hasło" required>
            <button type="submit">Zarejestruj się</button>
        </form>
        <a href="login.php">Masz już konto? Zaloguj się</a>
    </div>
</body>
</html>
