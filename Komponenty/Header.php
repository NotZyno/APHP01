<?php
class Header {
    private $username;

    public function __construct($username) {
        $this->username = $username ?? "Gość";
    }

    public function render(){
        echo "
        <header style='background-color: #007bff; padding: 15px; color: white; text-align: center;'>
            <h1>Cześć, {$this->username}!</h1>
            <button><a href='logout.php' style='
            color: black;
            text-decoration: none;
            font-size: 18px;
            background-color: white;
            '>Wyloguj się</a></button>
        </header>";
    }
}
?>
