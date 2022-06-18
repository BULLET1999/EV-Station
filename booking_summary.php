<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
}
?>

<?php
$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id' ") or die('query failed');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}
?>

<?php
$user_check_query = "SELECT * FROM slot_booking WHERE sch_status = 'Approved' ";
$result = mysqli_query($conn, $user_check_query);
$showButton = (mysqli_num_rows($result) > 0 ? true : false);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/backend.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Booking Summary - Electron</title>
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
        <div class="table-slot-container">
            <?php
            $res = mysqli_query($conn, "SELECT a.*, b.*,c.* FROM user_form a 
            JOIN slot_booking b On a.id = b.user_id 
            JOIN host_schedule c On b.scheduleid = c.schedule_id 
            Where user_id = '$user_id' && (sch_status = 'Processing' OR sch_status = 'Approved') order by booking_id ASC ");
            if (!$res) {
                printf("Error: %s\n", mysqli_error($conn));
                exit();
            }
            echo '<table style = "border: 1px solid black" class="table table-bordered table-striped">';
            echo "<thead>";
            echo "<tr>";
            echo "<th>Name</th>";
            echo "<th>Phone Number</th>";
            echo "<th>Time</th>";
            echo "<th>Day</th>";
            echo "<th>Date</th>";
            echo "<th>Car Number</th>";
            echo "<th>Car Model</th>";
            echo "<th>Charging</th>";
            echo "<th>status</th>";
            echo "<th>Booking Slip</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while ($slot_result = mysqli_fetch_array($res)) {
                echo "<tbody>";
                echo "<tr>";
                echo "<td>" . $slot_result['name'] . "</td>";
                echo "<td>" . $slot_result['phone_number'] . "</td>";
                echo "<td>" . $slot_result['slot_time'] . "</td>";
                echo "<td>" . $slot_result['schedule_day'] . "</td>";
                echo "<td>" . $slot_result['schedule_date'] . "</td>";
                echo "<td>" . $slot_result['car_num'] . "</td>";
                echo "<td>" . $slot_result['car_model'] . "</td>";
                echo "<td>" . $slot_result['charging_required'] . "%</td>";
                echo "<td>" . $slot_result['sch_status'] . "</td>";
                echo "<td>";
                if ($slot_result['sch_status'] == "Processing") {
                    echo "<a href='' style='pointer-events: none;' class='invoice-btn-red'>Download</a>";
                } else {
                    echo "<a href=invoice.php?id=" . $slot_result['booking_id'] . "&schid=" . $slot_result['schedule_id'] . " class='invoice-btn-green'>Download</a>";
                }
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </div>

    </div>

    <div class="footer">
        <p>&copy; Copyright <b><span style="color: black;">ELECT</span><span style="color: green;">RON</span></b>. All Rights Reserved</p>
    </div>
</body>

</html>