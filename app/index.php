<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Projekt PHP</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      color: white;
      background: linear-gradient(to top, #0f2027, #203a43, #2c5364);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      position: relative;
    }

    .bg-blur {
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      width: 100vw;
      height: 100vh;
      z-index: 0;
      background: url('https://i.pinimg.com/736x/c2/69/64/c269645656dd520a75d196d579bb92ef.jpg') center bottom/cover no-repeat;
      filter: blur(10px) brightness(0.7);
    }

    .container {
      max-width: 700px;
      padding: 40px;
      background: rgba(0, 0, 0, 0.5);
      border-radius: 10px;
      z-index: 1;
      position: relative;
      text-align: left;
    }

    h1 {
      font-size: 48px;
      margin-bottom: 10px;
    }

    p {
      font-size: 20px;
      color: #ddd;
      line-height: 1.6;
    }

    .countdown {
      display: flex;
      justify-content: flex-start;
      margin: 30px 0;
    }

    .time-box {
      margin-right: 20px;
      text-align: center;
    }

    .time-box span {
      display: block;
      font-size: 36px;
      font-weight: bold;
    }

    .time-box small {
      font-size: 14px;
    }

    .notify-form {
      display: flex;
      margin-top: 20px;
      max-width: 400px;
    }

    .notify-form input {
      flex: 1;
      padding: 12px;
      border: none;
      border-radius: 5px 0 0 5px;
      font-size: 16px;
    }

    .notify-form button {
      padding: 12px 20px;
      border: none;
      background-color: #f39c12;
      color: white;
      border-radius: 0 5px 5px 0;
      cursor: pointer;
      font-size: 16px;
    }

    .socials {
      margin-top: 40px;
    }

    .socials a {
      margin: 0 10px;
      color: white;
      font-size: 24px;
      text-decoration: none;
    }

    .login-link {
      display: inline-block;
      margin-top: 30px;
      padding: 12px 32px;
      background: #1877f2;
      color: #fff;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      font-size: 18px;
      transition: background 0.2s;
      box-shadow: 0 2px 8px rgba(24, 119, 242, 0.08);
    }
  </style>
</head>
<body>
  <div class="bg-blur"></div>
  <div class="container">
    <h1>Witaj na stronie</h1>
    <p>Projekt PHP 2025. 
        Dostałem 3 razy zawał i kilka razy lobotomii :)</p>
    <a href="views/Pages/login.php" class="login-link" style="display: block; text-align: center">Przejdź do logowania</a>

    <div class="socials">
      <a href="#"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v5/icons/facebook.svg" width="24"></a>
      <a href="#"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v5/icons/twitter.svg" width="24"></a>
      <a href="#"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v5/icons/instagram.svg" width="24"></a>
      <a href="#"><img src="https://cdn.jsdelivr.net/npm/simple-icons@v5/icons/youtube.svg" width="24"></a>
    </div>
  </div>
</body>
</html>
