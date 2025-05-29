<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

// DB connection
$conn = new mysqli("localhost", "root", "", "servo", 3307);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$firstName = $_POST['firstname'] ?? '';
$lastName = $_POST['lastname'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';


// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM userregister WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Email already exists. Please use another.";
    exit;
}


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO userregister (first_name, last_name, email, password, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $firstName, $lastName, $email, $hashedPassword, $phone, $address);


if ($stmt->execute()) {
    echo "Registration successful!";
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?>
