<?php
require_once 'vendor/autoload.php'; // Include Twilio SDK

use Twilio\Rest\Client;

// ✅ Twilio Credentials (Replace with your actual credentials)
$account_sid = 'ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';  // Your Account SID from Twilio
$auth_token = 'your_auth_token';                     // Your Auth Token from Twilio
$twilio_whatsapp_number = 'whatsapp:+14155238886';   // Twilio sandbox number

// ✅ Allow only POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "405 - Method Not Allowed";
    exit;
}

// ✅ Get and sanitize form data
$name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
$phone = isset($_POST['phone']) ? preg_replace('/[^0-9]/', '', $_POST['phone']) : '';
$provider = isset($_POST['provider']) ? htmlspecialchars($_POST['provider']) : '';

// ✅ Validate phone number (Indian format)
if (!preg_match('/^91[0-9]{10}$/', $phone)) {
    echo "Invalid phone number. Use Indian format like 91XXXXXXXXXX";
    exit;
}

// ✅ Format recipient
$to = 'whatsapp:+' . $phone;

// ✅ Message body
$body = "Hello $name,\nYour booking for *$provider* has been received via ServZo. We will contact you shortly.";

// ✅ Send the WhatsApp message
try {
    $client = new Client($account_sid, $auth_token);
    $client->messages->create($to, [
        'from' => $twilio_whatsapp_number,
        'body' => $body
    ]);

    // ✅ Redirect to success page
    header("Location: bookingsuccessful.html");
    exit;
} catch (Exception $e) {
    echo "Message failed to send. Error: " . $e->getMessage();
}
?>
