<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "conference";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email_address']);
    $password = $_POST['password'];
    $user_role = $_POST['user_role'];

    // Retrieve user data including participation_category
    $sql = "SELECT id, email_address, password, username, participation_category FROM users WHERE email_address=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Check if user role matches participation_category
            if ($user_role === "Participant" && $row['participation_category'] === "Participant") {
                // Start session to store user information
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email_address'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['participation_category'] = $row['participation_category'];
                
                header("Location: userdashboard.php");
                exit();
            } 
            elseif ($user_role === "Admin" && $row['participation_category'] === "Admin") {
                session_start();
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email_address'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['participation_category'] = $row['participation_category'];
                
                header("Location: admindashboard.php");
                exit();
            }
            else {
                // Role doesn't match participation_category
                echo "<script>
                    alert('Invalid user role! Please select the correct role.');
                    window.location.href = 'log.html';
                </script>";
                exit();
            }
        } else {
            // Invalid password
            echo "<script>
                alert('Wrong password! Please try again.');
                window.location.href = 'log.html';
            </script>";
            exit();
        }
    } else {
        // No user found
        echo "<script>
            alert('Email not found! Please check your email address.');
            window.location.href = 'log.html';
        </script>";
        exit();
    }

    $stmt->close();
}

$conn->close();
?>