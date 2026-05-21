<!--
Bravo Team - Tevyah Hanley, Angela Vargas, Cameron Mendez, Zachary Anderson
CSD460 - Software Development Capstone
Landing Page for Moffat Bay Lodge
Acts as first page to greet users and provide navigation to other pages

PHP updates 04/13/2026: landing page backend now includes PHP session initialization using session_start() to support user state management across the application. A logout script (logout.php added to pages) was also implemented to destroy sessions and redirect users back to the landing page.
-->
<?php
$heroImg = 'images/lodge/moffatbaylodge.png';
?>
<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Moffat Bay Lodge</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="preload" as="image" href="<?php echo $heroImg; ?>">
</head>

<body>


    <!-- Navigation -->
    <header>
        <div class="top-bar">
            <div class="logo">
                <img src="images/moffatbaylogo.png" alt="Logo">
                <span>Moffat Bay Lodge</span>
            </div>

            <nav>

                <ul>
                    <li>
                        <?php if (isset($_SESSION['first_name'])): ?>
                            <p style="color: #355e3b;">Welcome, <?php echo $_SESSION['first_name']; ?> 👋</p>
                            <a href="pages/logout.php" style="border: solid #355e3b;">Logout</a>
                        <?php endif; ?>
                    </li>
                    <li><a href="index.php">Home Page</a></li>
                    <li><a href="pages/about.php">About Us</a></li>
                    <li><a href="pages/attractions.php">Attractions</a></li>
                    <li><a href="pages/registration.php">Registration</a></li>
                    <li><a href="pages/login.php">Login Page</a></li>
                    <li><a href="pages/reservation.php">Reservations</a></li>
                    <li><a href="pages/reservation-lookup.php">Reservation Lookup</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" style="background-image: url('<?php echo $heroImg; ?>');">
        <div class="hero-overlay">
            <h1>Experience Earth-Tone Living at Moffat Bay Lodge</h1>
            <p>
                A peaceful lodge retreat inspired by nature, where earthy comfort meets coastal beauty.
            </p>
            <a href="pages/login.php" class="button">Begin Your Journey</a>
        </div>
    </section>

    <!-- Welcome Section -->

    <section class="section">
        <h2>Welcome to a Natural Escape</h2>
        <p class="we      lcome-text">
            Moffat B ay Lodge invites you into a calm, nature-inspired retreat designed for relaxation,
            adventure, and connection with the outdoors.
        </p>
    </section>

    <!-- Experience                 Section -->
    <section class="             section">
        <h2>Natu re-Inspired Experiences</h2>

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
        </se ction>

        <!-- Boo  king Section -->

        <section class="section">
            <div class="booking-section">
                <h2>Plan Your Stay</h2>
                <p>Start your reservation and step into a relaxing lodge experience.</p>
                <br>
                <a href="pages/reservation.php" class="button">Reserve Now</a>
            </div>
        </section>

        <!-- Foo                 ter -->
        <footer>
            <p>This is a prototype landing page for the Moffat Bay Lodge Project</p>
            <p>C ourse: CSD460</p>
            <p>Team Members: Angela Vargas, Zachary Anderson, Tevyah Hanley, Cameron Mendez</p>
        </footer>

</body>

</html>