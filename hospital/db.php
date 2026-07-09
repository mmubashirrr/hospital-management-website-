<?php
// db.php — This file connects PHP to your MySQL database
// We include this file in every other page so we don't repeat code

$host = "localhost";       // Where MySQL is running (usually localhost)
$db   = "hospital_db"; // The database name we created
$user = "root";            // Your MySQL username
$pass = "";                // Your MySQL password (empty for local XAMPP)

// mysqli = MySQL Improved — PHP's built-in way to talk to MySQL
// This creates a connection object called $conn
$conn = mysqli_connect($host, $user, $pass, $db);

// Check if connection failed
if (!$conn) {
    // mysqli_connect_error() gives us the reason it failed
    die("Connection failed: " . mysqli_connect_error());
}
// If we reach here, connection is successful
?>