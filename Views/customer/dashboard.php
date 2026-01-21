<?php
session_start();
// ডাটাবেস কানেকশন পাথ ঠিক আছে কিনা দেখে নেবেন
include '../../Controller/db_connect.php';

// ১. চেক করা হচ্ছে ইউজার লগইন আছে কিনা
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.php");
    exit();
}

$my_id = $_SESSION['user_id'];
$my_name = $_SESSION['fullname'];

// ২. শুধুমাত্র এই ইউজারের অর্ডারগুলো ডাটাবেস থেকে আনা হচ্ছে
$sql = "SELECT * FROM orders WHERE user_id = '$my_id' ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard | S&S Heritage</title>
    
    <link rel="stylesheet" href="../../home.css"> 
    <link rel="stylesheet" href="../dashboard.css">  

     <style>
        /* --- ড্যাশবোর্ড হেডার লেআউট (নাম বামে, বাটন ডানে) --- */
        .dashboard-header {
            display: flex;
            justify-content: space-between; /* দুই প্রান্তে ঠেলে দেবে */
            align-items: center;
            border-bottom: 1px solid #444;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .welcome-text h2 {
            color: #D4AF37;
            margin: 0;
            font-size: 1.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .welcome-text p {
            color: #ccc;
            font-size: 0.9rem;
            margin-top: 5px;
        }

       
        .empty-msg {
            text-align: center;
            margin-top: 50px;
            font-size: 1.2rem;
            color: #ccc;
        }
        .order-btn {
            background: #D4AF37;
            color: #1b1b1b;
            padding: 10px 25px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            margin-top: 15px;
            display: inline-block;
        }
        .order-btn:hover {
            background: #b5952f;
        }
    </style>
</head>
<body>
<!--updated by sani start do not touch-->
        <div id="logo">
             <img src="../../logo.png" alt="S&S Heritage Logo">
        </div>

    <div id="navbar">
           <ul>
                <li><a href="../../index.php">Home</a></li>
                <li><a href="../../Menu/menu.php">Menu</a></li>
                <li><a href="../../AboutUs/aboutus.php">About Us</a></li>
                <li><a href="../../CustomerReview/review.php">Customer's Reviews</a></li>

                <?php 
                    if (isset($_SESSION['user_id'])) {

                         echo '<li><a href="dashboard.php">Dashboard</a></li>';
                         echo' <li><a href="../../Views/logout.php"> Log Out </a></li>';

                        } 

                    else {

                         echo '<li><a href="../login.php">Log In</a></li>';
                        
                        }
                ?>

          </ul>
        </div>
        <!--updated by sani end  do not touch-->

    <div class="dashboard-container">
        
        <div class="dashboard-header">
            <div class="welcome-text">
                <h2>Welcome, <?php echo $my_name; ?>!</h2>
                <p>Here is the history of your delicious orders.</p>
            </div>
            
            
        </div>

        <h3>My Order History</h3>

        <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date & Time</th>
                        <th>Food Items</th>
                        <th>Total Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td>#<?php echo $row['order_id']; ?></td>
                        <td><?php echo date('d M Y, h:i A', strtotime($row['order_date'])); ?></td>
                        
                        <td style="text-align: left; width: 40%;">
                            <?php echo $row['food_name']; ?>
                        </td>
                        
                        <td style="font-weight: bold; color: #D4AF37;">
                            <?php echo $row['total_price']; ?> TK
                        </td>
                        
                        <td>
                            <?php 
                                if($row['order_status'] == 'Pending') {
                                    echo '<span style="color: #ff6b6b; font-weight: bold;">Pending...</span>';
                                } elseif($row['order_status'] == 'Cooking') {
                                    echo '<span style="color: #ffa502; font-weight: bold;">Cooking...</span>';
                                } else {
                                    echo '<span style="color: #2ed573; font-weight: bold;">Served</span>';
                                }
                            ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="empty-msg">
                <p>You haven't ordered anything yet.</p>
                <a href="../../Menu/menu.php" class="order-btn">Order Food Now</a>
            </div>
        <?php } ?>

    </div>

</body>
</html>