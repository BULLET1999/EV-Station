<?php
@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
}
?>
<?php
$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$admin_id'") or die('query failed');
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
    <title>Admin - Electron</title>
</head>

<body>
    <div class="admin_user_navbar">
        <a href="admin_page.php">Home</a>
        <a href="contact_us.html">Support</a>
        <a href="about.html">About Us</a>
        <a href="logout.php" style="float: right;">Logout</a>
        <a href="#" class="user_name" style="float: right;">Hii, <?php echo $fetch['name']; ?></a>
    </div>

    <div class="admin_menu_row">
        <p><span style="color: black;">ELECT</span><span style="color: green;">RON</span></p>
        <a href="admin_page.php"><i class='fas fa-desktop'></i> Dashboard</a>
        <a href="admin_details.php"><i class='fas fa-user-tie'></i> Admin</a>
        <a href="user_details.php"><i class='fas fa-user'></i> User</a>
        <a href="host_details.php"><i class='fas fa-user-check'></i> Host</a>
        <a href="pending_request.php"><i class='fas fa-user-clock'></i> Pending Requests</a>
        <a href="declined_host_request.php"><i class='fas fa-user-times'></i> Declined Request</a>
        <a href="suspend_host.php"><i class='fas fa-user-slash'></i> Suspended Host</a>
    </div>

    <div class="right_to_menu">
        <div class="flex-container">
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query('SELECT COUNT(*) FROM user_form WHERE user_type = "admin" && Status = "Approved";') as $row) {
                    echo "<span class='count' style='color: #16bbe5;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>ADMIN</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query('SELECT COUNT(*) FROM user_form WHERE user_type = "host" && Status = "Approved";') as $row) {
                    echo "<span class='count' style='color: #ea5d5d;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>HOST</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query('SELECT COUNT(*) FROM user_form WHERE user_type = "user"') as $row) {
                    echo "<span class='count' style='color: #fcad73;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>USER</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query('SELECT COUNT(*) FROM user_form WHERE user_type = "host" && Status = "Pending";') as $row) {
                    echo "<span class='count' style='color: #2daab8;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>PENDING REQUESTS</p>
            </div>
        </div>
        <div class="flex-container">
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query('SELECT COUNT(*) FROM user_form WHERE user_type = "host" && Status = "Suspended";') as $row) {
                    echo "<span class='count' style='color: #16bbe5;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>SUSPENDED HOSTS</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query('SELECT COUNT(*) FROM user_form WHERE user_type = "host" && Status = "Declined";') as $row) {
                    echo "<span class='count' style='color: #ea5d5d;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>DECLINED REQUESTS</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query('SELECT COUNT(*) FROM user_form') as $row) {
                    echo "<span class='count' style='color: #fcad73;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>TOTAL USER</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query('SELECT COUNT(*) FROM slot_booking WHERE sch_status = "Approved" ') as $row) {
                    echo "<span class= 'count' style='color: #2daab8;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>APPROVED BOOKINGS</p>
            </div>            
        </div>

        <div class="flex-container">
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query(" SELECT COUNT(*) FROM slot_booking WHERE sch_status = 'Pending' ;") as $row) {
                    echo "<span class='count' style='color: #16bbe5;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>PENDING BOOKINGS</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query("SELECT COUNT(*) FROM slot_booking WHERE sch_status = 'DENIED' ;") as $row) {
                    echo "<span class='count' style='color: #ea5d5d;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>REJECTED BOOKINGS</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query(" SELECT COUNT(*) FROM slot_booking; ") as $row) {
                    echo "<span class='count' style='color: #fcad73;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>TOTAL BOOKINGS</p>
            </div>
            <div>
                <?php
                require 'config.php';
                foreach ($conn->query(" SELECT COUNT(*) FROM host_schedule;") as $row) {
                    echo "<span class='count' style='color: #2daab8;'>" . $row['COUNT(*)'] . "</span>";
                }
                ?>
                <p>TOTAL SLOTS</p>
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