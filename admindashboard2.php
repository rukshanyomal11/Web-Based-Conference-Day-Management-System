<?php
session_start();

if(isset($_POST['logout'])) {
    // Clear session variables
    $_SESSION = array();
    
    // Destroy session cookie
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    
    // Destroy session
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
    <title>Admin Dashboard - Log Out</title>
    <link rel="stylesheet" href="admindashboard2.css">
    <script>
        window.history.forward();
        function noBack() { window.history.forward(); }
    </script>
</head>
<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
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
        <h3>Log Out</h3>
        <p>Are you sure you want to log out?</p>
        <form method="POST">
            <button type="submit" name="logout">Log Out</button>
        </form>
    </div>
</body>
</html>