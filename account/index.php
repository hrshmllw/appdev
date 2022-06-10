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
    $db_first_name = $get["first_name"];
    $db_middle_name = $get["middle_name"];
    $db_last_name = $get["last_name"];
    $db_email = $get["email"];
    $db_gender = $get["gender"];
    $db_contact = $get["contact"];
    $db_password = $get["password"];
}

$full_name = $db_first_name . " " . $db_middle_name . " " . $db_last_name;
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Account settings</title>
        <link rel="stylesheet" href="../bootstrap.css"/>
    </head>
    <body>
        <div class="list">
            <a href="../home.php">< Back</a>
            <form>
                <fieldset>
                    <legend><span style="font-size: 28px; font-weight:400">Account information</span></legend>
                    <tr>
                        <td>
                            <span style="font-size: 20px;">Email: </span> <?php echo $db_email; ?>
                            <br>
                            <a href="update_email.php">Change email</a>
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <span style="font-size: 20px;">Password: </span> <?php echo str_repeat("*", strlen($db_password)); ?>
                            <br>
                            <a href="update_password.php">Change password</a>
                        </td>
                    </tr>

                    <hr>

                    <legend><span style="font-size: 28px; font-weight:400">Personal information</span></legend>
                    <tr>
                        <td>
                            <span style="font-size: 20px;">Name: </span> <?php echo $full_name; ?>
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <span style="font-size: 20px;">Gender: </span> <?php echo $db_gender; ?>
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <span style="font-size: 20px;">Mobile number: </span> <?php echo $db_contact; ?>
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <br>
                            <a href="#">Update information</a><span style="float: right;"><a href="#">Delete account</a></span>
                        </td>
                    </tr>
                </fieldset>
            </form>
        </div>
    </body>
</html>