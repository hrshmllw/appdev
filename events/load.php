<?php
$connect = new PDO('mysql: host=localhost;dbname=appdev', 'root', '');
$data = array();

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

$query = "SELECT * FROM events WHERE user = '$username'";
$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

foreach($result as $row){
    $data[] = array(
        'id' => $row['id'],
        'user' => $row['user'],
        'title' => $row['title'],
        'start' => $row['start_event'],
        'end' => $row['end_event']
    );
}

echo json_encode($data);
?>