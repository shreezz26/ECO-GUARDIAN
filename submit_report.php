<?php
$host = "localhost";
$db = "eco";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$issue = $_POST['issue'];
$description = $_POST['description'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];

// Handle photo upload
$photo_path = '';
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = 'uploads/';
    if (!file_exists($upload_dir)) mkdir($upload_dir);
    $photo_path = $upload_dir . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], $photo_path);
}

$sql = "INSERT INTO complaints (issue_type, description, photo_path, latitude, longitude)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $issue, $description, $photo_path, $latitude, $longitude);

if ($stmt->execute()) {
    echo "Report submitted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>