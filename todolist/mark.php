<?php
include("../config.php");
include("../home.php");

if(isset($_GET['as'], $_GET['item'])){
    $as = $_GET['as'];
    $item = $_GET['item'];

    switch($as){
        case 'done':
            $doneQuery = $db->prepare("UPDATE tasks SET done = 1 WHERE id = :item AND user = :user");
            $doneQuery->execute(['item' => $item, 'user' => $_SESSION["username"]]);
        break;
        case 'undone':
            $doneQuery = $db->prepare("UPDATE tasks SET done = 0 WHERE id = :item AND user = :user");
            $doneQuery->execute(['item' => $item, 'user' => $_SESSION["username"]]);
    }
    echo "<meta http-equiv='refresh' content='0'>";
}
header("Location: index.php");
?>