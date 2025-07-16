<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.html");
    exit();
}

// Connect to database
$conn = new mysqli("localhost", "root", "", "alumni_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get logged-in user's full name
$email = $_SESSION['email'];
$name = "";

$stmt = $conn->prepare("SELECT full_name FROM alumni_users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();

// Fetch all alumni
$result = $conn->query("SELECT * FROM alumni_users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Alumni Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
        }

        .logout-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .container {
            padding: 30px;
        }

        h3 {
            color: #333;
            margin-bottom: 10px;
        }

        p {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            color: #333;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            font-size: 13px;
            cursor: pointer;
        }

        .edit-btn {
            background-color: #28a745;
            color: white;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>🎓 Alumni Dashboard</h2>
        <form action="logout.php" method="post">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="container">
        <h3>Welcome, <?php echo htmlspecialchars($name); ?>!</h3>
        <p>You are logged in as: <?php echo htmlspecialchars($email); ?></p>

        <h3>Registered Alumni List:</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Batch</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['batch']); ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>">
                            <button class="btn edit-btn">Edit</button>
                        </a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this alumni?');">
                            <button class="btn delete-btn">Delete</button>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

</body>
</html>

<?php $conn->close(); ?>