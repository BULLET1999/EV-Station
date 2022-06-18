<?php
@include 'config.php';
session_start();
$host_id = $_SESSION['host_id'];

if (!isset($_SESSION['host_id'])) {
    header('location:login.php');
}

$select_host = mysqli_query($conn, "SELECT * FROM `host_details` WHERE host_id = '$host_id'") or die('query failed');
if (mysqli_num_rows($select_host) > 0) {
    $fetch_host = mysqli_fetch_assoc($select_host);
}



if (isset($_POST['submit'])) {
    $schdate = mysqli_real_escape_string($conn, $_POST['schdate']);
    $schday  = mysqli_real_escape_string($conn, $_POST['schday']);
    $starttime = mysqli_real_escape_string($conn, $_POST['starttime']);
    $endtime = mysqli_real_escape_string($conn, $_POST['endtime']);
    $chargers = mysqli_real_escape_string($conn, $_POST['chargers']);
    $schavail = mysqli_real_escape_string($conn, $_POST['schavail']);
    $host_city = $fetch_host['city'];
    //INSERT
    $insert = " INSERT INTO host_schedule ( start_time, end_time, schedule_day, schedule_date, availability, host_id , chargers, host_city) 
    VALUES ( '$starttime', '$endtime', '$schday', '$schdate', '$schavail', '$host_id', '$chargers', '$host_city' ) ";
    mysqli_query($conn, $insert);

    if ($insert) {
        header("Location: addslot.php");
    } else {
    }
}
?>

<?php
$select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$host_id'") or die('query failed');
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
    <title>Create Slot - Electron</title>

    <style>
        .user_footer {
            background-color: white;
            padding: 20px;
            text-align: center;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
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
        <div class="host_content">
            <div class="row">
                <div class="row_heading">
                    <h2 class="page-header">Host Schedule</h2>
                    <ol class="breadcrumb">
                        <li class="active"><i class="fa fa-calendar"></i> Schedule</li>
                    </ol>
                </div>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Schedule</h3>
                </div>

                <div class="panel-body">
                    <form method="POST">
                        <div class="input-container">
                            <div class="input-field_name">
                                <p>Date<span style="color: red;">*</span></p>
                            </div>
                            <div class="input-field">
                                <i class='far fa-calendar-alt'></i>
                                <input id="date" type="date" placeholder="Date" id="schdate" name="schdate" required>
                            </div>
                        </div>

                        <div class="input-container">
                            <div class="input-field_name">
                                <p>Day<span style="color: red;">*</span></p>
                            </div>
                            <div class="input-field">
                                <i class='fas fa-calendar-day'></i>
                                <select id="schday" name="schday" required>
                                    <option value="Day Not Selected">Selected None</option>                                
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>                                    
                                    <option value="Saturday">Saturday</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-container">
                            <div class="input-field_name">
                                <p>Start Time(24hrs)<span style="color: red;">*</span></p>
                            </div>
                            <div class="input-field">
                                <i class='far fa-clock'></i>
                                <input type="time" placeholder="Start Time" id="starttime" name="starttime" required>
                            </div>
                        </div>

                        <div class="input-container">
                            <div class="input-field_name">
                                <p>End Time(24hrs)<span style="color: red;">*</span></p>
                            </div>
                            <div class="input-field">
                                <i class='far fa-clock'></i>
                                <input type="time" placeholder="End Time" id="endtime" name="endtime" required>
                            </div>
                        </div>

                        <div class="input-container">
                            <div class="input-field_name">
                                <p>Number of Chargers<span style="color: red;">*</span></p>
                            </div>
                            <div class="input-field">
                                <i class='far fa-clock'></i>
                                <input type="text" placeholder="Number of chargers" id="chargers" name="chargers" required>
                            </div>
                        </div>

                        <div class="input-container">
                            <div class="input-field_name">
                                <p>Availability<span style="color: red;">*</span></p>
                            </div>
                            <div class="input-field">
                                <i class='far fa-check-circle'></i>
                                <select id="schavail" name="schavail" required>
                                    <option value="Available">Selected None </option>
                                    <option value="Available">Available</option>
                                    <option value="Not Available">Not Available</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" name="submit" class="panel_btn">Submit</button>
                    </form>
                </div>
            </div>

            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Added Schedule's</h3>
                </div>
                <div class="panel-body">
                    <div class="">
                        <?php
                        require_once "config.php";
                        $sql = "SELECT * FROM host_schedule WHERE host_id ='$host_id' ";
                        if ($result = mysqli_query($conn, $sql)) {
                            if (mysqli_num_rows($result) > 0) {
                                echo '<table style = "border: 1px solid black">';
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Schedule Id</th>";
                                echo "<th>Schedule Date</th>";
                                echo "<th>Schedule Day</th>";
                                echo "<th>From</th>";
                                echo "<th>To</th>";
                                echo "<th>Availability</th>";
                                echo "<th>Chargers</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($row = mysqli_fetch_array($result)) {
                                    echo "<tr>";
                                    echo "<td>" . $row['schedule_id'] . "</td>";
                                    echo "<td>" . $row['schedule_date'] . "</td>";                            
                                    echo "<td>" . $row['schedule_day'] . "</td>";
                                    echo "<td>" . $row['start_time'] . "</td>";
                                    echo "<td>" . $row['end_time'] . "</td>";                                    
                                    echo "<td>" . $row['availability'] . "</td>";
                                    echo "<td>" . $row['chargers'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                                echo "</table>";
                                mysqli_free_result($result);
                            } else {
                                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                            }
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>
            
            <div class="user_footer">
                <p>&copy; Copyright <b><span style="color: black;">ELECT</span><span style="color: green;">RON</span></b>. All Rights Reserved</p>
            </div>

        </div>
    </div>
</body>

</html>