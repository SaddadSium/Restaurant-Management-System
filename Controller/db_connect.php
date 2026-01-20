<!--Developed by Sium-->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "registration"; // User database

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("User DB Connection Failed: " . $conn->connect_error);
}
?>
<!--Developed by Sium-->