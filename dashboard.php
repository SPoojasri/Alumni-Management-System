<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "alumni_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search
$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $stmt = $conn->prepare("SELECT id, full_name, email, batch FROM alumni_users WHERE full_name LIKE ? OR batch LIKE ?");
    $like = "%{$search}%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT id, full_name, email, batch FROM alumni_users");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Alumni Dashboard</title>
</head>
<body>
  <h2>Welcome to Your Dashboard</h2>
  <p>You are logged in as <b><?php echo $_SESSION['email']; ?></b></p>
  <p>Hello, <?php echo $_SESSION['full_name']; ?>!</p>
  <a href="logout.php">Logout</a>
  <br><a href="view_feedback.php">View Feedback</a>

  <h3>🔍 Search Alumni</h3>
  <form method="GET" action="dashboard.php">
    <input type="text" name="search" placeholder="Search by name or batch" value="<?php echo htmlspecialchars($search); ?>">
    <input type="submit" value="Search">
    <a href="dashboard.php">Clear</a>
  </form>

  <h3>📋 Registered Alumni List</h3>
  <table border="1" cellpadding="8">
    <tr>
      <th>Full Name</th>
      <th>Email</th>
      <th>Batch</th>
      <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
        <td><?php echo htmlspecialchars($row['email']); ?></td>
        <td><?php echo htmlspecialchars($row['batch']); ?></td>
        <td>
          <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
          <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure to delete this alumni?');">Delete</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</body>
</html>

<?php $conn->close(); ?>