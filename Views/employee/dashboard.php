<!--Developed by Sium-->
<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Employee') {
    header("Location: ../../Login/login.php");
    exit();
}
?>

<!doctype html>
<html>
<head>
    <title>Staff Dashboard | S&S Heritage</title>
    <link rel="stylesheet" href="../../home.css">
    <link rel="stylesheet" href="employee.css">
</head>
<body>
    
    <div class="top-nav">
        <div class="logo">S&S Staff Panel</div>
        <div class="user-info">
            <span><?php echo $_SESSION['fullname']; ?> (Staff)</span>
            <a href="../../Login/logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <h1>Assigned Tasks</h1>
        <div class="task-grid">
            <div class="task-box">
                <h2>Active Orders</h2>
                <p>Manage incoming food orders.</p>
                <a href="#" class="action-btn">View Orders</a>
            </div>
            </div>
    </div>
</body>
</html>
<!--Developed by Sium-->