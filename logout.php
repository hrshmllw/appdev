<?php
session_start();
unset($_SESSION["email"]);

session_unset();
session_destroy();

header("refresh:3; url=index.php");
?>

<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="Styles.css"/>
        <link rel="stylesheet" href="bootstrap.css"/>
    </head>
    <center>
        <h1>Logging out.</h1>

        <br>
        <br>

        Redirecting, please wait...
    </center>
</html>