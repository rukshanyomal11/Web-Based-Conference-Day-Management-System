<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Schedule</title>
    <link rel="stylesheet" href="admindashboard.css">
</head>
<body>
    <?php
    // Database connection
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'conference';

    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $speaker = $conn->real_escape_string($_POST['speaker']);
        $title = $conn->real_escape_string($_POST['title']);
        $datetime = $conn->real_escape_string($_POST['datetime']);

        // Insert into sessions table
        $sql = "INSERT INTO sessions (speaker, title, date_time) VALUES ('$speaker', '$title', '$datetime')";

        if ($conn->query($sql) === TRUE) {
            $message = "New session added successfully!";
        } else {
            $message = "Error adding session: " . $conn->error;
        }
    }
    ?>

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
        <h3>Session Schedule Add</h3>
        
        <!-- Display Message -->
        <?php if (isset($message)): ?>
            <p style="color: green;"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Form for Adding New Session -->
        <h4>Add New Session</h4>
        <form class="add-session-form" method="POST">
            <label for="speaker">Speaker:</label>
            <input type="text" id="speaker" name="speaker" required><br><br>

            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br><br>

            <label for="datetime">Date and Time:</label>
            <input type="datetime-local" id="datetime" name="datetime" required><br><br>

            <button type="submit" class="btn-submit">Add Session</button>
        </form>
    </div>
</body>
</html>
