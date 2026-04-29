<?php
session_start();


$host = "localhost";
$dbname = "MoffatBayBooking";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $date = $_POST['reservation_date'];
    $room = $_POST['room_type'];
    $guests = $_POST['guest_count'];
    $experiences = isset($_POST['experiences']) ? implode(", ", $_POST['experiences']) : "";


    $stmt = $conn->prepare("
        INSERT INTO Reservation (reservation_date, room_type, guest_count, experiences)
        VALUES (?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $date, $room, $guests, $experiences);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }


    $_SESSION['reservation'] = [
        "id" => $conn->insert_id,
        "date" => $date,
        "room" => $room,
        "guests" => $guests,
        "experiences" => $experiences
    ];


    header("Location: reservation-summary.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make a Reservation</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

<header>
    <div class="top-bar">
        <div class="logo">🌿 Moffat Bay Lodge</div>
        <nav>
            <ul>
                <li><a href="../index.php">Home Page</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="attractions.html">Attractions</a></li>
                <li><a href="registration.php">Registration</a></li>
                <li><a href="login.php">Login Page</a></li>
                <li><a href="reservation.php">Reservations</a></li>
                <li><a href="reservation-summary.php">Reservation Summary</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="login-container">

    <form class="login-form" method="POST" action="">

        <h2 class="login-title">Make a Reservation</h2>

        <label class="reservation-label">Select Date</label>
        <input type="date" name="reservation_date" class="login-input" required>

        <label class="reservation-label">Choose Room</label>
        <select name="room_type" class="login-input" required>
            <option value="">-- Select Room --</option>
            <option value="Private Room">Private Room</option>
            <option value="Family Room">Family Room</option>
            <option value="Couples Room">Couples Room</option>
        </select>

        <label class="reservation-label">Number of Guests</label>
        <select name="guest_count" class="login-input" required>
            <option value="">-- Select --</option>
            <option value="1-2">1-2 Guests</option>
            <option value="3-4">3-4 Guests</option>
            <option value="5-6">5-6 Guests</option>
        </select>

        <label class="reservation-label">Experiences</label>
        <div style="text-align:left; margin-bottom:10px;">
            <label><input type="checkbox" name="experiences[]" value="Hike"> Hike</label><br>
            <label><input type="checkbox" name="experiences[]" value="Kayaking"> Kayaking</label>
        </div>

        <button type="submit" class="login-button">Book Now</button>

    </form>

</div>

</body>
</html>
