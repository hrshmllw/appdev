<?php
$connect = new PDO('mysql: host=localhost;dbname=appdev', 'root', '');

session_start();
include("../config.php");

if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
} else{
    die("<center><span style='font-size: 35px';>You are not signed in.</span>
    <br>
    <span style='font-size: 12px';><a href='../index.php'>Return to homepage</a></span>
    </center>");
}

if(isset($_POST["title"])){
    $query = "INSERT INTO events (user, title, start_event, end_event)
    VALUES(:user, :title, :start_event, :end_event)";
    $statement = $connect->prepare($query);
    $statement->execute(
        array(
            ':user' => $_SESSION['username'],
            ':title' => $_POST['title'],
            ':start_event' => $_POST['start'],
            ':end_event' => $_POST['end']
        )
    );
}
?>