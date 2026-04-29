<?php
session_start();

$host = "localhost";
$dbname = "MoffatBayBooking";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $dbname);

$resultData = null;
$searched = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searched = true;

    $search = $_POST['search'];

    $stmt = $conn->prepare("SELECT * FROM Reservation WHERE reservation_id = ?");
    $stmt->bind_param("i", $search);
    $stmt->execute();

    $result = $stmt->get_result();
    $resultData = $result->fetch_assoc();
}

$res = $searched ? $resultData : ($_SESSION['reservation'] ?? null);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservation Summary</title>
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

    <div class="login-form">

        <h2 class="login-title">Reservation Summary</h2>

        <form method="POST" class="lookup-form">
            <input type="text" name="search" class="login-input" placeholder="Enter Reservation ID" required>
            <button class="login-button">Search</button>
        </form>

 
        <?php if ($res): ?>

            <p><strong>ID:</strong> <?= $res['reservation_id'] ?? $res['id']; ?></p>
            <p><strong>Date:</strong> <?= date("F j, Y", strtotime($res['reservation_date'] ?? $res['date'])); ?></p>
            <p><strong>Room:</strong> <?= $res['room_type'] ?? $res['room']; ?></p>
            <p><strong>Guests:</strong> <?= $res['guest_count'] ?? $res['guests']; ?></p>
            <p><strong>Experiences:</strong> <?= $res['experiences']; ?></p>

        <?php elseif ($searched): ?>

            <p style="color:red;">No reservation found.</p>

        <?php else: ?>

            <p style="text-align:center;">Search for a reservation above.</p>

        <?php endif; ?>

        <br>

        <a href="reservation.php" class="login-button" style="text-align:center;">Make New Reservation</a>

    </div>

</div>

</body>
</html>