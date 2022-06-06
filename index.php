<?php
session_start();
include("nav.php");
include("config.php");
if(isset($_SESSION["email"])){
    $email = $_SESSION["email"];
    echo "<script>window.location.href='home.php';</script>";
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Welcome</title>
    </head>

    <div class="splash">
        <div class="insplash">
            <span style="font-size: 50px">Welcome</span>
            <br>
            <button type="button" onclick="window.location.href='login.php'">Login</button>
            <button type="button" onclick="window.location.href='register.php'">Register</button>
        </div>

    </div>

</html>