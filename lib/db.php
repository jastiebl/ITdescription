<?php
$servername = "localhost"; // Use 'localhost' if the database is on the same server
$username = "jastiebl"; // Replace with your MariaDB username
$password = "OLE_miss2024"; // Replace with your MariaDB password
$dbname = "jastiebl"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
