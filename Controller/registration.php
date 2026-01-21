<!--Developed by Sium-->
<?php
require_once 'db_connect.php';

$success_msg = "";
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error_msg = "Passwords do not match!";
    } else {
        // Check Duplicate
        $checkQuery = "SELECT id FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param("ss", $email, $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error_msg = "Email or Username already exists!";
        } else {
            // Register User
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (fullname, email, username, password, role) VALUES (?, ?, ?, ?, 'Customer')";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("ssss", $fullname, $email, $username, $hashed_password);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Registration Successful! Please Login.');
                        window.location.href='../Views/login.php';
                      </script>";
                exit();
            } else {
                $error_msg = "Registration failed! Try again.";
            }
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register | S&S Heritage</title>
        <link rel="stylesheet" href="../home.css">
        <link rel="stylesheet" href="registration.css">
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

             <?php 
                 if (isset($_SESSION['user_id'])) {

                 echo '<li><a href="../Views/customer/dashboard.php">Dashboard</a></li>';
                 echo '<li><a href="../Views/logout.php">Log Out</a></li>';

                    } 

                 else {

                 echo '<li><a href="../Views/login.php">Log In</a></li>';
                        
                    }

             ?>
         </ul>
        </div>

        <div class="reg-container">
            <div class="reg-box">
                <div class="reg-header">
                    <h1>Join Us</h1>
                    <p>Create your account at S&S Heritage</p>

                    <?php 
                    if(!empty($error_msg)) 
                    { ?>
                        <p style="color: red; margin-bottom: 10px;"><?php echo $error_msg; ?></p>
                    <?php } ?>

                </div>

                <form action="" method="POST">
                    
                    <div class="input-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" id="fullname" name="fullname" required value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>">
                    </div>

                    <div class="input-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                    </div>

                    <div class="input-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="input-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>

                    <button type="submit" class="reg-btn">REGISTER</button>
                </form>

                <div class="login-link">
                    <p>Already have an account? <a href="../Views/login.php">Log In here</a></p>
                </div>
            </div>
        </div>
    </body>
</html>
<!--Developed by Sium-->