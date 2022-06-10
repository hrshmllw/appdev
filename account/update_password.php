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
    $db_password = $get["password"];
}

$new_password = $confirm_password = $current_password = "";
$new_passwordErr = $current_passwordErr = "";

if(isset($_POST["update_password"])){
    if(empty($_POST["current_password"])){
        $current_passwordErr = "Please enter your current password.";
    } else{
        $current_password = $_POST["current_password"];
    }

    if(empty($_POST["new_password"])){
        $new_passwordErr = "This field must not be empty.";
    } else{
        $new_password = $_POST["new_password"];
    }

    if(empty($_POST["confirm_password"])){
        $confirm_passwordErr = "This field must not be empty.";
    } else{
        $confirm_password = $_POST["confirm_password"];
    }

    if($db_password == $current_password){
        if($current_password != $new_password){
            if($new_password == $confirm_password){
                mysqli_query($connections, "UPDATE users SET password = '$new_password' WHERE username = '$username'");
                echo "<script>window.location.href='index.php'</script>";
            } else{
                $new_passwordErr = "Passwords do not match.";
            }
        } else{
            $new_passwordErr = "Current and new passwords must not be the same.";
        }
    } else{
        $current_passwordErr = "Please enter your current password.";
    }

}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Change password</title>
        <link rel="stylesheet" href="../bootstrap.css"/>
    </head>
    <body>
        <div class="list">
            <a href="index.php">< Back to account settings</a>
            <form method="POST" class="regform">
                <fieldset>
                    <legend><span style="font-size: 28px; font-weight:400">Change password</span></legend>
                    <tr>
                        <td>
                            <span style="font-size: 20px;">Current password: </span><span class="error"><?php echo $current_passwordErr; ?></span>
                            <br>
                            <input type="password" name="current_password" placeholder="Current password" style="float: left; width: 100%">
                        </td>
                    </tr>

                    <hr>

                    <tr>
                        <td>
                            <span style="font-size: 20px;">New password: </span> <span class="error"><?php echo $new_passwordErr; ?></span>
                            <br>
                            <input type="password" name="new_password" placeholder="New password" style="float: left; width: 100%">
                            <br>
                            <input type="password" name="confirm_password" placeholder="Confirm password" style="float: left; width: 100%">
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <input type="submit" name="update_password" value="Update"> &nbsp; <a href="index.php">Cancel</a>
                        </td>
                    </tr>
                </fieldset>
            </form>
        </div>
    </body>
</html>