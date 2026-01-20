<?php
session_start();
include '../../Controller/db_connect.php';

// অর্ডার ডিলিট
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM orders WHERE order_id=$id");
    header("Location: order_manager.php");
}

$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Manager</title>
    <link rel="stylesheet" href="../../Menu/menu.css">
    <link rel="stylesheet" href="../dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h1>Admin Order Manager</h1>
        
        <div class="nav-links">
            <a href="dashboard.php">Dashboard</a>
            <a href="order_manager.php" style="border-bottom: 2px solid #D4AF37;">Orders</a>
            <a href="accounts.php">Accounts</a>
            <a href="../../Login/logout.php" class="logout-btn">Logout</a>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Food Items</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['food_name']; ?></td>
                    <td><?php echo $row['total_price']; ?> TK</td>
                    <td><?php echo $row['order_date']; ?></td>
                    <td><?php echo $row['order_status']; ?></td>
                    <td>
                        <a href="order_manager.php?delete=<?php echo $row['order_id']; ?>" class="del-btn" onclick="return confirm('Delete this order?');">Delete</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>