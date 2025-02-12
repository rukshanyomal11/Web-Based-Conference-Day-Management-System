<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conference";
$port = 3306;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_with_initials = htmlspecialchars($_POST['name_with_initials']);
    $participation_category = htmlspecialchars($_POST['participation_category']);
    $email_address = htmlspecialchars($_POST['email_address']);
    $nic_passport = htmlspecialchars($_POST['nic_passport']);
    $mobile_number = htmlspecialchars($_POST['mobile_number']);
    $country = htmlspecialchars($_POST['country']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check for duplicate username or email
    $check_sql = "SELECT * FROM users WHERE username = ? OR email_address = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $username, $email_address);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<p class='error-message'>Username or email already exists!</p>";
    } else {
        $sql = "INSERT INTO users (name_with_initials, participation_category, email_address, nic_passport, mobile_number, country, username, password)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $name_with_initials, $participation_category, $email_address, $nic_passport, $mobile_number, $country, $username, $password);

        if ($stmt->execute()) {
            session_start();
            $_SESSION['registration_success'] = true;
            header("Location: log.html");
            exit();
        } else {
            echo "<p class='error-message'>Error executing statement: " . htmlspecialchars($stmt->error) . "</p>";
        }
        $stmt->close();
    }
    $check_stmt->close();
    $conn->close();
}
?>
