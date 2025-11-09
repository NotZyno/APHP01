<?php
/*
    **************** IMPORTANT ****************
    #Ten plik index.php jest, aby nie można było wchodzić do katalogu serwera oraz służy jako strona główna serwera
    #Plik ten zawiera przekierowanie do Formularzu logowania, jeżeli użytkownik nie jest zalogowany

    
    **************** Bootstrap ****************
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    **************** IMPORTANT ****************
    
    **************** MVC ****************
    * Models (Obsługa bazy danych tzn)
    * Views (Pliki wyświetlające, czyli Komponenty i Pages)
    * Controllers  (Zarządzają logiką programu oraz przetwarzają dane użytkownika przesłane w form oraz zarządzają przekierowaniami)
    Components (Komponenty np header)
    
    
    * 01.06.2025 Dzięki dodaniu do projektu architektury MVC, dodałem sobie więcej pracy :)
    * Przynajmniej można zobaczyć coś nowego, chociaż nowoczesne strony oparte na API calls nie używają tego,
    * ale still warto.
    *
    * Większość kodu, która wcześniej została napisana działała, wciąż działa, ale większość ścieżek się nie zgadza
    * Teraz tylko dodatkowa godzina debugowania kodu oraz sprawdzania ścieżek.
    * 
    * PS nie wiem po co to napisałem, ale kiedyś takie coś napisałem i została fajna pamiątka z tamtego okresu.
    * W sumie piszę to, ponieważ jest to pierwszy większy projekt strony internetowej i mam nadzieję,
    * że kiedyś wrócę i to zobaczę.
    
    
    #TODO

    * stylistyka ogólna strony
    * utworzenie grup
    * admin.php (Połączenie do bazdy danych, fetchowanie danych z bd)
    * dodać namespace (zamiast require_once)
    * dodać możliwość wyświetlania kont
    * możliwośc zgłoszenia
    * możliwość powiadomień
    * logika programu (mniej więcej ukończone)
    
    #TODO skończone
    
    * utworzenie postów i komentarzy do nich (tabele posts i comments)
    * dodać ustawienia konta (możliwość zmiany danych)
    * naprawić stylistykę header i menu
    * komponenty
    * MVC
    * username w header
    * strona powitalna (tworzenie danych użytkownika tzn username itd)
    * Rejestracja jako klasa
    * registration.php (Połączenie do bazdy danych, Create do bazy danych i sprawdzanie, czy nie ma powtórzenia danych)
    * utworzenie roli
    * login.php (Połączenie do bazdy danych, fetchowanie danych z bd)
    * utworzenie katalogów strony
    * baza danych (cała) 



*/


session_start();
$_SESSION["isLogged"] = $_SESSION["isLogged"] ?? null;
if($_SESSION["isLogged"] !== true)
{
    header("Location: Pages/login.php");
} else {
    if($_SESSION["permission"] === "admin") //permission == role
    {
        header("Location: Pages/Admin.php");

    } else {
        header("Location: Pages/user.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    
</body>
</html>