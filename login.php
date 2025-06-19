<?php
include 'db.php';

$identifier = $_POST['identifier'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE name = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $identifier, $identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // Verify the entered password against the hashed password in the database
    if (password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user'] = [
            'id' => $user['id'], // Corrected variable name to $user
            'name' => $user['name'], // Corrected variable name to $user
            'email' => $user['email'] // Corrected variable name to $user
        ];
        header("Location: index.html");
        exit();
    } else {
        header("Location: login.html?error=password");
        exit;
    }
} else {
    header("Location: login.html?error=user");
    exit;
}
?>