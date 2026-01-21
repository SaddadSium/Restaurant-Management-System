<?php
session_start();
date_default_timezone_set('Asia/Dhaka');
include '../../Controller/db_connect.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../Views/login.php");
    exit();
}

// Pending Orders
$pending_sql = "SELECT COUNT(*) as count FROM orders WHERE order_status = 'Pending'";
$pending_res = mysqli_fetch_assoc(mysqli_query($conn, $pending_sql));
$pending_orders = $pending_res['count'];

// Today's Sales 
$current_date = date('Y-m-d');
$daily_sql = "SELECT SUM(total_price) as total FROM orders WHERE DATE(order_date) = '$current_date'";
$daily_res = mysqli_fetch_assoc(mysqli_query($conn, $daily_sql));
$today_sales = $daily_res['total'] ? $daily_res['total'] : 0;

// Total Customers
$user_sql = "SELECT COUNT(*) as count FROM users WHERE role = 'Customer'";
$user_res = mysqli_fetch_assoc(mysqli_query($conn, $user_sql));
$total_customers = $user_res['count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | S&S Heritage</title>
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
        <div class="welcome-section">
            <h2>Admin Dashboard</h2>
            <p>Welcome back<?php echo $_SESSION['fullname']; ?></p>
        </div>

        <div class="report-box">
            <div class="box" style="border-color: #ff6b6b;">
                <h3 style="color: #ff6b6b;">Pending Orders</h3>
                <p style="color: white;"><?php echo $pending_orders; ?></p>
            </div>
            <div class="box">
                <h3>Today's Income</h3>
                <p><?php echo number_format($today_sales, 2); ?> TK</p>
            </div>
            <div class="box" style="border-color: #7bed9f;">
                <h3 style="color: #7bed9f;">Total Customers</h3>
                <p style="color: white;"><?php echo $total_customers; ?></p>
            </div>
        </div>
        
    </div>
</body>
</html>