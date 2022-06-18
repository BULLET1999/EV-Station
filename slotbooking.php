<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];
$slot_number = $_GET['schid'];
$hostid = $_GET['hostid'];

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
}

$select_slot = mysqli_query($conn, "SELECT * FROM `host_schedule` WHERE schedule_id = '$slot_number'") or die('query failed');
if (mysqli_num_rows($select_slot) > 0) {
    $fetch_slot = mysqli_fetch_assoc($select_slot);
}

if (isset($_POST['confirm_booking'])) {
    $slot_date = mysqli_real_escape_string($conn, $fetch_slot['schedule_date']);
    $carnum = mysqli_real_escape_string($conn, $_POST['carnum']);
    $carmodel = mysqli_real_escape_string($conn, $_POST['carmodel']);
    $cartime = mysqli_real_escape_string($conn, $_POST['cartime']);
    $chargerper = mysqli_real_escape_string($conn, $_POST['chargerper']);


    $query = "INSERT INTO slot_booking (  scheduleid, slot_date, user_id, car_num, car_model, slot_time, charging_required, hostid, sch_status ) 
    VALUES ( '$slot_number','$slot_date', '$user_id', '$carnum', '$carmodel', '$cartime', '$chargerper', '$hostid', 'Processing' ) ";

    $result = mysqli_query($conn, $query);
    if ($result) {
?>
        <script type="text/javascript">
            alert('Appointment made successfully.');
        </script>
    <?php
        header("Location: booking_summary.php");
    } else {
        echo mysqli_error($conn);
    ?>
        <script type="text/javascript">
            alert('Appointment booking fail. Please try again.');
        </script>
<?php
        header("Location: slotbook.php");
    }
}
?>

<?php
$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
if (mysqli_num_rows($select) > 0) {
    $fetch = mysqli_fetch_assoc($select);
}
?>

<?php

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="css/backend.css">
    <title>Confirm Booking - Electron</title>
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
        <div class="slot">
            <div class="book-slot">
                <h1>Confirm Your Booking</h1>
                <div class="user-info">
                    <p class="user-heading">User Information</p>
                    <p class="user-detials">ID: <span class="info"><?php echo $fetch['id']; ?></span> </p>
                    <p class="user-detials">Name: <span class="info"><?php echo $fetch['name']; ?></span> </p>
                    <p class="user-detials">Mobile Number: <span class="info"><?php echo $fetch['phone_number']; ?></span> </p>
                    <p class="user-detials">Email: <span class="info"><?php echo $fetch['email']; ?></span></p>
                </div>

                <div class="slot-info">
                    <p class="user-heading">Slot Information</p>
                    <p class="user-detials">Date: <span class="info"><?php echo $fetch_slot['schedule_date']; ?></span> </p>
                    <p class="user-detials">Day: <span class="info"><?php echo $fetch_slot['schedule_day']; ?></span> </p>
                    <p class="user-detials">Time: <span class="info"><?php echo $fetch_slot['start_time']; ?> - <?php echo $fetch_slot['end_time']; ?></span> </p>
                    <p class="user-detials">City: <span class="info"><?php echo $fetch_slot['host_city']; ?></span></p>
                </div>

                <div class="car-form">
                    <form method="POST">
                        <div class="input-car-info">
                            <input type="text" class="car-info" name="carnum" placeholder="Car Number" pattern="^[A-Z]{2}\s[0-9]{2}\s[A-Z]{2}\s[0-9]{4}$" required>
                            <input type="text" class="car-info" name="carmodel" placeholder="Car Model" required>
                            <input type="text" class="car-info" name="chargerper" placeholder="Charge Needed in %" required>
                            <input type="time" class="car-info" name="cartime" required>
                            <button type="submit" class="search_slot" name="confirm_booking">Confirm</button>
                        </div>
                    </form>
                    <p>Note <span style="color: red;">*</span></p>
                    <p class="">1. Please Enter the car number in (<span style="color: red;">DL 04 AB 2645</span>) this format.</p>
                    <p>2. Check your time before confirming.</p>
                </div>
            </div>
        </div>
    </div>


    <div class="footer">
        <p>&copy; Copyright <b><span style="color: black;">ELECT</span><span style="color: green;">RON</span></b>. All Rights Reserved</p>
    </div>
</body>

</html>