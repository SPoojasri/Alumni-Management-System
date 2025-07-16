<?php
$conn = mysqli_connect("localhost", "root", "", "alumni_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $batch = $_POST['batch'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $sql = "INSERT INTO alumni_users (full_name, email, password, batch)
            VALUES ('$full_name', '$email', '$hashed_password', '$batch')";

    if (mysqli_query($conn, $sql)) {
        echo "✅ Registration successful!";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>