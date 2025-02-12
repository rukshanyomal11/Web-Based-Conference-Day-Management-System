<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'conference';

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle session deletion
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Ensure the ID is an integer
    $sql_delete_session = "DELETE FROM sessions WHERE id = $delete_id";

    if ($conn->query($sql_delete_session) === TRUE) {
        echo "<script>alert('Session deleted successfully.'); window.location.href='admindashboard3.php';</script>";
    } else {
        echo "<script>alert('Error deleting session: " . $conn->error . "');</script>";
    }
}

// Fetch all sessions from the database
$sql_fetch_sessions = "SELECT * FROM sessions";
$result = $conn->query($sql_fetch_sessions);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Sessions</title>
    <link rel="stylesheet" href="admindashboard3.css">
</head>
<body>
    <!-- Header Section -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <p>Conference Manager Admin</p>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul>
            <li><a href="admindashboard.php">Session Schedule</a></li>
            <li><a href="admindashboard3.php">All Sessions</a></li>
            <li><a href="admindashboard1.php">File</a></li>
            <li><a href="admindashboard2.php">Log Out</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h3>All Sessions</h3>
        
        <!-- Table to Display All Sessions -->
        <table border="3" cellpadding="30" cellspacing="10" class="all-sessions-table">
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
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['speaker']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['date_time']) . "</td>";
                        echo "<td>
                                <a href='admindashboard3.php?delete_id=" . $row['id'] . "' onclick=\"return confirm('Are you sure you want to delete this session?');\">Delete</a>
                              </td>";
                        echo "</tr>";
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
$conn->close();
?>
