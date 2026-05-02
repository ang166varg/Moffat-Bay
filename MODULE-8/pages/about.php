<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>About Us | Moffat Bay Lodge</title>
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
                    <li><a href="reservation-lookup.php">Reservation Lookup</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="hero-overlay">
            <h1>About Moffat Bay Lodge</h1>
            <p>
                Learn more about our peaceful lodge retreat, our connection to nature,
                and the relaxing experience we hope to create for every guest.
            </p>
            <a href="reservation.php" class="button">Plan Your Stay</a>
        </div>
    </section>

    <section class="section">
        <h2>Our Story</h2>
        <p class="welcome-text">
            Moffat Bay Lodge was created as a nature-inspired destination where guests can
            step away from busy daily life and enjoy comfort, quiet, and scenic beauty.
            Surrounded by natural landscapes and calming coastal views, the lodge is designed
            to offer a welcoming atmosphere that feels restful, warm, and connected to the outdoors.
        </p>
    </section>

    <section class="section">
        <h2>What Makes Our Lodge Special</h2>

        <div class="card-container">
            <div class="card">
                <h3>🌲 Nature-Focused Setting</h3>
                <p>
                    Moffat Bay Lodge is surrounded by forest, shoreline, and peaceful open spaces
                    that help guests feel close to nature during their stay.
                </p>
            </div>

            <div class="card">
                <h3>🏡 Warm Lodge Atmosphere</h3>
                <p>
                    Our lodge offers an earthy and inviting environment with a style inspired by
                    comfort, simplicity, and natural beauty.
                </p>
            </div>

            <div class="card">
                <h3>🌿 Relaxing Guest Experience</h3>
                <p>
                    Whether visitors want adventure or rest, the lodge provides a calm place to
                    recharge, explore, and enjoy meaningful time away.
                </p>
            </div>
        </div>
    </section>

    <section class="section">
        <h2>Our Mission</h2>
        <p class="welcome-text">
            Our mission is to provide guests with a memorable lodge experience that combines
            relaxation, hospitality, and appreciation for the natural surroundings of Moffat Bay.
            We want every visit to feel peaceful, refreshing, and welcoming from arrival to departure.
        </p>
    </section>

    <section class="section">
        <h2>Contact Information</h2>
        <div class="card-container">
            <div class="card">
                <h3>📍 Address</h3>
                <p>123 Moffat Bay Road, Moffat Bay, WA 98250</p>
            </div>

            <div class="card">
                <h3>📞 Phone</h3>
                <p>(360) 555-0147</p>
            </div>

            <div class="card">
                <h3>✉️ Email</h3>
                <p>stay@moffatbaylodge.com</p>
            </div>
        </div>
    </section>
<section class="section">
    <h2>Meet Our Team</h2>

    <div class="card-container">

        <div class="card">
            <img src="../images/tevyah.jpg" alt="Tevyah Hanley" style="width:100%; border-radius:10px; margin-bottom:10px;">
            <h3>Tevyah Hanley</h3>
            <p>Tevyah Hanley is a software development student based in Columbus, Ohio, currently working in IT. He is building experience in both frontend and backend development.</p>
        </div>

        <div class="card">
            <img src="../images/Angela.jpg" alt="Angela Vargas" style="width:100%; border-radius:10px; margin-bottom:10px;">
            <h3>Angela Vargas</h3>
           <p>Angela Vargas is a software development student based in Loveland, Colorado, currently working as a Micromaintenece Tech for Target. She has experience with IT and in computer mechanics.</p>
        </div>

        <div class="card">
            <img src="../images/Mendez.jpg" alt="Cameron M" style="width:100%; border-radius:10px; margin-bottom:10px;">
            <h3>Cameron M</h3>
         <p>Cameron Mendez is a software development student based in Fort Worth, Texas, currently working in FO Network Design. Developing hands on experience in all aspects of the 	software development lifecycle.</p>
        </div>

        <div class="card">
            <img src="../images/zacharyA.jpg" alt="Zachary Anderson" style="width:100%; border-radius:10px; margin-bottom:10px;">
            <h3>Zachary Anderson</h3>
           <p>Zachary is a software development student based in Modesto,California. He currently is working outside of the IT profession but hopes witha degree in the field to transfer into it. The experience from this program has been incredibly beneficial to his skills.</p>
        </div>

    </div>
</section>
    <section class="section">
        <div class="booking-section">
            <h2>Come Experience Moffat Bay Lodge</h2>
            <p>
                Discover a place where comfort meets nature and every stay is designed to feel calm and memorable.
            </p>
            <br>
            <a href="reservation.php" class="button">Reserve Now</a>
        </div>
    </section>

    <footer>
        <p>This is a prototype about page for the Moffat Bay Lodge Project</p>
        <p>Course: CSD460</p>
        <p>Team Members: Angela Vargas, Zachary Anderson, Tevyah Hanley, Cameron Mendez</p>
    </footer>

</body>
</html>