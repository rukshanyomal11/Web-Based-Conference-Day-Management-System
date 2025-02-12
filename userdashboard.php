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

// Fetch sessions and check which ones the user has already joined
$sql = "SELECT s.id, s.speaker, s.title, s.date_time, 
        CASE WHEN m.id IS NOT NULL THEN 1 ELSE 0 END as is_joined
        FROM sessions s
        LEFT JOIN myssion m ON s.title = m.title AND m.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Schedule</title>
    <link rel="stylesheet" type="text/css" href="userdashboard.css">
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
        <h3>Session Schedule</h3>
        <table>
            <thead>
                <tr>
                    <th>Speaker</th>
                    <th>Title</th>
                    <th>Date and Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['speaker']) . "</td>
                                <td>" . htmlspecialchars($row['title']) . "</td>
                                <td>" . date("F j, Y - g:i A", strtotime($row['date_time'])) . "</td>
                                <td>";
                        if ($row['is_joined'] == 0) {
                            echo "<form method='post' action='join_session.php'>
                                    <input type='hidden' name='session_id' value='" . $row['id'] . "'>
                                    <button type='submit' class='join-btn'>Join</button>
                                  </form>";
                        } else {
                            echo "<span class='joined-text'>Joined</span>";
                        }
                        echo "</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No sessions available</td></tr>";
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