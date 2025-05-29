<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "root", "", "servo", 3307);

    header("Access-Control-Allow-Origin: *");


    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($con, $_POST['loginemail']);
    $pass = mysqli_real_escape_string($con, $_POST['loginpass']);

    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO userlogin (userloginemail,userloginpassword) VALUES ('$email', '$hashed_pass')";

    if (mysqli_query($con, $sql)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
} else {
    echo "Invalid request";
}
?>


