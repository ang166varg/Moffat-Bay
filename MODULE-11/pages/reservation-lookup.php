
<!--
Bravo Team - Tevyah Hanley, Angela Vargas, Cameron Mendez, Zachary Anderson
CSD460 - Software Development Capstone
Description - This is the reservation lookup page for the Moffat Bay Lodge project. It allows users to search for their reservations by ID.
-->
<?php

 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=lookup");
    exit();
}
 
$host     = "localhost";
$dbname   = "MoffatBayBooking";
$username = "root";
$password = "Starship12!";
 
$conn = new mysqli($host, $username, $password, $dbname);
 
$reservation  = null;
$attractions  = [];
$searched     = false;
$searchError  = false;
 
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['reservation_id'])) {
    $searched = true;
    $search   = (int) $_POST['reservation_id'];
 
    // Fetch reservation details
    $stmt = $conn->prepare("
        SELECT r.*, rt.room_name, rt.room_type, c.first_name, c.last_name
        FROM Reservation r
        JOIN roomtype rt ON r.room_id = rt.room_id
        JOIN Customer c ON r.customer_id = c.customer_id
        WHERE r.reservation_id = ? AND r.customer_id = ?
    ");
    $stmt->bind_param("ii", $search, $_SESSION['user_id']);
    $stmt->execute();
    $reservation = $stmt->get_result()->fetch_assoc();
    $stmt->close();
 
    if (!$reservation) {
        $searchError = true;
    } else {
        // Fetch attractions linked to this reservation
        $astmt = $conn->prepare("
            SELECT a.attraction_name, a.description, a.activity_type
            FROM attraction a
            JOIN reservation_attraction ra ON a.attraction_id = ra.attraction_id
            WHERE ra.reservation_id = ?
        ");
        $astmt->bind_param("i", $search);
        $astmt->execute();
        $result = $astmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $attractions[] = $row;
        }
        $astmt->close();
    }
}
 
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservation Lookup | Moffat Bay Lodge</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
 
<header>
    <div class="top-bar">
        <div class="logo">
            
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
                <li><a href="attractions.php">Attractions</a></li>
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
 
        <h2 class="reservation-title">Reservation Lookup</h2>
 
        <form method="POST" style="display:flex; gap:10px; margin-bottom:20px;">
            <input type="number" name="reservation_id" class="reservation-input"
                   placeholder="Enter Reservation ID" min="1" required style="flex:1;">
            <button type="submit" class="reservation-button">Search</button>
        </form>
 
        <?php if ($searchError): ?>
            <p style="color:red; text-align:center;">
                No reservation found for <?= htmlspecialchars($_SESSION['first_name'] ?? 'you') ?> with that ID. Please try again.
            </p>
 
        <?php elseif ($reservation): ?>
            <table>
                <tr>
                    <th>Reservation ID</th>
                    <td>#<?= htmlspecialchars($reservation['reservation_id']) ?></td>
                </tr>
                <tr>
                    <th>Guest Name</th>
                    <td><?= htmlspecialchars($reservation['first_name'] . ' ' . $reservation['last_name']) ?></td>
                </tr>
                <tr>
                    <th>Room</th>
                    <td><?= htmlspecialchars($reservation['room_name']) ?> (<?= htmlspecialchars($reservation['room_type']) ?>)</td>
                </tr>
                <tr>
                    <th>Check-In</th>
                    <td><?= htmlspecialchars($reservation['check_in_date']) ?></td>
                </tr>
                <tr>
                    <th>Check-Out</th>
                    <td><?= htmlspecialchars($reservation['check_out_date']) ?></td>
                </tr>
                <tr>
                    <th>Reservation Date</th>
                    <td><?= htmlspecialchars($reservation['reservation_date']) ?></td>
                </tr>
                <tr>
                    <th>Guests</th>
                    <td><?= htmlspecialchars($reservation['total_guests']) ?></td>
                </tr>
                <tr>
                    <th>Total Cost</th>
                    <td>$<?= number_format($reservation['total_cost'], 2) ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td><?= htmlspecialchars($reservation['reservation_status']) ?></td>
                </tr>
            </table>
 
            <!-- Attractions Section -->
            <h3 style="margin-top:30px;">Selected Attractions</h3>
            <?php if (!empty($attractions)): ?>
                <table>
                    <tr>
                        <th>Attraction</th>
                        <th>Description</th>
                    </tr>
                    <?php foreach ($attractions as $attraction): ?>
                    <tr>
                        <td><?= htmlspecialchars($attraction['attraction_name']) ?></td>
                        <td><?= htmlspecialchars($attraction['description'] ?? 'N/A') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p style="color:#666;">No attractions were selected for this reservation.</p>
            <?php endif; ?>
 
        <?php else: ?>
            <p style="text-align:center; color:#666;">Enter a reservation ID above to get started.</p>
        <?php endif; ?>
 
        <br>
        <a href="reservation.php" class="reservation-button">Make a Reservation</a>
        <a href="../index.php" class="reservation-button">Back to Home</a>
 
    </div>
</div>
 
</body>
</html>