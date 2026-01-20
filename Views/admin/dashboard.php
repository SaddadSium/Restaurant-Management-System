<?php
session_start();
include '../../Controller/db_connect.php';

// চেক করা হচ্ছে অ্যাডমিন লগইন আছে কিনা
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../Login/login.php");
    exit();
}

// --- Quick Stats (ড্যাশবোর্ডে দেখানোর জন্য ডাটা আনা) ---

// ১. পেন্ডিং অর্ডার সংখ্যা (যেগুলো রান্না বা সার্ভ করা বাকি)
$pending_sql = "SELECT COUNT(*) as count FROM orders WHERE order_status = 'Pending'";
$pending_res = mysqli_fetch_assoc(mysqli_query($conn, $pending_sql));
$pending_orders = $pending_res['count'];

// ২. আজকের মোট সেল
$daily_sql = "SELECT SUM(total_price) as total FROM orders WHERE DATE(order_date) = CURDATE()";
$daily_res = mysqli_fetch_assoc(mysqli_query($conn, $daily_sql));
$today_sales = $daily_res['total'] ? $daily_res['total'] : 0;

// ৩. মোট কাস্টমার সংখ্যা
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
    <link rel="stylesheet" href="../../Menu/menu.css"> <link rel="stylesheet" href="../dashboard.css">    <style>
        /* এই পেজের জন্য স্পেশাল কিছু স্টাইল */
        .welcome-section {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 1px solid #444;
            padding-bottom: 20px;
        }
        .welcome-section h2 {
            color: #D4AF37;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .welcome-section p {
            color: #ccc;
            font-size: 1.1rem;
        }
        
        /* কুইক অ্যাকশন বাটন */
        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 50px;
        }
        .action-card {
            background: rgba(212, 175, 55, 0.1);
            border: 1px solid #D4AF37;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            transition: 0.3s;
            text-decoration: none;
        }
        .action-card:hover {
            background: #D4AF37;
            transform: translateY(-5px);
        }
        .action-card h3 {
            color: white;
            font-size: 1.2rem;
            text-transform: uppercase;
        }
        .action-card:hover h3 {
            color: #1b1b1b;
        }
    </style>
</head>
<body>

    <div class="dashboard-container">
        
        <div class="welcome-section">
            <h2>Admin Dashboard</h2>
            <p>Welcome back, <?php echo $_SESSION['fullname']; ?></p>
        </div>

        <div class="nav-links">
            <a href="dashboard.php" style="border-bottom: 2px solid #D4AF37;">Dashboard</a>
            <a href="order_manager.php">Order Manager</a>
            <a href="accounts.php">Accounts & Reports</a>
            <a href="../../Login/logout.php" class="logout-btn">Logout</a>
        </div>

        <div class="report-box">
            <div class="box" style="border-color: #ff6b6b;">
                <h3 style="color: #ff6b6b;">Pending Orders</h3>
                <p style="color: white;"><?php echo $pending_orders; ?></p>
            </div>

            <div class="box">
                <h3>Today's Income</h3>
                <p><?php echo $today_sales; ?> TK</p>
            </div>

            <div class="box" style="border-color: #7bed9f;">
                <h3 style="color: #7bed9f;">Total Customers</h3>
                <p style="color: white;"><?php echo $total_customers; ?></p>
            </div>
        </div>

        <h3 style="text-align: center; color: #D4AF37; margin-top: 40px;">Quick Actions</h3>
        <div class="action-grid">
            <a href="order_manager.php" class="action-card">
                <h3>Manage Orders</h3>
                <span style="color: #ccc; font-size: 0.9rem;">View, Edit or Delete Orders</span>
            </a>
            
            <a href="accounts.php" class="action-card">
                <h3>View Accounts</h3>
                <span style="color: #ccc; font-size: 0.9rem;">Check Daily/Monthly Sales</span>
            </a>

            <a href="../../Menu/menu.php" class="action-card">
                <h3>Visit Menu</h3>
                <span style="color: #ccc; font-size: 0.9rem;">Check Food Items & Prices</span>
            </a>
        </div>

    </div>

</body>
</html>