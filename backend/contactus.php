<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// DB connection
$conn = new mysqli("localhost", "root", "", "servo", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$fullName = $_POST['fullname'] ?? '';
$email = $_POST['email'] ?? '';
$services = $_POST['services'] ?? '';
$about = $_POST['about'] ?? '';

$stmt = $conn->prepare("SELECT id FROM contactus WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Email already exists. Please use another.";
    exit;
}

$stmt = $conn->prepare("INSERT INTO contactus (fullname, email, services, about) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $fullName,$email,$services,$about);


if ($stmt->execute()) {
    echo "Registration successful!";
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?>
