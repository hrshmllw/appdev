<?php
session_start();
include("nav.php");
include("config.php");
if(isset($_SESSION["email"])){
    $email = $_SESSION["email"];
    echo "<script>window.location.href='logging.php';</script>";
}

date_default_timezone_set("Asia/Manila");
$date_now = date("m/d/Y");
$time_now = date("h:i a");
$notify = $attempt = $log_time = "";

$end_time = date("h:i A", strtotime("+5 minutes", strtotime($time_now)));

$email = $password = "";
$emailErr = $passwordErr = "";

if(isset($_POST["login"])){
    if(empty($_POST["email"])){
        $emailErr = "Email cannot be empty.";
    } else{
        $email = $_POST["email"];
    }

    if(empty($_POST["password"])){
        $passwordErr = "Password cannot be empty.";
    } else{
        $password = $_POST["password"];
    }

    if($email AND $password){
        $check_email = mysqli_query($connections, "SELECT * FROM users WHERE email = '$email'");
        $check_row = mysqli_num_rows($check_email);

        if($check_row > 0){
            $fetch = mysqli_fetch_assoc($check_email);
            $db_password = $fetch["password"];
            $db_attempt = $fetch["attempt"];
            $db_log_time = strtotime($fetch["log_time"]);
            $my_log_time = $fetch["log_time"];
            $new_time = strtotime($time_now);
            
            if($db_log_time <= $new_time){
                if($db_password == $password){
                    $_SESSION["email"] = $email;
                    mysqli_query($connections, "UPDATE users SET attempt = '', log_time = '' WHERE email = '$email'");
                    echo "<script>window.location.href='logging.php'</script>";
                } else{
                    $attempt = (int)$db_attempt + 1;
                    if($attempt >= 3){
                        $attempt = 3;
                        mysqli_query($connections, "UPDATE users SET attempt = '$attempt', log_time = '$end_time' WHERE email = '$email'");
                        $notify = "Max attempts reached. Try again after: <b>$end_time</b>";
                    } else{
                        mysqli_query($connections, "UPDATE users SET attempt = '$attempt' WHERE email = '$email'");
                        $passwordErr = "Incorrect password.";
                        $notify = "Login attempt: <b>$attempt/3</b>";
                    }
                }
            } else{
                $notify = "Try logging in again after: <b>$my_log_time</b>";
            }
        } else{
            $emailErr = "Account not registered.";
        }
    }
}
?>

<!DOCTYPE html>

<html>
    <head>
        <title>Login</title>
    </head>

    <form method="POST" class="loginform">
        <fieldset>
            <legend>Login</legend>
            Email: <span class="error"><?php echo $emailErr; ?></span>
            <br>
            <input type="text" name="email" placeholder="Email" value="<?php echo $email; ?>">
            Password: <span class="error"><?php echo $passwordErr; ?></span>
            <input type="password" name="password" placeholder="Password">
            <span class="error"><?php echo $notify; ?></span>
            <hr>
            <input type="submit" name="login" value="Login">
            <br>
            <span style="font-size: 12px; font-weight: 300;">Don't have an account? Register <a href="register.php">here</a>.</span>
        </fieldset>
    </form>
</html>