<!--Developed by Sium-->
<?php
session_start();
if ($_SESSION['role'] !== 'Admin') header("Location: ../../Login/login.php");
require_once '../../Controller/db_connect.php';
?>
<!doctype html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../home.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin</h2>
        <a href="../../Login/logout.php">Logout</a>
    </div>
    <div class="main-content">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['fullname']; ?></p>
    </div>
</body>
</html>
<!--Developed by Sium-->