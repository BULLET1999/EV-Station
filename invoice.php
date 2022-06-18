<?php
@include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

$invoice_id = $_GET['id'];
$sch_id = $_GET['schid'];

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
}

$res=mysqli_query($conn, "SELECT a.*, b.*,c.*,d.* FROM user_form a
JOIN slot_booking b
On a.id = b.user_id
JOIN host_schedule c
On b.scheduleid = c.schedule_id
JOIN host_details d
On c.host_id = d.host_id
WHERE user_id  = '$user_id' && schedule_id = '$sch_id' ");

$userRow=mysqli_fetch_array($res,MYSQLI_ASSOC);
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/invoice.css">
    <title>Booking confirmation Slip</title>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <p class="company-logo"><span style="color: Black;">ELCT</span><span style="color: Green;">RON</span></p>
                                <p class="company-slogon">A True Charging Solution For India.</p>
                            </td>
                            <td style="text-align: right;">
                                <p> Invoice: #<?php echo $invoice_id; ?> <br>
                                Created: <?php echo  date("d.m.y"); ?> </p>
                                
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="information">
                <td colspan="2">
                    <table cellpadding= "0" cellspacing="0">
                        <tr>
                            <td style="width: 50%; text-align: left;">
                                <p class="address-head">Charging Station Address</p>
                                <p class="address-text"><?php echo $userRow['host_address'];?>, <?php echo $userRow['city'];?>, <?php echo $userRow['state'];?> - <?php echo $userRow['pincode'];?></p>
                            </td>
                            <td style="width: 50%; text-align: left;">
                                <p class="address-head">Host Details</p>
                                <p class="address-text">Name: <?php echo $userRow['host_name'];?><br> Phone Number: <?php echo $userRow['host_phone_number'];?> <br>
                                Email: <?php echo $userRow['host_email'];?> <br>                    
                            </p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <td>
                    Slot Details
                </td>
                <td>
                    #
                </td>
            </tr>
            <tr class="item">
                <td>
                    Booking ID
                </td>
                <td>
                    <?php echo $userRow['booking_id'];?>
                </td>
            </tr>

            <tr class="item">
                <td>
                    Schedule ID
                </td>
                <td>
                <?php echo $userRow['schedule_id'];?>
                </td>
            </tr>

            <tr class="item">
                <td>
                    Name
                </td>
                <td>
                <?php echo $userRow['name'];?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    Contact Number
                </td>
                <td>
                <?php echo $userRow['phone_number'];?>
                </td>
            </tr>

            <tr class="item">
                <td>
                    Email
                </td>
                <td>
                <?php echo $userRow['email'];?>
                </td>
            </tr>

            <tr class="item">
                <td>
                    Schedule Day
                </td>
                <td>
                <?php echo $userRow['schedule_day'];?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    Schedule Date
                </td>
                <td>
                <?php echo $userRow['schedule_date'];?>
                </td>
            </tr>
            <tr class="item">
                <td>
                    Schedule Time
                </td>
                <td>
                <?php echo $userRow['slot_time'];?>
                </td>
            </tr>

            <tr class="item">
                <td>
                    Car Number
                </td>
                <td>
                <?php echo $userRow['car_num'];?>
                </td>
            </tr>

            <tr class="item">
                <td>
                    Car Model
                </td>
                <td>
                <?php echo $userRow['car_model'];?>
                </td>
            </tr>

            <tr class="item">
                <td>
                    Booking Status
                </td>
                <td>
                <?php echo $userRow['sch_status'];?>
                </td>
            </tr>



        </table>
    </div>
    <div class="print">
        <button class="print-btn" onclick="myFunction()">PRINT</button>
    </div>
    <script>
        function myFunction() {
            window.print();
        }
    </script>
</body>

</html>