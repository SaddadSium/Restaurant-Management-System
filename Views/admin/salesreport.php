<?php
session_start();
date_default_timezone_set('Asia/Dhaka'); 
include '../../Controller/db_connect.php';
$current_date = date('Y-m-d');

// --- Daily Income ---
$d_sql = "SELECT SUM(total_price) as total FROM orders WHERE DATE(order_date) = '$current_date'";
$d_res = mysqli_fetch_assoc(mysqli_query($conn, $d_sql));
$daily = $d_res['total'] ? $d_res['total'] : 0;

// --- Weekly Income ---
$w_sql = "SELECT SUM(total_price) as total FROM orders WHERE WEEK(order_date) = WEEK('$current_date') AND YEAR(order_date) = YEAR('$current_date')";
$w_res = mysqli_fetch_assoc(mysqli_query($conn, $w_sql));
$weekly = $w_res['total'] ? $w_res['total'] : 0;

// --- Monthly Income ---
$m_sql = "SELECT SUM(total_price) as total FROM orders WHERE MONTH(order_date) = MONTH('$current_date') AND YEAR(order_date) = YEAR('$current_date')";
$m_res = mysqli_fetch_assoc(mysqli_query($conn, $m_sql));
$monthly = $m_res['total'] ? $m_res['total'] : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reports | S & S  Heritage</title>
    <link rel="stylesheet" href="../../home.css">
    
    <link rel="stylesheet" href="../dashboard.css">
</head>
<body>

<div id="logo">
        <img src="../../logo.png" alt="logo">
    </div>

    <div class="" id="navbar">
            <ul>
               <li><a href="dashboard.php">Dash Board</a></li>
                <li><a href="order_manager.php">Manage Order's</a></li><li>
                <li><a href="salesreport.php">Sale's Report</a></li>
                <li><a href="manage_menu.php">Update Menu</a></li>
                <li><a href="adduser.php">Add User</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>

    </div> 


    <div class="dashboard-container">
        <h1>Accounts & Sales Report</h1>

        <div class="report-box">
            
            <div class="box">
                <h3>Today's Income</h3>
                <p><?php echo number_format($daily, 2); ?> TK</p>
            </div>

            <div class="box">
                <h3>Weekly Income</h3>
                <p><?php echo number_format($weekly, 2); ?> TK</p>
            </div>

            <div class="box">
                <h3>Monthly Income</h3>
                <p><?php echo number_format($monthly, 2); ?> TK</p>
            </div>
            
        </div>
    </div>

</body>
</html>