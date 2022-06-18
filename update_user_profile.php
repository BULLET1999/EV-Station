<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {
    $update_mobile = mysqli_real_escape_string($conn, $_POST['update_mobile']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);


    mysqli_query($conn, "UPDATE `user_form` SET phone_number = '$update_mobile', email = '$update_email' WHERE id = '$user_id'") or die('query failed');

    $old_pass = $_POST['old_pass'];
    $update_pass = mysqli_real_escape_string($conn, md5($_POST['update_pass']));
    $new_pass = mysqli_real_escape_string($conn, md5($_POST['new_pass']));
    $confirm_pass = mysqli_real_escape_string($conn, md5($_POST['confirm_pass']));

    if (!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)) {
        if ($update_pass != $old_pass) {
            $message[] = 'old password not matched!';
        } elseif ($new_pass != $confirm_pass) {
            $message[] = 'confirm password not matched!';
        } else {
            mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
            $message[] = 'password updated successfully!';
        }
    }

    $update_image = $_FILES['update_image']['name'];
    $update_image_size = $_FILES['update_image']['size'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = 'uploaded_img/' . $update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $message[] = 'image is too large';
        } else {
            $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET profile_photo = '$update_image' WHERE id = '$user_id'") or die('query failed');
            if ($image_update_query) {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
            }
            $message[] = 'image updated succssfully!';
        }
    }
}
?>
<?php
$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="css/backend.css">
    <title>Account Settings - Electron</title>
    <style>
        body {
            background-color: lightblue;
        }
    </style>
</head>

<body>

    <div class="user_navbar">
        <a href="user_page.php">Home</a>
        <a href="contact_us.html">Support</a>
        <a href="about.html">About Us</a>
        <a href="logout.php" style="float: right;">Logout</a>
        <a href="#" class="user_name" style="float: right;"><?php echo $fetch['name']; ?></a>
    </div>

    <div class="user_menu_row">
        <p><span style="color: black;">ELECT</span><span style="color: green;">RON</span></p>
        <a href="user_page.php"><i class='fas fa-desktop'></i> Dashboard</a>
        <a href="slotbook.php"><i class='far fa-calendar-check'></i> Book Slot</a>
        <a href="booking_summary.php"><i class='fas fa-history'></i> View Bookings</a>
        <a href="user_profile.php"><i class='fas fa-user-circle'></i> Profile</a>
        <a href="update_user_profile.php"><i class='fas fa-user-edit'></i> Update Profile</a>
        <a href="user_slot_history.php"><i class='fas fa-history'></i> History</a>
    </div>

    <div class="right_to_menu">
        <div class="profile_details_container">
            <div class="menu_profile_details">
                <a href="#">My Account</a>
                <a href="user_profile.php" class="setting" style="float: right;">Back</a>
            </div>
            <div class="update-profile">

                <form action="" method="post" enctype="multipart/form-data">
                    <div class="image">
                        <?php
                        if ($fetch['profile_photo'] == '') {
                            echo '<img src="images/default-avatar.png">';
                        } else {
                            echo '<img src="uploaded_img/' . $fetch['profile_photo'] . '">';
                        }
                        if (isset($message)) {
                            foreach ($message as $message) {
                                echo '<div class="message">' . $message . '</div>';
                            }
                        }
                        ?>
                    </div>

                    <p style="font-size: xx-large; color: black;">Hii, <?php echo $fetch['name']; ?></p>
                    <div class="flex">

                        <div class="inputBox">
                            <span>Email:</span>
                            <input type="email" name="update_email" value="<?php echo $fetch['email']; ?>" class="box">
                            <span>Mobile Number:</span>
                            <input type="mobile" name="update_mobile" value="<?php echo $fetch['phone_number']; ?>" class="box">
                            <span>Change Profile Photo:</span>
                            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
                        </div>
                        <div class="inputBox">
                            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
                            <span>Old password:</span>
                            <input type="password" name="update_pass" placeholder="Previous password" class="box">
                            <span>New password:</span>
                            <input type="password" name="new_pass" placeholder="Enter new password" class="box">
                            <span>Confirm password:</span>
                            <input type="password" name="confirm_pass" placeholder="Confirm new password" class="box">
                        </div>
                    </div>
                    <input type="submit" value="Confirm" name="update_profile" class="btn">
                    <a href="user_profile.php" class="delete-btn">Cancel</a>
                </form>
            </div>
            <div class="user_footer">
                <p>&copy; Copyright <b><span style="color: black;">ELECT</span><span style="color: green;">RON</span></b>. All Rights Reserved</p>
            </div>
        </div>
    </div>
</body>

</html>