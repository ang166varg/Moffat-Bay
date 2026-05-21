<!--
Bravo Team - Tevyah Hanley, Angela Vargas, Cameron Mendez, Zachary Anderson
CSD460 - Software Development Capstone
Description - This is the attractions page for the Moffat Bay Lodge project. It displays a list of
              attractions and activities available on the island. It retrieves the attraction data
              from the database and displays it in a user-friendly format.
-->
<?php
$heroImg = '../images/lodge/activities1.png';
?>
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$host = "localhost";
$dbname = "MoffatBayBooking";
$username = "root";
$password = "Starship12!";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT attraction_name, description, activity_type 
        FROM attraction 
        ORDER BY attraction_id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Attractions | Moffat Bay Lodge</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="preload" as="image" href="<?php echo $heroImg; ?>">
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
                            <p style="color: #355e3b;">Welcome,
                                <?php echo htmlspecialchars($_SESSION['first_name']); ?> 👋
                            </p>
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

    <section class="hero" style="background-image: url('<?php echo $heroImg; ?>');">
        <div class="hero-overlay">
            <h1>Island Attractions</h1>
            <p>
                Explore the natural beauty and outdoor adventures waiting for you at Moffat Bay.
            </p>
            <a href="reservation.php" class="button">Book Your Stay</a>
        </div>
    </section>

    <section class="section">
        <h2>Discover Adventure at Moffat Bay</h2>
        <p class="welcome-text">
            Moffat Bay Lodge offers guests access to peaceful scenery and exciting outdoor activities.
            Whether you want a relaxing day on the water or an unforgettable wildlife experience,
            the island has something for everyone to enjoy.
        </p>
    </section>

    <section class="section">
        <h2>Featured Activities</h2>

        <div class="card-container">

            <?php if ($result && $result->num_rows > 0): ?>

                <?php while ($row = $result->fetch_assoc()): ?>

                    <?php
                    $activityType = strtolower($row['activity_type']);

                    if (str_contains($activityType, 'hiking')) {
                        $img = "../images/lodge/hiking1.jpg";
                    } elseif (str_contains($activityType, 'kayaking')) {
                        $img = "../images/lodge/kayaking1.jpg";
                    } elseif (str_contains($activityType, 'whale')) {
                        $img = "../images/lodge/whale1.jpg";
                    } elseif (str_contains($activityType, 'scuba')) {
                        $img = "../images/lodge/scuba1.jpg";
                    } else {
                        $img = "../images/lodge/default.jpg";
                    }
                    ?>

                    <div class="card" style="background-image: url('<?php echo $img; ?>');">
                        <div class="card-default">
                            <h3>
                                <?php
                                if (str_contains($activityType, 'hiking'))
                                    echo "🥾 ";
                                elseif (str_contains($activityType, 'kayaking'))
                                    echo "🛶 ";
                                elseif (str_contains($activityType, 'whale'))
                                    echo "🐋 ";
                                elseif (str_contains($activityType, 'scuba'))
                                    echo "🤿 ";
                                else
                                    echo "🌿 ";
                                echo htmlspecialchars($row['attraction_name']);
                                ?>
                            </h3>
                            <p><strong>Activity Type:</strong>
                                <?php echo htmlspecialchars($row['activity_type']); ?>
                            </p>
                            <p>
                                <?php echo htmlspecialchars($row['description']); ?>
                            </p>
                        </div>
                        <div class="card-hover"></div>
                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="card">
                    <h3>No Attractions Available</h3>
                    <p>Attractions are currently unavailable. Please check back later.</p>
                </div>

            <?php endif; ?>

        </div>
    </section>

    <section class="section">
        <div class="booking-section">
            <h2>Plan Your Island Adventure</h2>
            <p>
                Reserve your stay at Moffat Bay Lodge and enjoy hiking, kayaking, whale watching,
                and scuba diving during your visit.
            </p>
            <br>
            <a href="reservation.php" class="button">Reserve Now</a>
        </div>
    </section>

    <footer>
        <p>This is a prototype attractions page for the Moffat Bay Lodge Project</p>
        <p>Course: CSD460</p>
        <p>Team Members: Angela Vargas, Zachary Anderson, Tevyah Hanley, Cameron Mendez</p>
    </footer>

</body>

</html>

<?php
$conn->close();
?>