<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'conference';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['download'])) {
    $id = (int)$_GET['download'];
    
    $stmt = $conn->prepare("SELECT title, file FROM file WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $file_path = 'uploads/' . $row['file'];
        
        if (file_exists($file_path)) {
            $file_extension = pathinfo($row['file'], PATHINFO_EXTENSION);
            
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $row['title'] . '.' . $file_extension . '"');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            
            readfile($file_path);
            exit;
        }
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Procedure Access</title>
    <link rel="stylesheet" href="userdashboard1.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <p>Conference Manager</p>
            </div>
        </div>
    </header>

    <div class="sidebar">
        <ul>
            <li><a href="userdashboard.php">Session Schedule</a></li>
            <li><a href="userdashboard3.php">My Session</a></li>
            <li><a href="userdashboard1.php">File</a></li>
            <li><a href="userdashboard2.php">Log Out</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h3>Procedure Access</h3>
        <p>Download conference materials and procedures below:</p>

        <table class="procedure-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT id, title FROM file ORDER BY id DESC";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td><a href='?download=" . $row['id'] . "' class='download-btn'>Download</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2' class='no-files'>No files available</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>