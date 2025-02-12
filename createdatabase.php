<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'conference';

$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database
$sql_create_db = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database '$database' created successfully.<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

$conn->select_db($database);

// Create `users` table
$sql_create_users_table = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_with_initials VARCHAR(255) NOT NULL,
    participation_category VARCHAR(50) NOT NULL,
    email_address VARCHAR(255) NOT NULL,
    nic_passport VARCHAR(100) NOT NULL,
    mobile_number VARCHAR(20) NOT NULL,
    country VARCHAR(100) NOT NULL,
    username VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL
);";

if ($conn->query($sql_create_users_table) === TRUE) {
    echo "Table 'users' created successfully.<br>";
} else {
    echo "Error creating table 'users': " . $conn->error . "<br>";
}

// Create `sessions` table
$sql_create_sessions_table = "
CREATE TABLE IF NOT EXISTS sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    speaker VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    date_time DATETIME NOT NULL
);";

if ($conn->query($sql_create_sessions_table) === TRUE) {
    echo "Table 'sessions' created successfully.<br>";
} else {
    echo "Error creating table 'sessions': " . $conn->error . "<br>";
}

// Create `myssion` table
$sql_create_myssion_table = "
CREATE TABLE IF NOT EXISTS myssion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    speaker VARCHAR(255) NOT NULL,
    date_time DATETIME NOT NULL,
    username VARCHAR(100) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);";

if ($conn->query($sql_create_myssion_table) === TRUE) {
    echo "Table 'myssion' created successfully.<br>";
} else {
    echo "Error creating table 'myssion': " . $conn->error . "<br>";
}

// Create `file` table
$sql_create_file_table = "
CREATE TABLE IF NOT EXISTS file (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    file VARCHAR(255) NOT NULL
);";

if ($conn->query($sql_create_file_table) === TRUE) {
    echo "Table 'file' created successfully.<br>";
} else {
    echo "Error creating table 'file': " . $conn->error . "<br>";
}


// Insert sample session data
$sql_insert_sessions_data = "
    INSERT INTO sessions (speaker, title, date_time) VALUES
    ('Dr. John Doe', 'AI and the Future of Technology', '2024-12-21 10:00:00'),
    ('Prof. Jane Smith', 'The Impact of Quantum Computing', '2024-12-21 14:00:00'),
    ('Dr. Alex Johnson', 'Cybersecurity in the Modern Age', '2024-12-22 09:00:00'),
    ('Dr. Emily Brown', 'Advances in Machine Learning', '2024-12-22 13:00:00'),
    ('Prof. Mark Davis', 'Ethics in Artificial Intelligence', '2024-12-23 11:00:00');
";

if ($conn->query($sql_insert_sessions_data) === TRUE) {
    echo "Sample session data inserted successfully.<br>";
} else {
    echo "Error inserting session data: " . $conn->error . "<br>";
}

$conn->close();
?>
