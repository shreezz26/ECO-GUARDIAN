<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = $_POST['location'];
    $details = $_POST['details'];

    $sql = "INSERT INTO complaints (location, details) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $location, $details);
    
    if ($stmt->execute()) {
        echo "<script>alert('Complaint Submitted!'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Error Submitting Complaint!');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
