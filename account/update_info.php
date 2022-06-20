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
    $db_gender = $get["gender"];
    $db_contact = $get["contact"];
}

$new_first_name = $new_middle_name = $new_last_name = $new_gender = $new_contact = "";
$new_first_nameErr = $new_middle_nameErr = $new_last_nameErr = $new_genderErr = $new_contactErr = "";

if(isset($_POST["update_info"])){
    if(empty($_POST["new_first_name"])){
        $new_first_nameErr = "This field must not be empty.";
    } else{
        $new_first_name = $_POST["new_first_name"];
    }

    if(empty($_POST["new_middle_name"])){
        $new_middle_nameErr = "This field must not be empty.";
    } else{
        $new_middle_name = $_POST["new_middle_name"];
    }

    if(empty($_POST["new_last_name"])){
        $new_last_nameErr = "This field must not be empty.";
    } else{
        $new_last_name = $_POST["new_last_name"];
    }

    $db_gender = $_POST["new_gender"];

    if(empty($_POST["new_contact"])){
        $new_contactErr = "This field must not be empty.";
    } else{
        $new_contact = $_POST["new_contact"];
    }

    $count_first_name_string = strlen($new_first_name);
    $count_middle_name_string = strlen($new_middle_name);
    $count_last_name_string = strlen($new_last_name);
    $count_contact_string = strlen($new_contact);

    if($count_first_name_string <= 1){
        $new_first_nameErr = "Minimum of 2 characters required.";
    }
    if($count_middle_name_string <= 1){
        $new_middle_nameErr = "Minimum of 2 characters required.";
    }
    if($count_last_name_string <= 1){
        $new_last_nameErr = "Minimum of 2 characters required.";
    }
    if(!preg_match("/^[a-zA-Zñ ]*$/", $new_first_name)){
        $new_first_nameErr = "Only alphabetic characters are allowed.";
    }
    if(!preg_match("/^[a-zA-Zñ ]*$/", $new_middle_name)){
        $new_middle_nameErr = "Only alphabetic characters are allowed.";
    }
    if(!preg_match("/^[a-zA-Zñ ]*$/", $new_last_name)){
        $new_last_nameErr = "Only alphabetic characters are allowed.";
    }
    if($count_contact_string < 11){
        $new_contactErr = "11 digits required.";
    }

    if(empty($new_first_nameErr) && empty($new_middle_nameErr) && empty($new_last_nameErr) && empty($new_genderErr) && empty($new_contactErr)){
        $db_first_name = $new_first_name;
        $db_middle_name = $new_middle_name;
        $db_last_name = $new_last_name;
        $db_contact = $new_contact;

        mysqli_query($connections, "UPDATE users SET
        
        first_name = '$db_first_name',
        middle_name = '$db_middle_name',
        last_name = '$db_last_name',
        gender = '$db_gender',
        contact = '$db_contact' WHERE username = '$username'");
        echo "<script>window.location.href='index.php';</script>";
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
        <title>Update personal information</title>
        <link rel="stylesheet" href="../bootstrap.css"/>
    </head>
    <body>
        <div class="list">
            <a href="index.php">< Back to account settings</a>
            <form method="POST" class="regform">
                <fieldset>
                    <legend><span style="font-size: 28px; font-weight:400">Update personal information</span></legend>
                    <tr>
                        <td>
                            <span style="font-size: 20px;">First name: </span><span class="error"><?php echo $new_first_nameErr; ?></span>
                            <br>
                            <input type="text" name="new_first_name" value="<?php echo $db_first_name; ?>" style="float: left; width: 100%">
                            
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <span style="font-size: 20px;">Middle name: </span><span class="error"><?php echo $new_middle_nameErr; ?></span>
                            <br>
                            <input type="text" name="new_middle_name" value="<?php echo $db_middle_name; ?>" style="float: left; width: 100%">
                            
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <span style="font-size: 20px;">Last name: </span><span class="error"><?php echo $new_last_nameErr; ?></span>
                            <br>
                            <input type="text" name="new_last_name" value="<?php echo $db_last_name; ?>" style="float: left; width: 100%">
                            
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <span style="font-size: 20px;">Gender: </span><span class="error"><?php echo $new_genderErr; ?></span>
                            <br>
                            <select name="new_gender">
                                <option name="new_gender" value="Male" <?php if($db_gender == "Male") { echo "selected"; } ?>>Male</option>
                                <option name="new_gender" value="Female" <?php if($db_gender == "Female") { echo "selected"; } ?>>Female</option>
                                <option name="new_gender" value="Other" <?php if($db_gender == "Other") { echo "selected"; } ?>>Other</option>
                                <option name="new_gender" value="N/A" <?php if($db_gender == "N/A") { echo "selected"; } ?>>Prefer not to say</option>
                            </select>
                            
                            <br>
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <span style="font-size: 20px;">Mobile number: </span><span class="error"><?php echo $new_contactErr; ?></span>
                            <br>
                            <input type="text" name="new_contact" value="<?php echo $db_contact; ?>" style="float: left; width: 100%" maxlength="11" onkeypress="return isNumberKey(event)">
                            
                        </td>
                    </tr>

                    <br>

                    <tr>
                        <td>
                            <input type="submit" name="update_info" value="Update"> &nbsp; <a href="index.php">Cancel</a>
                        </td>
                    </tr>
                </fieldset>
            </form>
        </div>
    </body>
</html>