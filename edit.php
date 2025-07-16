<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$conn = new mysqli("localhost", "root", "", "alumni_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("❌ No ID provided.");
}

$id = $_GET['id'];
echo "Editing ID: $id<br>";

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $batch = trim($_POST['batch']);

    $stmt = $conn->prepare("UPDATE alumni_users SET full_name = ?, email = ?, batch = ? WHERE id = ?");
    $stmt->bind_param("sssi", $full_name, $email, $batch, $id);

    if ($stmt->execute()) {
        echo "✅ Updated successfully! <a href='dashboard.php'>Back to Dashboard</a>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    exit;
}

// Fetch alumni to edit
$stmt = $conn->prepare("SELECT full_name, email, batch FROM alumni_users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    die("❌ Alumni not found.");
}

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Alumni</title>
</head>
<body>
  <h2>Edit Alumni Details</h2>
  <form method="POST">
    <label>Full Name:</label><br>
    <input type="text" name="full_name" value="<?php echo htmlspecialchars($row['full_name']); ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required><br><br>

    <label>Batch:</label><br>
    <input type="text" name="batch" value="<?php echo htmlspecialchars($row['batch']); ?>" required><br><br>

    <input type="submit" value="Update">
  </form>
</body>
</html>