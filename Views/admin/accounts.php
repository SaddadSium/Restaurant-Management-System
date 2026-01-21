<?php
session_start();
include '../../Controller/db_connect.php';

// Daily Income
$d_sql = "SELECT SUM(total_price) as total FROM orders WHERE DATE(order_date) = CURDATE()";
$d_res = mysqli_fetch_assoc(mysqli_query($conn, $d_sql));
$daily = $d_res['total'] ? $d_res['total'] : 0;

// Weekly Income
$w_sql = "SELECT SUM(total_price) as total FROM orders WHERE WEEK(order_date) = WEEK(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())";
$w_res = mysqli_fetch_assoc(mysqli_query($conn, $w_sql));
$weekly = $w_res['total'] ? $w_res['total'] : 0;

// Monthly Income
$m_sql = "SELECT SUM(total_price) as total FROM orders WHERE MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())";
$m_res = mysqli_fetch_assoc(mysqli_query($conn, $m_sql));
$monthly = $m_res['total'] ? $m_res['total'] : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accounts & Reports</title>
    <link rel="stylesheet" href="../../Menu/menu.css">
    <link rel="stylesheet" href="../dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Accounts & Sales Report</h1>
        
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="order_manager.php">Orders</a>
            <a href="accounts.php" style="border-bottom: 2px solid #D4AF37;">Accounts</a>
            <a href="../../Views/logout.php" class="logout-btn">Logout</a>
        </div>

        <div class="report-box">
            <div class="box">
                <h3>Today's Income</h3>
                <p><?php echo $daily; ?> TK</p>
            </div>
            <div class="box">
                <h3>Weekly Income</h3>
                <p><?php echo $weekly; ?> TK</p>
            </div>
            <div class="box">
                <h3>Monthly Income</h3>
                <p><?php echo $monthly; ?> TK</p>
            </div>
        </div>
        
        <h2 style="text-align: center; margin-top: 50px; color: #D4AF37;">Recent Transactions</h2>
        </div>
</body>
</html>