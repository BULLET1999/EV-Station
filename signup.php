<?php
@include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile = $_POST['phone_number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];
    $select = "SELECT * FROM user_form WHERE email = '$email' && password = '$pass' ";

    $result = mysqli_query($conn, $select);
    if (mysqli_num_rows($result) > 0) {
        $error[] = 'User already exist!';
    } else {
        if ($pass != $cpass) {
            $error[] = 'Password Not matched!';
        } else {
            if ($user_type == 'user') {
                $insert = "INSERT INTO user_form (name, email, password, user_type, status, phone_number) VALUES('$name', '$email', '$pass', '$user_type', 'Approved', '$mobile')";
                mysqli_query($conn, $insert);
                header('location: login.php');
            } else {
                $insert = "INSERT INTO user_form (name, email, password, user_type, status, phone_number) VALUES('$name', '$email', '$pass', '$user_type', 'Pending', '$mobile')";
                $query = mysqli_query($conn, $insert);
                if($query == 1) {
                    $ins = "INSERT INTO host_details (host_name, host_email, host_phone_number) VALUES('$name', '$email', '$mobile')";
                    $run = mysqli_query($conn, $ins);
                    header('location: login.php');
                }
            }
        }
    }
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/backend.css">
    <title>SignUp - Electron</title>
</head>

<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Sign Up</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
            ?>
            <input type="text" name="name" required placeholder="Full name">
            <input type="mobile" name="phone_number" required placeholder="Contact Number">
            <input type="email" name="email" required placeholder="Your email">
            <input type="password" name="password" required placeholder="Password">
            <input type="password" name="cpassword" required placeholder="Confirm password">
            <select name="user_type">
                <option value="user">User</option>
                <option value="host">Host</option>
            </select>
            <input type="submit" name="submit" value="Sign Up" class="form-btn">
            <p class="">Already have an account? <a href="login.php">Login Now</a></p>
        </form>
    </div>
</body>

</html>