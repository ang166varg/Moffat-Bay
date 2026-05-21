<!--
Bravo Team - Tevyah Hanley, Angela Vargas, Cameron Mendez, Zachary Anderson
CSD460 - Software Development Capstone
Description - This is the reservation page for the Moffat Bay Lodge project. It allows users to select a room and attractions for their stay.
-->
<?php
$heroImg = '../images/lodge/Log Cabin1.jpg';
?>
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=login_required&redirect=reservation.php");
    exit();

}

// -------------------------------------------------------
// Database connection
// -------------------------------------------------------
$host = "localhost";
$dbname = "MoffatBayBooking";
$username = "root";
$password = "Starship12!"; // Update with your actual MySQL password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// -------------------------------------------------------
// Load rooms from the roomtype table
// -------------------------------------------------------
$roomResult = $conn->query("SELECT * FROM roomtype WHERE availability_status = 'available' ORDER BY room_id");

$rooms = [];
while ($row = $roomResult->fetch_assoc()) {
    $rooms[] = $row;
}

// -------------------------------------------------------
// Load attractions from the attractions table
// -------------------------------------------------------
$attractionResult = $conn->query("SELECT * FROM attraction ORDER BY attraction_id");

$attractions = [];
while ($row = $attractionResult->fetch_assoc()) {
    $attractions[] = $row;
}

// -------------------------------------------------------
// Handle form submission — save reservation to DB
// -------------------------------------------------------
$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $checkIn = $_POST['check_in'] ?? "";
    $checkOut = $_POST['check_out'] ?? "";
    $roomId = (int) ($_POST['room_id'] ?? 0);
    $guestCount = (int) ($_POST['guest_count'] ?? 0);
    $selectedAttractions = $_POST['attractions'] ?? [];

    // Basic validation
    if (empty($checkIn) || empty($checkOut) || $roomId === 0 || $guestCount === 0) {
        $errorMessage = "Please fill in all required fields.";

    } elseif ($checkOut <= $checkIn) {
        $errorMessage = "Check-out date must be after check-in date.";

    } else {
        $nights = (strtotime($checkOut) - strtotime($checkIn)) / 86400;

        // Get nightly rate and max guests for selected room
        $rateStmt = $conn->prepare("SELECT nightly_rate, max_guests FROM roomtype WHERE room_id = ?");
        $rateStmt->bind_param("i", $roomId);
        $rateStmt->execute();
        $rateResult = $rateStmt->get_result()->fetch_assoc();
        $rateStmt->close();

        if ($guestCount > $rateResult['max_guests']) {
            $errorMessage = "Selected room allows a maximum of " . $rateResult['max_guests'] . " guests.";
        } else {
            $totalCost = $nights * $rateResult['nightly_rate'];
            $customerId = $_SESSION['user_id'] ?? NULL;

            // Step 1 — Insert into Reservation table
            $stmt = $conn->prepare("
                INSERT INTO Reservation (customer_id, room_id, check_in_date, check_out_date, total_guests, total_cost)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            if (!$stmt) {
                $errorMessage = "Prepare failed: " . $conn->error;
            } else {
                $stmt->bind_param("iissid", $customerId, $roomId, $checkIn, $checkOut, $guestCount, $totalCost);

                if ($stmt->execute()) {
                    // Step 2 — Get the new reservation ID
                    $newReservationId = $conn->insert_id;

                    // Step 3 — Insert each selected attraction into reservation_attraction
                    $attractionNames = [];
                    if (!empty($selectedAttractions)) {
                        $attractStmt = $conn->prepare("
                            INSERT INTO reservation_attraction (reservation_id, attraction_id)
                            VALUES (?, ?)
                        ");

                        foreach ($selectedAttractions as $attractionId) {
                            $attractStmt->bind_param("ii", $newReservationId, $attractionId);
                            $attractStmt->execute();

                            // Match attraction Id to name for already loaded $attractions array
                            foreach ($attractions as $a) {
                                if ($a['attraction_id'] == $attractionId) {
                                    $attractionNames[] = $a['attraction_name'];

                                }
                            }
                        }

                        $attractStmt->close();
                    }

                    // Store reservation details in session for summary page
                    $_SESSION['reservation_summary'] = [
                        'reservation_id' => $newReservationId,
                        'check_in' => $checkIn,
                        'check_out' => $checkOut,
                        'nights' => $nights,
                        'room_id' => $roomId,
                        'total_guests' => $guestCount,
                        'total_cost' => $totalCost,
                        'attractions' => $attractionNames,
                        'status' => 'pending'
                    ];

                    // Redirect to summary page
                    header("Location: reservation-summary.php");
                    exit();
                }
            }
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservations | Moffat Bay Lodge</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<!-- Set the hero image for the page -->

<body style="background-image: url('<?php echo $heroImg; ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 100vh;

">

    <header>
        <div class="top-bar">
            <div class="logo">

                <span>Moffat Bay Lodge</span>
            </div>

            <nav>

                <ul>
                    <li>
                        <?php if (isset($_SESSION['first_name'])): ?>
                            <p style="color: #355e3b;">Welcome, <?php echo $_SESSION['first_name']; ?> 👋</p>
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
        <form class="reservation-form" method="POST" action="">
            <h2 class="reservation-title">Make a Reservation</h2>

            <!-- Success / error messages -->
            <?php if (!empty($successMessage)): ?>
                <p style="color: green; margin-bottom: 10px;"><?= htmlspecialchars($successMessage) ?></p>
            <?php endif; ?>
            <?php if (!empty($errorMessage)): ?>
                <p style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($errorMessage) ?></p>
            <?php endif; ?>

            <!-- Check-in date -->
            <label class="reservation-label">Check-In Date</label>
            <input type="date" class="reservation-input" name="check_in" min="<?= date('Y-m-d') ?>" required>

            <!-- Check-out date -->
            <label class="reservation-label">Check-Out Date</label>
            <input type="date" class="reservation-input" name="check_out"
                min="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
            <p style="font-size: 14px; color: #555; margin-top: 5px;">
                Check-out date must be at least one day after the check-in date.
            </p>

            <!-- Room dropdown — pulled from roomtype table -->
            <label class="reservation-label">Choose Room</label>
            <select class="reservation-select" name="room_id" required>
                <option value="">-- Select Room --</option>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room['room_id'] ?>">
                        <?= htmlspecialchars($room['room_name']) ?>
                        (<?= htmlspecialchars($room['room_type']) ?>) —
                        $<?= number_format($room['nightly_rate'], 2) ?>/night,
                        max <?= $room['max_guests'] ?> guests
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Number of guests -->
            <label class="reservation-label">Number of Guests</label>
            <select class="reservation-select" name="guest_count" required>
                <option value="">-- Select Number of Guests --</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>

            <!-- Attractions — pulled from attractions table -->
            <label class="reservation-label">Add Attractions</label>
            <div class="reservation-checkbox-group">
                <?php foreach ($attractions as $attraction): ?>
                    <label>
                        <input type="checkbox" name="attractions[]" value="<?= $attraction['attraction_id'] ?>">
                        <?= htmlspecialchars($attraction['attraction_name']) ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="reservation-button">Book Now</button>
            <button type="reset" class="reservation-button">Cancel</button>
        </form>
    </div>

</body>

</html>