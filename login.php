<?php
session_start();
include("nav.php");
include("config.php");
if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
    echo "<script>window.location.href='home.php';</script>";
}

date_default_timezone_set("Asia/Manila");
$date_now = date("m/d/Y");
$time_now = date("h:i a");
$notify = $attempt = $log_time = "";

$end_time = date("h:i A", strtotime("+5 minutes", strtotime($time_now)));

$username = $password = "";
$usernameErr = $passwordErr = "";

if(isset($_POST["login"])){
    if(empty($_POST["username"])){
        $usernameErr = "Username cannot be empty.";
    } else{
        $username = $_POST["username"];
    }

    if(empty($_POST["password"])){
        $passwordErr = "Password cannot be empty.";
    } else{
        $password = $_POST["password"];
    }

    if($username AND $password){
        $check_username = mysqli_query($connections, "SELECT * FROM users WHERE username = '$username'");
        $check_row = mysqli_num_rows($check_username);

        if($check_row > 0){
            $fetch = mysqli_fetch_assoc($check_username);
            $db_password = $fetch["password"];
            $db_attempt = $fetch["attempt"];
            $db_log_time = strtotime($fetch["log_time"]);
            $my_log_time = $fetch["log_time"];
            $new_time = strtotime($time_now);
            
            if($db_log_time <= $new_time){
                if($db_password == $password){
                    $_SESSION["username"] = $username;
                    mysqli_query($connections, "UPDATE users SET attempt = '', log_time = '' WHERE username = '$username'");
                    echo "<script>window.location.href='logging.php'</script>";
                } else{
                    $attempt = (int)$db_attempt + 1;
                    if($attempt >= 3){
                        $attempt = 3;
                        mysqli_query($connections, "UPDATE users SET attempt = '$attempt', log_time = '$end_time' WHERE username = '$username'");
                        $notify = "Max attempts reached. Try again after: <b>$end_time</b>";
                    } else{
                        mysqli_query($connections, "UPDATE users SET attempt = '$attempt' WHERE username = '$username'");
                        $passwordErr = "Incorrect password.";
                        $notify = "Login attempt: <b>$attempt/3</b>";
                    }
                }
            } else{
                $notify = "Try logging in again after: <b>$my_log_time</b>";
            }
        } else{
            $usernameErr = "Account not registered.";
        }
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="bootstrap.css"/>
    </head>
    <body>
        <div class="logindiv">
            <a href="index.php">< Back</a>
            <form method="POST" class="loginform">
                <fieldset>
                    <legend>Login</legend>
                    Username: <span class="error"><?php echo $usernameErr; ?></span>
                    <br>
                    <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">
                    Password: <span class="error"><?php echo $passwordErr; ?></span>
                    <input type="password" name="password" placeholder="Password">
                    <span class="error"><?php echo $notify; ?></span>
                    <hr>
                    <input type="submit" name="login" value="Login">
                    <br>
                    <span style="font-size: 12px; font-weight: 300;">Don't have an account? Register <a href="register.php">here</a>.</span>
                </fieldset>
            </form>
        </div>
    </body>
</html>