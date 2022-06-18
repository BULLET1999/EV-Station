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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="css/backend.css">
    <title>Host Dashboard - Electron</title>
</head>

<body>
    <div class="host_user_navbar">
        <a href="host_page.php">Home</a>
        <a href="contact_us.html">Support</a>
        <a href="about.html">About Us</a>
        <a href="logout.php" style="float: right;">Logout</a>
        <a href="#" class="user_name" style="float: right;">Hii, <?php echo $fetch['name']; ?></a>
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
        <div class="flex-container">
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query(" SELECT COUNT(*) FROM host_schedule WHERE host_id = '$host_id' ; ") as $row) {
                    echo "<span class='count' style='color: #16bbe5;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>Created Slot</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query(" SELECT COUNT(*) FROM host_schedule WHERE host_id = '$host_id' && availability = 'Available' ; ") as $row) {
                    echo "<span class='count' style='color: #ea5d5d;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>Your Available Slots</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query(" SELECT COUNT(*) FROM host_schedule WHERE host_id = '$host_id' && availability = 'Not Available' ; ") as $row) {
                    echo "<span class='count' style='color: #fcad73;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>Your Not Available Slots</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query(" SELECT COUNT(*) FROM slot_booking WHERE hostid = '$host_id' && sch_status = 'Processing' ;") as $row) {
                    echo "<span class='count' style='color: #2daab8;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>Booking Requests</p>
            </div>
        </div>
        <div class="flex-container">
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query("SELECT COUNT(*) FROM slot_booking WHERE hostid = '$host_id' && sch_status = 'Approved' ;") as $row) {
                    echo "<span class='count' style='color: #16bbe5;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>Confirmed Slots</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query("SELECT COUNT(*) FROM slot_booking WHERE hostid = '$host_id' && sch_status = 'Denied' ;") as $row) {
                    echo "<span class='count' style='color: #ea5d5d;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>Declined Slots</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query("SELECT COUNT(*) FROM slot_booking WHERE hostid = '$host_id' && sch_status = 'Done' ;") as $row) {
                    echo "<span class='count' style='color: #fcad73;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>Total Charging Sessions</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query('SELECT COUNT(*) FROM slot_booking WHERE hostid = "$host_id" && sch_status = "Done" ') as $row) {
                    echo "<span class= 'count' style='color: #2daab8;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>BOOKING COMPLETED</p>
            </div>
        </div>
        <div class="footer">
            <p>&copy; Copyright <b><span style="color: black;">ELECT</span><span style="color: green;">RON</span></b>. All Rights Reserved</p>
        </div>
    </div>
</body>

</html>

<script>
    $('.count').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 2000,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>