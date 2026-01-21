<?php
declare(strict_types=1);

$host = "localhost";
$user = "root";
$pass = "";
$port = 3306;
$dbname = "registration"; 

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $pass, "", $port);
  
    $conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
    $conn->set_charset("utf8mb4");
    $conn->select_db($dbname);
    
    echo "✔ Database '$dbname' selected/created successfully.<br>";
    $conn->query("DROP TABLE IF EXISTS orders");
    $conn->query("DROP TABLE IF EXISTS menu_items");
    $conn->query("DROP TABLE IF EXISTS users");

    $conn->query("
        CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            fullname VARCHAR(100) NOT NULL,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(100) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role ENUM('Admin', 'Employee', 'Customer') NOT NULL DEFAULT 'Customer',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");

    $stmt = $conn->prepare("INSERT INTO users (fullname, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
    
    $users_data = [
        ['Admin User', 'admin', 'admin@gmail.com', '1234', 'Admin'],
        ['Staff Member', 'staff', 'staff@gmail.com', '1234', 'Employee'],
        ['Sium', 'customer', 'customer@gmail.com', '1234', 'Customer']
    ];

    foreach ($users_data as $u) {
        $hashed_pass = password_hash($u[3], PASSWORD_DEFAULT); // Password hashing
        $stmt->bind_param("sssss", $u[0], $u[1], $u[2], $hashed_pass, $u[4]);
        $stmt->execute();
    }
    echo "✔ 'users' table created and seeded (Admin/Staff/Customer).<br>";
    $conn->query("
        CREATE TABLE menu_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(150) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            image VARCHAR(255) NOT NULL,
            category VARCHAR(50) NOT NULL DEFAULT 'Meal'
        ) ENGINE=InnoDB
    ");

    // Seed Menu Items
    $stmt_menu = $conn->prepare("INSERT INTO menu_items (name, description, price, image, category) VALUES (?, ?, ?, ?, ?)");

    $menu_data = [
    ['Kacchi Biryani', 'Traditional Basmati Kacchi with tender mutton pieces.', 450.00, 'kacchi.jpg', 'Meal'],
    ['Chicken Roast', 'Traditional Bangladeshi wedding-style chicken roast.', 150.00, 'roast.jpg', 'Meal'],
    ['BBQ Chicken Pizza', '8-inch pizza topped with BBQ chicken, onion, and cheese.', 450.00, 'pizza.jpg', 'Fastfood'],
    ['Chicken Corn Soup', 'Comforting soup with sweet corn and egg drops.', 150.00, 'corn_soup.jpg', 'Fastfood'],
    ['Special Borhani', 'Spicy yogurt drink with mint and green chili.', 80.00, 'borhani.jpg', 'Drinks'],
    ['Royal Badam Lacchi', 'Sweet and creamy yogurt drink blended with crushed nuts.', 120.00, 'lacchi.jpg', 'Drinks'],
    ['Soft Drinks (Can)', 'Chilled can of Coke, Sprite, or Fanta.', 60.00, 'soft_drinks.jpg', 'Drinks'],
    ['Mineral Water (500ml)', 'Fresh mineral water bottle.', 30.00, 'water.jpg', 'Drinks'],
    ['Fresh Mango Juice', 'Refreshing juice made from hand-picked ripe mangoes.', 150.00, 'mango_juice.jpg', 'Drinks'],
    ['Beef Bhuna', 'Spicy and delicious beef curry.', 220.00, 'beef_bhuna.jpg', 'Meal'],
    ['Morog Polao', 'Flavorful chicken pilaf cooked with spices.', 350.00, 'morog_polao.jpg', 'Meal'],
    ['Khichuri', 'Traditional rice and lentil dish with beef.', 200.00, 'khichuri.jpg', 'Meal'],
    ['Mutton Rezala', 'Rich and creamy mutton curry.', 280.00, 'mutton_rezala.jpg', 'Meal'],
    ['Thai Soup', 'Spicy and tangy thick soup.', 180.00, 'thai_soup.jpg', 'Fastfood'],
    ['Burger', 'Juicy chicken burger with cheese.', 180.00, 'burger.jpg', 'Fastfood'],
    ['Chowmein', 'Stir-fried noodles with chicken and vegetables.', 160.00, 'chowmein.jpg', 'Fastfood'],
    ['Fried Chicken', 'Crispy fried chicken pieces.', 120.00, 'fried_chicken.jpg', 'Fastfood'],
    ['Cold Coffee', 'Chilled coffee blended with milk, sugar, and ice cream.', 160.00, 'cold_coffee.jpg', 'Drinks'],
    ['Caramel Pudding', 'Smooth and creamy custard dessert with caramel topping.', 100.00, 'pudding.jpg', 'Dessert'],
    ['Special Falooda', 'Rich dessert with noodles, jelly, fruits, nuts, and ice cream.', 180.00, 'falooda.jpg', 'Dessert'],
    ['Rasmalai', 'Soft cheese balls soaked in malai.', 200.00, 'rasmalai.jpg', 'Dessert'],
    ['Brownie', 'Chocolate brownie with nuts.', 120.00, 'brownie.jpg', 'Dessert']
    ];

    foreach ($menu_data as $m) {
        $stmt_menu->bind_param("ssdss", $m[0], $m[1], $m[2], $m[3], $m[4]);
        $stmt_menu->execute();
    }
    echo "✔ 'menu_items' table created and seeded with food items.<br>";

    $conn->query("
        CREATE TABLE orders (
            order_id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            food_name TEXT NOT NULL,
            total_price DECIMAL(10,2) NOT NULL,
            order_status ENUM('Pending', 'Cooking', 'Served') NOT NULL DEFAULT 'Pending',
            order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
            
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB
    ");

    $stmt_order = $conn->prepare("INSERT INTO orders (user_id, food_name, total_price, order_status) VALUES (?, ?, ?, ?)");

    $customer_id = 3;
    $food_items = "Kacchi Biryani(1), Cold Coffee(1)";
    $total = 610.00;
    $status = "Pending";

    $stmt_order->bind_param("isds", $customer_id, $food_items, $total, $status);
    $stmt_order->execute();

    echo "✔ 'orders' table created and seeded with one dummy order.<br>";

    echo "<hr><h3 style='color:green'>All tables setup successfully! You are ready to go.</h3>";

} catch (mysqli_sql_exception $e) {
    echo "<h3 style='color:red'>Error: " . $e->getMessage() . "</h3>";
}
?>