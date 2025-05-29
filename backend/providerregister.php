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
$businessName = $_POST['businessname'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$serviceArea = $_POST['servicearea'] ?? '';
$about = $_POST['about'] ?? '';
//$services = isset($_POST['services']) ? explode(",", $_POST['services']) : [];

$services = isset($_POST['services']) && is_array($_POST['services']) ? $_POST['services'] : [];
$servicesStr = implode(",", $services);


// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM providersregister WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo "Email already exists. Please use another.";
    exit;
}


$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO providersregister (first_name, last_name, business_name, email, password, phone, address, service_area, services, about) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $firstName, $lastName, $businessName, $email, $hashedPassword, $phone, $address, $serviceArea, $servicesStr, $about);


if ($stmt->execute()) {
    echo "Registration successful!";
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?>
