<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $successMessage = "Reservation form submitted successfully.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reservations | Moffat Bay Lodge</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="top-bar">
        <div class="logo">🌿 Moffat Bay Lodge</div>

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
                <li><a href="attractions.html">Attractions</a></li>
                <li><a href="registration.php">Registration</a></li>
                <li><a href="login.php">Login Page</a></li>
                <li><a href="reservation.php">Reservations</a></li>
                <li><a href="reservation-summary.html">Reservation Summary</a></li>
                <li><a href="reservation-lookup.html">Reservation Lookup</a></li>
            </ul>
        </nav>
    </div>

    <div class="reservation-container">
        <form class="reservation-form" method="POST" action="">
            <h2 class="reservation-title">Make a Reservation</h2>

            <?php if (!empty($successMessage)): ?>
                <p style="color: green; margin-bottom: 10px;"><?php echo $successMessage; ?></p>
            <?php endif; ?>

            <label class="reservation-label">Select Date</label>
            <input type="date" class="reservation-input" name="reservation_date" required>

            <label class="reservation-label">Choose Room</label>
            <select class="reservation-select" name="room_type" required>
                <option value="">-- Select Room --</option>
                <option value="Private Room">Private Room: $157.50/night</option>
                <option value="Family Room">Family Room: $210.00/night</option>
                <option value="Couples Room">Couples Room: $262.50/night</option>
            </select>

            <label class="reservation-label">Number of Guests</label>
            <select class="reservation-select" name="guest_count" required>
                <option value="">-- Select Number of Guests --</option>
                <option value="1-2 Guests">1-2 Guests</option>
                <option value="3-4 Guests">3-4 Guests</option>
                <option value="5-6 Guests">5-6 Guests</option>
            </select>

            <label class="reservation-label">Add Experiences</label>
            <div class="reservation-checkbox-group">
                <label><input type="checkbox" name="experiences[]" value="Guided Hike"> Guided Hike</label>
                <label><input type="checkbox" name="experiences[]" value="Paddleboarding"> Paddleboarding</label>
                <label><input type="checkbox" name="experiences[]" value="Smore Kit"> Smore Kit</label>
                <label><input type="checkbox" name="experiences[]" value="Kayaking"> Kayaking</label>
                <label><input type="checkbox" name="experiences[]" value="Basket Weaving"> Basket Weaving</label>
            </div>

            <button type="submit" class="reservation-button">Book Now</button>
            <button type="reset" class="reservation-button">Cancel</button>
        </form>
    </div>

</body>
</html>