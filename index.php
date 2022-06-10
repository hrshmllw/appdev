<?php
session_start();
include("nav.php");
include("config.php");
if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Welcome</title>
        <link rel="stylesheet" href="bootstrap.css"/>
    </head>

    <div class="splash">
        <div class="insplash">
            <span style="font-size: 50px">Welcome</span>
            <br>
            <?php if(isset($_SESSION['email'])): ?>
                <button type="button" onclick="window.location.href='home.php'">Get started</button>
            <?php else: ?>
                <button type="button" onclick="window.location.href='register.php'">Get started</button>
                <br>
                <span style="font-size: 11px; font-weight:300">or if you already have an account</span>
                <br>
                <button type="button" onclick="window.location.href='login.php'">Log in</button>
            <?php endif; ?>
        </div>

    </div>

</html>