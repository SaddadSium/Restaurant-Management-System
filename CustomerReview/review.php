<!--sani's code starts-->
<?php
session_start();
include '../Controller/db_connect.php'; 

// --- LOGIC: ONLY RUNS WHEN BUTTON IS CLICKED ---
if (isset($_POST['submit_review'])) {
    
    // 1. Check if the user is NOT logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect them to login page immediately
        header("Location: ../Views/login.php");
        echo "please log in first";
        exit(); // Stop any further code from running
    } 
    
    // 2. If the code reaches here, they ARE logged in
    $username = $_SESSION['username'];
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // 3. Save to database
    $sql = "INSERT INTO reviews (username, comment) VALUES ('$username', '$comment')";
    mysqli_query($conn, $sql);
    
    // 4. Refresh to show the new comment in the list
    header("Location: review.php");
    exit();
}

// FETCH DATA (Always happens so everyone can see reviews)
$result = mysqli_query($conn, "SELECT * FROM reviews ORDER BY created_at DESC");
?>




<!doctype html>
<html>
    <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Customer's Review | S&S Heritage</title>
          <link rel="stylesheet" href="../home.css">
        <link rel="stylesheet" href="review.css">
    </head>
    <body>
        <div id="logo">
                <img src="../logo.png" alt="logo">
        </div>
           <div class="" id="navbar">
            <ul>

                 <li><a href="../index.php">Home</a></li>
                 <li><a href="../Menu/menu.php">Menu</a></li>
                 <li><a href="../AboutUs/aboutus.php">About Us</a></li>
                 <li><a href="review.php">Customer's Reviews</a></li>
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
           <div>
            <br><br>

        <div id="review-box"> <h2>Customer Reviews</h2>
        
            <div class="scroll-list">
                  <?php while($row = mysqli_fetch_assoc($result)): ?>
                <div class="review-item">
                    <span class="user"><?php echo $row['username']; ?></span>
                    <span class="date"><?php echo $row['created_at']; ?></span>
                    <p><?php echo htmlspecialchars($row['comment']); ?></p>
                </div>
                    <?php endwhile; ?>
            </div>

             <form method="POST">
                 <textarea name="comment" placeholder="Share your experience..." required></textarea>
                 <button type="submit" name="submit_review" class="btn">Post Review</button>
             </form>
        
           
        </div>

        <div id="footer">
            <footer><br>
            <p>2026 S & S Heritage Restaurant.All rights reserved.</p> <br>
            <p> S & S Heritage Restaurant<br> Purbachal-300fit, Dhaka-1216, Bangladesh<br>Opening Hours: 10am - 10pm</p><br><br>
            </footer>
        </div>
    </body>
     
</html>
<!--sani's code ends-->