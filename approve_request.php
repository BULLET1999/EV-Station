<?php
    include 'config.php';
    $update_status = $_GET['id'];
    $id = mysqli_real_escape_string($conn,$update_status);
    mysqli_query($conn,"UPDATE user_form SET status = 'Approved' WHERE id= '$id' ");
    
    header('location: pending_request.php')

?>