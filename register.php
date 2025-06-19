<?php
include 'db.php';

$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$contact_number = filter_input(INPUT_POST, 'contact_number', FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

// Basic email validation (you might want more robust validation)
if ($email === false) {
    echo "<script>alert('Invalid email format.'); window.history.back();</script>";
    exit;
}

// Check for duplicate email or contact number
$checkSql = "SELECT * FROM users WHERE email = ? OR contact_number = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ss", $email, $contact_number);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows > 0) {
    // Redirect with error flag
    header("Location: register.html?error=exists");
    exit;
}

// Hash the password securely
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Initial Eco Points for new users
$initialPoints = 100;

// If no duplicates, insert the data with the hashed password and initial points
$sql = "INSERT INTO users (name, email, contact_number, password, points) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $name, $email, $contact_number, $hashedPassword, $initialPoints); // 'i' for integer

if ($stmt->execute()) {
    header("Location: login.html?registered=success");
    exit;
} else {
    echo "<script>alert('Error: " . $conn->error . "'); window.history.back();</script>";
}
?>