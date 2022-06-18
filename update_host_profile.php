<?php

include 'config.php';
session_start();
$host_id = $_SESSION['host_id'];

$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$host_id'") or die('query failed');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}
$host_email = $fetch['email'];




if (isset($_POST['update_profile'])) {
    $update_mobile = mysqli_real_escape_string($conn, $_POST['update_mobile']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);

    $update_address = mysqli_real_escape_string($conn, $_POST['update_address']);
    $update_state = mysqli_real_escape_string($conn, $_POST['update_state']);
    $update_city = mysqli_real_escape_string($conn, $_POST['update_city']);
    $update_pincode = mysqli_real_escape_string($conn, $_POST['update_pincode']);


    mysqli_query($conn, "UPDATE `user_form` SET phone_number = '$update_mobile', email = '$update_email' WHERE id = '$host_id'") or die('query failed');
    mysqli_query($conn, "UPDATE `host_details` SET host_address = '$update_address', city = '$update_city', state = '$update_state', pincode = '$update_pincode', host_id = '$host_id'  WHERE host_email = '$host_email'") or die('query failed');

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
            mysqli_query($conn, "UPDATE `user_form` SET password = '$confirm_pass' WHERE id = '$host_id'") or die('query failed');
            $message[] = 'password updated successfully!';
            header("Location: update_host_profile.php");
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
            $image_update_query = mysqli_query($conn, "UPDATE `user_form` SET profile_photo = '$update_image' WHERE id = '$host_id'") or die('query failed');
            if ($image_update_query) {
                move_uploaded_file($update_image_tmp_name, $update_image_folder);
                header("Location: update_host_profile.php");
            }
            $message[] = 'image updated succssfully!';
        }
    }
}
?>

<?php
?>

<?php
$select_host = mysqli_query($conn, "SELECT * FROM `host_details` WHERE host_email = '$host_email' ") or die('query failed');
if (mysqli_num_rows($select_host) > 0) {
    $fetch_address = mysqli_fetch_assoc($select_host);
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
    <div class="host_user_navbar">
        <a href="host_page.php">Home</a>
        <a href="contact_us.html">Support</a>
        <a href="about.html">About Us</a>
        <a href="logout.php" style="float: right;">Logout</a>
        <a href="#" class="user_name" style="float: right;"><?php echo $fetch['name']; ?></a>
    </div>

    <div class="host_menu_row">
        <p><span style="color: black;">ELECT</span><span style="color: green;">RON</span></p>
        <a href="host_page.php"><i class='fas fa-desktop'></i> Dashboard</a>
        <a href="addslot.php"><i class='far fa-edit'></i> Create Slot</a>
        <a href="view_slot_booking.php"><i class='far fa-edit'></i> Pending Booking</a>
        <a href="host_profile.php"><i class='fas fa-user-circle'></i> Profile</a>
        <a href="update_host_profile.php"><i class='fas fa-user-edit'></i> Update Profile</a>
        <a href="slot_history.php"><i class='fas fa-history'></i> History</a>
    </div>

    <div class="right_to_menu">
        <div class="profile_details_container">
            <div class="menu_profile_details">
                <a href="#">My Account</a>
                <a href="host_profile.php" class="setting" style="float: right;">Back</a>
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
                    <p class="address_head">Address</p>
                    <div class="address_update">

                        <span>Address:</span>
                        <input type="address" name="update_address" value="<?php echo $fetch_address['host_address']; ?>" class="address_box">

                        <span>City:</span>
                        <select id="city" name="update_city" class="address_box">
                            <option value="<?php echo $fetch_address['city']; ?>"><?php echo $fetch_address['city']; ?></option>
                            <option value="Jorhat">Jorhat</option>
                            <option value="Vadodara">Vadodara</option>
                            <option value="Faridabad">Faridabad</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Jammu">Jammu</option>
                            <option value="Sonipat">Sonipat</option>
                            <option value="Bathinda">Bathinda</option>
                            <option value="Kanpur">Kanpur</option>                            
                        </select>

                        <span>State:</span>
                        <select name="update_state" class="address_box">
                            <option value="<?php echo $fetch_address['state']; ?>"><?php echo $fetch_address['state']; ?></option>
                            <option value="Assam">Assam</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Jammu">Jammu</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                        </select>
                        <span>Pincode:</span>
                        <input type="pincode" name="update_pincode" class="address_box" value="<?php echo $fetch_address['pincode']; ?>">
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