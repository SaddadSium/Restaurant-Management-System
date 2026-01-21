<!--updated by sium-->
<?php
session_start();
include '../../Controller/db_connect.php';


if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $sql = "UPDATE orders SET order_status='$status' WHERE order_id='$order_id'";
    mysqli_query($conn, $sql);
}


$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);
?>
<!--updated by sium-->

<!--updated by sani-->
<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="../../home.css">
    <link rel="stylesheet" href="../dashboard.css">    
</head>
<body>
         <div id="logo">
              <img src="../../logo.png" alt="logo">
         </div>

         <div class="" id="navbar">
            <ul>
                <li><a href="dashboard.php">Dash Board</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
           </div><br><br>


        <div class="welcome-section">
        <h2>Employee Dashboard</h2>
        </div>
        
     
<!--updated by sani-->

<!--updated by sium-->   
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Food Items</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td>#<?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['food_name']; ?></td>
                    <td><?php echo $row['total_price']; ?> TK</td>
                    <td style="font-weight: bold; color: <?php echo ($row['order_status']=='Pending')?'red':'green'; ?>;">
                        <?php echo $row['order_status']; ?>
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                            <select name="status" class="status-select">
                                <option value="Pending" <?php if($row['order_status']=='Pending') echo 'selected'; ?>>Pending</option>
                                <option value="Cooking" <?php if($row['order_status']=='Cooking') echo 'selected'; ?>>Cooking</option>
                                <option value="Served" <?php if($row['order_status']=='Served') echo 'selected'; ?>>Served</option>
                            </select>
                            <button type="submit" name="update_status" class="action-btn">Update</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <!--updated by sium--> 
</body>
</html>