<?php
include("config.php");
if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
    echo '
    <!DOCTYPE html>
    
    <html>
        <link rel="stylesheet" type="text/css" href="Styles.css"/>
        <ul id="menu">
            <a href="index.php"><img src="logo.png" alt="Tasks" style="width: 5%; height: 5%;"></a>
            <li class="menuitem"><a href="logout.php">Logout</a></li>
            <li class="menuitem"><a href="account/index.php">Account</a></li>
            <li class="menuitem"><a href="home.php">Home</a></li>
    
        </ul>
    </html>';
} else{
    echo '
    
<!DOCTYPE html>

<html>
    <link rel="stylesheet" type="text/css" href="Styles.css"/>
    <ul id="menu">
        <a href="index.php"><img src="logo.png" alt="Tasks" style="width: 5%; height: 5%;"></a>
        <li class="menuitem"><a href="register.php">Register</a></li>
        <li class="menuitem"><a href="login.php">Login</a></li>
        <li class="menuitem"><a href="index.php">Home</a></li>
    </ul>
</html>';
}
?>