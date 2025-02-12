<?php
session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'conference';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user ID
if (!isset($_SESSION['user_id'])) {
    header("Location: log.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user sessions
$stmt = $conn->prepare("SELECT title, speaker, date_time FROM myssion WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sessions</title>
    <link rel="stylesheet" type="text/css" href="userdashboard3.css">
</head>
<body>
    <!-- Header Section -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <p>Conference Manager</p>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="userdashboard.php">Session Schedule</a></li>
            <li><a href="userdashboard3.php">My Session</a></li>
            <li><a href="userdashboard1.php">File</a></li>
            <li><a href="userdashboard2.php">Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h3>My Sessions</h3>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Speaker</th>
                    <th>Date and Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['title']) . "</td>
                                <td>" . htmlspecialchars($row['speaker']) . "</td>
                                <td>" . date("F j, Y - g:i A", strtotime($row['date_time'])) . "</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No sessions joined yet</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>