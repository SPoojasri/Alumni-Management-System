<?php
// Show errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start DB connection
$conn = new mysqli("localhost", "root", "", "alumni_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("❌ No ID provided.");
}

$id = intval($_GET['id']);

// Delete alumni with this ID
$stmt = $conn->prepare("DELETE FROM alumni_users WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "✅ Alumni deleted successfully! <a href='dashboard.php'>Back to Dashboard</a>";
} else {
    echo "❌ Failed to delete alumni: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>