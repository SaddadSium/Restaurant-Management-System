<?php
// File Location: views/admin/dashboard.php

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    // Login page e ferot pathano (2 dhap pichone giye Login folder)
    header("Location: ../../Login/login.php");
    exit();
}

// Database Connection Path Update
require_once '../../Controller/db_connect.php';

// Stats logic same thakbe
$cust_sql = "SELECT COUNT(*) as total_cust FROM users WHERE role='Customer'";
$cust_res = $conn->query($cust_sql);
$total_cust = $cust_res->fetch_assoc()['total_cust'];

$order_sql = "SELECT COUNT(*) as total_orders FROM orders"; 
$order_res = $conn->query($order_sql);
$total_orders = ($order_res) ? $order_res->fetch_assoc()['total_orders'] : 0;
?>

<!doctype html>
<html>
<head>
    <title>Admin Dashboard | S&S Heritage</title>
    <link rel="stylesheet" href="../../home.css"> 
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>S&S Admin</h2>
        </div>
        <ul class="nav-links">
            <li><a href="#" class="active">Dashboard</a></li>
            <li><a href="#">Manage Menu</a></li>
            <li><a href="#">Manage Orders</a></li>
            <li><a href="#">Reservations</a></li>
            <li><a href="#">User Reviews</a></li>
            <li class="logout"><a href="../../Login/logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Welcome, <?php echo $_SESSION['fullname']; ?></h1>
            <p>Admin Overview</p>
        </header>

        <div class="dashboard-cards">
            <div class="card">
                <h3>Total Customers</h3>
                <p class="number"><?php echo $total_cust; ?></p>
            </div>
            <div class="card">
                <h3>Total Orders</h3>
                <p class="number"><?php echo $total_orders; ?></p>
            </div>
            <div class="card">
                <h3>Pending Reservations</h3>
                <p class="number">0</p>
            </div>
            <div class="card">
                <h3>Today's Revenue</h3>
                <p class="number">$0.00</p>
            </div>
        </div>
        </div>
</body>
</html>