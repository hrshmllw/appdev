<?php
include("../config.php");
include("../home.php");

if(isset($_GET['as'], $_GET['item'])){
    $as = $_GET['as'];
    $item = $_GET['item'];

    switch($as){
        case 'delete':
            $doneQuery = $db->prepare("DELETE FROM tasks WHERE id = :item AND user = :user");
            $doneQuery->execute(['item' => $item, 'user' => $_SESSION["username"]]);
        break;
    }
    echo "<meta http-equiv='refresh' content='0'>";
}
header("Location: index.php");
?>