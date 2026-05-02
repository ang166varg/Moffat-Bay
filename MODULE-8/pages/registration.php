<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $host = "localhost";
    $dbname = "MoffatBayBooking";
    $username = "root";
    $password = "Starship12!";

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $first = $_POST['firstName'];
    $last = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['telephone'];
    $pass = $_POST['password'];
    $confirm = $_POST['confirmPassword'];

    if ($pass !== $confirm) {
        echo "<script>alert('Passwords do not match'); window.history.back();</script>";
        exit();
    }

    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("
        INSERT INTO Customer (first_name, last_name, email, phone, password_hash)
        VALUES (?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $first, $last, $email, $phone, $hashedPass);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Account created successfully!";
        header("Location: /Moffat-Bay/MODULE-7/pages/login.php");
        exit();
    } else {
        echo "Error creating account: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration | Moffat Bay Lodge</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

    <header>
        <div class="top-bar">
            <div class="logo">🌿 Moffat Bay Lodge</div>

            <nav>
                <ul>
                    <li>
                        <?php if (isset($_SESSION['first_name'])): ?>
                            <p style="color: #355e3b;">Welcome, <?php echo $_SESSION['first_name']; ?> 👋</p>
                            <a href="logout.php" style="border: solid #355e3b;">Logout</a>
                        <?php endif; ?>
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
            <h1>Create Your Account</h1>
            <p>
                Register with Moffat Bay Lodge to begin planning your stay and managing your reservations.
            </p>
            <a href="reservation.php" class="button">View Reservations</a>
        </div>
    </section>

    <div class="registration-container">
        <div class="registration-wrapper">

            <form class="registration-form" method="POST">
                <h2 class="registration-title">Guest Registration</h2>

                

                <label class="registration-label" for="firstName">First Name</label>
                <input 
                    class="registration-input" 
                    type="text" 
                    id="firstName" 
                    name="firstName" 
                    required>

                <label class="registration-label" for="lastName">Last Name</label>
                <input 
                    class="registration-input" 
                    type="text" 
                    id="lastName" 
                    name="lastName" 
                    required>

                <label class="registration-label" for="email">Email Address</label>
                <input 
                    class="registration-input" 
                    type="email" 
                    id="email" 
                    name="email" 
                    required
                    placeholder="example@email.com"
                    title="Enter a valid email address (example: bob@something.com). This will be your username.">

                <label class="registration-label" for="telephone">Telephone</label>
                <input 
                    class="registration-input" 
                    type="tel" 
                    id="telephone" 
                    name="telephone" 
                    required
                    placeholder="(555) 555-5555"
                    title="Enter a valid phone number so we are able to contact you about your reservation.">

                <label class="registration-label" for="password">Password</label>
                <input 
                    class="registration-input" 
                    type="password"
                    id="password"
                    name="password"
                    required
                    minlength="8"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                    title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, and one number.">

                <label class="registration-label" for="confirmPassword">Confirm Password</label>
                <input 
                    class="registration-input" 
                    type="password" 
                    id="confirmPassword" 
                    name="confirmPassword"
                    required
                    title="Re-enter password to confirm it matches.">

                <button class="registration-button" type="submit">Create Account</button>
            </form>

            <div class="requirements-box">
                <h3>Requirements</h3>
                <ul>
                    <li>All customers will be assigned a unique customer ID.</li>
                    <li>Email will be used as the username.</li>
                    <li>Password must be at least 8 characters long and include one uppercase letter, one lowercase letter, and one number.</li>
                    <li>Email must follow a standard format (example: bob@something.com).</li>
                    <li>Passwords will be securely hashed or encrypted.</li>
                </ul>
            </div>

        </div>
    </div>

    <footer>
        <p>This is a prototype registration page for the Moffat Bay Lodge Project</p>
        <p>Course: CSD460</p>
        <p>Team Members: Angela Vargas, Zachary Anderson, Tevyah Hanley, Cameron Mendez</p>
    </footer>

</body>
</html>