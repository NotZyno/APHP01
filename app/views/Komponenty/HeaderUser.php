<?php
class HeaderUser {
    private $username;
    private $mail;

    public function __construct($username, $mail) {
        $this->username = $username ?? "Gość";
        $this->mail = $mail ?? "default";
    }

    public function render() {
        $path = "../../public/uploads/" . $this->mail . "/profile_picture.png";
        echo "
        <link rel='stylesheet' href='../../public/Assets/css/headerUser.css'>
        <div class='header-user-wrapper'>
            <input type='checkbox' id='menu-toggle'>
            <label for='menu-toggle' class='menu-icon'>☰ Menu</label>
            <div class='side-menu'>
                <div style='display: flex; justify-content: center;'>
                    <a href='../Pages/settings.php' style='width:200px; padding: 0; border-radius: 100%'> <img src='$path' alt='avatar' style='width: 200px; height: 200px; border-radius: 100%; margin: 0 auto;'></a>
                </div>
                 <p style='text-align: center; font-size: 1.5rem; margin: 6px;'>$this->mail </p> 
                <br>
                <br>
                <br>
                <br>
                <a href='../Pages/logout.php' style='display: block; text-align: center;'>Wyloguj się</a>
                <details>
                    <summary>Lista stron</summary>
                    <ul>
                        <li><a href='../Pages/user.php'>Strona użytkownika</a></li>
                        <li><a href='../Pages/chat.php'>Chat</a></li>
                        <li><a href='../Pages/friendschat.php'>Posty od znajomych</a></li>
                    </ul>
                </details>
            </div>
        </div>
        ";
    }
}
?>
