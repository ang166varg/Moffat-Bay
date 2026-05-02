

<?php
/**
 * Reservation Summary Page
 *
 * Description: Displays a summary of the reservation details after submission.
 *
 * Author: Bravo Team
 * Date: 4/21/26
 */


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect if no summary in session
if (!isset($_SESSION['reservation_summary'])) {
    header("Location: reservation.php");
    exit();
}

$summary = $_SESSION['reservation_summary'];

// Load room name from DB
$host     = "localhost";
$dbname   = "MoffatBayBooking";
$username = "root";
<<<<<<< HEAD
$password = "Bangarang4$";
=======
$password = "Starship12!";
>>>>>>> e2491ea3949a493e787903e83d484c45f6428867

$conn = new mysqli($host, $username, $password, $dbname);

$roomStmt = $conn->prepare("SELECT room_name, room_type FROM roomtype WHERE room_id = ?");
$roomStmt->bind_param("i", $summary['room_id']);
$roomStmt->execute();
$room = $roomStmt->get_result()->fetch_assoc();
$roomStmt->close();
$conn->close();

// Clear summary from session after reading it
unset($_SESSION['reservation_summary']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Confirmation | Moffat Bay Lodge</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<header>
    <div class="top-bar">
         <div class="logo">
   	 <img src="/Moffat-Bay/images/MoffatBayLogo.png" alt="Logo">
   	 <span>Moffat Bay Lodge</span>
	</div>


        <nav>
            <ul>
                <li>
                    <?php if (isset($_SESSION['first_name'])): ?>
                        <p style="color: #355e3b;">Welcome, <?= htmlspecialchars($_SESSION['first_name']) ?> 👋</p>
                        <a href="logout.php" style="border: solid #355e3b;">Logout</a>
                    <?php endif; ?>
                </li>
                <li><a href="../index.php">Home Page</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="attractions.html">Attractions</a></li>
                <li><a href="registration.php">Registration</a></li>
                <li><a href="login.php">Login Page</a></li>
                <li><a href="reservation.php">Reservations</a></li>
                <li><a href="reservation-lookup.php">Reservation Lookup</a></li>
            </ul>
        </nav>
    </div>
</header>
    <div class="reservation-container">
        <div class="reservation-form">
            <h2 class="reservation-title">Reservation Confirmed!</h2>
            <p style="color: green; margin-bottom: 20px;">
                Thank you, <?= htmlspecialchars($_SESSION['first_name']) ?>! Your reservation has been received.
            </p>

            <table>
                <tr>
                    <th>Reservation ID</th>
                    <td>#<?= $summary['reservation_id'] ?></td>
                </tr>
                <tr>
                    <th>Room</th>
                    <td><?= htmlspecialchars($room['room_name']) ?> (<?= htmlspecialchars($room['room_type']) ?>)</td>
                </tr>
                <tr>
                    <th>Check-In</th>
                    <td><?= htmlspecialchars($summary['check_in']) ?></td>
                </tr>
                <tr>
                    <th>Check-Out</th>
                    <td><?= htmlspecialchars($summary['check_out']) ?></td>
                </tr>
                <tr>
                    <th>Nights</th>
                    <td><?= $summary['nights'] ?></td>
                </tr>
                <tr>
                    <th>Guests</th>
                    <td><?= $summary['total_guests'] ?></td>
                </tr>
                <tr>
                    <th>Attractions</th>
                    <td><?= !empty($summary['attractions']) ? htmlspecialchars(implode(", ", $summary['attractions'])) : "None selected" ?></td>
                </tr>
                <tr>
                    <th>Total Cost</th>
                    <td>$<?= number_format($summary['total_cost'], 2) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>Pending</td>
                </tr>
            </table>

            <br>
            <a href="reservation.php" class="reservation-button">Make Another Reservation</a>
            <a href="../index.php" class="reservation-button">Back to Home</a>
        </div>
    </div>

</body>
</html>