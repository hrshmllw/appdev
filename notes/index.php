<?php
session_start();
include("../config.php");
include("nav.php");

if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
} else{
    die("<center><span style='font-size: 35px';>You are not signed in.</span>
    <br>
    <span style='font-size: 12px';><a href='index.php'>Return to homepage</a></span>
    </center>");
}

$itemsQuery = $db->prepare("SELECT id, user, title, description, create_date FROM notes WHERE user = :user");

$itemsQuery->execute(['user' => $_SESSION["username"]]);

$notes = $itemsQuery->rowCount() ? $itemsQuery : [];

$title = $description = "";
$titleErr = $descriptionErr = "";
date_default_timezone_set("Asia/Manila");
$date_created = date("m/d/Y h:i:s a");

if(isset($_POST["add_note"])){
    if(empty($_POST["title"])){
        $titleErr = "Enter a task.";
    } else{
        $title = $_POST["title"];
    }

    $description = $_POST["description"];

    if(empty($titleErr)){
        mysqli_query($connections, "INSERT INTO notes(user, title, description, create_date)
        VALUES('$username', '$title', '$description', '$date_created')");
    }
    echo "<meta http-equiv='refresh' content='0'>";
}

$colors = array("ff7eb9", "ff65a3", "7afcff", "feff9c", "fff740");

?>

<!DOCTYPE html>

<html>
    <head>
        <title>Notes</title>
        <link rel="stylesheet" href="../bootstrap.css"/>
    </head>
    <body>
        <div class="new-note">
        <a href="../home.php">< Back</a>
        <form class="new-note" method="POST">
            <fieldset>
                <input type="text" name="title" placeholder="Note title" autocomplete="off" required>
                <textarea name="description" rows="5" placeholder="Note description"></textarea>
                <input type="submit" name="add_note" value="New note">
            </fieldset>
        </form>
        </div>
        <div class="notes">
            <?php foreach ($notes as $note): ?>
                <div class="note" style="background-color: #<?php echo $colors[array_rand($colors)]; ?>">
                    <div class="title">
                        <?php echo $note['title'] ?>
                    </div>
                    <div class="description">
                        <?php echo nl2br($note['description']) ?>
                    </div>
                    <small><?php echo date('d/m/Y H:i', strtotime($note['create_date'])) ?></small>
                    <input type="hidden" name="id" value="<?php echo $note['id'] ?>">
                    <a href="delete.php?as=delete&item=<?php echo $note['id']; ?>" class="close">X</a>
                    </form>
                </div>
            <?php endforeach ?>
        </div>
    </body>
</html>