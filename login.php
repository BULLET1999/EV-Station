<?php

@include 'config.php';

session_start();

if (isset($_POST['submit'])) {

    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = md5($_POST['password']);
    

    $select = " SELECT * FROM user_form WHERE email = '$email' && password = '$pass' && status = 'Approved' ";

    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_array($result);

        if ($row['user_type'] == 'admin') {

            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');

        } elseif ($row['user_type'] == 'user') {

            $_SESSION['user_id'] = $row['id'];
            header('location:user_page.php');

        } elseif ($row['user_type'] == 'host') {

            $_SESSION['host_id'] = $row['id'];
            header('location:host_page.php');

        }
    } else {

        $error[] = 'Incorrect email or password or your request for host is under process or your account is suspended or your request is declined!';

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
    <title>Login - Electron</title>
</head>

<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>login now</h3>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
            ?>
            <input type="email" name="email" required placeholder="Enter your email">
            <input type="password" name="password" required placeholder="Password">
            <input type="submit" name="submit" value="login now" class="form-btn">
            <p>Don't have an account? <a href="signup.php">SignUp Now</a></p>
        </form>

    </div>
    </div>
</body>

</html>