<?php
require_once("../../../Utility/db.php");
require_once("../../Kontrolery/WelcomeController.php");

$controller = new WelcomeController($db);
$controller->handleRequest();
$success = $controller->success;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
            body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;  /* wyśrodkowanie poziome */
            align-items: center;      /* wyśrodkowanie pionowe */
            min-height: 100vh;
            margin: 0;
            }

            #container {
            width: 100%;
            max-width: 400px;
            
            }

            h1 {
            color: #333;
            text-align: center;
            margin: 0px;
            }

            form {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 15px;
            }

            label {
            font-weight: bold;
            }

            input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            }

            button, .upload-btn {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-align: center;
            }

            button:hover, .upload-btn:hover {
            background-color: #0056b3;
            }

            #upload {
            display: none;
            }

            #image {
            text-align: center;
            }

            #imagePreview {
            margin-top: 10px;
            max-width: 150px;
            height: 150px;
            border-radius: 50%; /* Zaokrąglenie */
            object-fit: cover;   /* Obcięcie nadmiaru */
            display: none;
            border: 2px solid #ccc;
            margin: 0 auto;
            }

            .upload-btn {
            display: inline-block;
            cursor: pointer;
            }
            #bio {
            padding: 1rem;
            font-size: 1rem;
                }
    </style>
</head>
<body>
  <div id="container">
    <form action="" method="POST" enctype="multipart/form-data">
      <h1>Witamy na stronie!</h1>
      <h1>Dodaj informacje o sobie</h1>
       <?php if(!$success):?>
        <h2 style="text-align: center; color: red;">Brak przesłanego pliku lub wystąpił błąd.</h2>
       <?php endif;?>
      <label for="username">Nazwa użytkownika</label>
      <input type="text" name="username" id="username" required />

      <label for="firstname">Imię</label>
      <input type="text" name="firstname" id="firstname" required />

      <label for="lastname">Nazwisko</label>
      <input type="text" name="lastname" id="lastname" required />

      <label for="bio">Biografia</label>
      <textarea name="bio" id="bio" rows="5" placeholder="Napisz coś o sobie..." required></textarea>


      <div id="image">
        <label for="upload" class="upload-btn">Udostępnij zdjęcie</label>
        <input
          type="file"
          name="photo"
          id="upload"
          accept="image/*"
          onchange="showPreview(this)"
        />
        <img id="imagePreview" src="" alt="Podgląd zdjęcia" />
      </div>

      <button type="submit">Zakończ</button>
    </form>
  </div>

  <script>
    function showPreview(input) {
      const preview = document.getElementById("imagePreview");
      const button = document.querySelector(".upload-btn");
      button.style.display = "none";

      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
          preview.src = e.target.result;
          preview.style.display = "block";
        };
        reader.readAsDataURL(input.files[0]);
      } else {
        preview.src = "";
        preview.style.display = "none";
        button.style.display = "inline-block";
      }
    }
  </script>
</body>
</html>