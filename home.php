<?php
session_start();
include("config.php");
include("nav.php");

if(isset($_SESSION["email"])){
    $email = $_SESSION["email"];
} else{
    die("<center><span style='font-size: 35px';>You are not signed in.</span>
    <br>
    <span style='font-size: 12px';><a href='index.php'>Return to homepage</a></span>
    </center>");
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Home</title>
    </head>
    <body>
        <div id="main-container">
            <div class='box' id='topleft'>
                <button id="topleftbutton" onclick="window.location.href='todolist.php'"><span style="font-size: 25px; font-weight:400">To-do list</span></button>
            </div>
            <div class='box' id='topright'>
                <button id="toprightbutton" onclick="window.location.href='events/index.php'"><span style="font-size: 25px; font-weight:400">Calendar</span></button>
            </div>
            <div class='box' id='bottomleft'>
                <button id="bottomleftbutton" onclick="window.location.href='#'"><span style="font-size: 25px; font-weight:400">Spreadsheets</span></button>
            </div>
            <div class='box' id='bottomright'>
                <button id="bottomrightbutton" onclick="window.location.href='#'"><span style="font-size: 25px; font-weight:400">Notes</span></button>
            </div>
            <div id='deadcenter'></div>
        </div>
    </body>
</html>