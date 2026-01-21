<?php
session_start();
include '../../Controller/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../../Views/login.php");
    exit();
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']); 
    
    $img_sql = "SELECT image FROM menu_items WHERE id = $id";
    $img_res = mysqli_query($conn, $img_sql);
    if($img_res && mysqli_num_rows($img_res) > 0){
        $img_data = mysqli_fetch_assoc($img_res);
        $file_path = "../../images/" . $img_data['image'];
        if (file_exists($file_path)) {
            unlink($file_path); 
        }
    }


    $sql = "DELETE FROM menu_items WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Item Deleted Successfully!'); window.location='manage_menu.php';</script>";
    } else {
        echo "<script>alert('Failed to delete item.');</script>";
    }
}


if (isset($_POST['add_item'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $category = $_POST['category']; 
    
    $image = $_FILES['food_image']['name'];
    $target = "../../images/" . basename($image); 

    $sql = "INSERT INTO menu_items (name, description, price, image, category) VALUES ('$name', '$description', '$price', '$image', '$category')";
    
    if (mysqli_query($conn, $sql)) {
        if (move_uploaded_file($_FILES['food_image']['tmp_name'], $target)) {
            echo "<script>alert('New Item Added Successfully!'); window.location='manage_menu.php';</script>";
        } else {
            echo "<script>alert('Item added but Image upload failed!');</script>";
        }
    } else {
        echo "<script>alert('Failed to add item in Database!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Menu Items</title>
    <link rel="stylesheet" href="../../home.css">
    <link rel="stylesheet" href="../dashboard.css">
    
    <link rel="stylesheet" href="m_menu.css">
</head>
<body>

    <div id="logo">
        <img src="../../logo.png" alt="logo">
    </div>

    <div class="" id="navbar">
            <ul>
                <li><a href="dashboard.php">Dash Board</a></li>
                <li><a href="order_manager.php">Manage Order's</a></li><li>
                <li><a href="salesreport.php">Sale's Report</a></li>
                <li><a href="manage_menu.php">Update Menu</a></li>
                <li><a href="adduser.php">Add User</a></li>
                <li><a href="../login.php">Logout</a></li>
                
            </ul>

    </div>

    <h1 class="p-title">Manage Food Items</h1>
    <div class="form-container">
        <h3 class="form-title">Add New Food Item</h3>
        <form method="POST" enctype="multipart/form-data">   
            <label>Name:</label>
            <input type="text" name="name" placeholder="Input Item Name" required>
            <label>Category:</label>
            <select name="category" required>
                <option value="Meal">Meal</option>
                <option value="Fastfood">Fastfood</option>
                <option value="Drinks">Drinks</option>
                <option value="Dessert">Dessert</option>
            </select>
            <label>Price (TK):</label>
            <input type="number" name="price" placeholder="Price in TK" required>
            <label>Description:</label>
            <textarea name="description" placeholder="Write description here..." rows="3" required></textarea>
            <label>Food Image:</label>
            <input type="file" name="food_image" required>           
            <input type="submit" name="add_item" value="Add Item Now" class="add-btn">
        </form>
    </div>

    <div class="dashboard-container table-section">
        <h3 class="tb-title">Current Menu List</h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM menu_items ORDER BY id DESC"; 
                $result = mysqli_query($conn, $sql);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><img src="../../images/<?php echo $row['image']; ?>" class="table-img" alt="Food"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['category']; ?></td>
                    <td><?php echo $row['price']; ?> TK</td>
                    <td>
                        <a href="manage_menu.php?delete=<?php echo $row['id']; ?>" class="del-btn" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='5' class='empty-msg'>No items found in menu.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>