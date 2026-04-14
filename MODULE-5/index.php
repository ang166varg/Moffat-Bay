<!--
Bravo Team
Landing Page for Moffat Bay Lodge
Acts as first page to greet users and provide navigation to other pages

PHP updates 04/13/2026: landing page backend now includes PHP session initialization using session_start() to support user state management across the application. A logout script (logout.php added to pages) was also implemented to destroy sessions and redirect users back to the landing page.
-->

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Moffat Bay Lodge</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<!-- Navigation -->
<div class="top-bar">
    <div class="logo">🌿 Moffat Bay Lodge</div>
    
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <p>Welcome, <?php echo $_SESSION['email']; ?> 👋</p>
            <a href="pages/logout.php">Logout</a>    
        <?php endif; ?>
        <ul>
            <li><a href="index.php">Home Page</a></li>
            <li><a href="pages/about.html">About Us</a></li>
			<li><a href="pages/contact.html">Contact Us</a></li>
            <li><a href="pages/attractions.html">Attractions</a></li>
            <li><a href="pages/registration.html">Registration</a></li>
            <li><a href="pages/login.php">Login Page</a></li>
			<li><a href="pages/reservation.html">Reservations</a></li>
            <li><a href="pages/reservation-summary.html">Reservation Summary</a></li>
            <li><a href="pages/reservation-lookup.html">Reservation Lookup</a></li>
        </ul>
    </nav>
</div>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-overlay">
        <h1>Experience Earth-Tone Living at Moffat Bay Lodge</h1>
        <p>
            A peaceful lodge retreat inspired by nature, where earthy comfort meets coastal beauty.
        </p>
        <a href="login.html" class="button">Begin Your Journey</a>
    </div>
</section>

<!-- Welcome Section -->
<section class="section">
    <h2>Welcome to a Natural Escape</h2>
    <p class="welcome-text">
        Moffat Bay Lodge invites you into a calm, nature-inspired retreat designed for relaxation,
        adventure, and connection with the outdoors.
    </p>
</section>

<!-- Experience Section -->
<section class="section">
    <h2>Nature-Inspired Experiences</h2>

    <div class="card-container">
        <div class="card">
            <h3>🌲 Cozy Lodge Stay</h3>
            <p>Relax in warm, earthy lodge spaces surrounded by forest and water views.</p>
        </div>

        <div class="card">
            <h3>🌿 Outdoor Adventures</h3>
            <p>Explore hiking, kayaking, and peaceful nature trails.</p>
        </div>

        <div class="card">
            <h3>🍃 Relax & Unwind</h3>
            <p>Enjoy a slow-paced environment focused on wellness and comfort.</p>
        </div>
    </div>
</section>

<!-- Booking Section -->
<section class="section">
    <div class="booking-section">
        <h2>Plan Your Stay</h2>
        <p>Start your reservation and step into a relaxing lodge experience.</p>
        <br>
        <a href="reservation.html" class="button">Reserve Now</a>
    </div>
</section>

<!-- Footer -->
<footer>
    <p>This is a prototype landing page for the Moffat Bay Lodge Project</p>
    <p>Course: CSD460</p>
    <p>Team Members: Angela Vargas, Zachary Anderson, Tevyah Hanley, Cameron Mendez</p>
</footer>

</body>
</html>