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
    $db_username = $get["username"];
    $db_first_name = $get["first_name"];
    $db_middle_name = $get["middle_name"];
    $db_last_name = $get["last_name"];
    $db_email = $get["email"];
    $db_gender = $get["gender"];
    $db_contact = $get["contact"];
    $db_password = $get["password"];
}

$confirm_password = "";
$confirm_passwordErr = "";

if(isset($_POST["delete_button"])){
    if(empty($_POST["confirm_password"])){
        $confirm_passwordErr = "This field must not be empty.";
    } else{
        $confirm_password = $_POST["confirm_password"];
    }

    if($db_password == $confirm_password){
        mysqli_query($connections, "DELETE FROM users WHERE username = '$db_username'");
        echo "<script>window.location.href='deleting.php'</script>";
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Delete account</title>
        <link rel="stylesheet" href="../bootstrap.css"/>
    </head>
    <body>
        <div class="list">
            <a href="index.php">< Back to account settings</a>
            <form method="POST" class="regform">
                <fieldset>
                    <legend><span style="font-size: 28px; font-weight:400">Delete account</span></legend>
                    <tr>
                        <td>
                            <span style="font-size: 20px;">Are you sure you want to delete your account?</span>
                            <br>
                            <br>
                            <span style="font-size: 16px;">Please enter your password to continue: </span><span class="error"><?php echo $confirm_passwordErr; ?></span>
                            <input type="password" name="confirm_password" style="float: left; width: 100%">
                        </td>
                    </tr>

                    <hr>

                    <tr>
                        <td>
                            <input type="submit" name="delete_button" value="Delete"> &nbsp; <a href="index.php">Cancel</a>
                        </td>
                    </tr>
                </fieldset>
            </form>
        </div>
    </body>
</html>