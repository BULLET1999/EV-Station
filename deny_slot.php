<?php
    include 'config.php';
    $update_status = $_GET['id'];
    $id = mysqli_real_escape_string($conn, $update_status);
    mysqli_query($conn,"UPDATE slot_booking SET status = 'Denied' WHERE booking_id= '$id' ");    
    header('location: view_slot_booking.php')
?>