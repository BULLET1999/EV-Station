<?php
@include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
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
    <title>Find Slot - Electron</title>
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
        <div class="find_slot">
            <form method="POST">
                <div class="input-search">
                    <input id="date" type="date" class="findslot_bysearch" name="schdate" required>
                    <input type="text" class="findslot_bysearch" name="search" placeholder="Enter your City" required>
                    <button type="submit" class="search_slot" name="search_by_city">Search</button>                    
                </div>                
            </form>
        </div>

        <div class="show-table">
            <?php
            require_once "config.php";
            if (isset($_POST['search_by_city'])) {
                $city = $_POST['search'];
                $date = $_POST['schdate'];
                $sql = " SELECT * FROM host_schedule WHERE host_city = '$city' && schedule_date = '$date'  ";
                if ($result = mysqli_query($conn, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table style = "border: 1px solid black">';
                        echo "<thead>";
                        echo "<tr>";                        
                        echo "<th>Schedule Date</th>";
                        echo "<th>Schedule Day</th>";
                        echo "<th>From</th>";
                        echo "<th>To</th>";
                        echo "<th>City</th>";
                        echo "<th>Availability</th>";
                        echo "<th>Book</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";                            
                            echo "<td>" . $row['schedule_date'] . "</td>";
                            echo "<td>" . $row['schedule_day'] . "</td>";
                            echo "<td>" . $row['start_time'] . "</td>";
                            echo "<td>" . $row['end_time'] . "</td>";
                            echo "<td>" . $row['host_city'] . "</td>";
                            echo "<td>" . $row['availability'] . "</td>";
                            echo "<td>"; echo '<a href="slotbooking.php?schid=' . $row['schedule_id'] . '&hostid='. $row['host_id'] .'" class="book" >Book</a>'; " </td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        mysqli_free_result($result);
                    } else {
                        echo '<div class="alert alert-danger"><em>No slot available in you city of searched date.</em></div>';
                    }
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }                
            }
            ?>
        </div>

    </div>
    <div class="footer">
        <p>&copy; Copyright <b><span style="color: black;">ELECT</span><span style="color: green;">RON</span></b>. All Rights Reserved</p>
    </div>
</body>

</html>