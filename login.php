<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "alumni_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo "❌ Please enter both email and password.";
        exit;
    }

    $sql = "SELECT * FROM alumni_users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $stored_hash = $row['password'];

        // Show debug temporarily
        echo "Entered password: $password <br>";
        echo "Hashed in DB: $stored_hash <br>";

        if (password_verify($password, $stored_hash)) {
            $_SESSION['email'] = $email;
            $_SESSION['full_name'] = $row['full_name'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "❌ Incorrect password.";
        }
    } else {
        echo "❌ Email not found.";
    }
}
?>