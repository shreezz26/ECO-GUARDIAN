<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = filter_input(INPUT_POST, 'event_id', FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

    // Validate inputs further if needed

    $sql = "INSERT INTO event_participants (event_id, name, email, phone) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $event_id, $name, $email, $phone); // Added 's' for name

    if ($stmt->execute()) {
        echo "Participation recorded successfully!";
    } else {
        echo "Error recording participation: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
?>