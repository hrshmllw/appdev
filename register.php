<?php
include("nav.php");
include("config.php");

$username = $first_name = $middle_name = $last_name = $email = $gender = $contact = $password = "";
$usernameErr = $first_nameErr = $middle_nameErr = $last_nameErr = $emailErr = $genderErr = $contactErr = $passwordErr = "";

if(isset($_POST["button_register"])){
    if(empty($_POST["username"])){
        $usernameErr = "Required!";
    } else{
        $username = $_POST["username"];
    }

    if(empty($_POST["first_name"])){
        $first_nameErr = "Required!";
    } else{
        $first_name = $_POST["first_name"];
    }

    if(empty($_POST["middle_name"])){
        $middle_nameErr = "Required!";
    } else{
        $middle_name = $_POST["middle_name"];
    }

    if(empty($_POST["last_name"])){
        $last_nameErr = "Required!";
    } else{
        $last_name = $_POST["last_name"];
    }

    if(empty($_POST["email"])){
        $emailErr = "Required!";
    } else{
        $email = $_POST["email"];
    }

    if(empty($_POST["gender"])){
        $genderErr = "Required!";
    } else{
        $gender = $_POST["gender"];
    }

    if(empty($_POST["contact"])){
        $contactErr = "Required!";
    } else{
        $contact = $_POST["contact"];
    }

    if(empty($_POST["password"])){
        $passwordErr = "Required!";
    } else{
        $password = $_POST["password"];
    }

    if($username && $first_name && $middle_name && $last_name && $gender && $contact && $email && $password){
        $count_username_string = strlen($username);
        $count_first_name_string = strlen($first_name);
        $count_middle_name_string = strlen($middle_name);
        $count_last_name_string = strlen($last_name);
        $count_contact_string = strlen($contact);
        $count_password_string = strlen($password);
        $check_username = mysqli_query($connections, "SELECT username FROM users WHERE username = '$username'");

        if(!preg_match("/^[a-zA-Z0-9 ]*$/", $username)){
            $usernameErr = "Only alphanumeric characters are allowed.";
        }
        if(!preg_match("/^[a-zA-Z ]*$/", $first_name)){
            $first_nameErr = "Only alphabetic characters are allowed.";
        }
        if(!preg_match("/^[a-zA-Z ]*$/", $middle_name)){
            $middle_nameErr = "Only alphabetic characters are allowed.";
        }
        if(!preg_match("/^[a-zA-Z ]*$/", $last_name)){
            $last_nameErr = "Only alphabetic characters are allowed.";
        }
        if($count_first_name_string < 2){
            $first_nameErr = "Minimum of 3 characters required.";
        }
        if($count_middle_name_string < 2){
            $middle_nameErr = "Minimum of 3 characters required.";
        }
        if($count_last_name_string < 2){
            $last_nameErr = "Minimum of 3 characters required.";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid email format.";
        }
        if($count_contact_string < 11){
            $contactErr = "11 digits required.";
        }
        if($count_password_string < 8){
            $passwordErr = "Password must be 8-16 characters long.";
        }
        if(mysqli_num_rows($check_username) > 0){
            $usernameErr = "Username already taken.";
        }
        if(empty($usernameErr) && empty($first_nameErr) && empty($middle_nameErr) && empty($last_nameErr) && empty($genderErr) && empty($contactErr) && empty($emailErr) && empty($passwordErr)){
            mysqli_query($connections, "INSERT INTO users(username, first_name, middle_name, last_name, email, gender, contact, password)
            VALUES('$username', '$first_name', '$middle_name', '$last_name', '$email', '$gender', '$contact', '$password')");

            echo "<script>window.location.href='success.php';</script>";
        }
    }
}
?>

<script type="application/javascript">
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode

        if(charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }
        return true;
    }
</script>


<!DOCTYPE html>

<html>
    <head>
        <title>Registration</title>
        <link rel="stylesheet" href="bootstrap.css"/>
    </head>
    <body>
        <div class="list">
            <a href="index.php">< Back</a>
            <form method="POST" class="regform">
                <fieldset>
                    <legend>Information</legend>
                    <tr>
                        <td>
                            Username: <span class="error"><?php echo $usernameErr; ?></span>
                            <br>
                            <input type="text" name="username" placeholder="Username" value="<?php echo $username; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            First name: <span class="error"><?php echo $first_nameErr; ?></span>
                            <br>
                            <input type="text" name="first_name" placeholder="First name" value="<?php echo $first_name; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Middle name: <span class="error"><?php echo $middle_nameErr; ?></span>
                            <br>
                            <input type="text" name="middle_name" placeholder="Middle name" value="<?php echo $middle_name; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Last name: <span class="error"><?php echo $last_nameErr; ?></span>
                            <br>
                            <input type="text" name="last_name" placeholder="Last name" value="<?php echo $last_name; ?>">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Email: <span class="error"><?php echo $emailErr; ?></span>
                            <br>
                            <input type="text" name="email" value="<?php echo $email; ?>" placeholder="Email">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Gender: <span class="error"><?php echo $genderErr; ?></span>
                            <br>
                            <select name="gender">
                                <option name="gender" value="">Select gender</option>
                                <option name="gender" value="Male" <?php if($gender == "Male") { echo "selected"; } ?>>Male</option>
                                <option name="gender" value="Female" <?php if($gender == "Female") { echo "selected"; } ?>>Female</option>
                                <option name="gender" value="Other" <?php if($gender == "Other") { echo "selected"; } ?>>Other</option>
                                <option name="gender" value="N/A" <?php if($gender == "N/A") { echo "selected"; } ?>>Prefer not to say</option>
                            </select>
                        </td>
                    </tr>

                    <br>
                    <br>

                    <tr>
                        <td>
                            Mobile number: <span class="error"><?php echo $contactErr; ?></span>
                            <br>
                            <input type="text" name="contact" value="<?php echo $contact; ?>" maxlength="11" placeholder="Mobile number" onkeypress = 'return isNumberKey(event)'>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Password: <span class="error"><?php echo $passwordErr; ?></span>
                            <br>
                            <input type="password" name="password" value="<?php echo $password; ?>" maxlength="16" placeholder="Password">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <hr>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="submit" name="button_register" value="Register"/>
                        </td>
                    </tr>

                    <br>

                    <span style="font-size: 12px; font-weight: 300">Already have an account? Login <a href="login.php">here</a>.</span>
                </fieldset>
            </form>
        </div>        
    </body>
</html>