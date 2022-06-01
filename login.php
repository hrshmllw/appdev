<?php
include("nav.php");
include("config.php");
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="Styles.css"/>
    </head>

    <form method="POST" class="loginform">
        <fieldset>
            <legend>Login</legend>
            <input type="text" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <hr>
            <input type="submit" name="login" value="Login">
        </fieldset>
    </form>
</html>