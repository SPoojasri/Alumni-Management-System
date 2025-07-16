<?php
// Connect to database
$conn = new mysqli("localhost", "root", "", "alumni_db");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Fetch all feedback
$sql = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Feedback</title>
</head>
<body>
  <h2>📬 Alumni Feedback</h2>
  <a href="dashboard.php">← Back to Dashboard</a><br><br>

  <table border="1" cellpadding="8">
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Message</th>
      <th>Submitted On</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["id"] . "</td>
                <td>" . htmlspecialchars($row["name"]) . "</td>
                <td>" . htmlspecialchars($row["email"]) . "</td>
                <td>" . nl2br(htmlspecialchars($row["message"])) . "</td>
                <td>" . $row["created_at"] . "</td>
              </tr>";
      }
    } else {
      echo "<tr><td colspan='5'>No feedback found.</td></tr>";
    }
    ?>
  </table>
</body>
</html>

<?php
$conn->close();
?>