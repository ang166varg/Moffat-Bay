<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$conn = new mysqli("localhost", "root", "", "MoffatBayBooking");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $first = $_POST['firstName'];
    $last = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['telephone'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirmPassword'];


   if ($pass !== $confirm) {
    echo "<script>alert('Passwords do not match'); window.history.back();</script>";
    exit();
}

  
    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);


    $stmt = $conn->prepare("
        INSERT INTO Customer (first_name, last_name, email, phone, password_hash)
        VALUES (?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $first, $last, $email, $phone, $hashedPass);

    if ($stmt->execute()) {
      $_SESSION['success'] = "Account created successfully!";
    header("Location: /Prototype/pages/login.php");
    exit();
    } else {
        echo "Error creating account: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>