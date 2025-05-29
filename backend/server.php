//<?php
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $con = mysqli_connect("localhost", "root", "", "servo", 3307);

//     if (!$con) {
//         die("Connection failed: " . mysqli_connect_error());
//     }

//     $email = mysqli_real_escape_string($con, $_POST['loginemail']);
//     $pass = mysqli_real_escape_string($con, $_POST['loginpass']);

//     $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

//     $sql = "INSERT INTO login (Loginemail,Loginpassword) VALUES ('$email', '$hashed_pass')";

//     if (mysqli_query($con, $sql)) {
//         mysqli_close($con);
//         header("Location: ../thanks.html");
//         exit();
//     } else {
//         echo "Error: " . mysqli_error($con);
//     }

//     mysqli_close($con);
// //} else {
//     echo "Invalid request";
// }
//?> 


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database
    $con = mysqli_connect("localhost", "root", "", "servo", 3307);

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize inputs
    $email = mysqli_real_escape_string($con, $_POST['loginemail']);
    $pass = $_POST['loginpass'];

    // Check if user exists
    $sql = "SELECT * FROM login WHERE Loginemail = '$email'";
    $result = mysqli_query($con, $sql);

    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($pass, $row['Loginpassword'])) {
            echo "success";
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "Invalid credentials.";
    }

    mysqli_close($con);
} else {
    echo "Invalid request";
}
?>
