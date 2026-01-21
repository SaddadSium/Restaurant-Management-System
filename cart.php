<?php
session_start();

date_default_timezone_set('Asia/Dhaka');

include 'Controller/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login/login.php");
    exit();
}

if (isset($_POST['place_order'])) {
    if (!empty($_SESSION['cart'])) {
        $user_id = $_SESSION['user_id'];
        $total_price = 0;
        $food_items = [];

        foreach ($_SESSION['cart'] as $item) {
            $food_items[] = $item['name'] . "(" . $item['quantity'] . ")";
            $total_price += ($item['price'] * $item['quantity']);
        }
        
        $food_name_str = implode(", ", $food_items);
        $order_status = "Pending";
        $order_date = date('Y-m-d H:i:s'); 

        $sql = "INSERT INTO orders (user_id, food_name, total_price, order_status, order_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $user_id, $food_name_str, $total_price, $order_status, $order_date);
        
        if ($stmt->execute()) {
            unset($_SESSION['cart']);
            echo "<script>alert('Order Placed Successfully!'); window.location.href='Menu/menu.php';</script>";
        } else {
            echo "<script>alert('Failed to place order.');</script>";
        }
    }
}

if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>
    <link rel="stylesheet" href="home.css"> 
    <link rel="stylesheet" href="cart.css">      
</head>
<body>

      <div id="logo">
              <img src="logo.png" alt="logo">
         </div>

    <div id="navbar">
        <ul>
             <li><a href="index.php">Home</a></li>
             <li><a href="Menu/menu.php">Menu</a></li>
             <li><a href="AboutUs/aboutus.php">About Us</a></li>
             <li><a href="CustomerReview/review.php">Customer's Reviews</a></li>

             <?php 
                 if (isset($_SESSION['user_id'])) {
                 echo '<li><a href="Views/customer/dashboard.php">Dashboard</a></li>';
                 echo '<li><a href="Views/logout.php">Log Out</a></li>';
                    } 
                 else {
                 echo '<li><a href="Views/login.php">Log In</a></li>';       
                    }
             ?>
         </ul>
    </div>

    <div class="cart-container">
        <h1>Your Shopping Cart</h1>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $key => $item) {
                        $subtotal = $item['price'] * $item['quantity'];
                        $grand_total += $subtotal;
                        ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['price']; ?> TK</td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo $subtotal; ?> TK</td>
                            <td><a href="cart.php?remove=<?php echo $key; ?>" class="remove-btn">Remove</a></td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='5'>Cart is empty</td></tr>";
                }
                ?>
                <tr>
                    <td colspan="3" style="text-align: right;">Grand Total:</td>
                    <td class="grand-total"><?php echo $grand_total; ?> TK</td>
                    <td>
                        <?php if($grand_total > 0): ?>
                        <form method="post">
                            <button type="submit" name="place_order" class="checkout-btn">Confirm Order</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>