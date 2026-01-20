<!--Developed by Sium-->
<?php
session_start();
require_once '../Controller/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $input_username = trim($_POST['username']);
    $input_password = $_POST['password'];

    $sql = "SELECT id, fullname, password, role FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $input_username, $input_username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($input_password, $user['password'])) {     
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role'];

                if (isset($_SESSION['redirect_url'])) {
                    $url = $_SESSION['redirect_url'];
                    unset($_SESSION['redirect_url']); 
                    header("Location: " . $url); 
                    exit();
                }
                if ($user['role'] === 'Admin') {
                    header("Location: ../views/admin/dashboard.php");
                } 
                elseif ($user['role'] === 'Employee') {
                    header("Location: ../views/employee/dashboard.php");
                } 
                else {
                    header("Location: ../views/customer/dashboard.php");
                }
                exit();

            } else {
                $error_msg = "Incorrect Password!";
            }
        } else {
            $error_msg = "User not found!";
        }
        $stmt->close();
    } else {
        $error_msg = "Database error!";
    }
    $conn->close();
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login | S&S Heritage</title>
        <link rel="stylesheet" href="../home.css">
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        
        <div id="logo">
             <img src="../logo.png" alt="S&S Heritage Logo">
        </div>

        <div id="navbar">
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../Menu/menu.php">Menu</a></li>
                <li><a href="../AboutUs/aboutus.php">About Us</a></li> 
                <li><a href="../CustomerReview/review.php">Customer's Reviews</a></li>
                <li><a href="login.php" class="active">Log In</a></li>
            </ul>
        </div>

        <div class="login-container">
            <div class="login-box">
                <div class="login-header">
                    <h1>Welcome Back</h1>
                    <p>Sign in to S&S Heritage</p>
                    
                    <?php if(!empty($error_msg)) { ?>
                        <p style="color: red; font-weight: bold;"><?php echo $error_msg; ?></p>
                    <?php } ?>

                </div>

                <form action="" method="POST">
                    <div class="input-group">
                        <label for="username">Username or Email</label>
                        <input type="text" id="username" name="username" required>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="login-btn">LOG IN</button>
                </form>

                <div class="register-link">
                    <p>New to S&S Heritage? <a href="../Controller/registration.php">Create an Account</a></p>
                </div>
            </div>
        </div>
    </body>
</html>
<!--Developed by Sium-->