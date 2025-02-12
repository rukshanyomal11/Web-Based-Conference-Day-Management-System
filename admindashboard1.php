<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'conference';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    
    if (isset($_FILES['file-upload']) && $_FILES['file-upload']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file-upload'];
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $uniqueFileName = uniqid() . '_' . $fileName;
        $destination = $uploadDir . $uniqueFileName;
        
        if (move_uploaded_file($fileTmpName, $destination)) {
            $stmt = $conn->prepare("INSERT INTO file (title, file) VALUES (?, ?)");
            $stmt->bind_param("ss", $title, $uniqueFileName);
            
            if ($stmt->execute()) {
                echo "<script>alert('File uploaded successfully!');</script>";
            } else {
                echo "<script>alert('Database error: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('Error moving uploaded file.');</script>";
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Add</title>
    <link rel="stylesheet" href="admindashboard1.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <p>Conference Manager Admin</p>
            </div>
        </div>
    </header>

    <div class="sidebar">
        <ul>
            <li><a href="admindashboard.php">Session Schedule</a></li>
            <li><a href="admindashboard3.php">All Session</a></li>
            <li><a href="admindashboard1.php">File</a></li>
            <li><a href="admindashboard2.php">Log Out</a></li>
        </ul>
    </div>

    <div class="main-content">
        <h3>File Add</h3>
        <div class="upload-form">
            <form action="admindashboard1.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="file-upload">Upload File:</label>
                    <input type="file" id="file-upload" name="file-upload" required>
                    <div class="file-types">All file types allowed</div>
                </div>
                
                <button type="submit" class="submit-btn">Upload File</button>
            </form>
        </div>
    </div>
</body>
</html>