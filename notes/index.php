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

$itemsQuery = $db->prepare("SELECT id, user, task, done FROM tasks WHERE user = :user");

$itemsQuery->execute(['user' => $_SESSION["username"]]);

$items = $itemsQuery->rowCount() ? $itemsQuery : [];

$task = "";
$taskErr = "";
date_default_timezone_set("Asia/Manila");
$date_created = date("m/d/Y h:i:s a");

if(isset($_POST["add_task"])){
    if(empty($_POST["task"])){
        $taskErr = "Enter a task.";
    } else{
        $task = $_POST["task"];
    }

    if(empty($taskErr)){
        mysqli_query($connections, "INSERT INTO tasks(user, task, done, created)
        VALUES('$username', '$task', '0', '$date_created')");
    }
    echo "<meta http-equiv='refresh' content='0'>";
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Notes</title>
        <link rel="stylesheet" href="../bootstrap.css"/>
    </head>

    <body>
        <div class="list">
            <a href="../home.php">< Back</a>
            <form method="POST" class="additem">
                <fieldset>
                    <legend>Notes</legend>
                    <?php
                    echo "<span>User: $username</span>";
                    ?>
                    <form>
                        <input type="text" name="task" placeholder="Enter a new task." class="input" autocomplete="off" required>
                        <input type="submit" name="add_task" value="Add to list" class="submit">
                    </form>

                    <hr>

                    <?php if(!empty($items)) : ?>
                    <ul class="items">
                        <?php foreach($items as $item): ?>
                            <li>
                                <span class="item<?php echo $item['done'] ? 'done' : '' ?>"><?php echo $item['task'];?></span>
                                <?php if(!$item['done']): ?>
                                    <a href="mark.php?as=done&item=<?php echo $item['id']; ?>" class="donebutton">Mark as done</a>
                                    <a href="delete.php?as=delete&item=<?php echo $item['id']; ?>" class="deletebutton">Delete</a>
                                <?php else: ?>
                                    <a href="mark.php?as=undone&item=<?php echo $item['id']; ?>" class="donebutton">Undo</a>
                                    <a href="delete.php?as=delete&item=<?php echo $item['id']; ?>" class="deletebutton">Delete</a>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                        There are no items on your list.
                    <?php endif; ?>
                </fieldset>
            </form>
        </div>
    </body>
</html>