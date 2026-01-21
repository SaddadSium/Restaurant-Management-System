<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "registration";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($host, $user, $pass, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role']; 

    if ($password !== $confirm_password) {
        $message = "<p style='color:red'>Passwords do not match!</p>";
    } else {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $fullname, $username, $email, $hashed_password, $role);
            
            if ($stmt->execute()) {
                $message = "<p style='color:green'>User created successfully!</p>";
            }
            $stmt->close();
        } catch (mysqli_sql_exception $e) {
            $message = "<p style='color:red'>Error: Username or Email already exists.</p>";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User | Admin Dashboard</title>
    <link rel="stylesheet" href="../../home.css"> 
    <link rel="stylesheet" href="../dashboard.css">
    <link rel="stylesheet" href="adduser.css">
</head>
<body>

    <div id="logo">
        <img src="../../logo.png" alt="logo">
    </div>

    <div id="navbar">
        <ul>
            <li><a href="dashboard.php">Dash Board</a></li>
            <li><a href="order_manager.php">Manage Order's</a></li>
            <li><a href="salesreport.php">Sale's Report</a></li>
            <li><a href="manage_menu.php">Update Menu</a></li>
            <li><a href="adduser.php">Add User</a></li>
            <li><a href="../login.php">Logout</a></li>
        </ul>
    </div> 

    <div class="main-content">
    <div class="form-container">
        <h2>Create New User</h2>
        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="fullname" required>

            <label>User Name</label>
            <input type="text" name="username" required>

            <label>Email Address</label>
            <input type="email" name="email" required>

            <label>Select Role</label>
            <div class="role-selection">
                <label><input type="radio" name="role" value="Admin" required> Admin</label>
                <label><input type="radio" name="role" value="Employee" required> Employee</label>
            </div>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Confirm Password</label>
            <input type="password" name="confirm_password" required>

            <button type="submit">Create Account</button>
        </form>
    </div>
</div>
</body>
</html>