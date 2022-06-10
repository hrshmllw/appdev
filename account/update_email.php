<?php
session_start();
include("../config.php");
include("nav.php");

if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
} else{
    die("<center><span style='font-size: 35px';>You are not signed in.</span>
    <br>
    <span style='font-size: 12px';><a href='../index.php'>Return to homepage</a></span>
    </center>");
}

$get_record = mysqli_query($connections, "SELECT * FROM users WHERE username = '$username'");

while($get = mysqli_fetch_assoc($get_record)){
    $db_email = $get["email"];
}

$new_email = "";
$new_emailErr = "";

if(isset($_POST["update_button"])){
    if(empty($_POST["new_email"])){
        $new_emailErr = "This field must not be empty.";
    } else{
        $new_email = $_POST["new_email"];
        $db_email = $new_email;
    }

    if(empty($new_emailErr)){
        mysqli_query($connections, "UPDATE users SET email = '$db_email' WHERE username = '$username'");
        echo "<script>window.location.href='index.php';</script>";
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Change email</title>
        <link rel="stylesheet" href="../bootstrap.css"/>
    </head>
    <body>
        <div class="list">
            <a href="index.php">< Back to account settings</a>
            <form method="POST" class="regform">
                <fieldset>
                    <legend><span style="font-size: 28px; font-weight:400">Change email</span></legend>
                    <tr>
                        <td>
                            <span style="font-size: 20px;">Email: </span> <?php echo $db_email; ?>
                            <br>
                            <input type="text" name="new_email" placeholder="New email" style="float: left; width: 100%">
                            <span class="error"><?php echo $new_emailErr; ?></span>
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <input type="submit" name="update_button" value="Update"> &nbsp; <a href="index.php">Cancel</a>
                        </td>
                    </tr>
                </fieldset>
            </form>
        </div>
    </body>
</html>