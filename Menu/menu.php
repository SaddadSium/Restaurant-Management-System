<!--Developed by Sium-->
<?php
session_start();
include '../Controller/db_connect.php';

$message = "";
$category = isset($_GET['category']) ? $_GET['category'] : 'Meal';

if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect_url'] = "../Menu/menu.php?category=$category"; 
        header("Location: ../Login/login.php");
        exit();
    }

    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];
    $image = $_POST['product_image'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $_SESSION['cart'][$id] = array(
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => 1
        );
    }
    $message = "Successfully added " . $name . " to cart!";
}

$sql = "SELECT * FROM menu_items WHERE category = '$category'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $category; ?> Menu | S&S Heritage</title>
    <link rel="stylesheet" href="menu.css">
    <link rel="stylesheet" href="../home.css">
</head>
<body>

    <div id="logo">
         <img src="../logo.png" alt="S&S Heritage Logo">
    </div>

    <div id="navbar">
        <ul>
            <li><a href="../index.php">Home</a></li>
            <li><a href="menu.php" class="active">Menu</a></li>
            <li><a href="../AboutUs/aboutus.php">About Us</a></li> 
            <li><a href="../CustomerReview/review.php">Customer's Reviews</a></li> <!--upadeted  by sani-->
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="../Login/logout.php" class="logout-btn">Log Out</a></li>
            <?php else: ?>
                <li><a href="../Login/login.php">Log IN</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="cart-notification">
        <a href="cart.php">
            🛒 Cart: <?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
        </a>
    </div>

    <div class="menu-container">
        <h1>Our Delicious Menu</h1>

        <div class="category-tabs">
            <a href="menu.php?category=Meal" class="<?php if($category == 'Meal') echo 'active-tab'; ?>">Meal</a>
            <a href="menu.php?category=Dessert" class="<?php if($category == 'Dessert') echo 'active-tab'; ?>">Dessert</a>
            <a href="menu.php?category=Drinks" class="<?php if($category == 'Drinks') echo 'active-tab'; ?>">Drinks</a>
            <a href="menu.php?category=Fastfood" class="<?php if($category == 'Fastfood') echo 'active-tab'; ?>">Fastfood</a>
        </div>

        <?php if ($message != ""): ?>
            <div class="alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="menu-grid">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $imagePath = "../images/" . $row['image']; 
                    ?>
                    <div class="menu-card">
                        <div class="image-container">
                            <img src="<?php echo $imagePath; ?>" alt="<?php echo $row['name']; ?>">
                        </div>
                        <div class="card-content">
                            <div class="card-header">
                                <h3><?php echo $row['name']; ?></h3>
                                <span class="price"><?php echo $row['price']; ?> TK</span>
                            </div>
                            <p class="description"><?php echo $row['description']; ?></p>
                            
                            <form method="post" action="">
                                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $row['image']; ?>">
                                <button type="submit" name="add_to_cart" class="order-btn">ADD TO CART</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p style='color: white; font-size: 1.2rem;'>No items found in this category.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
<!--Developed by Sium-->