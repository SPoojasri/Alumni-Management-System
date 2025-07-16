<?php
$conn = new mysqli("localhost", "root", "", "alumni_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$message = trim($_POST['message']);

$stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $message);
if ($stmt->execute()) {
    echo "✅ Thank you! Your feedback has been submitted.";
} else {
    echo "❌ Error: " . $stmt->error;
}

$conn->close();
?>