<?php
// Turn off deprecation warnings
error_reporting(E_ALL & ~E_DEPRECATED);

// Start output buffering
ob_start();

session_start();

// Include TCPDF and PHP QR Code libraries
require_once('tcpdf/tcpdf.php');
require_once('phpqrcode/qrlib.php');

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'conference';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: log.html");
    exit();
}

if (isset($_POST['session_id'])) {
    $session_id = $_POST['session_id'];
    $user_id = $_SESSION['user_id'];

    // First, check if the user has already joined this session
    $check_stmt = $conn->prepare("
        SELECT m.id 
        FROM myssion m 
        JOIN sessions s ON m.title = s.title 
        WHERE m.user_id = ? AND s.id = ?
    ");
    $check_stmt->bind_param("ii", $user_id, $session_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        ob_end_clean(); // Clear buffer
        echo "<script>
                alert('You have already joined this session!');
                window.location.href = 'userdashboard.php';
              </script>";
    } else {
        // Get session details
        $stmt = $conn->prepare("
            SELECT s.title, s.speaker, s.date_time, u.name_with_initials, u.username
            FROM sessions s
            JOIN users u ON u.id = ?
            WHERE s.id = ?
        ");
        $stmt->bind_param("ii", $user_id, $session_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $username = $_SESSION['username'];

            // Insert into `myssion` table
            $insert_stmt = $conn->prepare("
                INSERT INTO myssion (user_id, title, speaker, date_time, username)
                VALUES (?, ?, ?, ?, ?)
            ");
            $insert_stmt->bind_param(
                "issss",
                $user_id,
                $data['title'],
                $data['speaker'],
                $data['date_time'],
                $username
            );

            if ($insert_stmt->execute()) {
                // Generate QR Code content
                $qr_content = "Name: " . $data['name_with_initials'] . "\n";
                $qr_content .= "Username: " . $data['username'] . "\n";
                $qr_content .= "Speaker: " . $data['speaker'] . "\n";
                $qr_content .= "Title: " . $data['title'] . "\n";
                $qr_content .= "Date/Time: " . date("F j, Y - g:i A", strtotime($data['date_time']));

                // Create temporary QR code image
                $qr_file = 'temp_qr_' . $user_id . '.png';
                QRcode::png($qr_content, $qr_file, QR_ECLEVEL_L, 10);

                // Create PDF
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetTitle('Conference Session QR Code');
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $pdf->AddPage();

                // Add content to PDF
                $pdf->SetFont('helvetica', 'B', 16);
                $pdf->Cell(0, 10, 'Conference Session Details', 0, 1, 'C');
                $pdf->Ln(10);

                // Add QR Code
                $pdf->Image($qr_file, 70, 50, 70, 70, 'PNG');
                $pdf->Ln(80);

                // Add session details
                $pdf->SetFont('helvetica', '', 12);
                $pdf->Cell(0, 10, 'Name: ' . $data['name_with_initials'], 0, 1);
                $pdf->Cell(0, 10, 'Username: ' . $data['username'], 0, 1);
                $pdf->Cell(0, 10, 'Speaker: ' . $data['speaker'], 0, 1);
                $pdf->Cell(0, 10, 'Title: ' . $data['title'], 0, 1);
                $pdf->Cell(0, 10, 'Date/Time: ' . date("F j, Y - g:i A", strtotime($data['date_time'])), 0, 1);

                // Clean output buffer
                ob_end_clean();

                // Generate PDF file
                $pdf->Output('session_qr_' . $user_id . '.pdf', 'D');

                // Clean up temporary QR code image
                unlink($qr_file);
                exit();
            } else {
                ob_end_clean(); // Clear buffer
                echo "<script>
                        alert('Error joining session: " . $insert_stmt->error . "');
                        window.location.href = 'userdashboard.php';
                      </script>";
            }
            $insert_stmt->close();
        } else {
            ob_end_clean(); // Clear buffer
            echo "<script>
                    alert('Session not found!');
                    window.location.href = 'userdashboard.php';
                  </script>";
        }
        $stmt->close();
    }
    $check_stmt->close();
} else {
    ob_end_clean(); // Clear buffer
    echo "<script>
            alert('Invalid request!');
            window.location.href = 'userdashboard.php';
          </script>";
}

$conn->close();
?>