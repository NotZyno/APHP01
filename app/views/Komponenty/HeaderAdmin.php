<?php
class HeaderAdmin {
    private $username;

    public function __construct($username) {
        $this->username = $username ?? "Gość";
    }
    public function render() {
        echo "
       <link rel='stylesheet' href='../../public/Assets/css/headerAdmin.css'>

        <div class='header-admin-wrapper'>
            <header class='details-wrapper'>
                <div class='left'>
                    <details>
                        <summary>Lista stron</summary>
                        <ul>
                            <li><a href='../Pages/user.php'>Strona użytkownika</a></li>
                            <li><a href='../Pages/Admin.php'>Panel Administratora</a></li>
                            <li><a href='../Pages/chat.php'>Czat</a></li>
                            <li><a href='../Pages/friendschat.php'>Posty od znajomych</a></li>
                        </ul>
                    </details>
                </div>

                <div class='center'>
                    <h1>Cześć, {$this->username}!</h1>
                </div>

                <div class='right'>
                    <a href='../Pages/logout.php' class='logout-button'>Wyloguj się</a>
                </div>
            </header>

            <div style='height: 100px;'></div>
        </div>
        ";
    }
}
?>
