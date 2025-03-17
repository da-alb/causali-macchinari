<?php
/*
 * db_connect.php
 *
 * This file establishes a connection to the MariaDB database.
 *
 * IMPORTANT: Replace the placeholder values with your actual database credentials.
 * DO NOT commit your actual credentials to a public repository like GitHub.
 */

$servername = "localhost"; // Or your database server hostname
$username = "your_database_user"; // Your database username
$password = "your_database_password"; // Your database password
$dbname = "your_database_name"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// You can add additional configuration here if needed,
// such as setting the character set:
// $conn->set_charset("utf8mb4");

?>