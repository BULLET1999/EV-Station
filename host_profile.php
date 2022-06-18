<?php
@include 'config.php';
session_start();
$host_id = $_SESSION['host_id'];

if (!isset($_SESSION['host_id'])) {
    header('location:login.php');
}
?>

<?php

$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$host_id'") or die('query failed');
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
    <title>Profile - Electron</title>
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
                <a href="update_host_profile.php" class="setting" style="float: right;">Settings</a>
            </div>
            <div class="user_information">
                <?php
                $select = mysqli_query($conn, "SELECT * FROM user_form WHERE id = '$host_id'")
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