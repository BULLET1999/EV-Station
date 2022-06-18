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
    <link rel="stylesheet" href="css/backend.css">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <title>Declined Host - Electron</title>
</head>
<body>
    <div class="admin_user_navbar">
        <a href="admin_page.php">Home</a>
        <a href="contact_us.html">Support</a>
        <a href="about.html">About Us</a>
        <a href="logout.php" style="float: right;">Logout</a>
        <a href="#" class="user_name" style="float: right;"><?php echo $fetch['name']; ?></a>
    </div>

    <div class="admin_menu_row">
        <p><span style="color: black;">ELECT</span><span style="color: green;">RON</span></p>
        <a href="admin_page.php" ><i class='fas fa-home'></i> Dashboard</a>
        <a href="admin_details.php"><i class='fas fa-user-tie'></i> Admin</a>
        <a href="user_details.php"><i class='fas fa-user'></i> User</a>
        <a href="host_details.php"><i class='fas fa-user-check'></i> Host</a>        
        <a href="pending_request.php"><i class='fas fa-user-clock'></i> Pending Requests</a>
        <a href="declined_host_request.php"><i class='fas fa-user-times'></i> Declined Request</a>
        <a href="suspend_host.php"><i class='fas fa-user-slash'></i> Suspended Host</a>
    </div>

    <div class="table_container">
        <?php
        require_once "config.php";
        $sql = "SELECT * FROM user_form WHERE user_type ='host' && Status = 'Declined' ";
        if ($result = mysqli_query($conn, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                echo '<table style = "border: 1px solid black" class="table table-bordered table-striped">';
                echo "<thead>";
                echo "<tr>";
                echo "<th>Name</th>";
                echo "<th>Phone Number</th>";
                echo "<th>Email</th>";
                echo "<th>Status</th>";
                echo "<th>Edit</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['phone_number'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td>";
                    echo '<a href="approve_request.php?id=' . $row['id'] . '" class="accept" >Approve</a>';                    
                    echo "</td>";
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
    <div class="footer">
        <p>&copy; Copyright <b><span style="color: black;">ELECT</span><span style="color: green;">RON</span></b>. All Rights Reserved</p>
    </div>
</body>
</html>