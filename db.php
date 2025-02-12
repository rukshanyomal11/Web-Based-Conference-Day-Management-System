<?php
$servername = "localhost";
$username = "root"; //  MySQL username
$password = "";     //  MySQL password
$dbname = "conference"; //  database name
$port = 3306; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
