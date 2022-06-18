<?php

include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];
if (!isset($user_id)) {
    header('location: login.php');
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
    <title>My Account - Electron</title>
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
                <a href="update_user_profile.php" class="setting" style="float: right;">Settings</a>
            </div>
            <div class="user_information">
                <?php
                $select = mysqli_query($conn, "SELECT * FROM user_form WHERE id = '$user_id'")
                    or die('query failed');
                if (mysqli_num_rows($select) > 0) {
                    $fetch = mysqli_fetch_assoc($select);
                }
                if ($fetch['profile_photo'] == '') {
                    echo '<img src="images/default-avatar.png">';
                } else {
                    echo '<img src="uploaded_img/' . $fetch['profile_photo'] . '">';
                }
                ?>
                <p class="">USER INFORMATION</p>
                <form>
                    <div class="flex">
                        <div class="inputbox">

                            <span>Name:</span>
                            <div class="box">
                                <p class="box_text"><?php echo $fetch['name'] ?></p>
                            </div>

                            <span>Email:</span>
                            <div class="box">
                                <p class="box_text"><?php echo $fetch['email'] ?></p>
                            </div>

                            <span>Mobile Number:</span>
                            <div class="box">
                                <p class="box_text"><?php echo $fetch['phone_number'] ?></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="user_footer">
                <p>&copy; Copyright <b><span style="color: black;">ELECT</span><span style="color: green;">RON</span></b>. All Rights Reserved</p>
            </div>
        </div>
    </div>
</body>

</html>