<?php
session_start();
include("nav.php");
include("config.php");

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
    </head>

    <form method="POST" class="loginform">
        <fieldset>
            <legend>Login</legend>
            <input type="text" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <hr>
            <input type="submit" name="login" value="Login">
            <br>
            <span style="font-size: 12px; font-weight: 300;">Don't have an account? Register <a href="register.php">here</a>.</span>
        </fieldset>
    </form>
</html>