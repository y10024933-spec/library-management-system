<?php
$host = "localhost"; // database host
$username = "root";  // database username
$password = "";      // database password
$dbname = "school_db"; // database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
