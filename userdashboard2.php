<?php
session_start();
if(isset($_POST['logout'])) {
    // Clear all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    
    // Destroy the session
    session_destroy();
    
    // Clear cache and prevent back button
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    header("Location: main.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Out</title>
    <link rel="stylesheet" href="userdashboard2.css">
    <script>
        // Prevent going back to previous page
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
    </script>
</head>
<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
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
        <h3>Log Out</h3>
        <p>Are you sure you want to log out?</p>
        <form method="POST">
            <button type="submit" name="logout" class="logout-button">Log Out</button>
        </form>
    </div>
</body>
</html>